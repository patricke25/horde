#!/usr/bin/env php
<?php
if (strpos('@php_dir@', '@php_dir') === 0) {
    set_include_path(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'lib' . PATH_SEPARATOR . get_include_path());
}

/**
 * We are heavily relying on the PEAR libraries which are not clean with regard
 * to E_STRICT.
 */
error_reporting(E_ALL & ~E_STRICT);

require_once 'Horde/Autoloader/Default.php';
Components::main();
