<?php

class Tracr_Service_Trac_Ticket_Resolution extends Tracr_Service_Trac
{
	protected $_supportedMethods = array(
		'getAll',
		'get',
		'delete',
		'create',
		'update'
	);
	
	public function __construct($username, $password, $instance)
	{
		parent::__construct($username, $password, $instance);
	}

	/**
	 * Get a list of all ticket resolution names.	
	 * @return array
	 */
	protected function _getAll()
	{
		return $this->call("ticket.resolution.getAll");
	}
	
	/**
	 * Get a ticket resolution.	
	 * @param string $name
	 * @return array
	 */
	protected function _get($name)
	{
		return $this->call("ticket.resolution.get", array($name));
	}
	
	/**
	 * Delete a ticket resolution	
	 * @param string $name
	 * @return int
	 */
	protected function _delete($name)
	{
		return $this->call("ticket.resolution.delete", array($name));
	}
	
	/**
	 * Create a new ticket resolution with the given value.
	 * @param string $name
	 * @param string $value
	 * @return int
	 */
	protected function _create($name, $value)
	{
		return $this->call("ticket.resolution.create",
			array(
				$name,
				$value
			)
		);
	}
	
	/**
	 * Update ticket resolution with the given value.
	 * @param string $name
	 * @param string $value
	 * @return int
	 */
	protected function _update($name, $value)
	{
		return $this->call("ticket.resolution.update",
			array(
				$name,
				$value
			)
		);
	}
}