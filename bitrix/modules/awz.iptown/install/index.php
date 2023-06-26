<?
use Bitrix\Main\Localization\Loc,
    Bitrix\Main\EventManager,
    Bitrix\Main\ModuleManager,
    Bitrix\Main\Application;

Loc::loadMessages(__FILE__);

class awz_iptown extends CModule
{
	var $MODULE_ID = "awz.iptown";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $PARTNER_NAME;
    var $PARTNER_URI;
    var $MODULE_GROUP_RIGHTS = "N";

    public function __construct()
    {
        $arModuleVersion = array();
        include(__DIR__.'/version.php');

        $dirs = explode('/',dirname(__DIR__ . '../'));
        $this->MODULE_ID = array_pop($dirs);
        unset($dirs);

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("AWZ_IPTOWN_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("AWZ_IPTOWN_MODULE_DESCRIPTION");
        $this->PARTNER_NAME = Loc::getMessage("AWZ_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("AWZ_PARTNER_URI");
		return true;
	}

    function DoInstall()
    {
        global $APPLICATION, $step;

        $this->InstallFiles();
        $this->InstallDB();
        $this->checkOldInstallTables();
        $this->InstallEvents();
        $this->createAgents();

        ModuleManager::RegisterModule($this->MODULE_ID);

        return true;
    }

    function DoUninstall()
    {
        $this->deleteAgents();
        ModuleManager::UnRegisterModule($this->MODULE_ID);
        return true;
        /*
        global $APPLICATION, $step;

        $step = intval($step);
        if($step < 2) {
            $APPLICATION->IncludeAdminFile(Loc::getMessage('AWZ_IPTOWN_INSTALL_TITLE'), $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'. $this->MODULE_ID .'/install/unstep.php');
        }
        elseif($step == 2) {
            if($_REQUEST['save'] != 'Y' && !isset($_REQUEST['save'])) {
                $this->UnInstallDB();
            }
            $this->UnInstallFiles();
            $this->UnInstallEvents();
            $this->deleteAgents();

            ModuleManager::UnRegisterModule($this->MODULE_ID);

            return true;
        }*/
    }

    function InstallDB()
    {
        return true;
    }

    function UnInstallDB()
    {
        return true;
    }

    function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    function InstallFiles()
    {
        return true;
    }

    function UnInstallFiles()
    {
        return true;
    }

    function createAgents() {
        CAgent::AddAgent(
            "\\Awz\\IpTown\\Geo::loadBase();",
            $this->MODULE_ID,
            "N",
            86400*7);
        return true;
    }

    function deleteAgents() {
        CAgent::RemoveAgent("\\Awz\\IpTown\\Geo::loadBase();", $this->MODULE_ID);
        return true;
    }

    function checkOldInstallTables(){

        return true;

    }
}