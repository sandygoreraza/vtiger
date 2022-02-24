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

include_once 'vtlib/Vtiger/Module.php';
include_once 'Deletefolder.php';

$Modulename='<modelname>';

$Vtiger_Utils_Log = true;

$module = Vtiger_Module::getInstance($Modulename);
if ($module) $module->delete();

###get all files in modules to delete


$ModuleFolderPath ='modules/'.$Modulename;


new DeleteFolder($ModuleFolderPath);

//system("rm -rf ".escapeshellarg($ModuleFolderPath));

$filename = 'languages/en_us/'."$Modulename".'.php';

if (file_exists($filename)) {
  unlink($filename);
}
//then delete language module

echo $filename.'</br>';
echo 'Module'.' '.$Modulename.' '.'deleted';

