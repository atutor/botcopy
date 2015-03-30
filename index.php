<?php
define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');
$_custom_css = $_base_path . 'mods/hello_world/module.css'; // use a custom stylesheet
$_cuatom_css .= '<meta http-equiv="refresh" content="0; url=index_admin.php" />';
require (AT_INCLUDE_PATH.'header.inc.php');
?>


<?php require (AT_INCLUDE_PATH.'footer.inc.php'); ?>