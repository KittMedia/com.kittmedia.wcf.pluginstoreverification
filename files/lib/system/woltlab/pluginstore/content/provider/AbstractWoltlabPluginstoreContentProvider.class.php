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
	 * @see		\wcf\system\woltlab\pluginstore\content\provider\IWoltlabPluginStoreContentProvider::__toString()
	 */
	public function __toString() {
		return '';
	}
	
	/**
	 * @see		\wcf\system\woltlab\pluginstore\content\provider\IWoltlabPluginStoreContentProvider::getSelectOptions()
	 */
	public function getSelectOptions() {
		return [];
	}
	
	/**
	 * @see		\wcf\system\woltlab\pluginstore\content\provider\IWoltlabPluginStoreContentProvider::isAccessible()
	 */
	public function isAccessible(WoltlabPluginstoreContentProviderFile $file, User $user) {
		return false;
	}
	
	/**
	 * @see		\wcf\system\woltlab\pluginstore\content\provider\IWoltlabPluginStoreContentProvider::isAvailable()
	 */
	public function isAvailable() {
		return !empty($this->getSelectOptions());
	}
	
	/**
	 * @see		\wcf\system\woltlab\pluginstore\content\provider\IWoltlabPluginStoreContentProvider::provideContent()
	 */
	abstract function provideContent(WoltlabPluginstoreContentProviderFile $file, User $user);
}
