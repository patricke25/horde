<?php
/**
 * Operator base application file.
 *
 * $Horde: incubator/operator/lib/base.php,v 1.1 2008/04/19 01:26:06 bklang Exp $
 *
 * This file brings in all of the dependencies that every Operator script will
 * need, and sets up objects that all scripts use.
 */

// Check for a prior definition of HORDE_BASE (perhaps by an auto_prepend_file
// definition for site customization).
if (!defined('HORDE_BASE')) {
    @define('HORDE_BASE', dirname(__FILE__) . '/../..');
}

// Load the Horde Framework core, and set up inclusion paths.
require_once HORDE_BASE . '/lib/core.php';

// Registry.
$registry = &Registry::singleton();
if (is_a(($pushed = $registry->pushApp('operator', !defined('AUTH_HANDLER'))), 'PEAR_Error')) {
    if ($pushed->getCode() == 'permission_denied') {
        Horde::authenticationFailureRedirect();
    }
    Horde::fatal($pushed, __FILE__, __LINE__, false);
}
$conf = &$GLOBALS['conf'];
@define('OPERATOR_TEMPLATES', $registry->get('templates'));

// Notification system.
$notification = &Notification::singleton();
$notification->attach('status');

// Define the base file path of Operator.
@define('OPERATOR_BASE', dirname(__FILE__) . '/..');

// Operator base library
require_once OPERATOR_BASE . '/lib/Operator.php';

// Operator backend.
require_once OPERATOR_BASE . '/lib/Driver.php';
$GLOBALS['operator_driver'] = Operator_Driver::factory();

// Start output compression.
Horde::compressOutput();
