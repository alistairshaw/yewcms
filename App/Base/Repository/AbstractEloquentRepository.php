<?php namespace AlistairShaw\YewCMS\App\Base\Repository;

use AlistairShaw\YewCMS\App\Base\Entity\Entity;
use AlistairShaw\YewCMS\App\Base\Entity\EntityFactory;
use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidIdException;
use AlistairShaw\YewCMS\App\Base\Exceptions\InvalidSearchParameterException;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Collection;
use AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime\DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class AbstractEloquentRepository implements Repository {

	use SoftDeletes;

	/**
	 * @var Model
	 */
	protected $model;

	/**
	 * @var EntityFactory
	 */
	protected $factory;

	/**
	 * @var array
	 */
	protected $validSearchVariables = [];

	/**
	 * @param int $limit
	 * @param int $offset
	 * @return Collection
	 */
	public function all($limit = 0, $offset = 0)
	{
		if ($limit == 0)
		{
			$results = $this->model->All();
		}
		else
		{
			$results = $this->model->take($limit)->skip($offset)->get();
		}

		return $this->makeCollection($results);
	}

	/**
	 * @param $results Collection
	 * @return static
	 */
	protected function makeCollection($results)
	{
		$final = [];
		foreach ($results as $record)
		{
			$recordArray = $record->toArray();
			$final[]     = $this->factory->create($recordArray)->toOutput();
		}

		return Collection::make($final);
	}

	/**
	 * Returns total number of records
	 * @return int
	 */
	public function total()
	{
		return $this->model->count();
	}

	/**
	 * @param array $searchParams
	 * @param int   $offset
	 * @param int   $limit
	 * @param null  $query
	 * @return Collection
	 * @throws InvalidSearchParameterException
	 */
	public function search($searchParams, $offset = 0, $limit = 10, $query = null)
	{
		$auth = false;
		if (isset($searchParams['auth']))
		{
			$auth = $searchParams['auth'];
			unset($searchParams['auth']);
		}

		if ($query === null) $query = $this->model;
		foreach ($this->checkSearchVariables($searchParams, $auth) as $field => $value)
		{
			if ($field == 'everywhere')
			{
				foreach ($this->validSearchVariables as $eVar)
				{
					$query = $query->where($eVar, '=', $value)->orWhere($eVar, 'LIKE', '%' . $value . '%');
				}
				continue;
			}

			if (is_array($value))
			{
				$query = $query->whereIn($field, $value);
			}
			else
			{
				if (is_bool($value)) $value = (int) $value;
				$query = $query->where($field, '=', $value)->orWhere($field, 'LIKE', '%' . $value . '%');
			}

		}

		if ($limit > 0)
		{
			$query = $query->take($limit)->skip($offset);
		}

		if (isset($searchParams['sortBy']))
		{
			$this->checkIfKeyIsSearchable($searchParams['sortBy']);
			$searchParams['sortDirection'] = (isset($searchParams['sortDirection']) && $searchParams['sortDirection'] == 'DESC') ? 'DESC' : 'ASC';
			$query->orderBy($searchParams['sortBy'], $searchParams['sortDirection']);
		}

		$results = $query->get();

		return $this->makeCollection($results);
	}

	/**
	 * @param int $id
	 * @return Entity
	 * @throws InvalidIdException
	 */
	public function find($id)
	{
		if ( ! (int) $id > 0)
		{
			throw new InvalidIdException($id);
		}

		if ($record = $this->model->find($id))
		{
			$record = $record->toArray();

			return $this->factory->create($record);
		}

		return null;
	}

	/**
	 * @param Entity $entity
	 * @return Entity
	 */
	public function save($entity)
	{
		$entity->setUpdatedAt(DateTime::now());

		$data  = $entity->toArray();
		$final = [];
		foreach ($data as $key => $value)
		{
			$newKey = $this->fromCamelCase($key);

			// only add to final array if fillable is not set OR if the key is present
			if ($this->model->getFillable() && in_array($newKey, $this->model->getFillable()) || !$this->model->getFillable())
			{
				$final[ $newKey ] = $value;
			}
		}

		// if the record exists, then we update it
		if ($record = $this->model->find($entity->id()))
		{
			$record->update($final);
		}
		// otherwise create a new one and set the ID
		else
		{
			$record = $this->model->create($final);
			$entity->setId($record->id);
		}

		return $entity;
	}

	/**
	 * @param Entity $entity
	 * @return boolean
	 */
	public function destroy($entity)
	{
		return (bool) $this->model->destroy($entity->id);
	}

	/**
	 * @param $input
	 * @return string
	 */
	private function fromCamelCase($input)
	{
		preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
		$ret = $matches[0];
		foreach ($ret as &$match)
		{
			$match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
		}

		return implode('_', $ret);
	}

	/**
	 * Checks if the variables sent through are searchable, converts from camel case if necessary,
	 *    throws exception if it finds an invalid one
	 * @param      $searchVars
	 * @param bool $auth Set to false if user isn't authorised to search everything
	 * @return array
	 * @throws InvalidSearchParameterException
	 */
	protected function checkSearchVariables($searchVars, $auth = false)
	{
		$skipThese = ['limit', 'offset', 'sortBy', 'sortDirection'];

		// if auth is set to true, then we can open up the valid auth variables
		if ($auth)
		{
			if (isset($this->validAuthSearchVariables)) $this->validSearchVariables = $this->validAuthSearchVariables;
		}

		$final = [];
		foreach ($searchVars as $key => $val)
		{
			$originalKey = $key;

			// these fields are ok, we don't want them in our final array though
			if (in_array($key, $skipThese)) continue;

			// 'everywhere' is special, we want it in our final array, but don't need to check it
			if ($key == 'everywhere')
			{
				$final['everywhere'] = $val;
			}
			else
			{
				$key = $this->checkIfKeyIsSearchable($key, $originalKey);
			}

			$final[ $key ] = $val;
		}

		return $final;
	}

	/**
	 * @param        $key
	 * @param string $originalKey
	 * @return string
	 * @throws InvalidSearchParameterException
	 */
	private function checkIfKeyIsSearchable($key, $originalKey = '')
	{
		if ($originalKey == '') $originalKey = $key;

		if ( ! in_array($key, $this->validSearchVariables))
		{
			$key = $this->fromCamelCase($key);
			if ( ! in_array($key, $this->validSearchVariables))
			{
				throw new InvalidSearchParameterException($originalKey, $this->validSearchVariables);
			}
		}

		return $key;
	}

}