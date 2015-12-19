<?php namespace AlistairShaw\YewCMS\App\Base\Entity;

interface EntityFactory {

	/**
	 * @param array  $data
	 * @return Entity
	 */
	public function create($data = array());

	/**
	 * @param Entity $entity
	 * @param array  $data
	 * @return mixed
	 */
	public function update(Entity $entity, $data = array());

}