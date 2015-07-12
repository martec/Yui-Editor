function extbutgen(butname,qse_area) {
	but = '<a class="yuieditor-button yuieditor-button-'+butname+'" onclick="descbut(\''+butname+'\',1,\'\',\'\',\'\',\''+qse_area+'\')" title="'+butname+'"><div></div></a>';
	$(but).appendTo('.yuieditor-group_'+qse_area+':last');
}
function extdescbutgen(butname,qse_area) {
	but = '<a class="yuieditor-button yuieditor-button-'+butname+'" id="yuieditor-'+butname+'_'+qse_area+'" title="'+butname+'"><div></div></a>'+
			'<div id="yuieditor-'+butname+'_'+qse_area+'_popup" class="yuieditor-dropdown" style="display: none;"><div>'+
					'<label for="desc_'+butname+'">'+yuivar['Description (optional):']+'</label>'+
					'<input type="text" id="desc_'+butname+'" />'+
				'</div>'+
				'<input type="button" class="button" value="'+yuivar.Insert+'" onclick="descbut(\''+butname+'\',1,\'\',document.getElementById(\'desc_'+butname+'\').value,\'\',\''+qse_area+'\');$(\':input:not(:button)\', \'#yuieditor-'+butname+'_'+qse_area+'_popup\').val([]);$(\'#yuieditor-'+butname+'_'+qse_area+'_popup\').hide();" />'+
			'</div>';
	$(but).appendTo('.yuieditor-group_'+qse_area+':last');
	$('#yuieditor-'+butname+'_'+qse_area+'').popupMenu(false);
}
function yuibimage(but_name) {
	button = '';
	if (but_name=='imgur') {
		if (iclid.trim()!='') {
			button = '<style type="text/css">'+
				'.yuieditor-button-'+but_name+' div  {'+
					'background-image: url('+rootpath+'/jscripts/yui/editor/'+but_name+'.png) !important;'+
				'}'+
				'.yuieditor-button-'+but_name+' div.imgurup  {'+
					'background-image: url('+rootpath+'/jscripts/yui/editor/spinner.gif) !important;'+
				'}'+			
			'</style>';
		}
	}
	else {
		button = '<style type="text/css">'+
			'.yuieditor-button-'+but_name+' div  {'+
				'background-image: url('+rootpath+'/jscripts/yui/editor/'+but_name+'.png) !important;'+
			'}'+
		'</style>';
	}
	return button;
}
function imgur(qse_area) {
	document.querySelector('textarea').insertAdjacentHTML( 'afterEnd', '<input class="imgur" style="visibility:hidden;position:absolute;top:0;" type="file" onchange="upload(this.files[0],'+qse_area.id+')" accept="image/*">' );
	document.querySelector('input.imgur').click();				
}
function yuibutton(but_name,type,qse_area) {
	if (but_name=='imgur') {
		if (iclid.trim()!='') {
			but = '<a class="yuieditor-button yuieditor-button-imgur" onclick="imgur('+qse_area+');" title="imgur"><div></div></a>';
			$(but).appendTo('.yuieditor-group_'+qse_area+':last');			
		}
	}
	else {
		if (!type) {
			extbutgen(but_name,qse_area);
		}
		else {
			extdescbutgen(but_name,qse_area);
		}
	}
}
function colorbutgen(qse_area) {
	return '<a class="yuieditor-button yuieditor-button-color" id="yuieditor-color_'+qse_area+'" title="fontcolor"><div></div></a>';
}
function hrbutgen(qse_area) {
	return '<a class="yuieditor-button yuieditor-button-horizontalrule" accesskey="h" onclick="editor.insert_text(\'[hr]\',\'\', \''+qse_area+'\')" title="'+yuivar['Insert a horizontal rule']+'"><div></div></a>';
}
function fontbutgen(qse_area) {
	return	'<a class="yuieditor-button yuieditor-button-font" id="yuieditor-font_'+qse_area+'" title="'+yuivar['Font Name']+'"><div></div></a>'+
			'<div id="yuieditor-font_'+qse_area+'_popup" class="yuieditor-dropdown yuieditor-font-picker" style="display: none;"><div>'+
				'<a class="yuieditor-font-option" onclick="descbut(\'font\',1,\'\',\'Arial\',\'\',\''+qse_area+'\')"><font face="Arial">Arial</font></a>'+
				'<a class="yuieditor-font-option" onclick="descbut(\'font\',1,\'\',\'Arial Black\',\'\',\''+qse_area+'\')"><font face="Arial Black">Arial Black</font></a>'+
				'<a class="yuieditor-font-option" onclick="descbut(\'font\',1,\'\',\'Comic Sans MS\',\'\',\''+qse_area+'\')"><font face="Comic Sans MS">Comic Sans MS</font></a>'+
				'<a class="yuieditor-font-option" onclick="descbut(\'font\',1,\'\',\'Courier New\',\'\',\''+qse_area+'\')"><font face="Courier New">Courier New</font></a>'+
				'<a class="yuieditor-font-option" onclick="descbut(\'font\',1,\'\',\'Georgia\',\'\',\''+qse_area+'\')"><font face="Georgia">Georgia</font></a>'+
				'<a class="yuieditor-font-option" onclick="descbut(\'font\',1,\'\',\'Impact\',\'\',\''+qse_area+'\')"><font face="Impact">Impact</font></a>'+
				'<a class="yuieditor-font-option" onclick="descbut(\'font\',1,\'\',\'Sans-serif\',\'\',\''+qse_area+'\')"><font face="Sans-serif">Sans-serif</font></a>'+
				'<a class="yuieditor-font-option" onclick="descbut(\'font\',1,\'\',\'Serif\',\'\',\''+qse_area+'\')"><font face="Serif">Serif</font></a>'+
				'<a class="yuieditor-font-option" onclick="descbut(\'font\',1,\'\',\'Times New Roman\',\'\',\''+qse_area+'\')"><font face="Times New Roman">Times New Roman</font></a>'+
				'<a class="yuieditor-font-option" onclick="descbut(\'font\',1,\'\',\'Trebuchet MS\',\'\',\''+qse_area+'\')"><font face="Trebuchet MS">Trebuchet MS</font></a>'+
				'<a class="yuieditor-font-option" onclick="descbut(\'font\',1,\'\',\'Verdana\',\'\',\''+qse_area+'\')"><font face="Verdana">Verdana</font></a></div>'+
			'</div>';
}
function fontsizebutgen(qse_area) {
	return	'<a class="yuieditor-button yuieditor-button-size" id="yuieditor-size_'+qse_area+'" title="'+yuivar['Font Size']+'"><div></div></a>'+
			'<div id="yuieditor-size_'+qse_area+'_popup" class="yuieditor-dropdown yuieditor-fontsize-picker" style="display: none;"><div>'+
				'<a class="yuieditor-fontsize-option" onclick="descbut(\'size\',1,\'\',\'xx-small\',\'\',\''+qse_area+'\')"><font size="1">1</font></a>'+
				'<a class="yuieditor-fontsize-option" onclick="descbut(\'size\',1,\'\',\'x-small\',\'\',\''+qse_area+'\')"><font size="2">2</font></a>'+
				'<a class="yuieditor-fontsize-option" onclick="descbut(\'size\',1,\'\',\'small\',\'\',\''+qse_area+'\')"><font size="3">3</font></a>'+
				'<a class="yuieditor-fontsize-option" onclick="descbut(\'size\',1,\'\',\'medium\',\'\',\''+qse_area+'\')"><font size="4">4</font></a>'+
				'<a class="yuieditor-fontsize-option" onclick="descbut(\'size\',1,\'\',\'large\',\'\',\''+qse_area+'\')"><font size="5">5</font></a>'+
				'<a class="yuieditor-fontsize-option" onclick="descbut(\'size\',1,\'\',\'x-large\',\'\',\''+qse_area+'\')"><font size="6">6</font></a>'+
				'<a class="yuieditor-fontsize-option" onclick="descbut(\'size\',1,\'\',\'xx-large\',\'\',\''+qse_area+'\')"><font size="7">7</font></a>'+
			'</div>';
}
function imgbutgen(qse_area) {
	return	'<a class="yuieditor-button yuieditor-button-image" id="yuieditor-image_'+qse_area+'" accesskey="p" title="'+yuivar['Insert an image']+'"><div></div></a>'+
			'<div id="yuieditor-image_'+qse_area+'_popup" class="yuieditor-dropdown" style="display: none;"><div>'+
					'<label for="url">'+yuivar['URL:']+'</label>'+
					'<input type="text" id="url" />'+
				'</div>'+
				'<div>'+
					'<label for="width">'+yuivar['Width (optional):']+'</label>'+
					'<input type="text" id="width" />'+
				'</div>'+
				'<div>'+
					'<label for="height">'+yuivar['Height (optional):']+'</label>'+
					'<input type="text" id="height" />'+
				'</div>'+
				'<input type="button" class="button" value="'+yuivar.Insert+'" onclick="descbut(\'img\',2,document.getElementById(\'width\').value,document.getElementById(\'url\').value,document.getElementById(\'height\').value,\''+qse_area+'\');$(\':input:not(:button)\', \'#yuieditor-image_'+qse_area+'_popup\').val([]);$(\'#yuieditor-image_'+qse_area+'_popup\').hide();" />'+
			'</div>';
}
function emailbutgen(qse_area) {
	return	'<a class="yuieditor-button yuieditor-button-email" id="yuieditor-email_'+qse_area+'" accesskey="e" title="'+yuivar['Insert an email']+'"><div></div></a>'+
			'<div id="yuieditor-email_'+qse_area+'_popup" class="yuieditor-dropdown" style="display: none;"><div>'+
					'<label for="email">'+yuivar['E-mail:']+'</label>'+
					'<input type="text" id="email" />'+
				'</div>'+
				'<div>'+
					'<label for="descemail">'+yuivar['Description (optional):']+'</label>'+
					'<input type="text" id="descemail" />'+
				'</div>'+
				'<input type="button" class="button" value="'+yuivar.Insert+'" onclick="descbut(\'email\',0,document.getElementById(\'email\').value,document.getElementById(\'descemail\').value,\'\',\''+qse_area+'\');$(\':input:not(:button)\', \'#yuieditor-email_'+qse_area+'_popup\').val([]);$(\'#yuieditor-email_'+qse_area+'_popup\').hide();" />'+
			'</div>';
}
function linkbutgen(qse_area) {
	return	'<a class="yuieditor-button yuieditor-button-link" id="yuieditor-link_'+qse_area+'" accesskey="w" title="'+yuivar['Insert a link']+'"><div></div></a>'+
			'<div id="yuieditor-link_'+qse_area+'_popup" class="yuieditor-dropdown" style="display: none;"><div>'+
					'<label for="urllink">'+yuivar['URL:']+'</label>'+
					'<input type="text" id="urllink" />'+
				'</div>'+
				'<div>'+
					'<label for="desclink">'+yuivar['Description (optional):']+'</label>'+
					'<input type="text" id="desclink" />'+
				'</div>'+
				'<input type="button" class="button" value="'+yuivar.Insert+'" onclick="descbut(\'url\',0,document.getElementById(\'urllink\').value,document.getElementById(\'desclink\').value,\'\',\''+qse_area+'\');$(\':input:not(:button)\', \'#yuieditor-link_'+qse_area+'_popup\').val([]);$(\'#yuieditor-link_'+qse_area+'_popup\').hide();" />'+
			'</div>';
}
function videobutgen(qse_area) {
	return	'<a class="yuieditor-button yuieditor-button-video" id="yuieditor-video_'+qse_area+'" accesskey="v" title="'+yuivar['Insert a video']+'"><div></div></a>'+
			'<div id="yuieditor-video_'+qse_area+'_popup" class="yuieditor-dropdown" style="display: none;"><div>'+
					'<label for="videotype">'+yuivar['Video Type:']+'</label>'+
					'<select id="videotype">' +
						'<option value="dailymotion" selected>'+yuivar['Dailymotion']+'</option>'+
						'<option value="facebook">'+yuivar['Facebook']+'</option>'+
						'<option value="liveleak">'+yuivar['LiveLeak']+'</option>'+
						'<option value="metacafe">'+yuivar['MetaCafe']+'</option>'+
						'<option value="veoh">'+yuivar['Veoh']+'</option>'+
						'<option value="vimeo">'+yuivar['Vimeo']+'</option>'+
						'<option value="youtube">'+yuivar['Youtube']+'</option>'+
					'</select>'+
				'</div>'+
				'<div>'+
					'<label for="videolink">'+yuivar['Video URL:']+'</label>'+
					'<input type="text" id="videolink" />'+
				'</div>'+
				'<input type="button" class="button" value="'+yuivar.Insert+'" onclick="descbut(\'video\',0,document.getElementById(\'videotype\').value,document.getElementById(\'videolink\').value,\'\',\''+qse_area+'\');$(\'#videolink\').val([]);$(\'#yuieditor-video_'+qse_area+'_popup\').hide();" />'+
			'</div>';
}
function extrabutreq(list,type,qse_area) {
	icm_but_rls = list.split(',');
	for (var i = 0; i < icm_but_rls.length; i++) {
		yuibutton(''+icm_but_rls[i]+'',type,qse_area);
		$(yuibimage(''+icm_but_rls[i]+'')).insertAfter('textarea');
	}
}
$(document).ready(function() {
	function genbuttons(qse_area) {
		$(toolbar(qse_area)).insertBefore("#"+qse_area+"");
		buttons(qse_area);
		$('#yuieditor-font_'+qse_area+'').popupMenu();
		$('#yuieditor-size_'+qse_area+'').popupMenu();
		$('#yuieditor-color_'+qse_area+'').popupMenu();
		$('#yuieditor-image_'+qse_area+'').popupMenu(false);
		$('#yuieditor-email_'+qse_area+'').popupMenu(false);
		$('#yuieditor-link_'+qse_area+'').popupMenu(false);
		$('#yuieditor-video_'+qse_area+'').popupMenu(false);
		$('#yuieditor-emoticons_'+qse_area+'').popupMenu(false);
	};
	function geneditor(qse_area) {
		document.getElementById(qse_area).style.width = '99.5%';
		genbuttons(qse_area);
		setTimeout(function() {
			$('.color_palette_placeholder_'+qse_area).each(function() {
				registerPalette($(this),$(this).attr('data-local'));
			});
		},400);
	};	
	if ($('#message').length) {
		geneditor('message');
	}
	if ($('#signature').length) {
		geneditor('signature');
	}
	($.fn.on || $.fn.live).call($(document), 'click', '.quick_edit_button', function () {
		ed_id = $(this).attr('id');
		var pid = ed_id.replace( /[^0-9]/g, '');
		qse_area = 'quickedit_'+pid;
		genbuttons(qse_area);
		setTimeout(function() {
			$('.color_palette_placeholder_'+qse_area).each(function() {
				registerPalette($(this),$(this).attr('data-local'));
			});
			$('#quickedit_'+pid).focus();
			offset = $('#quickedit_'+pid).offset().top - 60;
			$('html, body').animate({
				scrollTop: offset
			}, 700);
		},400);
	});
	function buttons(qse_area) {
		$(simpbutgen('bold','b','b',1,'',qse_area,yuivar.Bold)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(simpbutgen('italic','i','i',1,'',qse_area,yuivar.Italic)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(simpbutgen('underline','u','u',1,'',qse_area,yuivar.Underline)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(simpbutgen('strike','s','s',1,'',qse_area,yuivar.Strikethrough)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(simpbutgen('left','l','align',1,'left',qse_area,yuivar['Align left'])).appendTo('.yuieditor-group_'+qse_area+':last');
		$(simpbutgen('center','c','align',1,'center',qse_area,yuivar.Center)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(simpbutgen('right','r','align',1,'right',qse_area,yuivar['Align right'])).appendTo('.yuieditor-group_'+qse_area+':last');
		$(simpbutgen('justify','j','align',1,'justify',qse_area,yuivar.Justify)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(fontbutgen(qse_area)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(fontsizebutgen(qse_area)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(colorbutgen(qse_area)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(hrbutgen(qse_area)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(imgbutgen(qse_area)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(emailbutgen(qse_area)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(linkbutgen(qse_area)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(videobutgen(qse_area)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(emotbutgen(qse_area)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(simpbutgen('bulletlist','t','list',3,'',qse_area,yuivar['Bullet list'])).appendTo('.yuieditor-group_'+qse_area+':last');
		$(simpbutgen('orderedlist','o','list',4,'',qse_area,yuivar['Numbered list'])).appendTo('.yuieditor-group_'+qse_area+':last');
		$(simpbutgen('code','g','code',1,'',qse_area,yuivar.Code)).appendTo('.yuieditor-group_'+qse_area+':last');
		$(simpbutgen('quote','q','quote',1,'',qse_area,yuivar.PHP)).appendTo('.yuieditor-group_'+qse_area+':last');
		if (!extrabut.trim() == ''){
			extrabutreq(extrabut,0,qse_area);
		}
		if (!extrabutdesc.trim() == ''){
			extrabutreq(extrabutdesc,1,qse_area);
		}
	}
});

/*****************************
 * Add imgur upload function *
 *****************************/
function upload(file,qse_area) {
	/* Is the file an image? */
	if (!file || !file.type.match(/image.*/)) return;

	/* It is! */
	document.body.className = "uploading";
	var d = document.querySelector(".yuieditor-button-imgur div");
	d.className = d.className + " imgurup";

	/* Lets build a FormData object*/
	var fd = new FormData(); // I wrote about it: https://hacks.mozilla.org/2011/01/how-to-develop-a-html5-image-uploader/
	fd.append("image", file); // Append the file
	var xhr = new XMLHttpRequest(); // Create the XHR (Cross-Domain XHR FTW!!!) Thank you sooooo much imgur.com
	xhr.open("POST", "https://api.imgur.com/3/image.json"); // Boooom!
	xhr.onload = function() {
		var code = '[img]' + JSON.parse(xhr.responseText).data.link + '[/img]';
		editor.insert_text(code,'',qse_area.id);
		var d = document.querySelector(".yuieditor-button-imgur div.imgurup");
		d.className = d.className - " imgurup";
		document.querySelector('input.imgur').remove();
	}
	// Ok, I don't handle the errors. An exercice for the reader.
	xhr.setRequestHeader('Authorization', 'Client-ID '+iclid+'');
	/* And now, we send the formdata */
	xhr.send(fd);
};