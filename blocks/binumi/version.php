<?php
/**
 * BINUMI BLOCK FOR MOODLE
 *
 * @package    block_binumi
 * @copyright  2011 - 2015 Binumi Agency Hong Kong Limited.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$plugin                     = new StdClass();
$plugin->component          = 'block_binumi';
$plugin->version 			= 2015090800;
$plugin->requires 			= 2012062500;
$plugin->release  			= '1.0.0';
$plugin->maturity 			= MATURITY_STABLE;
$plugin->dependencies       = array(
	'local_binumi' => 2015090800,
);