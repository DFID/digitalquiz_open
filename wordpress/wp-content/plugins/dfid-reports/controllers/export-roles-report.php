<?php

require_once REPORTS_MODULE_DIRECTORY . "helpers" . DIRECTORY_SEPARATOR . "roles.php";
$departmentsHelper = new RolesHelper();
header("Content-type: application/x-msdownload",true,200);
header("Content-Disposition: attachment; filename=" . $departmentsHelper->getExportFileName());
header("Pragma: no-cache");
header("Expires: 0");

echo $departmentsHelper->getCsv();
exit();