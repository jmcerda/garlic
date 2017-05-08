(function () {
	tinymce.PluginManager.add('formstack', function (ed, url) {
		ed.addButton('formstack', {
			title  : formstack_tinymce.button,
			type   : 'button',
			image  : url + '/stack.gif',
			onclick: function () {
				var forms = getValues();
				var bodies = [];
				if ('no_api_key' == forms[0].text) {
					bodies.push({
						type: 'container',
						name: 'container',
						html: '<p>' + forms[0].value + '</p>'
					})
				} else {
					bodies.push({
						type  : 'listbox',
						name  : 'lists',
						label : formstack_tinymce.list_label,
						values: forms,
					});
				}
				ed.windowManager.open({
					title   : formstack_tinymce.tinymce_title,
					body    : bodies,
					onsubmit: function (e) {
						if (typeof e.data.lists === 'undefined') {
							return;
						}
						var list = e.data.lists;
						var id, viewkey;
						id = list.split('-')[0];
						viewkey = list.split('-')[1];
						var tag = '[Formstack id="' + id + '" viewkey="' + viewkey + '"]';
						ed.insertContent(tag);
					}
				});
			}
		});
		function getValues() {
			var options = [];
			jQuery.each(formstack_forms, function (i, val) {
				options.push({'text': val.name, 'value': val.value});
			});
			return options;
		}
	});
})()
