<?php
/***********************************************************************************************
** The contents of this file are subject to the Vtiger Module-Builder License Version 1.3
 * ( "License" ); You may not use this file except in compliance with the License
 * The Original Code is:  Technokrafts Labs Pvt Ltd
 * The Initial Developer of the Original Code is Technokrafts Labs Pvt Ltd.
 * Portions created by Technokrafts Labs Pvt Ltd are Copyright ( C ) Technokrafts Labs Pvt Ltd.
 * All Rights Reserved.
**
*************************************************************************************************/

/**
 * CREATED BY SANDY GORERAZA USING PHPSTORM 2021.3.2
 * Below is a custom Library for creating Entity Module for Vtiger Framework
 * It follows all coding guidlines from https://crmtiger.com/ and https://www.vtiger.com/developers/
 *
 *
 *
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';

echo '<html><head><title>vtlib Module Script</title>';
echo '<style type="text/css">@import url("themes/oxygen/style.css");br { display: block; margin: 2px; }</style>';
echo '</head><body class=small style="font-size: 12px; margin: 2px; padding: 2px;">';
echo '<style>.log{ font-size:20px  !important ;}</style>';
echo '<a href="index.php"><img src="themes/oxygen/images/loading.gif" alt="vtiger CRM" title="vtiger CRM" border=0></a><hr style="height: 1px">';

include_once('vtlib/Vtiger/Module.php');
//require_once('vtlib/Vtiger/Language.php');
require_once('vtlib/Vtiger/Package.php');
include_once 'includes/main/WebUI.php';

include_once 'include/Webservices/Utils.php';


// Turn on debugging level
echo "<div class='log'>";
$Vtiger_Utils_Log = true;
echo "</div>";

//Module name instance for vtiger NB : NO SPACING OF WHITE SPACE

$CUSTOMNAME = '<MODULENAME>';
//Custome fields associated with Module name above
$ModuleFieldsType = array('First name','Last name','National ID','Company','Home Address','Phone number','Email Address','Nationality');

//$ModuleFieldsType = array('First name');



$moduleInstance = new Vtiger_Module();
$moduleInstance->name = $CUSTOMNAME;


//$menuInstance = Vtiger_Menu::getInstance('Tools');//Chose Tools menu Tab as parent for the new module
//$menuInstance->addModule($moduleInstance); //API will create menu item which serves as UI entry point for the module
$moduleInstance->parent = "Support";
$moduleInstance->save();

//DB SCHEMA SETUP
$moduleInstance->initTables();

// Webservice Setup note: when the module is imported the Webservice initialize API is automatically invoked
$moduleInstance->initWebservice();


///Module container which holds the fields together instance
$blockInstance = new Vtiger_Block();
$blockInstance->label = ''.strtoupper($CUSTOMNAME).' '.'INFORMATION';
$moduleInstance->addBlock($blockInstance);

//LBL_CUSTOM_INFORMATION block should always be created to support Custom Fields for a module
$blockInstance2 = new Vtiger_Block();
$blockInstance2->label = 'LBL_CUSTOM_INFORMATION';
$moduleInstance->addBlock($blockInstance2);

// Module Filter Setup
$filter1 = new Vtiger_Filter();
$filter1->name = 'All';
$filter1->isdefault = true;
$moduleInstance->addFilter($filter1);

foreach ($ModuleFieldsType as $MFields)
{
 $fieldInstanceInstance = new vtiger_Field();
 $fieldInstanceInstance->name = str_replace(' ', '', $MFields);
 $fieldInstanceInstance->table = $moduleInstance->basetable;
 $fieldInstanceInstance->label = $MFields; 
 $fieldInstanceInstance->column = strtolower($fieldInstanceInstance->name);
 $fieldInstanceInstance->columntype = 'VARCHAR(100)';
 $fieldInstanceInstance->uitype = 1;
 $fieldInstanceInstance->displaytype = 1;
 $fieldInstanceInstance->presence = 2;
 $fieldInstanceInstance->typeofdata = 'V~M';

 $blockInstance->addField($fieldInstanceInstance);///write column name to table

}

###create manditory additional fields ###
$fieldInstance = new Vtiger_Field();
$fieldInstance->name = 'assigned_user_id';
$fieldInstance->label = 'Assigned To';
$fieldInstance->table = 'vtiger_crmentity';
$fieldInstance->column = 'smownerid';
$fieldInstance->uitype = 53;
$fieldInstance->displaytype = 1;
$fieldInstance->presence = 2;
$fieldInstance->typeofdata = 'V~M';
$blockInstance->addField($fieldInstance);

$fieldInstance = new Vtiger_Field();
$fieldInstance->name = 'createdtime';
$fieldInstance->label = 'Created Time';
$fieldInstance->table = 'vtiger_crmentity';
$fieldInstance->column = 'createdtime';
$fieldInstance->displaytype = 2;
$fieldInstance->uitype = 70;
$fieldInstance->typeofdata = 'D~O';
$blockInstance->addField($fieldInstance);

$fieldInstance = new Vtiger_Field();
$fieldInstance->name = 'modifiedtime';
$fieldInstance->label = 'Modified Time';
$fieldInstance->table = 'vtiger_crmentity';
$fieldInstance->column = 'modifiedtime';
$fieldInstance->displaytype = 2;
$fieldInstance->uitype = 70;
$fieldInstance->typeofdata = 'D~O';
$blockInstance->addField($fieldInstance);
###create manditory additional fields ###

####Sharing Access Setup accepted values <PERMISSION_TYPE> Public_ReadOnly,Public_ReadWrite,Public_ReadWriteDelete;
$moduleInstance->setDefaultSharing('Public');



#################necessary module files and folders START#############
$targetpath = 'modules/' . $moduleInstance->name;

if (! is_file($targetpath)) {
    mkdir($targetpath);

    $templatepath = 'vtlib/ModuleDir/6.0.0';

    $moduleFileContents = file_get_contents($templatepath . '/ModuleName.php');
    $field1 ="";
    $replacevars = array(
        'ModuleName' => $moduleInstance->name,
        '<modulename>' => strtolower($moduleInstance->name),
        '<entityfieldlabel>' => $field1->label,
        '<entitycolumn>' => $field1->column,
        '<entityfieldname>' => $field1->name
    );

    foreach ($replacevars as $key => $value) {
        $moduleFileContents = str_replace($key, $value, $moduleFileContents);
    }
    file_put_contents($targetpath . '/' . $moduleInstance->name . '.php', $moduleFileContents);
}

if (! file_exists('languages/en_us/ModuleName.php')) {
    $ModuleLanguageContents = file_get_contents($templatepath . '/languages/en_us/ModuleName.php');

    $replaceparams = array(
        'Module Name' => $moduleInstance->name,
        'Custom' => $moduleInstance->name,
        'ModuleBlock' => $moduleInstance->name,
        'ModuleFieldLabel Text' => $field1->label
    );

    foreach ($replaceparams as $key => $value) {
        $ModuleLanguageContents = str_replace($key, $value, $ModuleLanguageContents);
    }

    $languagePath = 'languages/en_us';
    file_put_contents($languagePath . '/' . $moduleInstance->name . '.php', $ModuleLanguageContents);
}

Settings_MenuEditor_Module_Model::addModuleToApp($moduleInstance->name, $moduleInstance->parent);
#################necessary module files and folders END#############


#####vtlib API to export language pack as a Zip package which can be used for importing through Module Manager
$package = new Vtiger_Package();
$package->export(
    Vtiger_Module::getInstance($moduleInstance->name),
    'test/vtlib',
    $moduleInstance->name.''.'_'.'.zip',
    false////if you want direct download from the browser set API to true
);

echo $moduleInstance->name." is Created";
echo '</body></html>';
