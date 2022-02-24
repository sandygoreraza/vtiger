<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

include_once 'vtlib/Vtiger/Module.php';
include_once 'Deletefolder.php';

$Modulename='<modelname>';

$Vtiger_Utils_Log = true;

$module = Vtiger_Module::getInstance($Modulename);
if ($module) $module->delete();

###get all files in modules to delete


$ModuleFolderPath ='modules/'.$Modulename;

###INVOKE DELETE OBJECT
new DeleteFolder($ModuleFolderPath);


$filename = 'languages/en_us/'."$Modulename".'.php';

if (file_exists($filename)) {
  unlink($filename);
}
//then delete language module

echo $filename.'</br>';
echo 'Module'.' '.$Modulename.' '.'deleted';

