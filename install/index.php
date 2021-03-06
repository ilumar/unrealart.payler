<?
IncludeModuleLangFile(__FILE__);
Class unrealart_payler extends CModule
{
	const MODULE_ID = 'unrealart.payler';
	var $MODULE_ID = 'unrealart.payler';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $strError = '';

	function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__)."/version.php");
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = GetMessage("payler.payment_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("payler.payment_MODULE_DESC");

		$this->PARTNER_NAME = GetMessage("payler.payment_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("payler.payment_PARTNER_URI");
	}

	function rmFolder($dir) {
		foreach(glob($dir . '/*') as $file) {
			if(is_dir($file)){
				$this->rmFolder($file);
			} else {
				$r = unlink($file);
			}
		}
		rmdir($dir);
		return true;
	}

	function copyDir( $source, $destination ) {
		if ( is_dir( $source ) ) {
			@mkdir( $destination, 0755 );
			$directory = dir( $source );
			while ( FALSE !== ( $readdirectory = $directory->read() ) ) {
				if ( $readdirectory == '.' || $readdirectory == '..' ) continue;
				$PathDir = $source . '/' . $readdirectory; 
				if ( is_dir( $PathDir ) ) {
					$this->copyDir( $PathDir, $destination . '/' . $readdirectory );
					continue;
				}
			copy( $PathDir, $destination . '/' . $readdirectory );
			}
			$directory->close();
		} else {
			copy( $source, $destination );
		}
	}

	function InstallFiles($arParams = array())
	{
		if (is_dir($source = $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.self::MODULE_ID.'/install')) {
            $this->copyDir( $source."/payment", $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/include/sale_payment/');
            $this->copyDir( $source."/tools", $_SERVER['DOCUMENT_ROOT'].'/bitrix/tools/');
		}
		return true;
	}

	function UnInstallFiles()
	{
        $this->rmFolder($_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/include/sale_payment/payler/');
        $this->rmFolder($_SERVER['DOCUMENT_ROOT'].'/bitrix/tools/payler/');
		return true;
	}

	function DoInstall()
	{
		global $APPLICATION;
		$this->InstallFiles();
		RegisterModule(self::MODULE_ID);
	}

	function DoUninstall()
	{
		global $APPLICATION;
		UnRegisterModule(self::MODULE_ID);
		$this->UnInstallFiles();
	}
}
?>
