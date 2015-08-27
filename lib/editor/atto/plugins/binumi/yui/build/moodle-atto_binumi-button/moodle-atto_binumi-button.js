YUI.add('moodle-atto_binumi-button', function (Y, NAME) {

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
 * @package    atto_binumi
 * @copyright  2011 - 2015 Binumi Agency Hong Kong Limited
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * @module moodle-atto_binumi-button
 */

/**
 * Atto text editor binumi plugin.
 *
 * @namespace M.atto_binumi
 * @class button
 * @extends M.editor_atto.EditorPlugin
 */
Y.namespace('M.atto_binumi').Button = Y.Base.create('button', Y.M.editor_atto.EditorPlugin, [], {

    /**
     * A reference to the Binumi Chooser
     */
    _chooser: null,


    /**
     * Init
     */
    initializer: function() {

        if (this.get('disabled')){
            return;
        }

        console.log('test');
        /*if (!this.get('chooser_js_url') ||
            !this.get('url') ||
            !this.get('mode')) {
            var msg = M.util.get_string('noparamserror', 'atto_binumi');
            throw new Error(msg);
        }

        // Load the chooser js
        this._loadScript(this.get('chooser_js_url'));
*/
        // Add the Binumi Chooser button
        this.addButton({
            icon: 'icon',
            iconComponent: 'atto_binumi',
            callback: this._initChooser
        });
    },

    /**
     * Init the Chooser
     */
    _initChooser: function() {
       /* if (!binumi) {
            var msg = M.util.get_string('nochooserjserror', 'atto_binumi');
            throw new Error(msg);
        }
        if (!this._chooser) {
            // Init the chooser with the following params
            var params = {
                'url': this.get('url'),
                'mode': this.get('mode')
            };
            this._chooser = binumi.chooser.init(params);

            // Listen and handle the Chooser "media" event
            this._chooser.on('media', Y.bind(this._insertContent, this));

            // Listen and handle the Chooser "error" event
            this._chooser.on('error', function(err) {
                throw err;
            });
        }
        this._chooser.open();*/


        var dialogue = this.getDialogue({
            headerContent: 'Binumi Chooser',
            width: '800px',
            focusAfterHide: true
        });

        var iframe = Y.Node.create('<iframe></iframe>');
        // We set the height here because otherwise it is really small. That might not look
        // very nice on mobile devices, but we considered that enough for now.
        iframe.setStyles({
            height: '700px',
            border: 'none',
            width: '100%'
        });
        iframe.setAttribute('src', 'https://dev.binumi.com');

        dialogue.set('bodyContent', iframe)
            .show();

        this.markUpdated();
    },

    /**
     * Create <a> > <img> elements and inject them into
     * the editor content
     */
    _insertContent: function(media) {
        console.log('insertContent', media, this);
/*
 <iframe width="640" height="364"
 src="https://dev.binumi.com/index/video?loop=false&poster=true&autoplay=false&height=360&width=640&controls=controls&url=https://lv-keyframes.s3-ap-southeast-1.amazonaws.com/uploads/0_dev/1__2c72fdc8b9e28ddefb010ee46cacf169_z169"
 frameborder="0" scrolling="no" mozallowfullscreen="true" webkitallowfullscreen="true" allowfullscreen="true">
 </iframe>
 */
        var element = Y.Node.create('<iframe></iframe>').setAttrs({
           'width': '640',
            'height': '364',
            'src': '',
            frameborder: '0',
            scrolling: 'no',
            mozallowfullscreen: 'true',
            webkitallowfullscreen: 'true',
            allowfullscreen: 'true'
        });


        // Insert the html into the editor
        this.editor.focus();
        var html = element.getDOMNode().outerHTML;
        this.get('host').insertContentAtFocusPoint(html);
        this.markUpdated();
    },

    /**
     * Load a script url and append to the document.body
     * @param {string} url
     */
    _loadScript: function(url) {
        var script = document.createElement('script');
        script.src = url;
        (document.body || document.head || document.documentElement).appendChild(script);
    }

}, { ATTRS: {
        disabled: {
            value: false
        },
        chooser_js_url: {
            value: null
        },
        url: {
            value: null
        },
        mode: {
            value: 'popup'
        }
    }
});


}, '@VERSION@', {"requires": ["moodle-editor_atto-plugin"]});
