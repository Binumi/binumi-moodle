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

class block_binumi extends block_base {

	/** block init */
	function init() {
		$this->title = get_string('pluginname', 'block_binumi');
	}

	/** Get the content for the block */
	function get_content() {

	    if ($this->content !== NULL) {
	      return $this->content;
	    }

	    global $CFG;
		$cid = optional_param('id', '', PARAM_INT);
		$this->content =  new stdClass;
	    $this->content->text = '<a href="'.$CFG->wwwroot. '/blocks/binumi/portal.php?cid='.$cid.'"> '. get_string('binumiportal', 'block_binumi').'</a><br>';
	    $this->content->footer = '';

	    return $this->content;
	  }

	/**
	 * Locations where block can be displayed
	 *
	 * @return array
	 */
	public function applicable_formats() {
	    return array('course-view' => true);
	}


	/** One block per course */
	public function instance_allow_multiple() {
		return false;
	}

}