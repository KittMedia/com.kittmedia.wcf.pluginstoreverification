<?php
namespace wcf\acp\page;
use wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreContentProviderFile;
use wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreFileList;
use wcf\page\SortablePage;

/**
 * Represents the woltlab vendor api pluginstore verification content provider
 * mapping list page.
 * 
 * @author	Dennis Kraffczyk
 * @copyright	2011-2017 KittMedia Productions
 * @license	Commercial <https://kittblog.com/board/licenses/free.html>
 * @package	com.kittmedia.wcf.pluginstoreverification
 * @property	WoltlabPluginstoreFileList	$objectList
 */
class WoltlabCustomerVendorAPIPluginstoreVerificationContentProviderMappingListPage extends SortablePage {
	/**
	 * @inheritdoc
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.content.woltlabVendorAPI.pluginstoreVerificationContentProviderMappingList';
	
	/**
	 * @inheritdoc
	 */
	public $defaultSortField = 'woltlab_pluginstore_file.fileID';
	
	/**
	 * @inheritdoc
	 */
	public $objectListClassName = WoltlabPluginstoreFileList::class;
	
	/**
	 * @inheritdoc
	 */
	public $validSortFields = ['woltlab_pluginstore_file.fileID'];
	
	/**
	 * @inheritdoc
	 */
	protected function initObjectList() {
		parent::initObjectList();
		
		$this->objectList->decoratorClassName = WoltlabPluginstoreContentProviderFile::class;
		$this->objectList->sqlSelects .= 'mapping.*';
		$this->objectList->sqlJoins .= 'LEFT JOIN wcf'.WCF_N.'_woltlab_pluginstore_file_content_provider_mapping mapping
						ON (mapping.fileID = woltlab_pluginstore_file.fileID)';
		$this->objectList->getConditionBuilder()->add('woltlab_pluginstore_file.isDisabled = ?', [0]);
	}
}
