var ment_settings = {
	at: "@",
	searchKey: "text",
	displayTpl: "<li>${text}</li>",
	insertTpl: '${atwho-at}"${text}"',
	startWithSpace: true,
	maxLen: maxnamelength,
	callbacks: {
		remoteFilter: function(query, callback) {
			if (query.length > 2) {
				$.getJSON('xmlhttp.php?action=get_users', {query: query}, function(data) {
					callback(data);
				});			
			}
			else {
				callback([]);
			}
		}
	}
}
$(document).ready(function() {
	if ($('#message, #signature').length) {
		$('#message, #signature').atwho(ment_settings);
	}
	($.fn.on || $.fn.live).call($(document), 'click', '.quick_edit_button', function () {
		ed_id = $(this).attr('id');
		var pid = ed_id.replace( /[^0-9]/g, '');
		qse_area = 'quickedit_'+pid;
		$('#'+qse_area+'').atwho(ment_settings);
	});
});