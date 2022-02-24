<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

include_once('vtlib/Vtiger/Module.php');

$Vtiger_Utils_Log = true;

 $Fmodule = '<MODULENAMEONE>';
$Smodule = '<MODULENAMETWO>';

$moduleInstance = Vtiger_Module::getInstance($Fmodule);
$accountsModule = Vtiger_Module::getInstance($Smodule);
$relationLabel  = $Fmodule.'->'.$Smodule;
$moduleInstance->setRelatedList(
      $accountsModule, $relationLabel, Array('ADD','SELECT')
);
