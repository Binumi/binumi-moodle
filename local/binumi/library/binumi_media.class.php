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
 *
 * Binumi's local plugin
 *
 * @package    local
 * @subpackage binumi
 * @copyright  2011 - 2015 Binumi Agency Hong Kong Limited.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

defined('MOODLE_INTERNAL') || die('Invalid access');

global $CFG;
require_once $CFG->dirroot . '/lib/filelib.php';
require_once 'binumi_config.class.php';
require_once 'binumi_client.class.php';
require_once 'binumi_media_rowset.class.php';


/**
 * A class that encapsulates fetching media from the API
 */
class binumi_media
{
    private $_binumi_client;

    /**
     * Constructor
     *
     * @param binumi_client $client
     */
    public function __construct($client) {
        $this->_binumi_client = $client;
    }

    /**
     * Fetch media from the media api endpoint url
     * LTI signed if applicable
     *
     * @param string $search
     * @param int $page
     * @param int $per_page
     * @param int|null $courseid
     * @return binumi_media_rowset
     */
    public function get_media($search='', $page=1, $per_page=30, $courseid=null) {

        $params = array(
            'type' => 'video',
            'status' => 'published',
            'joins' => 'thumbs',
            'per_page' => $per_page,
            '_p' => $page,
        );
        if (!is_null($courseid)) {
            $params['context_id'] = $courseid;
        }
        if (!empty($search)) {
            $params['search'] = urlencode($search);
            $params['sort'] = 'relevance';
        }

        $url = $this->_binumi_client->get_url('api2', 'media');

        if ($this->_binumi_client->has_lti_config() && !is_null($courseid)) {
            $headers = array();
            $authtkt_str = $this->_binumi_client->get_auth_cookie($courseid);
            if (empty($authtkt_str)) {
                // TODO: report an error?
            } else {
                $headers = array('Cookie: ' . $authtkt_str);
                $url .= '?' . $this->_binumi_client->get_query($params);
                $result = $this->_binumi_client->get($url, null, $headers);
            }
        } else {
            $result = $this->_binumi_client->get($url);
        }

        $rowset = null;
        if (empty($result)) {
            // TODO: report an error?
        } else {
            $result = json_decode($result);
            $rowset = new binumi_media_rowset(
                $this->_binumi_client, $result->items
            );
        }
        return $rowset;
    }

    /**
     * Get the total media count
     *
     * @param string $search
     * @param int $courseid
     * @return int
     */
    public function get_media_count($search, $courseid=null) {

        $params = array(
            'type' => 'video',
            'status' => 'published',
        );

        if (!is_null($courseid)) {
            $params['context_id'] = $courseid;
        }
        if (!empty($search)) {
            $params['search'] = urlencode($search);
        }

        $url = $this->_binumi_client->get_url('api2', 'media', 'count');

        if ($this->_binumi_client->has_lti_config() && !is_null($courseid)) {
            $headers = array();
            $authtkt_str = $this->_binumi_client->get_auth_cookie($courseid);
            if (empty($authtkt_str)) {
                // TODO: report an error?
            } else {
                $headers = array('Cookie: ' . $authtkt_str);
                $url .= '?' . $this->_binumi_client->get_query($params);
                $result = $this->_binumi_client->get($url, null, $headers);
            }
        } else {
            $result = $this->_mcore_client->get($url);
        }

        $count = 0;
        if (empty($result)) {
            // TODO: report an error?
        } else {
            $result = json_decode($result);
            $count = $result->count;
        }
        return (int)$count;
    }
}
