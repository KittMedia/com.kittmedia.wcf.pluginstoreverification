<?php
namespace wcf\system\woltlab\pluginstore\content\provider;
use wcf\data\user\group\UserGroup;
use wcf\data\user\User;
use wcf\data\user\UserAction;
use wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreContentProviderFile;
use wcf\system\cache\builder\UserGroupCacheBuilder;
use wcf\system\WCF;

/**
 * User group content provider.
 * 
 * @author	Dennis Kraffczyk
 * @copyright	2011-2017 KittMedia Productions
 * @license	Commercial <https://kittblog.com/board/licenses/free.html>
 * @package	com.kittmedia.wcf.pluginstoreverification
 */
class UserGroupContentProvider extends AbstractWoltlabPluginstoreContentProvider {
	/**
	 * @inheritdoc
	 */
	public function __toString() {
		return WCF::getLanguage()->get('wcf.woltlabapi.pluginstore.contentProvider.userGroup');
	}
	
	/**
	 * @inheritdoc
	 */
	public function getSelectOptions() {
		return UserGroupCacheBuilder::getInstance()->getData([], 'groups');
	}
	
	/**
	 * @inheritdoc
	 */
	public function isAccessible(WoltlabPluginstoreContentProviderFile $file, User $user = null) {
		$userGroup = new UserGroup($file->objectID);
		return !$userGroup->isMember($user);
	}
	
	/**
	 * @inheritdoc
	 */
	public function provideContent(WoltlabPluginstoreContentProviderFile $file, User $user) {
		$userAction = new UserAction([$user], 'addToGroups', [
			'addDefaultGroups' => false,
			'deleteOldGroups' => false,
			'groups' => [$file->objectID]
		]);
		$userAction->executeAction();
	}
}
