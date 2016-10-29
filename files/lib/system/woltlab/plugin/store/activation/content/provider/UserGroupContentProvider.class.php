<?php
namespace wcf\system\woltlab\plugin\store\activation\content\provider;
use \wcf\system\cache\builder\UserGroupCacheBuilder;

/**
 * Provides user groups as activatable content.
 * 
 * @author	Dennis Kraffczyk
 * @copyright	2011-2016 KittMedia Productions
 * @license	Commercial <https://kittblog.com/board/licenses/commercial.html>
 * @package	com.kittmedia.wcf.pluginstoreverification
 * @category	Community Framework
 */
class UserGroupContentProvider extends AbstractWoltlabPluginStoreActivationContentProvider {
	/**
	 * @see		\wcf\system\woltlab\plugin\store\activation\content\provider\IWoltlabPluginStoreActivationContentProvider:: getContentProviderIdentifier()
	 */
	public function getContentProviderIdentifier() {
		return 'com.kittmedia.wcf.pluginstoreverification.content.provider.user.group';
	}
	
	/**
	 * @see		\wcf\system\woltlab\plugin\store\activation\content\provider\IWoltlabPluginStoreActivationContentProvider:: getSelectOptionsArray()
	 */
	public function getSelectOptionsArray() {
		$selectOptions = array();
		
		foreach (UserGroupCacheBuilder::getInstance()->getData(array(), 'groups') as $userGroup) {
			if ($userGroup->getGroupOption('user.pluginstoreverification.enable') && !$userGroup->isMember()) {
				if (!$userGroup->getGroupOption('user.pluginstoreverification.pluginStoreFileID') || !$userGroup->getGroupOption('user.pluginstoreverification.pluginStorePackageName')) {
					continue;
				}
				
				$selectOptions[$this->getContentProviderIdentifier().'-'.$userGroup->getGroupOption('user.pluginstoreverification.pluginStoreFileID')] = $userGroup->getGroupOption('user.pluginstoreverification.pluginStorePackageName');
			}
		}
		
		return $selectOptions;
	}
}
