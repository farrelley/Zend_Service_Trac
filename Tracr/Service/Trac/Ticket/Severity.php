<?php

class Tracr_Service_Trac_Ticket_Severity extends Tracr_Service_Trac
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
	 * Get a list of all ticket severity names.	
	 * @return array
	 */
	protected function _getAll()
	{
		return $this->call("ticket.severity.getAll");
	}
	
	/**
	 * Get a ticket severity.	
	 * @param string $name
	 * @return array
	 */
	protected function _get($name)
	{
		return $this->call("ticket.severity.get", array($name));
	}
	
	/**
	 * Delete a ticket severity	
	 * @param string $name
	 * @return int
	 */
	protected function _delete($name)
	{
		return $this->call("ticket.severity.delete", array($name));
	}
	
	/**
	 * Create a new ticket severity with the given value.	
	 * @param string $name
	 * @param string $value
	 * @return int
	 */
	protected function _create($name, $value)
	{
		return $this->call("ticket.severity.create",
			array(
				$name,
				$value
			)
		);
	}
	
	/**
	 * Update ticket severity with the given value.	
	 * @param string $name
	 * @param string $value
	 * @return int
	 */
	protected function _update($name, $value)
	{
		return $this->call("ticket.severity.update",
			array(
				$name,
				$value
			)
		);
	}
}