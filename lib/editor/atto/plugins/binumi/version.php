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
 * @package    atto
 * @usbpackage binumi
 * @copyright  2011 - 2015 Binumi Agency Hong Kong Limited
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin                     = new StdClass();
$plugin->component          = 'atto_binumi';
$plugin->version            = 2015032500;
$plugin->requires           = 2014041100; //Moodle 2.7
$plugin->release            = '1.2';
$plugin->maturity           = MATURITY_STABLE;
$plugin->dependencies       = array(
    'local_binumi' => 2015032500,
    //'filter_binumi' => 2015022100,
);
