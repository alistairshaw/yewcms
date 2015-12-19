<?php namespace AlistairShaw\YewCMS\App\Base\Repository;

use AlistairShaw\YewCMS\App\Base\Entity\Entity;
use AlistairShaw\YewCMS\App\Base\ValueObjects\Collection;

interface Repository {

	/**
	 * @param int $limit
	 * @param int $offset
	 * @return Collection
	 */
	public function all($limit = 0, $offset = 0);

	/**
	 * Returns total number of all records
	 * @return int
	 */
	public function total();

	/**
	 * @param array $searchParams
	 * @param int   $limit
	 * @param int   $offset
	 * @return Collection
	 */
	public function search($searchParams, $offset = 0, $limit = 10);

	/**
	 * @param int $id
	 * @return Entity
	 */
	public function find($id);

	/**
	 * @param $entity
	 * @return Entity
	 */
	public function save($entity);

	/**
	 * @param int $id
	 * @return bool
	 */
	public function destroy($id);

}