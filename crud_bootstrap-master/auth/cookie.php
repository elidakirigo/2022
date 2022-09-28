<?php

require_once 'conn.php';

// setcookie(name, value, expire, path, domain, secure, httponly);

setcookie('username', '', time() + 60 * 60 * 24 * 7, '/');