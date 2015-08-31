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

        // Add the Binumi Chooser button
        this.addButton({
            icon: 'icon',
            iconComponent: 'atto_binumi',
            callback: this._initChooser
        });

        var self = this;
        window.addEventListener('message', function(e) {
            self._dialogue.hide();
            if (e.data.hasOwnProperty('embed') && e.data.hasOwnProperty('thumbnail')) {
                self._insertContent(e.data.embed, e.data.thumbnail);
            }
        });
    },

    /**
     * Init the Chooser
     */
    _initChooser: function() {
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
        iframe.setAttribute('src', this.get('url'));
        dialogue.set('bodyContent', iframe)
            .show();

        this.markUpdated();
    },

    /**
     * Create <a> > <img> elements and inject them into
     * the editor content
     */
    _insertContent: function(media, thumbnail) {
        /*var element = Y.Node.create('<iframe></iframe>').setAttrs({
            'width': '640',
            'height': '364',
            'src': media,
            frameborder: '0',
            scrolling: 'no',
            mozallowfullscreen: 'true',
            webkitallowfullscreen: 'true',
            allowfullscreen: 'true'
        });*/


        // Insert the html into the editor
       /* this.editor.focus();
        var html = element.getDOMNode().outerHTML;
        this.get('host').insertContentAtFocusPoint(html);
        this.markUpdated();*/

        var html = '<a class="binumi-embed" href="' + media + '" target="_blank"><img src="'+ thumbnail+'" alt="Binumi Embed"  /></a>';
        this.editor.focus();
        this.get('host').insertContentAtFocusPoint(html);
        this.markUpdated();
    },


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
