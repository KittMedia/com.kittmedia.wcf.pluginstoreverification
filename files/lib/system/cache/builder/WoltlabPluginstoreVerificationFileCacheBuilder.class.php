<?php
namespace wcf\system\cache\builder;
use wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreContentProviderFile;
use wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreFileList;
use wcf\system\WCF;

/**
 * Caches the pluginstore content provider files.
 * 
 * @author	Dennis Kraffczyk
 * @copyright	2011-2017 KittMedia Productions
 * @license	Commercial <https://kittblog.com/board/licenses/free.html>
 * @package	com.kittmedia.wcf.pluginstoreverification
 */
class WoltlabPluginstoreVerificationFileCacheBuilder extends AbstractCacheBuilder {
	/**
	 * @inheritdoc
	 */
	protected function rebuild(array $parameters) {
		$fileList = new WoltlabPluginstoreFileList();
		$fileList->decoratorClassName = WoltlabPluginstoreContentProviderFile::class;
		$fileList->sqlSelects .= 'mapping.*';
		$fileList->sqlJoins .= 'LEFT JOIN wcf'.WCF_N.'_woltlab_pluginstore_file_content_provider_mapping mapping
						ON (mapping.fileID = woltlab_pluginstore_file.fileID)';
		$fileList->sqlConditionJoins = $fileList->sqlJoins;
		$fileList->getConditionBuilder()->add('woltlab_pluginstore_file.isDisabled = ?', [0]);
		$fileList->getConditionBuilder()->add('mapping.contentProviderObjectTypeID IS NOT NULL');
		$fileList->readObjects();
		$files = $fileList->getObjects();
		
		// sort by name
		uasort($files, function($fileA, $fileB) {
			if (WCF::getLanguage()->get($fileA->name) == WCF::getLanguage()->get($fileB->name)) {
				return 0;
			}
			else if (WCF::getLanguage()->get($fileA->name) < WCF::getLanguage()->get($fileB->name)) {
				return -1;
			}
			else {
				return 1;
			}
		});
		
		return $files;
	}
}
