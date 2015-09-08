<?php

/**
 * BINUMI BLOCK FOR MOODLE
 *
 * @package    block_binumi
 * @copyright  2011 - 2015 Binumi Agency Hong Kong Limited.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * ----------------------------------------------------------------------
 */

require_once ("../../config.php");
require_once $CFG->dirroot . '/local/binumi/lib.php';
require_once 'binumi_client.class.php';
global $CFG, $DB;

require_login();

$cid = required_param('cid', PARAM_INT);

/** Navigation Bar **/
$PAGE->navbar->ignore_active();

$course = $DB->get_record('course', array('id'=>$cid), '*', $strictness=IGNORE_MISSING);

$PAGE->navbar->add($course->shortname, new moodle_url($CFG->wwwroot . '/course/view.php?id=' . $cid));
$PAGE->navbar->add(get_string('binumiportal', 'block_binumi'));

$PAGE->set_url('/blocks/binumi/portal.php');
$PAGE->set_context(context_course::instance($cid));
$PAGE->set_heading(get_string('binumiportal', 'block_binumi'));
$PAGE->set_title(get_string('binumiportal', 'block_binumi'));

$client = new binumi_client();
$url = $client->get_siteurl().'/lti/portal';
$src = $client->get_signed_url($url, $cid, $client->get_lti_params($course));
$outputhtml = '<iframe src="'.$src.'" frameborder=0 style="width:100%;height: 800px;border: none;"></iframe>';

echo $OUTPUT->header();
echo $outputhtml;
echo $OUTPUT->footer();