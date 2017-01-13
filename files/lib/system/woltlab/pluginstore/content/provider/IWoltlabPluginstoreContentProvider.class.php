<?php
namespace wcf\system\woltlab\pluginstore\content\provider;
use wcf\data\user\User;
use wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreContentProviderFile;

/**
 * Any pluginstore content provider should implement this interface.
 * 
 * @author	Dennis Kraffczyk
 * @copyright	2011-2017 KittMedia Productions
 * @license	Commercial <https://kittblog.com/board/licenses/free.html>
 * @package	com.kittmedia.wcf.pluginstoreverification
 */
interface IWoltlabPluginstoreContentProvider {
	/**
	 * Returns the name of this content provider for use in the
	 * content provider mapping form.
	 * @return	string
	 */
	public function __toString();
	
	/**
	 * Returns an array that reflects a list of selectable options.
	 * Example:
	 * 	array(
	 * 		uniqueID => description,
	 * 		…
	 * 	)
	 * @return	array<mixed>
	 */
	public function getSelectOptions();
	
	/**
	 * Returns true if this content provider is available
	 * @param	wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreContentProviderFile		$file		file for checking the accessible state
	 * @param	wcf\data\user\User								$user		optional user object
	 * @return	boolean
	 */
	public function isAccessible(WoltlabPluginstoreContentProviderFile $file, User $user);
	
	/**
	 * Returns true if this content provider is available.
	 * Or false if this content provider is not available.
	 * @return	boolean
	 */
	public function isAvailable();
	
	/**
	 * Provides the access to the related content.
	 * @param	wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreContentProviderFile		$file		file for checking the accessible state
	 * @param	wcf\data\user\User								$user		optional user object
	 */
	public function provideContent(WoltlabPluginstoreContentProviderFile $file, User $user);
}
