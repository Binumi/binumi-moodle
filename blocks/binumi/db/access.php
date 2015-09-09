<?php

/**
 * __________.__                     .__
 * \______   \__| ____  __ __  _____ |__|
 *  |    |  _/  |/    \|  |  \/     \|  |
 *  |    |   \  |   |  \  |  /  Y Y  \  |
 *  |______  /__|___|  /____/|__|_|  /__|
 *         \/        \/            \/
 *
 * Binumi's block plugin
 *
 * @package    block
 * @subpackage binumi
 * @copyright  2011 - 2015 Binumi Agency Hong Kong Limited.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

$capabilities = array(
 
    'block/binumi:myaddinstance' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'user' => CAP_ALLOW
        ),
 
        'clonepermissionsfrom' => 'moodle/my:manageblocks'
    ),
 
    'block/binumi:addinstance' => array(
        'riskbitmask' => RISK_SPAM | RISK_XSS,
 
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),
 
        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    )
    
	
	
	
	
);