<?php
// Khi chạy Docker: set env DB_HOST=db, BASE_URL=http://localhost:8080/thitracnghiem/public/
// Khi chạy local:  không cần set env, dùng giá trị mặc định bên dưới
define("BASE_URL",  getenv("BASE_URL")  ?: "http://localhost:8080/thitracnghiem/public/");
define("DB_HOST",   getenv("DB_HOST")   ?: "localhost");
define("DB_NAME",   getenv("DB_NAME")   ?: "thitracnghiem");
define("DB_USER",   getenv("DB_USER")   ?: "root");
define("DB_PASS",   getenv("DB_PASS")   ?: "");
define("DB_PORT",   (int)(getenv("DB_PORT") ?: 3306));
