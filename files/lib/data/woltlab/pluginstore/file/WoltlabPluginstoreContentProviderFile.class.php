<?php
namespace wcf\data\woltlab\pluginstore\file;
use wcf\data\DatabaseObjectDecorator;
use wcf\system\woltlab\pluginstore\content\provider\WoltlabPluginstoreContentProviderHandler;

/**
 * Represents a woltlab pluginstore content provider file.
 * 
 * @author	Dennis Kraffczyk
 * @copyright	2011-2017 KittMedia Productions
 * @license	Commercial <https://kittblog.com/board/licenses/free.html>
 * @package	com.kittmedia.wcf.pluginstoreverification
 * @mixin	WoltlabPluginstoreFile
 * @method	WoltlabPluginstoreFile	getDecoratedObject()
 * @property-read	integer		$contentProviderObjectTypeID	id of the assigned `com.kittmedia.wcf.pluginstoreverification.content.provider` object type
 * @property-read	integer		$objectID			id of the assigned object
 */
class WoltlabPluginstoreContentProviderFile extends DatabaseObjectDecorator {
	/**
	 * @see		\wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreFile';
	
	/**
	 * Content provider
	 * @var		wcf\system\woltlab\pluginstore\content\provider\IWoltlabPluginstoreContentProvider|null
	 */
	protected $contentProvider = null;
	
	/**
	 * Returns the name of this file.
	 * @return	string
	 */
	public function __toString() {
		return $this->getDecoratedObject()->getTitle();
	}
	
	/**
	 * Returns the content provider of this file or `null`
	 * if no content provider is assigned to this file.
	 * @return	wcf\system\woltlab\pluginstore\content\provider\IWoltlabPluginstoreContentProvider|null
	 */
	public function getContentProvider() {
		if ($this->contentProvider === null) {
			if ($this->contentProviderObjectTypeID) {
				$this->contentProvider = WoltlabPluginstoreContentProviderHandler::getInstance()->getContentProviderByObjectTypeID($this->contentProviderObjectTypeID);
			}
		}
		
		return $this->contentProvider;
	}
	
	/**
	 * Returns the name of the content provider for this file.
	 * @return	string
	 */
	public function getContentProviderName() {
		if ($this->contentProviderObjectTypeID) {
			return $this->getContentProvider()->__toString();
		}
		
		return '';
	}
	
	/**
	 * Returns the name of the assigned object from the content provider
	 * of this file.
	 * @return	string
	 */
	public function getContentProviderObjectName() {
		if ($this->objectID) {
			$selectOptions = $this->getContentProvider()->getSelectOptions();
			return (isset($selectOptions[$this->objectID]) ? $selectOptions[$this->objectID] : '');
		}
		
		return '';
	}
}
