<?php
namespace wcf\acp\page;
use wcf\page\SortablePage;

/**
 * Represents the woltlab vendor api pluginstore verification content provider
 * mapping list page.
 * 
 * @author	Dennis Kraffczyk
 * @copyright	2011-2017 KittMedia Productions
 * @license	Commercial <https://kittblog.com/board/licenses/free.html>
 * @package	com.kittmedia.wcf.pluginstoreverification
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
	public $objectListClassName = 'wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreFileList';
	
	/**
	 * @inheritdoc
	 */
	public $validSortFields = ['woltlab_pluginstore_file.fileID'];
	
	/**
	 * @inheritdoc
	 */
	protected function initObjectList() {
		parent::initObjectList();
		
		$this->objectList->decoratorClassName = 'wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreContentProviderFile';
		$this->objectList->sqlSelects .= 'mapping.*';
		$this->objectList->sqlJoins .= 'LEFT JOIN wcf'.WCF_N.'_woltlab_pluginstore_file_content_provider_mapping mapping
						ON (mapping.fileID = woltlab_pluginstore_file.fileID)';
		$this->objectList->getConditionBuilder()->add('woltlab_pluginstore_file.isDisabled = ?', [0]);
	}
}
