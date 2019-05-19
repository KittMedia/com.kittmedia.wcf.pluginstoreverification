<?php
namespace wcf\acp\form;
use wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreFile;
use wcf\form\AbstractForm;
use wcf\system\cache\builder\WoltlabPluginstoreVerificationFileCacheBuilder;
use wcf\system\database\util\PreparedStatementConditionBuilder;
use wcf\system\exception\UserInputException;
use wcf\system\woltlab\pluginstore\content\provider\WoltlabPluginstoreContentProviderHandler;
use wcf\system\WCF;
use wcf\util\ArrayUtil;

/**
 * Represents the woltlab vendor api pluginstore content provider file mapping form.
 * 
 * @author	Dennis Kraffczyk
 * @copyright	2011-2017 KittMedia Productions
 * @license	Commercial <https://kittblog.com/board/licenses/free.html>
 * @package	com.kittmedia.wcf.pluginstoreverification
 */
class WoltlabCustomerVendorAPIPluginstoreContentProviderFileEditForm extends AbstractForm {
	/**
	 * @see		\wcf\page\AbtractPage::$action
	 */
	public $action = 'edit';
	
	/**
	 * @see		\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.content.woltlabVendorAPI.pluginstoreVerificationContentProviderMappingList';
	
	/**
	 * @see		\wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'woltlabCustomerVendorAPIPluginstoreContentProviderFileEdit';
	
	/**
	 * List of available content provider
	 * @var		array<wcf\system\woltlab\pluginstore\content\provider\IWoltlabPluginstoreContentProvider>
	 */
	public $availableContentProvider = null;
	
	/**
	 * File
	 * @var		wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreFile
	 */
	public $file = null;
	
	/**
	 * File id
	 * @var		integer
	 */
	public $fileID = 0;
	
	/**
	 * ID of the content providers object type
	 * @var		integer
	 */
	public $contentProviderID = 0;
	
	/**
	 * List of selected options (not supported currently)
	 * @var		array<integer>
	 */
	public $contentProviderOption = [];
	
	/**
	 * Selected option id
	 * @var		integer
	 */
	public $contentProviderOptionID = '';
	
	/**
	 * @see		wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) $this->fileID = intval($_REQUEST['id']);
		
		$this->file = new WoltlabPluginstoreFile($this->fileID);
		if (!$this->file->getObjectID()) {
			throw new IllegalLinkException();
		}
	}
	
	/**
	 * @see		wcf\page\IPage::readData()
	 */
	public function readData() {
		$this->availableContentProvider[] = WCF::getLanguage()->get('wcf.global.language.noSelection');
		$this->availableContentProvider += WoltlabPluginstoreContentProviderHandler::getInstance()->getAvailableContentProvider();
		parent::readData();
		
		if (empty($_POST)) {
			// read current mapping
			$conditions = new PreparedStatementConditionBuilder();
			$conditions->add('fileID = ?', [$this->fileID]);
			
			$sql = "SELECT		*
				FROM		wcf".WCF_N."_woltlab_pluginstore_file_content_provider_mapping
				".$conditions;
			$statement = WCF::getDB()->prepareStatement($sql);
			$statement->execute($conditions->getParameters());
			
			if (!($row = $statement->fetchArray())) {
				$row = [
					'contentProviderObjectTypeID' => 0,
					'objectID' => 0
				];
			}
			
			$this->contentProviderID = $row['contentProviderObjectTypeID'];
			$this->contentProviderOptionID = $row['objectID'];
		}
	}
	
	/**
	 * @see		wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign([
			'availableContentProvider' => $this->availableContentProvider,
			'contentProviderID' => $this->contentProviderID,
			'contentProviderOptionID' => $this->contentProviderOptionID,
			'file' => $this->file,
			'fileID' => $this->file->getObjectID()
		]);
	}
	
	/**
	 * @see		wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['contentProviderID'])) $this->contentProviderID = intval($_POST['contentProviderID']);
		if (isset($_POST['contentProviderOption'])) $this->contentProviderOption = ArrayUtil::toIntegerArray($_POST['contentProviderOption']);
	}
	
	/**
	 * @see		wcf\form\IForm::validate()
	 */
	public function validate() {
		parent::validate();
		
		if ($this->contentProviderID) {
			if (!isset($this->availableContentProvider[$this->contentProviderID])) {
				throw new UserInputException('contentProviderID', 'invalid');
			}
			
			foreach ($this->contentProviderOption as $optionValue) {
				$this->contentProviderOptionID = $optionValue;
				// multiple options are not supported currently
				break;
			}
			
			if (!array_key_exists($this->contentProviderOptionID, $this->availableContentProvider[$this->contentProviderID]->getSelectOptions())) {
				throw new UserInputException('contentProviderOptionID'.$this->contentProviderID, 'invalid');
			}
		}
	}
	
	/**
	 * @see		wcf\form\IForm::validate()
	 */
	public function save() {
		parent::save();
		
		// delete all mapping entries from database
		$conditions = new PreparedStatementConditionBuilder();
		$conditions->add('fileID = ?', [$this->fileID]);
		$sql = "DELETE FROM	wcf".WCF_N."_woltlab_pluginstore_file_content_provider_mapping
			".$conditions;
		WCF::getDB()->prepareStatement($sql)->execute($conditions->getParameters());
		
		if ($this->contentProviderID) {
			$sql = "INSERT INTO	wcf".WCF_N."_woltlab_pluginstore_file_content_provider_mapping
						(fileID, contentProviderObjectTypeID, objectID)
				VALUES		(?, ?, ?)";
			$statement = WCF::getDB()->prepareStatement($sql);
			$statement->execute([
				$this->file->getObjectID(),
				$this->contentProviderID,
				$this->contentProviderOptionID
			]);
		}
		
		WoltlabPluginstoreVerificationFileCacheBuilder::getInstance()->reset();
		
		$this->saved();
		
		WCF::getTPL()->assign('success', true);
	}
}
