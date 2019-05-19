<?php
namespace wcf\system\woltlab\pluginstore\content\provider;
use wcf\data\object\type\ObjectTypeCache;
use wcf\system\SingletonFactory;

/**
 * Handles the woltlab plugin store content provider.
 * 
 * @author	Dennis Kraffczyk
 * @copyright	2011-2017 KittMedia Productions
 * @license	Commercial <https://kittblog.com/board/licenses/free.html>
 * @package	com.kittmedia.wcf.pluginstoreverification
 */
class WoltlabPluginstoreContentProviderHandler extends SingletonFactory {
	/**
	 * Name of the content provider object type definition
	 */
	const OBJECT_TYPE_DEFINITION = 'com.kittmedia.wcf.pluginstoreverification.content.provider';
	
	/**
	 * Available content provider
	 * @var		array<wcf\system\woltlab\pluginstore\content\provider\IWoltlabPluginstoreContentProvider>
	 */
	protected $availableContentProvider = null;
	
	/**
	 * Content provider object types
	 * @var		array<wcf\data\object\type\ObjectType>
	 */
	protected $contentProviderCache = null;
	
	/**
	 * @inheritdoc
	 */
	protected function init() {
		$this->contentProviderCache = ObjectTypeCache::getInstance()->getObjectTypes(static::OBJECT_TYPE_DEFINITION);
		
		foreach ($this->contentProviderCache as $objectTypeName => $contentProviderObjectType) {
			if ($contentProviderObjectType->getProcessor()->isAvailable()) {
				$this->availableContentProvider[$contentProviderObjectType->getObjectID()] = $contentProviderObjectType->getProcessor();
			}
			
			$this->contentProviderCache[$contentProviderObjectType->getObjectID()] = $contentProviderObjectType;
			unset($this->contentProviderCache[$objectTypeName]);
		}
	}
	
	/**
	 * Returns a list of available content provider.
	 * Content provider are available if their `isAvailable`–method returns `true`.
	 * @return	array<wcf\system\woltlab\pluginstore\content\provider\IWoltlabPluginstoreContentProvider>
	 */
	public function getAvailableContentProvider() {
		return $this->availableContentProvider;
	}
	
	/**
	 * Returns a content provider by its object type id or `null`
	 * if no content provider is registered by given `$objectTypeID`.
	 * @param	integer		$objectTypeID
	 * @return	wcf\system\woltlab\pluginstore\content\provider\IWoltlabPluginstoreContentProvider|null
	 */
	public function getContentProviderByObjectTypeID($objectTypeID) {
		if (isset($this->contentProviderCache[$objectTypeID])) {
			return $this->contentProviderCache[$objectTypeID]->getProcessor();
		}
		
		return null;
	}
}
