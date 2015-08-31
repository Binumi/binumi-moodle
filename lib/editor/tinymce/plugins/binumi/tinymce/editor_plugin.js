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

            ed.addCommand('mceBinumiChooser', function() {
                 t.popup = ed.windowManager.open({
                     file: pluginUrl + '/iframe.html?src=' + encodeURIComponent(ed.getParam('binumi_chooser_url', {})),
                     width: 1000 + parseInt(ed.getLang('advimage.delta_width', 0)),
                     height: 700 + parseInt(ed.getLang('advimage.delta_height', 0)),
                     inline: 1
                }, {
                    plugin_url: pluginUrl
                });
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
