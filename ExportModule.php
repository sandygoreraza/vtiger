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

$Vtiger_Utils_Log = true;

$moduleInstancetool = Vtiger_Module::getInstance('Contacts');
$moduleInstancetool->enableTools(Array('Import', 'Export'));
