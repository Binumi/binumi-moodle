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
 * Automatic media embedding filter class.
 *
 * @package    filter
 * @subpackage binumi
 * @copyright  2011 - 2015 Binumi Agency Hong Kong Limited
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

defined('MOODLE_INTERNAL') || die('Invalid access');

global $CFG;
require_once $CFG->libdir . '/filelib.php';
require_once $CFG->dirroot . '/local/binumi/lib.php';
require_once('binumi_client.class.php');


/**
 * Find instances of Binumi links and replace the link with embed code
 * from the Binumi API.
 */
class filter_binumi extends moodle_text_filter {

    private $_binumi_client;
    private $_re_embed_url;
    private $_default_thumb_width = 640;
    private $_default_thumb_height = 364;

    /**
     * Constructor
     * @param object $context
     * @param object $localconfig
     */
    public function __construct($context, array $localconfig) {
        parent::__construct($context, $localconfig);
        $this->_binumi_client = new binumi_client();
        $host = $this->_binumi_client->get_host();
	    $this->_re_embed_url = "/($host)\/index\/video/";
    }

    /**
     * Filter the page html and look for an <a><img> element added by the chooser
     * or an <a> element added by the moodle file picker
     *
     *
     * @param string $html
     * @param array $options
     * @return string
     */
    public function filter($html, array $options = array()) {
        global $COURSE;
        $courseid = (isset($COURSE->id)) ? $COURSE->id : null;

        if (empty($html) || !is_string($html) ||
            strpos($html, $this->_binumi_client->get_host()) === false) {
            return $html;
        }
        $dom = new DomDocument();
        $sanitized_html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

        if (defined('LIBXML_HTML_NOIMPLIED') && defined('LIBXML_HTML_NODEFDTD')) {
            @$dom->loadHtml($sanitized_html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        } else {
            @$dom->loadHtml($sanitized_html);
        }
        $xpath = new DOMXPath($dom);
        foreach ($xpath->query('//a') as $node) {
            $href = $node->getAttribute('href');
	        $class = $node->getAttribute('class');
            if (empty($href)) {
                continue;
            }
	        if ($class != 'binumi-embed') {
		        continue;
	        }
            if ((boolean)preg_match($this->_re_embed_url, $href)) {
                $newnode  = $dom->createDocumentFragment();
                $imgnode = $node->firstChild;

	            $href = htmlspecialchars($href) ;

                extract($this->_get_image_elem_dimensions($imgnode));
                $html = $this->_get_iframe_embed_html($href, $width, $height);
                $newnode->appendXML($html);
                $node->parentNode->replaceChild($newnode, $node);

            }
        }
        return $dom->saveHTML();
    }

    /**
     * Fetch the width an height from an image element
     */
    private function _get_image_elem_dimensions($imgnode) {
        if ($imgnode && $imgnode instanceof DOMElement) {
            $width = $imgnode->getAttribute('width');
            $height = $imgnode->getAttribute('height');
        }
        if (empty($width) || empty($height)
            || ($width == 195 && $height == 110)) {
            // Keep old moodle embeds at the default size
            $width = $this->_default_thumb_width;
            $height = $this->_default_thumb_height;
        }
        return array(
            'width' => $width,
            'height' => $height
        );
    }

    /**
     * Get the iframe embed html
     * @return string
     */
    private function _get_iframe_embed_html($embed_url, $width, $height) {
        $template = '<iframe src="URL" ' .
            'width="WIDTH" ' .
            'height="HEIGHT" ' .
            'webkitallowfullscreen="webkitallowfullscreen" ' .
            'allowfullscreen="allowfullscreen" ' .
            'frameborder="0"> ' .
            '</iframe>';
        $patterns = array('/URL/', '/WIDTH/', '/HEIGHT/');
        $replace = array($embed_url, $width, $height);
        return preg_replace($patterns, $replace, $template);
    }

}
