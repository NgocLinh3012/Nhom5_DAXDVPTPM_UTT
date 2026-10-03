<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

define('BASE_URL', '');

define('DB_HOST', getenv('DB_HOST') ?: 'db');
define('DB_NAME', getenv('DB_NAME') ?: 'thitracnghiem');
define('DB_USER', getenv('DB_USER') ?: 'utt_user');
define('DB_PASS', getenv('DB_PASS') ?: 'utt_password');
define('DB_PORT', (int)(getenv('DB_PORT') ?: 3306));