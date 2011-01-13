<?php

class Tracr_Service_Trac_Ticket_Type extends Tracr_Service_Trac
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
	 * Get a list of all ticket type names.
	 * @return array
	 */
	protected function _getAll()
	{
		return $this->call("ticket.type.getAll");
	}
	
	/**
	 * Get a ticket type.
	 * @param string $name
	 * @return array
	 */
	protected function _get($name)
	{
		return $this->call("ticket.type.get", array($name));
	}
	
	/**
	 * Delete a ticket type	
	 * @param string $name
	 * @return int
	 */
	protected function _delete($name)
	{
		return $this->call("ticket.type.delete", array($name));
	}
	
	/**
	 * Create a new ticket type with the given value.
	 * @param string $name
	 * @param string $value
	 * @return int
	 */
	protected function _create($name, $value)
	{
		return $this->call("ticket.type.create",
			array(
				$name,
				$value
			)
		);
	}
	
	/**
	 * Update ticket type with the given value.
	 * @param string $name
	 * @param string $value
	 * @return int
	 */
	protected function _update($name, $value)
	{
		return $this->call("ticket.type.update",
			array(
				$name,
				$value
			)
		);
	}
}