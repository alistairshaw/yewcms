<?php namespace AlistairShaw\YewCMS\App\Base\Entity;

use AlistairShaw\YewCMS\App\Base\ValueObjects\DateTime\DateTime;

interface Entity {

	/**
	 * @return int
	 */
	public function id();

	/**
	 * @param int $id
	 */
	public function setId($id);

	/**
	 * @return DateTime
	 */
	public function createdAt();

	/**
	 * @param DateTime $createdAt
	 */
	public function setCreatedAt(DateTime $createdAt);

	/**
	 * @return DateTime
	 */
	public function updatedAt();

	/**
	 * @param DateTime $updatedAt
	 */
	public function setUpdatedAt(DateTime $updatedAt);

	/**
	 * @return DateTime
	 */
	public function deletedAt();

	/**
	 * @param DateTime $deletedAt
	 * @return mixed
	 */
	public function setDeletedAt(DateTime $deletedAt);

	/**
	 * @return array
	 */
	public function toArray();

	/**
	 * @return array
	 */
	public function toOutput();
}