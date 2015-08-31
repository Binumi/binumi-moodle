/**
 * @author Binumi
 */

(function() {
    tinymce.PluginManager.requireLangPack('binumi');

    tinymce.create('tinymce.plugins.BinumiChooserPlugin', {
        init : function(ed, pluginUrl) {
            var t = this;
            t.editor = ed;
            t.url = pluginUrl;

            var params = {
                'url': ed.getParam('binumi_chooser_url', undefined),
                'launchUrl': ed.getParam('binumi_launch_url', undefined),
                'mode': 'popup'
            };

            ed.addCommand('mceBinumiChooser', function() {
                /*if (!window.binumi) {
                    ed.windowManager.alert(
                        ed.getLang('binumi.loaderror')
                    );
                    return;
                }*/
                if (!t.chooser) {
                    /*t.chooser = mediacore.chooser.init(params);
                    t.chooser.on('media', function(media) {
                        var imgElem = t.editor.dom.createHTML('img', {
                            src:  media.thumb_url,
                            width: 400,
                            height: 225,
                            alt: media.title,
                            title: media.title
                        });
                        var attrs = {
                            'href': media.embed_url,
                            'data-media-id': media.id
                        };
                        var aElem = t.editor.dom.createHTML('a', attrs, imgElem);
                        t.editor.execCommand('mceInsertContent', false, aElem);
                    });
                    t.chooser.on('error', function(err) {
                        throw err;
                    });*/
                    alert('a');
                }
                //t.chooser.open();
            });

            ed.addButton('binumi', {
                title : 'binumi.desc',
                image : t.url + '/img/icon.png',
                cmd : 'mceBinumiChooser'});

        },

        getInfo : function() {
            return {
                longname : 'Binumi Chooser',
                author : 'Binumi',
                version : "1.0"
            };
        }

    });

    tinymce.PluginManager.add('binumi', tinymce.plugins.BinumiChooserPlugin);
})();
