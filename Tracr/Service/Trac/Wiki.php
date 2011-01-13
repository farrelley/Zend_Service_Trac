<?php

class Tracr_Service_Trac_Wiki extends Tracr_Service_Trac
{
	protected $_supportedMethods = array(
    	'getRecentChanges',
		'getRPCVersionSupported',
		'getPage',
		'getPageVersion',
		'getPageHTML',
		'getPageHTMLVersion',
		'getAllPages',
		'getPageInfo',
		'getPageInfoVersion',
		'putPage',
		'listAttachments',
		'getAttachment',
		'putAttachment',
		'putAttachmentEx',
		'deletePage',
		'deleteAttachment',
		'listLinks',
		'wikiToHtml'
    );
    
	public function __construct($username, $password, $instance)
	{
		parent::__construct($username, $password, $instance);
	}
	
	/**
	 * wiki.getRecentChanges
	 * 
	 * Get list of changed pages since timestamp.
	 * 
	 * @param string $since
	 * @return arary
	 */
	protected function _getRecentChanges($since) 
	{
		$zd = new Zend_Date($since);
		$date = $zd->toString(Zend_Date::ISO_8601);
		
		return $this->call("wiki.getRecentChanges", 
			array(
				new Zend_XmlRpc_Value_DateTime($date)
			)
		);
	}
	
	/**
	 * wiki.getRPCVersionSupported
	 * 
	 * Returns 2 with this version of the Trac API.	
	 * 
	 * @return int
	 */
	protected function _getRPCVersionSupported() 
	{
		return $this->call("wiki.getRPCVersionSupported");
	}
	
	/**
	 * wiki.getPage
	 * 
	 * Get the raw Wiki text of page, latest version.
	 * 
	 * @param string $pagename
	 * @param int $version
	 * @return string
	 */
	protected function _getPage($pagename, $version = null) 
	{
		return $this->call("wiki.getPage", 
			array(
				$pagename,
				$version
			)
		);
	}
	
	/**
	 * wiki.getPageVersion
	 * 
	 * Get the raw Wiki text of page, latest version.	
	 * 
	 * @param string $pagename
	 * @param int $version
	 * @return string
	 */
	protected function _getPageVersion($pagename, $version = null) 
	{
		return $this->call("wiki.getPageVersion", 
			array(
				$pagename,
				$version
			)
		);
	}
	
	/**
	 * wiki.getPageHTML
	 * 
	 * Return page in rendered HTML, latest version.	
	 * 
	 * @param string $pagename
	 * @param int $version
	 * @return string
	 */
	protected function _getPageHTML($pagename, $version = null) 
	{
		return $this->call("wiki.getPageHTML",
			array(
				$pagename,
				$version
			)
		);
	}
	
	/**
	 * wiki.getPageHTMLVersion
	 * 
	 * Return page in rendered HTML, latest version.	
	 * 
	 * @param string $pagename
	 * @param int $version
	 * @return string
	 */
	protected function _getPageHTMLVersion($pagename, $version = null) 
	{
		return $this->call("wiki.getPageHTMLVersion",
			array(
				$pagename,
				$version
			)
		);
	}
	
	/**
	 * wiki.getAllPages
	 * Returns a list of all pages. The result is an array of utf8 pagenames.	
	 * 
	 * @return array
	 */
	protected function _getAllPages() 
	{
		return $this->call("wiki.getAllPages");
	}
	
	/**
	 * wiki.getPageInfo
	 * 
	 * Returns information about the given page.	
	 * 
	 * @param string $pagename
	 * @param int $version
	 * @return array
	 */
	protected function _getPageInfo($pagename, $version = null) 
	{
		return $this->call("wiki.getPageInfo",
			array(
				$pagename,
				$version
			)
		);
	}
	
	/**
	 * wiki.getPageInfoVersion
	 * 
	 * Returns information about the given page.	
	 * 
	 * @param string $pagename
	 * @param int $version
	 * @return array
	 */
	protected function _getPageInfoVersion($pagename, $version = null) 
	{
		return $this->call("wiki.getPageInfoVersion",
			array(
				$pagename,
				$version
			)
		);
	}
	
	/**
	 * wiki.putPage
	 * 
	 * writes the content of the page.	
	 * 
	 * @param string $pagename
	 * @param string $content
	 * @param array $attr
	 * @return bool
	 */
	protected function _putPage($pagename, $content, array $attr = array()) 
	{
		return $this->call("wiki.putPage", 
			array(
				$pagename,
				$content,
				new Zend_XmlRpc_Value_Struct($attr)
			)
		);
	}
	
	/**
	 * wiki.listAttachments
	 * 
	 * Lists attachments on a given page.
	 * 
	 * @param string $pagename
	 * @return array
	 * 
	 */
	protected function _listAttachments($pagename)
	{
		return $this->call("wiki.listAttachments", array($pagename));
	}
	
	/**
	 * wiki.getAttachment
	 * 
	 * returns the content of an attachment.
	 * 
	 * @param string $path
	 * @return array
	 */
	protected function _getAttachment($path) 
	{
		return $this->call("wiki.getAttachment", array($path));
	}
	
	/**
	 * wiki.putAttachment
	 * 
	 * (over)writes an attachment. Returns True if successful. This method is compatible 
	 * with WikiRPC. putAttachmentEx has a more extensive set of (Trac-specific) features.
	 * 
	 * @param string $path
	 * @param string $data Must be base64_encoded
	 * @return bool
	 */
	protected function _putAttachment($path, $data) 
	{
		return $this->call("wiki.putAttachment",
			array(
				$path,
				new Zend_XmlRpc_Value_Base64($data)
			)
		);
	}
	
	/**
	 * wiki.putAttachmentEx 
	 * 
	 * Attach a file to a Wiki page. Returns the (possibly transformed) filename of 
	 * the attachment. Use this method if you don't care about WikiRPC compatibility.	
	 * 
	 * @param string $pagename
	 * @param string $filename
	 * @param string $description
	 * @param string $data Must be base64_encoded
	 * @param bool $replace
	 * @return bool
	 */
	protected function _putAttachmentEx($pagename, $filename, $description, $data, $replace = true) 
	{
		return $this->call("wiki.putAttachmentEx",
			array(
				$pagename,
				$filename,
				$description,
				new Zend_XmlRpc_Value_Base64($data),
				$replace
			)
		);
	}
	
	/**
	 * wiki.deletePage
	 * 
	 * Delete a Wiki page (all versions) or a specific version by including an optional 
	 * version number. Attachments will also be deleted if page no longer exists. 
	 * Returns True for success.	
	 * 
	 * @param string $name
	 * @param int $version
	 * @return bool
	 */
	protected function _deletePage($name, $version = null) 
	{
		return $this->call("wiki.deletePage",
			array(
				$name,
				$version
			)
		);
	}
	
	/**
	 * wiki.deleteAttachment
	 * 
	 * Delete an attachment.
	 * 
	 * @param string $path
	 * @return bool
	 */
	protected function _deleteAttachment($path) 
	{
		return $this->call("wiki.deleteAttachment", array($path));
	}
	
	/**
	 * wiki.listLinks
	 * 
	 * Not implemented
	 * 
	 * @param string $pagename
	 * @return array
	 */
	protected function _listLinks($pagename) 
	{
		return $this->call("wiki.listLinks", array($pagename));
	}
	
	/**
	 * wiki.wikiToHtml
	 * 
	 * Render arbitrary Wiki text as HTML.
	 * 	
	 * @param string $text
	 * @return string
	 */
	protected function _wikiToHtml($text) 
	{
		return $this->call("wiki.wikiToHtml", array($text));
	}
}