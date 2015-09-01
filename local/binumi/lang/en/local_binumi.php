<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * __________.__                     .__
 * \______   \__| ____  __ __  _____ |__|
 *  |    |  _/  |/    \|  |  \/     \|  |
 *  |    |   \  |   |  \  |  /  Y Y  \  |
 *  |______  /__|___|  /____/|__|_|  /__|
 *         \/        \/            \/
 *
 * Binumi's local plugin language strings
 *
 * @package    local
 * @subpackage binumi
 * @copyright  2011 - 2015 Binumi Agency Hong Kong Limited.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Plugin settings.
$string['pluginname'] = 'Binumi package config';

$string['setting_heading_desc'] = 'These settings customize the method in which your Moodle instance connects to Binumi site.<br/><br/> It also may be necessary to purge your Moodle caches after changing these settings.<br/><br/>';

$string['setting_host_label'] = 'Binumi Hostname:';
$string['setting_host_desc'] = '**Note:** This setting defines binumi site url (*e.g: www.binumi.com*).<br/><em>It should NOT contain the http(s):// portion of the url. Just the hostname.<br/><br/>';

$string['setting_consumer_key_label'] = 'Your Binumi Consumer Key';

$string['setting_consumer_key_desc'] = '**Note:** This must match an existing LTI consumer key in Binumi site.';

$string['setting_shared_secret_label'] = 'Your Binumi Shared Secret';

$string['setting_shared_secret_desc'] = '**Note:** This must match an existing LTI consumer shared secret in Binumi site.';

$string['host_empty_error'] = 'Binumi hostname field is empty. Please update your plugin config with the correct hostname';

$string['no_course_id'] = 'Expected a valid course id';

$string['no_lti_config'] = 'Expected some LTI configuration settings. Please update your Binumi Package';