<?php
namespace wcf\form;
use wcf\system\api\woltlab\vendor\WoltlabVendorAPI;
use wcf\system\exception\HTTPServerErrorException;
use wcf\system\exception\HTTPUnauthorizedException;
use wcf\system\exception\NamedUserException;
use wcf\system\exception\UserInputException;
use wcf\system\cache\builder\WoltlabPluginstoreVerificationFileCacheBuilder;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Represents the WoltLab(R) plugin store verification form.
 * 
 * @author	Dennis Kraffczyk, Matthias Kittsteiner
 * @copyright	2011-2018 KittMedia
 * @license	Commercial <https://kittmedia.com/licenses/#licenseFree>
 * @package	com.kittmedia.wcf.pluginstoreverification
 * @category	Community Framework
 */
class WoltlabPluginStoreVerificationForm extends AbstractForm {
	/**
	 * @inheritdoc
	 */
	public $loginRequired = true;
	
	/**
	 * @inheritdoc
	 */
	public $neededModules = [
		'WOLTLAB_VENDOR_ID',
		'WOLTLAB_VENDOR_API_KEY'
	];
	
	/**
	 * List of available files
	 * @var		array<\wcf\data\woltlab\pluginstore\file\WoltlabPluginstoreContentProviderFile>
	 */
	public $availableFiles = [];
	
	/**
	 * buyers api key
	 * @var		string
	 */
	public $apiKey = '';
	
	/**
	 * Id of selected file
	 * @var		integer
	 */
	public $fileID = 0;
	
	/**
	 * Checks if the privacy information has been accepted.
	 * @var		boolean
	 */
	public $privacyAccept = false;
	
	/**
	 * Indicates if access to content will be denied or not
	 * @var		boolean
	 */
	public $provideAccess = false;
	
	/**
	 * buyers woltlabID
	 * @var		integer
	 */
	public $woltlabID = '';
	
	/**
	 * @inheritdoc
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign([
			'apiKey' => $this->apiKey,
			'availableFiles' => $this->availableFiles,
			'fileID' => $this->fileID,
			'privacyAccept' => $this->privacyAccept,
			'woltlabID' => $this->woltlabID
		]);
	}
	
	/**
	 * @inheritdoc
	 */
	public function readData() {
		$this->availableFiles = WoltlabPluginstoreVerificationFileCacheBuilder::getInstance()->getData([
			'languageID' => WCF::getLanguage()->getObjectID()
		]);
		
		foreach ($this->availableFiles as $fileID => $file) {
			if (!$file->getContentProvider()->isAccessible($file, WCF::getUser())) {
				unset($this->availableFiles[$fileID]);
			}
		}
		
		parent::readData();
	}
	
	/**
	 * @inheritdoc
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['apiKey'])) $this->apiKey = StringUtil::trim($_POST['apiKey']);
		if (isset($_POST['pluginstoreFileID'])) $this->fileID = intval($_POST['pluginstoreFileID']);
		if (isset($_POST['privacyAccept'])) $this->privacyAccept = boolval($_POST['privacyAccept']);
		if (isset($_POST['woltlabID'])) $this->woltlabID = intval($_POST['woltlabID']);
	}
	
	/**
	 * @inheritdoc
	 */
	public function validate() {
		parent::validate();
		
		if (!$this->privacyAccept) {
			throw new UserInputException('privacyAccept');
		}
		else if (empty($this->apiKey)) {
			throw new UserInputException('apiKey');
		}
		else if (empty($this->woltlabID)) {
			throw new UserInputException('woltlabID');
		}
		else if (empty($this->fileID)) {
			throw new UserInputException('pluginstoreFileID');
		}
		else if (!isset($this->availableFiles[$this->fileID])) {
			throw new UserInputException('pluginstoreFileID', 'invalid');
		}
		else {
			$file = $this->availableFiles[$this->fileID];
			if (!$file->getContentProvider()->isAccessible($file, WCF::getUser())) {
				throw new UserInputException('pluginstoreFileID', 'invalid');
			}
		}
		
		try {
			if (!($this->provideAccess = WoltlabVendorAPI::getInstance()->isPurchasedPluginStoreProduct($this->fileID, $this->woltlabID, $this->apiKey))) {
				throw new UserInputException('pluginstoreFileID', 'notPurchased');
			}
		}
		catch (HTTPServerErrorException $e) {
			if (ENABLE_DEBUG_MODE) {
				throw $e;
			}
			
			// log exception
			$e->getExceptionID();
			
			// show a userfriendly message instead
			throw new NamedUserException('wcf.woltlabapi.error.apiServerFailed');
		}
		catch (HTTPUnauthorizedException $e) {
			throw new UserInputException('woltlabID', 'invalid');
		}
	}
	
	/**
	 * @inheritdoc
	 */
	public function save() {
		parent::save();
		
		if ($this->provideAccess) {
			$file = $this->availableFiles[$this->fileID];
			$file->getContentProvider()->provideContent($file, WCF::getUser());
		}
		
		$this->apiKey = $this->woltlabID = '';
		$this->fileID = 0;
		$this->privacyAccept = false;
		
		WCF::getTPL()->assign('success', true);
		
		$this->saved();
	}
}
