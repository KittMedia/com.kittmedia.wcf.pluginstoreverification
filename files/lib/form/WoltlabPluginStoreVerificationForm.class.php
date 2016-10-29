<?php
namespace wcf\form;
use \wcf\system\exception\UserInputException;
use \wcf\system\woltlab\plugin\store\activation\content\provider\WoltlabPluginStoreActivationContentHandler;
use \wcf\system\WCF;
use \wcf\util\StringUtil;

/**
 * Represents the WoltLab(R) plugin store verification form.
 * 
 * @author	Dennis Kraffczyk
 * @copyright	2011-2016 KittMedia Productions
 * @license	Commercial <https://kittblog.com/board/licenses/free.html>
 * @package	com.kittmedia.wcf.pluginstoreverification
 * @category	Community Framework
 */
class WoltlabPluginStoreVerificationForm extends AbstractForm {
	/**
	 * @see		\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.header.menu.woltlabPluginStoreVerification';
	
	/**
	 * @see		\wcf\page\AbstractPage::$loginRequired
	 */
	public $loginRequired = true;
	
	/**
	 * @see		\wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array(
		'PLUGINSTOREVERIFICATION_VENDOR_ID',
		'PLUGINSTOREVERIFICATION_VENDOR_API_KEY'
	);
	
	/**
	 * List of available content
	 * @var		array<mixed>
	 */
	public $availableContentTree = array();
	
	/**
	 * buyers api key
	 * @var		string
	 */
	public $apiKey = '';
	
	/**
	 * Selected content value
	 * @var		string
	 */
	public $content = '';
	
	/**
	 * buyers woltlabID
	 * @var		integer
	 */
	public $woltlabID = '';
	
	/**
	 * @see		\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'apiKey' => $this->apiKey,
			'availableContentTree' => $this->availableContentTree,
			'content' => $this->content,
			'woltlabID' => $this->woltlabID
		));
	}
	
	/**
	 * @see		\wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		$contentProvider = WoltlabPluginStoreActivationContentHandler::getInstance()->getAvailableContentProvider();
		
		if (count($contentProvider) > 1) {
			foreach ($contentProvider as $provider) {
				$this->availableContentTree[$provider->getProviderName()] = $provider->getSelectOptionsArray();
			}
		}
		else {
			$this->availableContentTree = reset($contentProvider)->getSelectOptionsArray();
		}
	}
	
	/**
	 * @see		\wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['apiKey'])) $this->apiKey = StringUtil::trim($_POST['apiKey']);
		if (isset($_POST['content'])) $this->content = StringUtil::trim($_POST['content']);
		if (isset($_POST['woltlabID'])) $this->woltlabID = intval($_POST['woltlabID']);
	}
	
	/**
	 * @see		\wcf\form\IForm::validate()
	 */
	public function validate() {
		parent::validate();
		
		if (empty($this->apiKey)) {
			throw new UserInputException('apiKey');
		}
		else if (empty($this->woltlabID)) {
			throw new UserInputException('woltlabID');
		}
		
		$contentParts = explode('-', $this->content);
		if (!(count($contentParts) == 2)) {
			throw new UserInputException('content');
		}
		else if (($contentProvider = WoltlabPluginStoreActivationContentHandler::getInstance()->getContentProviderByObjectTypeName($contentParts[0])) == null) {
			throw new UserInputException('content', 'invalid');
		}
		else if (!array_key_exists($this->content, $contentProvider->getSelectOptionsArray())) {
			throw new UserInputException('content', 'invalid');
		}
	}
	
	/**
	 * @see		\wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();
		
		$this->saved();
	}
}
