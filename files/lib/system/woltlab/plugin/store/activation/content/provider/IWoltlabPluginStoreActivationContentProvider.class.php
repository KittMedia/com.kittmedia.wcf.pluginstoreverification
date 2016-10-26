<?php
namespace wcf\system\woltlab\plugin\store\activation\content\provider;

/**
 * Any woltlab plugin store activation content provider should implement this interface.
 * 
 * @author	Dennis Kraffczyk
 * @copyright	2011-2016 KittMedia Productions
 * @license	Commercial <https://kittblog.com/board/licenses/commercial.html>
 * @package	com.kittmedia.wcf.pluginstoreverification
 * @category	Community Framework
 */
interface IWoltlabPluginStoreActivationContentProvider {
	/**
	 * Returns an array with the identifier of this content provider and the
	 * identifier of the selectable option as key. The content provider
	 * identifier and the selectable option identifier (WOLTLAB-FILE-ID)
	 * are separated by a hyphen.
	 * 
	 * The value should be a language variable.
	 * 
	 * Example of the array:
	 *	- com.example.myfancycontentprovider-WOLTLAB-FILE-ID => com.example.my.langvar
	 * 
	 * @return	array<mixed>
	 */
	public function getSelectOptionsArray();
	
	/**
	 * Returns true if this content provider is available for the current user.
	 * Otherwise false will be returned.
	 * @return	boolean
	 */
	public function isAvailable();
}
