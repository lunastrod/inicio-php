<?php
$debug_mode = true;

if ($debug_mode) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

function dd($data) {
    echo "<pre style='background: #161616; color: #c8f135; padding: 10px; border: 1px solid #2a2a2a; font-family: monospace;'>";
    print_r($data);
    echo "</pre>";
}