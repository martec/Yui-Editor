<?php
/**
 * Yui Editor
 * https://github.com/martec
 *
 * Copyright (C) 2015-2015, Martec
 *
 * Yui Editor is licensed under the GPL Version 2 license:
 *	http://opensource.org/licenses/gpl-2.0.php
 *
 * @fileoverview Yui Editor - Lightweight editor based of phpBB, PunBB and SCEditor editor for Mybb
 * @author Martec
 * @requires jQuery and Mybb
 * @credits phpBB (https://www.phpbb.com/), PunBB (http://punbb.informer.com/), SCEditor (http://www.sceditor.com/) and At.js (http://ichord.github.io/At.js/).
 */

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

define('YE', '1.0.0');

// Plugin info
function yuieditor_info ()
{

	global $db, $lang;

	$lang->load('config_yuieditor');

	$YE_description = <<<EOF
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
{$lang->yuieditor_plug_desc}
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/pt_BR/i/scr/pixel.gif" width="1" height="1">
</form>
EOF;

	return array(
		"name"			  => "Yui Editor",
		"description"	 => $YE_description,
		"website"		 => "https://github.com/martec/yuieditor",
		"author"		=> "martec",
		"authorsite"	=> "http://community.mybb.com/user-49058.html",
		"version"		 => YE,
		"compatibility" => "18*"
	);
}

function yuieditor_install()
{
	global $db, $lang, $mybb;

	$lang->load('config_yuieditor');
	
	$query	= $db->simple_select("settinggroups", "COUNT(*) as rows");
	$dorder = $db->fetch_field($query, 'rows') + 1;

	$groupid = $db->insert_query('settinggroups', array(
		'name'		=> 'yuieditor',
		'title'		=> 'Yui Editor',
		'description'	=> $lang->yuieditor_sett_desc,
		'disporder'	=> $dorder,
		'isdefault'	=> '0'
	));
	
	$new_setting[] = array(
		'name'		=> 'yuieditor_replace',
		'title'		=> $lang->yuieditor_replace_title,
		'description'	=> $lang->yuieditor_replace_desc,
		'optionscode'	=> 'onoff',
		'value'		=> '0',
		'disporder'	=> 1,
		'gid'		=> $groupid
	);

	$new_setting[] = array(
		'name'		=> 'yuieditor_smile',
		'title'		=> $lang->yuieditor_smile_title,
		'description'	=> $lang->yuieditor_smile_desc,
		'optionscode'	=> 'onoff',
		'value'		=> '0',
		'disporder'	=> 2,
		'gid'		=> $groupid
	);
	
	$new_setting[] = array(
		'name'		=> 'yuieditor_quickquote',
		'title'		=> $lang->yuieditor_quickquote_title,
		'description'	=> $lang->yuieditor_quickquote_desc,
		'optionscode'	=> 'onoff',
		'value'		=> '1',
		'disporder'	=> 3,
		'gid'		=> $groupid
	);
	
	$new_setting[] = array(
		'name'		=> 'yuieditor_mention',
		'title'		=> $lang->yuieditor_mention_title,
		'description'	=> $lang->yuieditor_mention_desc,
		'optionscode'	=> 'onoff',
		'value'		=> '1',
		'disporder'	=> 4,
		'gid'		=> $groupid
	);
	
	$new_setting[] = array(
		'name'		=> 'yuieditor_autosave',
		'title'		=> $lang->yuieditor_autosave_title,
		'description'	=> $lang->yuieditor_autosave_desc,
		'optionscode'	=> 'onoff',
		'value'		=> '1',
		'disporder'	=> 5,
		'gid'		=> $groupid
	);

	$new_setting[] = array(
		'name'		=> 'yuieditor_saveamount',
		'title'		=> $lang->yuieditor_saveamount_title,
		'description'	=> $lang->yuieditor_saveamount_desc,
		'optionscode'	=> 'numeric',
		'value'		=> '20',
		'disporder'	=> 6,
		'gid'		=> $groupid
	);

	$new_setting[] = array(
		'name'		=> 'yuieditor_savetime',
		'title'		=> $lang->yuieditor_savetime_title,
		'description'	=> $lang->yuieditor_savetime_desc,
		'optionscode'	=> 'numeric',
		'value'		=> '15',
		'disporder'	=> 7,
		'gid'		=> $groupid
	);

	$new_setting[] = array(
		'name'		=> 'yuieditor_canonicallink',
		'title'		=> $lang->yuieditor_canonical_title,
		'description'	=> $lang->yuieditor_canonical_desc,
		'optionscode'	=> 'onoff',
		'value'		=> '1',
		'disporder'	=> 8,
		'gid'		=> $groupid
	);
	
	$new_setting[] = array(
		'name'		=> 'yuieditor_rules',
		'title'		=> $lang->yuieditor_rules_title,
		'description'	=> $lang->yuieditor_rules_desc,
		'optionscode'	=> 'textarea',
		'value'		=> 'imgur',
		'disporder'	=> 9,
		'gid'		=> $groupid
	);

	$new_setting[] = array(
		'name'		=> 'yuieditor_rules_des',
		'title'		=> $lang->yuieditor_rulesdes_title,
		'description'	=> $lang->yuieditor_rules_desc,
		'optionscode'	=> 'textarea',
		'value'		=> '',
		'disporder'	=> 10,
		'gid'		=> $groupid
	);

	$new_setting[] = array(
		'name'		=> 'yuieditor_imgurapi',
		'title'		=> $lang->yuieditor_imgur_title,
		'description'	=> $lang->yuieditor_imgur_desc,
		'optionscode'	=> 'text',
		'value'		=> '',
		'disporder'	=> 11,
		'gid'		=> $groupid
	);

	$db->insert_query_multiple("settings", $new_setting);
	rebuild_settings();
}

