<?php
session_start();

echo "create_config";
require_once("create_config.php");

echo "create_database";
require_once("create_database.php");

echo "create_admin_account";
require_once("create_admin_account.php");

header("Location: ../install_finished.php");