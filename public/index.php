<?php

// Start session
session_start();

// Hiển thị lỗi khi dev
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Core system
require_once __DIR__ . "/../Core/config.php";
require_once __DIR__ . "/../Core/Database.php";
require_once __DIR__ . "/../Core/Controller.php";
require_once __DIR__ . "/../Core/App.php";

// Base API Controller
//require_once __DIR__ . "/../MVC/Controllers/ApiBaseController.php";

// Run application
new App();