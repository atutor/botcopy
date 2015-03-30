<?php
define('AT_INCLUDE_PATH', '../../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');
admin_authenticate(AT_ADMIN_PRIV_BOTCOPY);
require (AT_INCLUDE_PATH.'header.inc.php');
?>

<h3>BotCopy</h3>

<?php require (AT_INCLUDE_PATH.'footer.inc.php'); ?>