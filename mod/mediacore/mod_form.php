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
 *       __  _____________   _______   __________  ____  ______
 *      /  |/  / ____/ __ \ /  _/   | / ____/ __ \/ __ \/ ____/
 *     / /|_/ / __/ / / / / / // /| |/ /   / / / / /_/ / __/
 *    / /  / / /___/ /_/ /_/ // ___ / /___/ /_/ / _, _/ /___
 *   /_/  /_/_____/_____//___/_/  |_\____/\____/_/ |_/_____/
 *
 * MediaCore mod video resource
 *
 * @package    mediacore
 * @category   mod
 * @copyright  2015 MediaCore Technologies
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

defined('MOODLE_INTERNAL') || die('Invalid access');

global $CFG;
require_once $CFG->dirroot .'/course/moodleform_mod.php';
require_once $CFG->dirroot . '/local/mediacore/lib.php';


class mod_mediacore_mod_form extends moodleform_mod {

    /**
     */
    public function definition() {
        global $CFG, $DB, $OUTPUT, $PAGE, $COURSE;

        $client = new mediacore_client();

        // CSS
        $PAGE->requires->css('/mod/mediacore/styles.css');
        $class = 'mediacore-resource';
        $PAGE->add_body_class($class);

        // JS
        $params = $client->get_texteditor_params();
        $PAGE->requires->data_for_js('mcore_params', $params);
        $module = array(
            'name'      => 'mediacore',
            'fullpath'  => '/mod/mediacore/main.js',
            'requires'  => array('yui2-event'),
        );
        $PAGE->requires->js_init_call(
            'M.mod_mediacore.init',
            /* args */ null,
            /* domready */ true,
            /* js specs */ $module
        );

        // Form
        $mform =& $this->_form;
        $mform->addElement('header', 'mcore-general', 'General');
        $this->add_form_fields($mform);
        $this->add_media_btn($mform);
        $this->add_hidden_fields($mform);
        $this->standard_coursemodule_elements();
        $this->add_action_buttons();
    }

    /**
     */
    public function add_form_fields($mform) {
        //
        // Name
        $mform->addElement('text', 'name', 'Name:');
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }
        $mform->addRule('name', null, 'required', null, 'client');

        // Description
        $this->add_intro_editor(false);
    }

    /**
     */
    public function add_media_btn($mform) {
        $is_new = true; //TODO

        $iframe_html = $this->_get_preview_iframe($is_new);
        $mform->addElement(
            'static', 'mcore-media-iframe', 'Media Preview', $iframe_html
        );

        $mediagroup = array();
        $attr = array('id' => 'mcore-add-media-btn');
        $add_btn_text = ($is_new) ? 'Add Media' : 'Replace Media';
        $mediagroup[] =& $mform->createElement(
            'button', 'mcore-add-media-btn', $add_btn_text,
            'mediacore_add', '', $attr
        );

        $mform->addGroup($mediagroup, 'media_group', '&nbsp;', '&nbsp;', false);
    }

    /**
     */
    private function _get_preview_iframe($is_new) {

        if ($is_new) {
            $src = new moodle_url('/mod/mediacore/pix/generic-thumb.png');
        } else {
            $src = ''; //TODO
        }

        $params = array(
            'id' => 'mcore-media-iframe',
            'src' => $src->out(false),
            'width' => '560',
            'height' => '315',
            'allowfullscreen' => 'true',
            'webkitallowfullscreen' => 'true',
            'mozallowfullscreen' => 'true',
            'scrolling' => 'no',
            'frameborder' => '0',
            'style' => 'display:block',
        );

        return html_writer::tag('iframe', '', $params);
    }

    /**
     */
    public function add_hidden_fields($mform) {
        $attr = array('id' => 'mcore-media-id');
        $mform->addElement('hidden', 'media_id', '', $attr);
        $mform->setType('media_id', PARAM_TEXT);

        $attr = array('id' => 'mcore-embed-url');
        $mform->addElement('hidden', 'embed_url', '', $attr);
        $mform->setType('embed_url', PARAM_URL);

        $attr = array('id' => 'mcore-thumb-url');
        $mform->addElement('hidden', 'thumb_url', '', $attr);
        $mform->setType('thumb_url', PARAM_URL);

        $attr = array('id' => 'mcore-metadata');
        $mform->addElement('hidden', 'metadata', '', $attr);
        $mform->setType('metadata', PARAM_TEXT);
    }

    /**
     * Validates the form
     * TODO
     *
     * @param array $data Array of form values
     * @param array $files Array of files
     * @return array $errors Array of error messages
     */
    public function validation($data, $files) {
        $errors = array();
        if (empty($data['media_id'])) {
            $errors['name'] = 'No media was attached.';
        }
        return $errors;
    }
}
