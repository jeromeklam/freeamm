<?php
$vdir = getenv('COMPOSER_VENDOR_DIR');
if (trim($vdir) == '') {
    require_once __DIR__ . '/../vendor/autoload.php';
} else {
    require_once rtrim($vdir, '/') . '/autoload.php';
}
