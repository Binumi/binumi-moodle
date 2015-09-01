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
 * The Binumi Chooser Atto editor button implementation
 *
 * @package    atto
 * @subpackage binumi
 * @copyright  2011 - 2015 Binumi Agency Hong Kong Limited
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die('Invalid access');

global $CFG;
require_once $CFG->dirroot . '/local/binumi/lib.php';
require_once 'binumi_client.class.php';


/**
 * Initialise this plugin
 * @param string $elementid
 */
function atto_binumi_strings_for_js() {
    global $PAGE;

    $PAGE->requires->strings_for_js(
        array(
            'noparamserror',
            'nochooserjserror',
        ), 'atto_binumi');
}


/**
 * Return the js params required for this module.
 * @return array of additional params to pass to javascript init function.
 */
function atto_binumi_params_for_js() {
    global $COURSE;

    //NOTE: the params used for the tinymce editor plugin and
    //  the atto editor plugin are the same
    $client = new binumi_client();
    $params = $client->get_texteditor_params();

    return array(
        'chooser_js_url' => $params['binumi_chooser_js_url'],
        'url' => $params['binumi_chooser_url'],
        'mode' => 'popup',
    );
}
