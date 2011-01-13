<?php

class Tracr_Service_Trac_Ticket_Priority extends Tracr_Service_Trac
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
	 * Get a list of all ticket priority names.	
	 * @return array
	 */
	protected function _getAll()
	{
		return $this->call("ticket.priority.getAll");
	}
	
	/**
	 * Get a ticket priority.	
	 * @param string $name
	 * @return array
	 */
	protected function _get($name)
	{
		return $this->call("ticket.priority.get", array($name));
	}
	
	/**
	 * Delete a ticket priority
	 * @param string $name
	 * @return int
	 */
	protected function _delete($name)
	{
		return $this->call("ticket.priority.delete", array($name));
	}
	
	/**
	 * Create a new ticket priority with the given value.	
	 * @param string $name
	 * @param string $value
	 * @return int
	 */
	protected function _create($name, $value)
	{
		return $this->call("ticket.priority.create",
			array(
				$name,
				$value
			)
		);
	}
	
	/**
	 * Update ticket priority with the given value.	
	 * @param string $name
	 * @param string $value
	 * @return int
	 */
	protected function _update($name, $value)
	{
		return $this->call("ticket.priority.update",
			array(
				$name,
				$value
			)
		);
	}
}