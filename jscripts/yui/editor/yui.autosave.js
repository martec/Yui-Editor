function ye_as() {
	sc_asd = JSON.parse(localStorage.getItem('sc_as'));
	if (document.querySelector("link[rel='canonical']")) {
		link_can = document.querySelector("link[rel='canonical']").href;
	}
	else {
		link_can = location.href;
	}
	if (!sc_asd) {
		sc_asd = {};
	}
	if (document.getElementById("message")) {
		if (document.getElementById("message").value != sc_asd[link_can]) {
			if (document.getElementById("message").value.trim()) {
				sc_asd[link_can] = document.getElementById("message").value;
				localStorage.setItem('sc_as', JSON.stringify(sc_asd));
			}
			else {
				if (sc_asd[link_can]) {
					delete sc_asd[link_can];
					localStorage.setItem('sc_as', JSON.stringify(sc_asd));
				}
			}
		}
	}
	if (document.getElementById("signature")) {
		if (document.getElementById("signature").value != sc_asd[link_can]) {
			if (document.getElementById("signature").value.trim()) {
				sc_asd[link_can] = document.getElementById("signature").value;
				localStorage.setItem('sc_as', JSON.stringify(sc_asd));
			}
			else {
				if (sc_asd[link_can]) {
					delete sc_asd[link_can];
					localStorage.setItem('sc_as', JSON.stringify(sc_asd));
				}
			}
		}
	}
}

function ye_ac() {
	sc_asd = JSON.parse(localStorage.getItem('sc_as'));
	if (document.querySelector("link[rel='canonical']")) {
		link_can = document.querySelector("link[rel='canonical']").href;
	}
	else {
		link_can = location.href;
	}
	if (!sc_asd) {
		sc_asd = {};
	}
	if (sc_asd[link_can]) {
		delete sc_asd[link_can];
		localStorage.setItem('sc_as', JSON.stringify(sc_asd));
	}
}

function ye_ar() {
	sc_asd = JSON.parse(localStorage.getItem('sc_as'));
	if (!sc_asd) {
		sc_asd = {};
	}
	if(Object.keys(sc_asd).length > ye_saveamount) {
		delete sc_asd[Object.keys(sc_asd)[0]];
		localStorage.setItem('sc_as', JSON.stringify(sc_asd));
	}
}
function ye_onblur() {
	if (document.getElementById("message")) {
		if (document.getElementById("message").value.trim()) {
			ye_as();
		}
		else {
			ye_ac();
		}
	}
	if (document.getElementById("signature")) {
		if (document.getElementById("signature").value.trim()) {
			ye_as();
		}
		else {
			ye_ac();
		}
	}
};
$(document).ready(function() {
	($.fn.on || $.fn.live).call($(document), 'click', 'input[accesskey*="s"]', function () {
		ye_ac();
	});
	setInterval(function() {
		ye_as();
		ye_ar();
	},ye_savetime*1000);
	setTimeout(function() {
		sc_asd = JSON.parse(localStorage.getItem('sc_as'));
		restitem = "";
		if (document.querySelector("link[rel='canonical']")) {
			link_can = document.querySelector("link[rel='canonical']").href;
		}
		else {
			link_can = location.href;
		}
		if (sc_asd) {
			restitem = sc_asd[link_can];
		}
		if (restitem) {
			restorebut = '<a class="yuieditor-button yuieditor-button-restore" title="'+ye_rest_lang+'" onclick="MyBBEditor.insertText(restitem);"><div></div></a>';
			$(restorebut).appendTo('.yuieditor-group_message:last');
		}
	},600);
	if (document.getElementById("message")) {
		document.getElementById("message").onblur = function() {ye_onblur()};
	}
	if (document.getElementById("signature")) {
		document.getElementById("signature").onblur = function() {ye_onblur()};
	}
});