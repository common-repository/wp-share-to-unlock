// Docu : http://wiki.moxiecode.com/index.php/TinyMCE:Create_plugin/3.x#Creating_your_own_plugins

(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('wwwsharetounlock');

	tinymce.create('tinymce.plugins.wwwsharetounlock', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			// Register example button
			ed.addButton('wwwsharetounlock', {
				title : 'Share To Unlock',
                image : url + '/images/icon.png',
                onclick : function() {
                    ed.focus();
                    var content = tinyMCE.activeEditor.getContent();
                    if(content.match(/\[share-to-unlock(.*?)\]/))
                    {
                        tinyMCE.activeEditor.windowManager.alert("You can use only one shortcode on the post");
                    }
                    else
                    {
                        var c = ed.selection.getContent();
                        tinyMCE.activeEditor.selection.setContent('[share-to-unlock]'+c+'[/share-to-unlock]');
                    }

                }
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('wwwsharetounlock', n.nodeName == 'IMG');
			});
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
					longname  : 'Share To Unlock',
					author 	  : 'Peter',
					authorurl : 'http://server.com',
					infourl   : '',
					version   : "0.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('wwwsharetounlock', tinymce.plugins.wwwsharetounlock);
})();