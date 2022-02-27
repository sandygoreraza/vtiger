<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

/**
 * CREATED BY SANDY GORERAZA USING PHPSTORM 2021.3.2
 * Below is a custom Library for creating Entity Module for Vtiger Framework
 * It follows all coding guidlines from https://crmtiger.com/ and https://www.vtiger.com/developers/
 */
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';

echo '<html><head><title>vtlib Module Script</title>';

echo '</head><body class=small style="font-size: 25px; margin: 2px; padding: 2px;">';

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

$CUSTOMNAME = 'Administration';



$moduleInstanceCustom = Vtiger_Module::getInstance($CUSTOMNAME);//Module Name


if(!$moduleInstanceCustom){


    $moduleInstance = new Vtiger_Module();
    $moduleInstance->name = $CUSTOMNAME;


//$menuInstance = Vtiger_Menu::getInstance('Tools');//Chose Tools menu Tab as parent for the new module
//$menuInstance->addModule($moduleInstance); //API will create menu item which serves as UI entry point for the module
    $moduleInstance->parent = "Tools";
    $moduleInstance->save();

//DB SCHEMA SETUP
    $moduleInstance->initTables();


///Module container which holds the fields together instance
    $blockInstance = new Vtiger_Block();
    $blockInstance->label = ''.strtoupper($CUSTOMNAME).' '.'INFORMATION';
    $moduleInstance->addBlock($blockInstance);

//LBL_CUSTOM_INFORMATION block should always be created to support Custom Fields for a module
    $blockInstance2 = new Vtiger_Block();
    $blockInstance2->label = 'LBL_CUSTOM_INFORMATION';
    $moduleInstance->addBlock($blockInstance2);


        $fieldInstanceInstance = new vtiger_Field();
        $fieldInstanceInstance->name = 'firstname';
        $fieldInstanceInstance->table = $moduleInstance->basetable;
        $fieldInstanceInstance->label = 'First name';
        $fieldInstanceInstance->column = strtolower($fieldInstanceInstance->name);
        $fieldInstanceInstance->columntype = 'VARCHAR(255)';
        $fieldInstanceInstance->typeofdata = 'V~M';
        $fieldInstanceInstance->displaytype = 1;
        $fieldInstanceInstance->presence = 2;
        $fieldInstanceInstance->setRelatedModules(array('Accounts'));
        $blockInstance->addField($fieldInstanceInstance);///write column name to table


    $fieldInstanceInstance1 = new vtiger_Field();
    $fieldInstanceInstance1->name = 'lastname';
    $fieldInstanceInstance1->table = $moduleInstance->basetable;
    $fieldInstanceInstance1->label = 'Last name';
    $fieldInstanceInstance1->column = strtolower($fieldInstanceInstance1->name);
    $fieldInstanceInstance1->columntype = 'VARCHAR(255)';
    $fieldInstanceInstance1->typeofdata = 'V~M';
    $fieldInstanceInstance1->displaytype = 1;
    $fieldInstanceInstance1->presence = 2;
    $fieldInstanceInstance1->setRelatedModules(array('Accounts'));
    $blockInstance->addField($fieldInstanceInstance1);///write column name to table


    $fieldInstanceInstance2 = new vtiger_Field();
    $fieldInstanceInstance2->name = 'emailaddress';
    $fieldInstanceInstance2->table = $moduleInstance->basetable;
    $fieldInstanceInstance2->label = 'Email Address';
    $fieldInstanceInstance2->uitype = 13;
    $fieldInstanceInstance2->column = strtolower($fieldInstanceInstance2->name);
    $fieldInstanceInstance2->columntype = 'VARCHAR(255)';
    $fieldInstanceInstance2->typeofdata = 'V~M';
    $fieldInstanceInstance2->displaytype = 1;
    $fieldInstanceInstance2->presence = 2;
    $fieldInstanceInstance2->setRelatedModules(array('Accounts'));

    $blockInstance->addField($fieldInstanceInstance2);///write column name to table





    $fieldInstanceInstance3 = new vtiger_Field();
    $fieldInstanceInstance3->name = 'phonenumber';
    $fieldInstanceInstance3->table = $moduleInstance->basetable;
    $fieldInstanceInstance3->label = 'Phone Number';
    $fieldInstanceInstance3->uitype = 7;
    $fieldInstanceInstance3->column = strtolower($fieldInstanceInstance3->name);
    $fieldInstanceInstance3->columntype = 'VARCHAR(255)';
    $fieldInstanceInstance3->typeofdata = 'D~O';
    $fieldInstanceInstance3->displaytype = 1;
    $fieldInstanceInstance3->presence = 2;
    $fieldInstanceInstance3->setRelatedModules(array('Accounts'));
    $blockInstance->addField($fieldInstanceInstance3);///write column name to table



    $fieldInstanceInstance4 = new vtiger_Field();
    $fieldInstanceInstance4->name = 'url';
    $fieldInstanceInstance4->table = $moduleInstance->basetable;
    $fieldInstanceInstance4->label = 'Url';
    $fieldInstanceInstance4->uitype = 17;
    $fieldInstanceInstance4->column = strtolower($fieldInstanceInstance4->name);
    $fieldInstanceInstance4->columntype = 'VARCHAR(255)';
    $fieldInstanceInstance4->typeofdata = 'D~O';
    $fieldInstanceInstance4->displaytype = 1;
    $fieldInstanceInstance4->presence = 2;
    $fieldInstanceInstance4->setRelatedModules(array('Accounts'));

    $blockInstance->addField($fieldInstanceInstance4);///write column name to table

###create manditory additional fields ###
    $fieldInstance1 = new Vtiger_Field();
    $fieldInstance1->name = 'assigned_user_id';
    $fieldInstance1->label = 'Assigned To';
    $fieldInstance1->table = 'vtiger_crmentity';
    $fieldInstance1->column = 'smownerid';
    $fieldInstance1->uitype = 53;
    $fieldInstance1->displaytype = 1;
    $fieldInstance1->presence = 2;
    $fieldInstance1->typeofdata = 'V~M';
    $blockInstance->addField($fieldInstance1);

    $fieldInstance2 = new Vtiger_Field();
    $fieldInstance2->name = 'createdtime';
    $fieldInstance2->label = 'Created Time';
    $fieldInstance2->table = 'vtiger_crmentity';
    $fieldInstance2->column = 'createdtime';
    $fieldInstance2->displaytype = 2;
    $fieldInstance2->uitype = 70;
    $fieldInstance2->typeofdata = 'D~O';
    $blockInstance->addField($fieldInstance2);

    $fieldInstance3 = new Vtiger_Field();
    $fieldInstance3->name = 'modifiedtime';
    $fieldInstance3->label = 'Modified Time';
    $fieldInstance3->table = 'vtiger_crmentity';
    $fieldInstance3->column = 'modifiedtime';
    $fieldInstance3->displaytype = 2;
    $fieldInstance3->uitype = 70;
    $fieldInstance3->typeofdata = 'D~O';
    $blockInstance->addField($fieldInstance3);
###create manditory additional fields ###

####Sharing Access Setup accepted values <PERMISSION_TYPE> Public_ReadOnly,Public_ReadWrite,Public_ReadWriteDelete;
    $moduleInstance->setDefaultSharing('Public');
// Webservice Setup note: when the module is imported the Webservice initialize API is automatically invoked
    $moduleInstance->initWebservice();

// Module Filter Setup
    $filter1 = new Vtiger_Filter();
    $filter1->name = 'All';
    $filter1->isdefault = true;
    $moduleInstance->addFilter($filter1);
    $filter1->addField($fieldInstanceInstance2)
        ->addField($fieldInstanceInstance2, 1)
        ->addField($fieldInstanceInstance3, 2)->
    addField($fieldInstanceInstance4, 3);

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


####set fields for summary view ######
//$setSummaryFields = Vtiger_Module::getInstance($CUSTOMNAME);
//
//    $CleanFieldSummmaryInstance = str_replace(' ', '', $SummaryFields['fieldlabel']);
//    $fieldColumn = strtolower($CleanFieldSummmaryInstance);
//
//    if ($SummaryFields['summaryfield'] === 1){
//        $fld = Vtiger_Field::getInstance($CleanFieldSummmaryInstance,$setSummaryFields);
//        $adb->query('update vtiger_field set summaryfield=1 where fieldid='.$fld->id);
//    }else{
//        continue;
//    }


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





}else{
    echo "<b>".$CUSTOMNAME."</b>"." module already installed!";

}
