<?php

class Tracr_Service_Trac_Ticket extends Tracr_Service_Trac
{
	protected $_supportedMethods = array(
		'query',
		'getRecentChanges',
		'getActions',
		'get',
		'create',
		'update',
		'delete',
		'changeLog',
		'listAttachments',
		'getAttachment',
		'putAttachment',
		'deleteAttachment',
		'getTicketFields'
	);
	
	public function __construct($username, $password, $instance)
	{
		parent::__construct($username, $password, $instance);
	}
	
	/**
	 * ticket.query
	 * 
	 * Perform a ticket query, returning a list of ticket ID's.	
	 * 
	 * @param string $qryString
	 * @return array
	 */
	protected function _query($qryString)
	{
		return $this->call("ticket.query", array($qryString));
	}
	
	/**
	 * @fixme
	 * ticket.getRecentChanges
	 * 
	 * Returns a list of IDs of tickets that have changed since timestamp.
	 * 
	 * @param string $since
	 * @return array
	 */
	protected function _getRecentChanges($since)
	{
		$zd = new Zend_Date($since);
		$date = $zd->toString(Zend_Date::ISO_8601);
		return $this->call("ticket.getRecentChanges", 
			array(
				new Zend_XmlRpc_Value_DateTime($date)
			)
		);
	}
	
	/**
	 * ticket.getActions
	 * 
	 * Returns the actions that can be performed on the ticket as a list of 
	 * [action, label, hints, [input_fields]] elements, where input_fields is a list of 
	 * [name, value, [options]] for any required action inputs.
	 * 
	 * @param int $id
	 * @return array
	 */
	protected function _getActions($id)
	{
		return $this->call("ticket.getActions", array($id));	
	}
	
	/**
	 * ticket.get
	 * 
	 * Fetch a ticket. Returns [id, time_created, time_changed, attributes].
	 * 
	 * @param int $id
	 * @return array
	 */
	protected function _get($id)
	{
		return $this->call("ticket.get", array($id));
	}
	
	/**
	 * ticket.create
	 * 
	 * Create a new ticket, returning the ticket ID.
	 * 
	 * @param string $summary
	 * @param string $description
	 * @param array $attr
	 * @param bool $notify
	 * @return int
	 */
	protected function _create($summary, $description, array $attr = array(), $notify = false)
	{
		return $this->call("ticket.create", 
			array(
				$summary,
				$description,
				new Zend_XmlRpc_Value_Struct(
					$attr
				),
				$notify
			)
		);
	}
	
	/**
	 * ticket.update
	 * 
	 * Update a ticket, returning the new ticket in the same form as getTicket(). Requires 
	 * a valid 'action' in attributes to support workflow.	
	 * 
	 * @param int $id
	 * @param string $comment
	 * @param array $attr
	 * @param bool $notify
	 * @return array
	 */
	protected function _update($id, $comment, array $attr = array(), $notify = false)
	{
		return $this->call("ticket.update", 
			array(
				$id, 
				$comment, 
				new Zend_XmlRpc_Value_Struct(
					$attr
				),
				$notify
			)
		);
	}
	
	/**
	 * tickets.delete
	 * 
	 * Delete ticket with the given id.
	 * 
	 * @param int $id
	 * @return int
	 */
	protected function _delete($id)
	{
		return $this->call("ticket.delete", array($id));
	}
	
	/**
	 * ticket.changeLog
	 * 
	 * Return the changelog as a list of tuples of the form (time, author, field, 
	 * oldvalue, newvalue, permanent). While the other tuple elements are quite 
	 * self-explanatory, the permanent flag is used to distinguish collateral changes 
	 * that are not yet immutable (like attachments, currently).	
	 * 
	 * @param int $id
	 * @param int $when
	 * @return array
	 */
	protected function _changeLog($id, $when = 0)
	{
		return $this->call("ticket.changeLog", 
			array(
				(int) $id, 
				(int) $when
			)
		);
	}
	
	/**
	 * ticket.listAttachments
	 * 
	 * Lists attachments for a given ticket. Returns (filename, description, size, 
	 * time, author) for each attachment.
	 * 
	 * @param int $id
	 * @return array
	 */
	protected function _listAttachments($id)
	{
		return $this->call("ticket.listAttachments", 
			array(
				(int) $id
			)
		);
	}
	
	/**
	 * ticket.getAttachment
	 * 
	 * returns the content of an attachment.
	 * 
	 * @param string $ticket
	 * @param string $filename
	 * @return string base64
	 */
	protected function _getAttachment($ticket, $filename)
	{
		return $this->call("ticket.getAttachment", 
			array(
				$ticket,
				$filename
			)
		);
	}
	
	/**
	 * ticket.putAttachment
	 * 
	 * Add an attachment, optionally (and defaulting to) overwriting an existing one. 
	 * Returns filename.	
	 * 
	 * @param int $ticket id of the ticket 
	 * @param string $filename
	 * @param string $description
	 * @param string $data This must be base64_encoded
	 * @param bool $replace defaults true
	 * @return string
	 */
	protected function _putAttachment($ticket, $filename, $description, $data, $replace = true)
	{
		return $this->call("ticket.putAttachment",
			array(
				$ticket,
				$filename,
				$description,
				new Zend_XmlRpc_Value_Base64($data),
				$replace
			)
		);
	}
	
	/**
	 * ticket.deleteAttachment
	 * 
	 * Delete an attachment.	
	 * 
	 * @param int $ticket Id of the Ticket
	 * @param string $filename
	 * @return bool
	 */
	protected function _deleteAttachment($ticket, $filename)
	{
		return $this->call("ticket.deleteAttachment",
			array(
				$ticket,
				$filename
			)
		);
	}
	
	/**
	 * ticket.getTicketFields
	 * 
	 * Return a list of all ticket fields fields.	
	 * 
	 * @return array
	 */
	protected function _getTicketFields() 
	{
		return $this->call("ticket.getTicketFields");
	}
	
}