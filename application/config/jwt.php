<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['jwt_secret_key'] = 'your-super-secret-key-change-this-in-production'; // Ganti ini!
$config['jwt_refresh_secret_key'] = 'your-refresh-secret-key-change-this-too'; // Ganti ini juga!
$config['jwt_algorithm'] = 'HS256';
$config['jwt_access_token_expire'] = 3600; // 1 jam (dalam detik)
$config['jwt_refresh_token_expire'] = 2592000; // 30 hari (dalam detik)