function yuieditor_is_installed()
{
	global $db;

	$query = $db->simple_select("settinggroups", "COUNT(*) as rows", "name = 'yuieditor'");
	$rows  = $db->fetch_field($query, 'rows');

	return ($rows > 0);
}

function yuieditor_uninstall()
{
	global $db;
	
	$groupid = $db->fetch_field(
		$db->simple_select('settinggroups', 'gid', "name='yuieditor'"),
		'gid'
    );

	$db->delete_query('settings', 'gid=' . $groupid);
	$db->delete_query("settinggroups", "name = 'yuieditor'");
	rebuild_settings();
}

function yuieditor_activate()
{
	global $db;
	include_once MYBB_ROOT.'inc/adminfunctions_templates.php';

	$new_template_global['yuibutquick'] = "<link rel=\"stylesheet\" href=\"{\$mybb->asset_url}/jscripts/yui/editor/editor.css?ver=".YE."\" type=\"text/css\" media=\"all\" />
<script type=\"text/javascript\">
<!--
	var extrabut = '{\$mybb->settings['yuieditor_rules']}',
	extrabutdesc = '{\$mybb->settings['yuieditor_rules_des']}',
	emoticons = {
		dropdown: {
			{\$dropdownsmilies}
		},
		more: {
			{\$moresmilies}
		}
	},
	MYBB_SMILIES = '{\$ye_smilies}',
	ye_savetime = '{\$mybb->settings['yuieditor_savetime']}',
	ye_saveamount = '{\$mybb->settings['yuieditor_saveamount']}',
	ye_rest_lang = '{\$lang->yuieditor_restore}',
	iclid = '{\$mybb->settings['yuieditor_imgurapi']}',
	maxnamelength = '{\$mybb->settings['maxnamelength']}',
	{\$editor_language};
// -->
</script>
<script type=\"text/javascript\" src=\"{\$mybb->asset_url}/jscripts/yui/editor/yui.editor.js?ver=".YE."\"></script>
<script type=\"text/javascript\" src=\"{\$mybb->asset_url}/jscripts/yui/editor/yui.editor.helper.js?ver=".YE."\"></script>
{\$quickquote}
{\$yui_mention}
{\$ye_autosave}";

	foreach($new_template_global as $title => $template)
	{
		$new_template_global = array('title' => $db->escape_string($title), 'template' => $db->escape_string($template), 'sid' => '-1', 'version' => '1801', 'dateline' => TIME_NOW);
		$db->insert_query('templates', $new_template_global);
	}
	
	$new_template['postbit_quickquote'] = "<button style=\"display: none; float: right;\" id=\"qr_pid_{\$post['pid']}\">{\$lang->postbit_button_quote}</button>
<script type=\"text/javascript\">
	\$(document).ready(function() {
		quick_quote({\$post['pid']},'{\$post['username']}',{\$post['dateline']});
	});
</script>";

	$new_template['usercp_ye_drafts'] = "<html>
<head>
<title>{\$mybb->settings['bbname']} - {\$lang->yuieditor_page_title}</title>
{\$headerinclude}
<script type=\"text/javascript\">
\$(document).ready(function() {
	(\$.fn.on || \$.fn.live).call(\$(document), 'click', '.remove_autosave', function (e) {
		e.preventDefault();
		sc_asd = JSON.parse(localStorage.getItem('sc_as'));
		if (!sc_asd) {
			sc_asd = {};
		}
		if (sc_asd[\$(this).attr('id')]) {
			delete sc_asd[\$(this).attr('id')];
		}
		localStorage.setItem('sc_as', JSON.stringify(sc_asd));
		\$(this).parents('.as_tr').fadeOut('slow');
		if(!Object.keys(sc_asd).length) {
			if (!\$('.as_none').length) {
				\$('#sc_auto').append( '<tr class=\"as_none\"><td class=\"trow1\" colspan=\"7\">{\$lang->yuieditor_any_draft}</td><tr>' );
			}
		}
	});

	(\$.fn.on || \$.fn.live).call(\$(document), 'click', '#morelink', function (e) {
		e.preventDefault();
		sc_asd = JSON.parse(localStorage.getItem('sc_as'));
		var restitem = \"\";
		link_can = \$(this).attr('href');
		if (sc_asd) {
			restitem = sc_asd[link_can];
		}
		if (!restitem) {
			restitem = \"{\$lang->yuieditor_not_message}\";
		}
		heightwin = window.innerHeight*0.6;
		\$('body').append( '<div class=\"redmore\"><div style=\"overflow-y: auto;max-height: '+heightwin+'px !important; \"><table cellspacing=\"{\$theme['borderwidth']}\" cellpadding=\"{\$theme['tablespace']}\" class=\"tborder\"><tr><td class=\"thead\" colspan=\"2\"><div><strong>{\$lang->yuieditor_message}</strong></div></td></tr><td class=\"trow1\"><textarea readonly=\"readonly\" style=\"width:99%;height: '+heightwin*0.8+'px;\" >'+restitem+'</textarea></td></table></div></div>' );
		\$('.redmore').modal();
	});

	(\$.fn.on || \$.fn.live).call(\$(document), 'click', '.edit_autosave', function (e) {
		e.preventDefault();
		sc_asd = JSON.parse(localStorage.getItem('sc_as'));
		var restitem = \"\";
		link_can = \$(this).attr('href');
		if (sc_asd) {
			restitem = sc_asd[link_can];
		}
		if (!restitem) {
			restitem = \"{\$lang->yuieditor_not_message}\";
		}
		heightwin = window.innerHeight*0.6;
		\$('body').append( '<div class=\"edit\"><div style=\"overflow-y: auto;max-height: '+heightwin+'px !important; \"><table cellspacing=\"{\$theme['borderwidth']}\" cellpadding=\"{\$theme['tablespace']}\" class=\"tborder\"><tr><td class=\"thead\" colspan=\"2\"><div><strong>{\$lang->yuieditor_edit_message}</strong></div></td></tr><td class=\"trow1\"><textarea id=\"edit_textarea\" style=\"width:99%;height: '+heightwin*0.8+'px;\" >'+restitem+'</textarea></td></table></div><button id=\"sv_edit\" style=\"margin:4px;\" ided=\"'+link_can+'\">{\$lang->yuieditor_save}</button></div>' );
		\$('.edit').modal();
	});

	(\$.fn.on || \$.fn.live).call(\$(document), 'click', '#sv_edit', function (e) {
		e.preventDefault();
		sc_asd = JSON.parse(localStorage.getItem('sc_as'));
		var restitem = \"\";
		link_can = \$(this).attr('ided');
		if (!sc_asd) {
			sc_asd = {};
		}
		if (\$('#edit_textarea').val() != sc_asd[link_can]) {
			if (\$.trim(\$('#edit_textarea').val())) {
				sc_asd[link_can] = \$('#edit_textarea').val();
				localStorage.setItem('sc_as', JSON.stringify(sc_asd));
			}
			else {
				if (sc_asd[link_can]) {
					delete sc_asd[link_can];
					localStorage.setItem('sc_as', JSON.stringify(sc_asd));
				}
			}
		}
		else {
			if(!\$('#mes_no_edit').length) {
				$('<div/>', { id: 'mes_no_edit', class: 'bottom-right' }).appendTo('body');
			}
			setTimeout(function() {
				$('#mes_no_edit').jGrowl('{\$lang->yuieditor_not_edit}', { life: 500 });
			},200);
			return;
		}
		location.reload();
	});

	(\$.fn.on || \$.fn.live).call(\$(document), 'click', '#remove_all', function (e) {
		e.preventDefault();
		sc_asd = JSON.parse(localStorage.getItem('sc_as'));
		localStorage.setItem('sc_as', JSON.stringify({}));
		\$(document).find('.as_tr').fadeOut('slow');
		if (!\$('.as_none').length) {
			\$('#sc_auto').append( '<tr class=\"as_none\"><td class=\"trow1\" colspan=\"7\">{\$lang->yuieditor_any_draft}</td><tr>' );
		}
	});

	var i = 0;
	sc_asd = JSON.parse(localStorage.getItem('sc_as'));
	if (!sc_asd) {
		sc_asd = {};
	}
	if(!Object.keys(sc_asd).length) {
		\$('#sc_auto').append( '<tr class=\"as_none\"><td class=\"trow1\" colspan=\"7\">{\$lang->yuieditor_any_draft}</td><tr>' );
	}
	\$.each( sc_asd, function( key, value ) {
		i +=1;
		numtrow = 2;
		if (i % 2 == 0) { numtrow = 1; }
		if (value.length > 200) { value = value.substr(0,200) + '... <a href=\"'+key+'\" id=\"morelink\">{\$lang->yuieditor_readmore}</a>'; }
		$('#sc_auto').append( '<tr class=\"as_tr\"><td class=\"trow'+numtrow+'\"><a href=\"'+key+'\"><span class=\"smalltext\">'+key.substr(key.lastIndexOf('/') + 1)+'</span></a></td><td class=\"trow'+numtrow+'\"><span class=\"smalltext\">'+value+'</span></td><td class=\"trow'+numtrow+'\" align=\"center\"><a href=\"'+key+'\" class=\"edit_autosave\"><img src=\"{\$mybb->settings['bburl']}/images/icons/pencil.png\" title=\"{\$lang->yuieditor_edit}\" alt=\"{\$lang->yuieditor_edit}\" /></a></td><td class=\"trow'+numtrow+'\" align=\"center\"><a href=\"'+key+'\" class=\"remove_autosave\" id=\"'+key+'\"><img src=\"{\$mybb->settings['bburl']}/images/invalid.png\" title=\"{\$lang->yuieditor_delete}\" alt=\"{\$lang->yuieditor_delete}\" /></a></td><tr>' );
	});
});
</script>
</head>
<body>
{\$header}
<table width=\"100%\" border=\"0\" align=\"center\">
	<tr>
		{\$usercpnav}
		<td valign=\"top\">
			<table id=\"sc_auto\" border=\"0\" cellspacing=\"{\$theme['borderwidth']}\" cellpadding=\"{\$theme['tablespace']}\" class=\"tborder no_bottom_border\">
				<thead>
					<tr>
						 <td class=\"thead\" colspan=\"4\"><strong>{\$lang->yuieditor_page_title}</strong></td>
					</tr>
					<tr>
						<td class=\"tcat\" width=\"20%\" ><span class=\"smalltext\"><strong>{\$lang->yuieditor_local}</strong></span></td>
						<td class=\"tcat\" width=\"70%\"><span class=\"smalltext\"><strong>{\$lang->yuieditor_content}</strong></span></td>
						<td class=\"tcat\" align=\"center\" width=\"5%\"><span class=\"smalltext\"><strong>{\$lang->yuieditor_edit}</strong></span></td>
						<td class=\"tcat\" align=\"center\" width=\"5%\"><span class=\"smalltext\"><strong>{\$lang->yuieditor_delete}</strong></span></td>
					</tr>
				</thead>
			</table>
			<br />
			<div align=\"center\">
				<button id=\"remove_all\">{\$lang->yuieditor_remove_all}</button>
			</div>
		</td>
	</tr>
</table>
{\$footer}
</body>
</html>";

	$new_template['usercp_nav_ye'] = "<script type=\"text/javascript\">
\$(document).ready(function() {
	sc_asd = JSON.parse(localStorage.getItem('sc_as'));
	if (!sc_asd) {
		sc_asd = {};
	}
	var titlangas = \"{\$lang->yuieditor_page_title}\";
	if(Object.keys(sc_asd).length) {
		var titlangas = \"<strong>\" + titlangas + \" (\" + Object.keys(sc_asd).length + \")\" + \"</strong>\";
	}
	\$('#itenum').html(titlangas);
});
</script>
<tbody>
<tr>
	<td class=\"tcat tcat_menu tcat_collapse{\$collapsedimg['yedraftlist']}\">
		<div class=\"expcolimage\"><img src=\"{\$theme['imgdir']}/collapse{\$collapsedimg['yedraftlist']}.png\" id=\"yedraftlist_img\" class=\"expander\" alt=\"[-]\" title=\"[-]\" /></div>
		<div><span class=\"smalltext\"><strong>{\$lang->yuieditor_page_title}</strong></span></div>
	</td>
</tr>
</tbody>
<tbody style=\"{\$collapsed['yedraftlist_e']}\" id=\"yedraftlist_e\">
	<tr><td class=\"trow1 smalltext\"><a href=\"usercp.php?action=ye_autosave\" class=\"usercp_nav_item usercp_nav_drafts\" id=\"itenum\"></a></td></tr>
</tbody>";

    foreach($new_template as $title => $template2)
	{
		$new_template = array('title' => $db->escape_string($title), 'template' => $db->escape_string($template2), 'sid' => '-2', 'version' => '1801', 'dateline' => TIME_NOW);
		$db->insert_query('templates', $new_template);
	}

	find_replace_templatesets(
		'showthread',
		'#' . preg_quote('{$footer}') . '#i',
		'{$footer}{$yuibutquick}'
	);

	find_replace_templatesets(
		'private_quickreply',
		'#' . preg_quote('<textarea') . '#i',
		'{$yuibutquick}<textarea'
	);

	find_replace_templatesets(
		'showthread_quickreply',
		'#' . preg_quote('<span class="smalltext">{$lang->message_note}<br />') . '#i',
		'<span class="smalltext">{$lang->message_note}<br />{$smilieinserter}'
	);

	find_replace_templatesets(
		'private_quickreply',
		'#' . preg_quote('<span class="smalltext">{$lang->message_note}<br />') . '#i',
		'<span class="smalltext">{$lang->message_note}<br />{$smilieinserter}'
	);
	
	find_replace_templatesets(
		'showthread',
		'#' . preg_quote('{$headerinclude}') . '#i',
		'{$headerinclude}
{$can_link}'
	);

	find_replace_templatesets(
		'postbit_classic',
		'#' . preg_quote('{$post[\'iplogged\']}') . '#i',
		'	{$post[\'quick_quote\']}
	{$post[\'iplogged\']}'
	);

	find_replace_templatesets(
		'postbit',
		'#' . preg_quote('{$post[\'iplogged\']}') . '#i',
		'	{$post[\'quick_quote\']}
	{$post[\'iplogged\']}'
	);
	
	$codebuttons_local = array('calendar_addevent', 'calendar_editevent', 'editpost', 'modcp_announcements_edit', 'modcp_announcements_new', 'modcp_editprofile', 'newreply', 'newthread', 'private_send', 'usercp_editsig', 'warnings_warn_pm');
	foreach ($codebuttons_local as &$local) {
		find_replace_templatesets(
			''.$local.'',
			'#' . preg_quote('{$codebuttons}') . '#i',
			'{$yuibutquick}{$codebuttons}'
		);
	}
}

function yuieditor_deactivate()
{
	global $db;
	include_once MYBB_ROOT."inc/adminfunctions_templates.php";

	$db->delete_query("templates", "title IN('yuibutquick','postbit_quickquote','usercp_ye_drafts','usercp_nav_ye')");

	find_replace_templatesets(
		'showthread',
		'#' . preg_quote('{$footer}{$yuibutquick}') . '#i',
		'{$footer}'
	);

	find_replace_templatesets(
		'private_quickreply',
		'#' . preg_quote('{$yuibutquick}<textarea') . '#i',
		'<textarea'
	);

	find_replace_templatesets(
		'showthread_quickreply',
		'#' . preg_quote('<span class="smalltext">{$lang->message_note}<br />{$smilieinserter}') . '#i',
		'<span class="smalltext">{$lang->message_note}<br />'
	);

	find_replace_templatesets(
		'private_quickreply',
		'#' . preg_quote('<span class="smalltext">{$lang->message_note}<br />{$smilieinserter}') . '#i',
		'<span class="smalltext">{$lang->message_note}<br />'
	);
	
	find_replace_templatesets(
		'showthread',
		'#' . preg_quote('{$headerinclude}
{$can_link}') . '#i',
		'{$headerinclude}'
	);

	find_replace_templatesets(
		'postbit_classic',
		'#' . preg_quote('	{$post[\'quick_quote\']}
	{$post[\'iplogged\']}') . '#i',
		'{$post[\'iplogged\']}'
	);

	find_replace_templatesets(
		'postbit',
		'#' . preg_quote('	{$post[\'quick_quote\']}
	{$post[\'iplogged\']}') . '#i',
		'{$post[\'iplogged\']}'
	);
	
	$codebuttons_local = array('calendar_addevent', 'calendar_editevent', 'editpost', 'modcp_announcements_edit', 'modcp_announcements_new', 'modcp_editprofile', 'newreply', 'newthread', 'private_send', 'usercp_editsig', 'warnings_warn_pm');
	foreach ($codebuttons_local as &$local) {
		find_replace_templatesets(
			''.$local.'',
			'#' . preg_quote('{$yuibutquick}{$codebuttons}') . '#i',
			'{$codebuttons}'
		);
	}
}

$plugins->add_hook('global_start', 'ye_cache');
function ye_cache()
{
	global $templatelist, $mybb, $settings;

	if (isset($templatelist)) {
		$templatelist .= ',';
	}

	if (THIS_SCRIPT == 'showthread.php' || THIS_SCRIPT == 'private.php') {	
		if($mybb->settings['yuieditor_smile'] != 0 && $mybb->settings['yuieditor_quickquote'] != 1) {
			$templatelist .= 'yuibutquick,smilieinsert,smilieinsert_smilie,smilieinsert_getmore';
		}
		elseif($mybb->settings['yuieditor_quickquote'] != 0 && $mybb->settings['yuieditor_smile'] != 1) {
			$templatelist .= 'yuibutquick,postbit_quickquote';
		}
		elseif($mybb->settings['yuieditor_quickquote'] != 0 && $mybb->settings['yuieditor_smile'] != 0) {
			$templatelist .= 'yuibutquick,postbit_quickquote,smilieinsert,smilieinsert_smilie,smilieinsert_getmore';
		}
		else {
			$templatelist .= 'yuibutquick';
		}
	}
	if (THIS_SCRIPT == 'usercp.php') {
		if($mybb->settings['yuieditor_autosave'] != 0) {
			$templatelist .= 'usercp_ye_drafts,usercp_nav_ye';
		}
	}
	if ($settings['yuieditor_replace']) {
		$plugin_local = array('calendar.php', 'editpost.php', 'modcp.php', 'newreply.php', 'newthread.php', 'private.php', 'usercp.php', 'warnings.php');
		foreach ($plugin_local as &$local) {
			if (THIS_SCRIPT == ''.$local.'') {
				$templatelist .= 'yuibutquick';
			}
		}
	}
}

function yuieditor_inserter_quick($smilies = true)
{
	global $db, $mybb, $theme, $templates, $lang, $smiliecache, $cache;

	if (!$lang->yuieditor) {
		$lang->load('yuieditor');
	}

	$editor_lang_strings = array(
		"editor_bold" => "Bold",
		"editor_italic" => "Italic",
		"editor_underline" => "Underline",
		"editor_strikethrough" => "Strikethrough",
		"editor_subscript" => "Subscript",
		"editor_superscript" => "Superscript",
		"editor_alignleft" => "Align left",
		"editor_center" => "Center",
		"editor_alignright" => "Align right",
		"editor_justify" => "Justify",
		"editor_fontname" => "Font Name",
		"editor_fontsize" => "Font Size",
		"editor_fontcolor" => "Font Color",
		"editor_removeformatting" => "Remove Formatting",
		"editor_cut" => "Cut",
		"editor_cutnosupport" => "Your browser does not allow the cut command. Please use the keyboard shortcut Ctrl/Cmd-X",
		"editor_copy" => "Copy",
		"editor_copynosupport" => "Your browser does not allow the copy command. Please use the keyboard shortcut Ctrl/Cmd-C",
		"editor_paste" => "Paste",
		"editor_pastenosupport" => "Your browser does not allow the paste command. Please use the keyboard shortcut Ctrl/Cmd-V",
		"editor_pasteentertext" => "Paste your text inside the following box:",
		"editor_pastetext" => "PasteText",
		"editor_numlist" => "Numbered list",
		"editor_bullist" => "Bullet list",
		"editor_undo" => "Undo",
		"editor_redo" => "Redo",
		"editor_rows" => "Rows:",
		"editor_cols" => "Cols:",
		"editor_inserttable" => "Insert a table",
		"editor_inserthr" => "Insert a horizontal rule",
		"editor_code" => "Code",
		"editor_width" => "Width (optional):",
		"editor_height" => "Height (optional):",
		"editor_insertimg" => "Insert an image",
		"editor_email" => "E-mail:",
		"editor_insertemail" => "Insert an email",
		"editor_url" => "URL:",
		"editor_insertlink" => "Insert a link",
		"editor_unlink" => "Unlink",
		"editor_more" => "More",
		"editor_insertemoticon" => "Insert an emoticon",
		"editor_videourl" => "Video URL:",
		"editor_videotype" => "Video Type:",
		"editor_insert" => "Insert",
		"editor_insertyoutubevideo" => "Insert a YouTube video",
		"editor_currentdate" => "Insert current date",
		"editor_currenttime" => "Insert current time",
		"editor_print" => "Print",
		"editor_viewsource" => "View source",
		"editor_description" => "Description (optional):",
		"editor_enterimgurl" => "Enter the image URL:",
		"editor_enteremail" => "Enter the e-mail address:",
		"editor_enterdisplayedtext" => "Enter the displayed text:",
		"editor_enterurl" => "Enter URL:",
		"editor_enteryoutubeurl" => "Enter the YouTube video URL or ID:",
		"editor_insertquote" => "Insert a Quote",
		"editor_invalidyoutube" => "Invalid YouTube video",
		"editor_dailymotion" => "Dailymotion",
		"editor_metacafe" => "MetaCafe",
		"editor_veoh" => "Veoh",
		"editor_vimeo" => "Vimeo",
		"editor_youtube" => "Youtube",
		"editor_facebook" => "Facebook",
		"editor_liveleak" => "LiveLeak",
		"editor_insertvideo" => "Insert a video",
		"editor_php" => "PHP",
		"editor_maximize" => "Maximize"
	);
	$editor_language = "yuivar = {\n";

	$editor_languages_count = count($editor_lang_strings);
	$i = 0;
	foreach($editor_lang_strings as $lang_string => $key)
	{
		$i++;
		$js_lang_string = str_replace("\"", "\\\"", $key);
		$string = str_replace("\"", "\\\"", $lang->$lang_string);
		$editor_language .= "\t\"{$js_lang_string}\": \"{$string}\"";

		if($i < $editor_languages_count)
		{
			$editor_language .= ",";
		}

		$editor_language .= "\n";
	}

	$editor_language .= "};";

	if(defined("IN_ADMINCP"))
	{
		global $page;
		$codeinsertquick = $page->build_codebuttons_editor($editor_language, $smilies);
	}
	else
	{
		// Smilies
		$emoticon = "";
		$emoticons_enabled = "false";
		if($smilies && $mybb->settings['smilieinserter'] != 0 && $mybb->settings['smilieinsertercols'] && $mybb->settings['smilieinsertertot'])
		{
			$emoticon = ",emoticon";
			$emoticons_enabled = "true";

			if(!$smiliecache)
			{
				if(!is_array($smilie_cache))
				{
					$smilie_cache = $cache->read("smilies");
				}
				foreach($smilie_cache as $smilie)
				{
					if($smilie['showclickable'] != 0)
					{
						$smilie['image'] = str_replace("{theme}", $theme['imgdir'], $smilie['image']);
						$smiliecache[$smilie['sid']] = $smilie;
					}
				}
			}

			unset($smilie);

			if(is_array($smiliecache))
			{
				reset($smiliecache);

				$smilies_json = $dropdownsmilies = $moresmilies = "";
				$i = 0;

				foreach($smiliecache as $smilie)
				{
					$finds = explode("\n", $smilie['find']);

					// Only show the first text to replace in the box
					$smilie['find'] = $finds[0];

					$find = htmlspecialchars_uni($smilie['find']);
					$image = htmlspecialchars_uni($smilie['image']);
					$smilies_json .= '"'.$mybb->asset_url.'/'.$image.'": "'.$find.'",';
					if($i < $mybb->settings['smilieinsertertot'])
					{
						$dropdownsmilies .= '"'.$find.'": "'.$mybb->asset_url.'/'.$image.'",';
					}
					else
					{
						$moresmilies .= '"'.$find.'": "'.$mybb->asset_url.'/'.$image.'",';
					}

					++$i;
				}
			}
		}
		
		if($mybb->settings['yuieditor_quickquote'] == 1 && strpos($_SERVER['PHP_SELF'],'showthread.php'))
		{
			$quickquote = "<script type=\"text/javascript\" src=\"".$mybb->asset_url."/jscripts/yui/editor/thread.quickquote.js?ver=".YE."\"></script>";
			$ye_smilies = $smilies_json;
		}
		
		if($mybb->settings['yuieditor_autosave'] == 1)
		{
			$ye_autosave = "<script type=\"text/javascript\" src=\"".$mybb->asset_url."/jscripts/yui/editor/yui.autosave.js?ver=".YE."\"></script>";
		}

		if($mybb->settings['yuieditor_mention'] == 1)
		{
			$yui_mention = "<link rel=\"stylesheet\" href=\"".$mybb->asset_url."/jscripts/yui/editor/jquery.atwho.min.css?ver=".YE."\" type=\"text/css\" media=\"all\" />
<script type=\"text/javascript\" src=\"".$mybb->asset_url."/jscripts/yui/editor/jquery.caret.min.js?ver=".YE."\"></script>
<script type=\"text/javascript\" src=\"".$mybb->asset_url."/jscripts/yui/editor/jquery.atwho.min.js?ver=".YE."\"></script>
<script type=\"text/javascript\" src=\"".$mybb->asset_url."/jscripts/yui/editor/yui.mention.js?ver=".YE."\"></script>";
		}			

		eval("\$yuiinsertquick = \"".$templates->get("yuibutquick")."\";");
	}

	return $yuiinsertquick;
}

$plugins->add_hook("showthread_start", "yuieditor_quick");
$plugins->add_hook("private_start", "yuieditor_quick");
function yuieditor_quick () {

	global $smilieinserter, $yuibutquick, $mybb;

	$yuibutquick = yuieditor_inserter_quick();
	$smilieinserter = '';
	if($mybb->settings['yuieditor_smile'] != 0) {
		$smilieinserter = build_clickable_smilies();
	}
}

$plugins->add_hook('postbit', 'ye_quickquote_postbit');

function ye_canonical($link)
{
    global $settings, $plugins, $can_link;

    if($link)
    {
        $can_link = "<link rel=\"canonical\" href=\"{$settings['bburl']}/$link\" />";
    }
}

function ye_quickquote_postbit(&$post)
{
	global $templates, $lang, $mybb, $postcounter, $tid, $page;

	$post['quick_quote'] = '';
	if($mybb->settings['yuieditor_quickquote'] != 0) {
		eval("\$post['quick_quote'] = \"" . $templates->get("postbit_quickquote") . "\";");
	}

	if($mybb->settings['yuieditor_canonicallink'] != 0) {
		if (($postcounter - 1) % $mybb->settings['postsperpage'] == "0") {
			if($tid > 0)
			{
				if($page > 1)
				{
					ye_canonical(get_thread_link($tid, $page));
				}

				else
				{
					ye_canonical(get_thread_link($tid));
				}
			}
		}
	}
}

global $settings;

if ($settings['yuieditor_autosave']) {
    $plugins->add_hook('usercp_start', 'YE_autosave_list');
}
function YE_autosave_list()
{
	global $mybb, $lang, $theme, $templates, $headerinclude, $header, $footer, $usercpnav;

	if ($mybb->input['action'] == 'ye_autosave') {
		if (!$lang->yuieditor) {
			$lang->load('yuieditor');
		}

		add_breadcrumb($lang->nav_usercp, 'usercp.php');
		add_breadcrumb($lang->yuieditor_page_title, 'usercp.php?action=ye_autosave');

		eval("\$content = \"".$templates->get('usercp_ye_drafts')."\";");
		output_page($content);
	}
}

if ($settings['yuieditor_autosave']) {
    $plugins->add_hook('usercp_menu', 'YE_ucpmenu', 20);
}
function YE_ucpmenu()
{
	global $mybb, $templates, $theme, $usercpmenu, $lang, $collapsed, $collapsedimg;

	if (!$lang->yuieditor) {
		$lang->load('yuieditor');
	}

    eval("\$usercpmenu .= \"".$templates->get('usercp_nav_ye')."\";");
}

if ($settings['yuieditor_replace']) {
    $plugins->add_hook('pre_output_page', 'yuieditor_replace', 100);
	
	$plugin_local = array('calendar_start', 'editpost_start', 'modcp_start', 'newreply_start', 'newthread_start', 'private_start', 'usercp_start', 'warnings_start');
	foreach ($plugin_local as &$local) {
		$plugins->add_hook(''.$local.'', 'yuieditor');
	}
}

function yuieditor_replace($page) {

	$page = str_replace(build_mycode_inserter('signature'), '', $page);
	$page = str_replace(build_mycode_inserter('message'), '', $page);
	
	return $page;
}

function yuieditor () {

	global $yuibutquick;

	$yuibutquick = yuieditor_inserter_quick();
}
?>