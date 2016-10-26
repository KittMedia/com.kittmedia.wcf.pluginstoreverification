<?php
namespace wcf\system\woltlab\plugin\store\activation\content\provider;

/**
 * Abstract implementation of IWoltlabPluginStoreActivationContentProvider.
 * Any content provider should extend this class.
 * 
 * @author	Dennis Kraffczyk
 * @copyright	2011-2016 KittMedia Productions
 * @license	Commercial <https://kittblog.com/board/licenses/commercial.html>
 * @package	com.kittmedia.wcf.pluginstoreverification
 * @category	Community Framework
 */
abstract class AbstractWoltlabPluginStoreActivationContentProvider implements IWoltlabPluginStoreActivationContentProvider {
	/**
	 * Returns an identifier for the values of this content provider.
	 * A good identifier could be the name of the object type.
	 * 
	 * @return	string
	 */
	abstract public function getContentProviderIdentifier();
	
	/**
	 * @see		\wcf\system\woltlab\plugin\store\activation\content\provider\IWoltlabPluginStoreActivationContentProvider::getSelectOptionsArray()
	 */
	public function getSelectOptionsArray() {
		return array();
	}
	
	/**
	 * @see		\wcf\system\woltlab\plugin\store\activation\content\provider\IWoltlabPluginStoreActivationContentProvider::isAvailable()
	 */
	public function isAvailable() {
		return !empty($this->getSelectOptionsArray());
	}
}
