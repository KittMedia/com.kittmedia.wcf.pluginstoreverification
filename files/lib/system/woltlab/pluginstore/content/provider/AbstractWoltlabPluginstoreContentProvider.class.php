<?php
namespace wcf\system\woltlab\pluginstore\content\provider;
use wcf\data\user\User;
use wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreContentProviderFile;

/**
 * Provides a default implementation of a pluginstore content provider.
 * 
 * @author	Dennis Kraffczyk
 * @copyright	2011-2017 KittMedia Productions
 * @license	Commercial <https://kittblog.com/board/licenses/free.html>
 * @package	com.kittmedia.wcf.pluginstoreverification
 */
abstract class AbstractWoltlabPluginstoreContentProvider implements IWoltlabPluginstoreContentProvider {
	/**
	 * @inheritdoc
	 */
	public function __toString() {
		return '';
	}
	
	/**
	 * @inheritdoc
	 */
	public function getSelectOptions() {
		return [];
	}
	
	/**
	 * @inheritdoc
	 */
	public function isAccessible(WoltlabPluginstoreContentProviderFile $file, User $user) {
		return false;
	}
	
	/**
	 * @inheritdoc
	 */
	public function isAvailable() {
		return !empty($this->getSelectOptions());
	}
	
	/**
	 * @inheritdoc
	 */
	public abstract function provideContent(WoltlabPluginstoreContentProviderFile $file, User $user);
}
