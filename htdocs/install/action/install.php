<?php
session_start();
require_once("create_config.php");
require_once("create_database.php");
require_once("create_admin_account.php");

header("Location: ../install_finished.php");