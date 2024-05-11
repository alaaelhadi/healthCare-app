<?php
include_once('../admin/session/logged.php');

$sessionManager = new SessionManager();
$sessionManager->logout();

?>