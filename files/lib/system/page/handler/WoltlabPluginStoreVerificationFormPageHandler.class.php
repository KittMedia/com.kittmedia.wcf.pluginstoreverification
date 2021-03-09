<?php
namespace wcf\system\page\handler;
use wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreContentProviderFile;
use wcf\system\cache\builder\WoltlabPluginstoreVerificationFileCacheBuilder;
use wcf\system\exception\SystemException;
use wcf\system\WCF;

/**
 * Implementation of IMenuPageHandler for the WoltlabPluginStoreVerificationForm.
 *
 * @author	Dennis Kraffczyk
 * @copyright	2011-2021 KittMedia
 * @license	Free <https://shop.kittmedia.com/core/licenses/#licenseFree>
 * @package	com.kittmedia.wcf.pluginstoreverification
 * @category	Suite Core
 * @since	2.2.2
 */
class WoltlabPluginStoreVerificationFormPageHandler extends AbstractMenuPageHandler {
	/**
	 * @inheritdoc
	 */
	public function isVisible($objectID = null) {
		return static::hasAvailableContent();
	}
	
	/**
	 * Returns `true` if the current user has content that can be provided.
	 * Otherwise `false` will be returned.
	 * @return	bool
	 * @throws	SystemException
	 */
	public static function hasAvailableContent() {
		/** @var WoltlabPluginstoreContentProviderFile[] $availableFiles */
		
		$availableFiles = WoltlabPluginstoreVerificationFileCacheBuilder::getInstance()->getData([
			'languageID' => WCF::getLanguage()->getObjectID()
		]);
		
		foreach ($availableFiles as $fileID => $file) {
			if (!$file->getContentProvider()->isAccessible($file, WCF::getUser())) {
				unset($availableFiles[$fileID]);
			}
		}
		
		return !empty($availableFiles);
	}
}
