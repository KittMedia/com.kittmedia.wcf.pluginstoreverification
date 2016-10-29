<?php
namespace wcf\system\woltlab\plugin\store\activation\content\provider;
use \wcf\data\object\type\ObjectTypeCache;
use \wcf\system\SingletonFactory;

/**
 * Handles all woltlab plugin store activation content provider.
 * 
 * @author	Dennis Kraffczyk
 * @copyright	2011-2016 KittMedia Productions
 * @license	Commercial <https://kittblog.com/board/licenses/commercial.html>
 * @package	com.kittmedia.wcf.pluginstoreverification
 * @category	Community Framework
 */
class WoltlabPluginStoreActivationContentHandler extends SingletonFactory {
	/**
	 * Name of object type definition
	 * @var		string
	 */
	const OBJECT_TYPE_DEFINITION = 'com.kittmedia.wcf.pluginstoreverification.content.provider';
	
	/**
	 * List of all available activation content provider for the active user.
	 * @var		array<\wcf\system\woltlab\plugin\store\activation\content\provider\IWoltlabPluginStoreActivationContentProvider>
	 */
	protected $availableActivationContentProvider = null;
	
	/**
	 * List of all installed activation content provider.
	 * @var		array<\wcf\system\woltlab\plugin\store\activation\content\provider\IWoltlabPluginStoreActivationContentProvider>
	 */
	protected $activationContentProvider = null;
	
	/**
	 * @see		\wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		$this->availableContentHandler = array();
		
		foreach (ObjectTypeCache::getInstance()->getObjectTypes(static::OBJECT_TYPE_DEFINITION) as $contentProviderObjectType) {
			$this->activationContentProvider[$contentProviderObjectType->objectType] = $contentProviderObjectType->getProcessor();
			
			if ($this->activationContentProvider[$contentProviderObjectType->objectType]->isAvailable()) {
				$this->availableActivationContentProvider[$contentProviderObjectType->objectType] = $this->activationContentProvider[$contentProviderObjectType->objectType];
			}
		}
	}
	
	/**
	 * Returns all available content provider.
	 * @return	array<\wcf\system\woltlab\plugin\store\activation\content\IWoltlabPluginStoreActivationContentProvider>
	 */
	public function getAvailableContentProvider() {
		return $this->availableActivationContentProvider;
	}
	
	/**
	 * Returns the content provider by its object type name or null
	 * if no content providers with given object type is registered.
	 * @param	string		 $objectTypeName
	 * @return	\wcf\system\woltlab\plugin\store\activation\content\IWoltlabPluginStoreActivationContentProvider|null
	 */
	public function getContentProviderByObjectTypeName($objectTypeName) {
		if (array_key_exists($objectTypeName, $this->availableActivationContentProvider)) {
			return $this->availableActivationContentProvider[$objectTypeName];
		}
		
		return null;
	}
}
