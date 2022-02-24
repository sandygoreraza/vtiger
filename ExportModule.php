<?php
include_once 'vtlib/Vtiger/Module.php';

$Vtiger_Utils_Log = true;

$moduleInstancetool = Vtiger_Module::getInstance('Contacts');
$moduleInstancetool->enableTools(Array('Import', 'Export'));