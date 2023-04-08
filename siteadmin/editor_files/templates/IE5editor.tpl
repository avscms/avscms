<table id="##name##_load_message" style="display:block; position:absolute; z-index:1000" width="##width##" height="##height2##">
	<tr> 
		<td valign="middle" style="text-align: center"><div style="margin: auto; background-color:#666666; border:1px solid #333333; padding: 10px; width: 100px; color:#FFFFFF; font-family:verdana,arial,helvetica,sans-serif; font-size:12px; font-weight:bold">##please_wait##&nbsp;</div></td>
	</tr>
</table>
<!-- begin 1st instance only -->
<script language="JavaScript" type="text/javascript" src="##directory##js/IE5script.js"></script>
<script language="JavaScript" type="text/javascript" src="##directory##js/editorShared.js"></script>
<script language="JavaScript" type="text/javascript" src="##directory##js/dialogEditorShared.js"></script>
<!-- end 1st instance only -->
<script language="JavaScript" type="text/javascript">
<!--// Hide
<!-- begin 1st instance only -->
document.createStyleSheet('##directory##editor_theme.css');
//<!-- begin ie50_remove -->
if (!wp_oPopUp) {var wp_oPopUp = window.createPopup()}
//<!-- end ie50_remove -->
var wp_directory = '##directory##';
var wp_is_ie50 = ##is_ie50##;
<!-- end 1st instance only -->
var config_##name## = new wp_config(); 
config_##name##.name = '##name##';
config_##name##.instance_lang = '##instance_lang##';
config_##name##.encoding = '##encoding##';
config_##name##.xhtml_lang = '##xhtml_lang##';
config_##name##.useXHTML = ##usexhtml##;
config_##name##.baseURLurl = '##baseURLurl##';
config_##name##.baseURL = '##baseURL##'
config_##name##.instance_img_dir = '##instance_img_dir##';
config_##name##.instance_doc_dir = '##instance_doc_dir##';
//<!-- begin removeserver -->
config_##name##.domain1 = new RegExp('(href=|src=|action=)"##domain##',"gi");
config_##name##.domain2 = new RegExp('(href=|src=|action=)"##domain2##',"gi");
//<!-- end removeserver -->
config_##name##.imagewindow = "##imgwindow##";
config_##name##.links = ##links##;
config_##name##.custom_inserts = ##custom_objects##;
config_##name##.stylesheet = ##stylesheet##;
config_##name##.imenu_height = ##imenu_height##;
config_##name##.bmenu_height = ##bmenu_height##;
config_##name##.smenu_height = ##smenu_height##;
config_##name##.tmenu_height = ##tmenu_height##;
config_##name##.usep = ##usep##;
config_##name##.showbookmarkmngr = ##showbookmarkmngr##;
config_##name##.subsequent = ##subsequent##;
config_##name##.color_swatches = '##color_swatches##';
config_##name##.border_visible = ##guidelines##;
config_##name##.doctype = '##doctype##';
config_##name##.charset = '##charset##';
// lang
config_##name##.lang['guidelines_hidden'] = '##guidelines_hidden##';
config_##name##.lang['guidelines_visible'] = '##guidelines_visible##';
config_##name##.lang['place_cursor_in_table'] = '##place_cursor_in_table##';
config_##name##.lang['only_split_merged_cells'] = '##only_split_merged_cells##';
config_##name##.lang['no_cell_right'] = '##no_cell_right##';
config_##name##.lang['different_row_spans'] = '##different_row_spans##';
config_##name##.lang['no_cell_below'] = '##no_cell_below##';
config_##name##.lang['different_column_spans'] = '##different_column_spans##';
config_##name##.lang['select_hyperlink_text'] = '##select_hyperlink_text##';
config_##name##.lang['upgrade'] = '##upgrade##';
config_##name##.lang['format'] = '##format##';
config_##name##.lang['font'] = '##font##';
config_##name##.lang['class'] = '##class##';
config_##name##.lang['size'] = '##size##';
function wp_##name##_mouseUpHandler (evt) {
	wp_mouseUpHandler(##name##, evt);
}
// End -->
</script>
<table id="##name##_container" width="##width##" height="##absheight##" class="wpContainer" border="0" cellpadding="0" cellspacing="0">
	<tr> 
		<td valign="bottom"> 
			<div id="##name##_tab_one" style="display:block;"> 
				<table id="##name##_toolbar1" class="wpToolbar" style="##toolbar1_style##" border="0" cellpadding="0" cellspacing="0">
					<tr> 
						##savebutton##
						<!-- begin print -->
						<td><img cid="forecolor" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'Print');" alt="##print##" src="##directory##images/print.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end print -->
						<!-- begin find -->
						<td><img cid="forecolor" class="wpReady" width="22" height="22" onClick="wp_findit(##name##);" alt="##find_and_replace##" src="##directory##images/find.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end find -->
						<!-- begin spacer1 -->
						<td><img class="wpSpacer" width="1" height="22" src="##directory##images/spacer.gif" alt="" /></td>
						<!-- end spacer1 -->
						<!-- begin cut -->
						<td><img cid="cut" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'Cut');" alt="##cut##" src="##directory##images/cut.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end cut -->
						<!-- begin copy -->
						<td><img cid="cut" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'Copy');" alt="##copy##" src="##directory##images/copy.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end copy -->
						<!-- begin paste -->
						<td><img cid="paste" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'Paste');" alt="##paste##" src="##directory##images/paste.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end paste -->
						<!-- begin pasteword -->
						<td><img cid="redo" class="wpReady" width="22" height="22" onClick="wp_paste_word_html(##name##,this);" alt="##paste_word##" src="##directory##images/pasteword.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end pasteword -->
						<!-- begin spacer2 -->
						<td><img class="wpSpacer" width="1" height="22" src="##directory##images/spacer.gif" alt="" /></td>
						<!-- end spacer2 -->
						<!-- begin undo -->
						<td><img cid="undo" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'Undo');" alt="##undo##" src="##directory##images/undo.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end undo -->
						<!-- begin redo -->
						<td><img cid="redo" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'Redo');" alt="##redo##" src="##directory##images/redo.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end redo -->
						<!-- begin spacer3 -->
						<td><img class="wpSpacer" width="1" height="22" src="##directory##images/spacer.gif" alt="" /></td>
						<!-- end spacer3 -->
						<!-- begin tbl -->
						<td><img cid="forecolor" class="wpReady" width="22" height="22" onClick="wp_open_table_window(##name##,this);" alt="##insert_table##" src="##directory##images/instable.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- begin edittable -->
						<td><img cid="edittable" class="wpReady" src="##directory##images/edittable.gif" width="22" height="22" alt="##table_properties##" onClick="wp_open_table_editor(##name##,this);" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<td><img cid="edittable" class="wpReady" src="##directory##images/insrow.gif" width="22" height="22" alt="##add_row##" onClick="wp_processRow(##name##,'choose',this);" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<td><img cid="edittable" class="wpReady" src="##directory##images/delrow.gif" width="22" height="22" alt="##delete_row##" onClick="wp_processRow(##name##,'remove',this);" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<td><img cid="edittable" class="wpReady" src="##directory##images/inscol.gif" width="22" height="22" alt="##insert_column##" onClick="wp_processColumn(##name##,'choose',this);" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<td><img cid="edittable" class="wpReady" src="##directory##images/delcol.gif" width="22" height="22" alt="##delete_column##" onClick="wp_processColumn(##name##,'remove',this);" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<td><img cid="edittable" class="wpReady" src="##directory##images/mrgcell.gif" width="22" height="22" alt="##merge_cell##" onClick="wp_mergeCell(##name##,this);" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<td><img cid="splitcell" class="wpReady" src="##directory##images/spltcell.gif" width="22" height="22" alt="##unmerge_cell##" onClick="wp_splitCell(##name##,this);" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end edittable -->
						<!-- end tbl -->
						<!-- begin spacer4 -->
						<td><img class="wpSpacer" width="1" height="22" src="##directory##images/spacer.gif" alt="" /></td>
						<!-- end spacer4 -->
						<!-- begin image -->
						<td><img cid="insertimage" class="wpReady" width="22" height="22" onClick="wp_open_image_window(##name##,this);" alt="##insert_image##" src="##directory##images/image.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end image -->
						<!-- begin smiley -->
						<td><img cid="insertimage" class="wpReady" width="22" height="22" onClick="wp_insert_smiley(##name##,this);" alt="##insert_emoticon##" src="##directory##images/smiley.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end smiley -->
						<!-- begin ruler -->
						<td><img cid="inserthorizontalrule" class="wpReady" width="22" height="22" onClick="wp_open_horizontal_rule_window(##name##,this);" alt="##horizontal_line##" src="##directory##images/icon_rule.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end ruler -->
						<!-- begin link -->
						<td><img cid="createlink" class="wpReady" width="22" height="22" onClick="wp_##hyperlink_function##;" alt="##insert_hyperlink##" src="##directory##images/link.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end link -->
						<!-- begin document -->
						<td><img cid="createlink" class="wpReady" width="22" height="22" onClick="wp_open_document_window(##name##,this);" alt="##document_link##" src="##directory##images/doc_link.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end document -->
						<!-- begin bookmark -->
						<td><img cid="insertimage" class="wpReady" width="22" height="22" onClick="wp_open_bookmark_window(##name##,this);" alt="##insert_bookmark##" src="##directory##images/bookmark.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end bookmark -->
						<!-- begin special -->
						<td><img cid="inserthorizontalrule" class="wpReady" width="22" height="22" onClick="wp_open_special_characters_window(##name##,this);" alt="##special_characters##" src="##directory##images/specialchar.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end special -->
						<!-- begin custom -->
						<td><img cid="inserthorizontalrule" class="wpReady" width="22" height="22" onClick="wp_custom_object(##name##,this);" alt="##insert_object##" src="##directory##images/custom.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end custom -->
					</tr>
				</table>
				<table id="##name##_toolbar2" class="wpToolbar" style="##toolbar2_style##" border="0" cellpadding="0" cellspacing="0">
					<tr> 
						<td> <table id="##name##_format_list" class="wpDropBorderWide" style="##format_list_style##" onClick="wp_show_menu(##name##,'format', this)" border="0" cellpadding="0" cellspacing="1" onMouseOver="this.style.backgroundColor = 'highlight';" onMouseOut="this.style.backgroundColor = '#ffffff';" title="##paragraph_format##">
								<tr> 
									<td width="70"><div id="##name##_format_list-text">##format##</div></td>
									<td width="10"><img unselectable="on" src="##directory##images/down_arrow.gif" width="10" height="14" alt="" /></td>
								</tr>
							</table>
							<iframe ##secure##width="272" height="202" id="##name##_format_frame" frameborder="0" class="wpFrameDropBorder"></iframe></td>
						<td> <table id="##name##_class_menu" class="wpDropBorderWide" style="##class_list_style##" onClick="wp_show_menu(##name##,'class', this)" border="0" cellpadding="0" cellspacing="1" onMouseOver="this.style.backgroundColor = 'highlight';" onMouseOut="this.style.backgroundColor = '#ffffff';" title="##style_class##">
								<tr> 
									<td width="70"><div id="##name##_class_menu-text">##class##</div></td>
									<td width="10"><img src="##directory##images/down_arrow.gif" width="10" height="14" alt="" /></td>
								</tr>
							</table>
							<iframe ##secure##width="272" height="141" id="##name##_class_frame" frameborder="0" class="wpFrameDropBorder"></iframe></td>
						<td> <table id="##name##_font-face" class="wpDropBorderWide" style="##font_list_style##" onClick="wp_show_menu(##name##,'font', this)" border="0" cellpadding="0" cellspacing="1" onMouseOver="this.style.backgroundColor = 'highlight';" onMouseOut="this.style.backgroundColor = '#ffffff';" title="##font_face##">
								<tr> 
									<td width="70"><div id="##name##_font-face-text">##font##</div></td>
									<td width="10"><img src="##directory##images/down_arrow.gif" width="10" height="14" alt="" /></td>
								</tr>
							</table>
							<iframe ##secure##width="272" height="141" id="##name##_font_frame" frameborder="0" class="wpFrameDropBorder"></iframe></td>
						<td> <table id="##name##_font_size" class="wpDropBorderNarrow" style="##size_list_style##" onClick="wp_show_menu(##name##,'size', this)" border="0" cellpadding="0" cellspacing="1" onMouseOver="this.style.backgroundColor = 'highlight';" onMouseOut="this.style.backgroundColor = '#ffffff';" title="##font_size##">
								<tr> 
									<td width="30"><div id="##name##_font_size-text">##size##</div></td>
									<td width="10"><img src="##directory##images/down_arrow.gif" width="10" height="14" alt="" /></td>
								</tr>
							</table>
							<iframe ##secure##width="112" height="202" id="##name##_size_frame" frameborder="0" class="wpFrameDropBorder"></iframe></td>
						<!-- begin spacer5 -->
						<td><img class="wpSpacer" width="1" height="22" src="##directory##images/spacer.gif" alt="" /></td>
						<!-- end spacer5 -->
						<!-- begin bold -->
						<td><img cid="bold" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'Bold');" alt="##bold##" src="##directory##images/bold.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end bold -->
						<!-- begin italic -->
						<td><img cid="italic" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'Italic');" alt="##italic##" src="##directory##images/italic.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end italic -->
						<!-- begin underline -->
						<td><img cid="underline" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'Underline');" alt="##underline##" src="##directory##images/under.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end underline -->
						<!-- begin spacer6 -->
						<td><img class="wpSpacer" width="1" height="22" src="##directory##images/spacer.gif" alt="" /></td>
						<!-- end spacer6 -->
						<!-- begin left -->
						<td><img cid="justifyleft" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'JustifyLeft');" alt="##align_left##" src="##directory##images/left.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end left -->
						<!-- begin center -->
						<td><img cid="justifycenter" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'JustifyCenter');" alt="##align_center##" src="##directory##images/center.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end center -->
						<!-- begin right -->
						<td><img cid="justifyright" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'JustifyRight');" alt="##align_right##" src="##directory##images/right.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end right -->
						<!-- begin full -->
						<td><img cid="justifyfull" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'JustifyFull');" alt="##justify##" src="##directory##images/justify.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end full -->
						<!-- begin spacer7 -->
						<td><img class="wpSpacer" width="1" height="22" src="##directory##images/spacer.gif" alt="" /></td>
						<!-- end spacer7 -->
						<!-- begin ol -->
						<td><img cid="insertorderedlist" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'InsertOrderedList');" alt="##numbering##" src="##directory##images/numlist.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end ol -->
						<!-- begin ul -->
						<td><img cid="insertunorderedlist" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'InsertUnorderedList');" alt="##bullets##" src="##directory##images/bullist.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end ul -->
						<!-- begin outdent -->
						<td><img cid="outdent" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'Outdent');" alt="##decrease_indent##" src="##directory##images/deindent.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end outdent -->
						<!-- begin indent -->
						<td><img cid="indent" class="wpReady" width="22" height="22" onClick="wp_callFormatting(##name##,'Indent');" alt="##increase_indent##" src="##directory##images/inindent.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end indent -->
						<!-- begin spacer8 -->
						<td><img class="wpSpacer" width="1" height="22" src="##directory##images/spacer.gif" alt="" /></td>
						<!-- end spacer8 -->
						<!-- begin color -->
						<td><img cid="forecolor" class="wpReady" width="22" height="22" onClick="wp_colordialog(##name##,this,'forecolor');"	alt="##font_color##" src="##directory##images/fontcolor.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end color -->
						<!-- begin highlight -->
						<td><img cid="backcolor" class="wpReady" width="22" height="22" onClick="wp_colordialog(##name##,this,'backcolor');" alt="##highlight##" src="##directory##images/bgcolor.gif" type="btn" onMouseOver="wp_m_over(this, ##name##);" onMouseOut="wp_m_out(this, ##name##);" onMouseDown="wp_m_down(this, ##name##);" onMouseUp="wp_m_up(this, ##name##);" /></td>
						<!-- end highlight -->
					</tr>
				</table>
				<iframe ##secure##id="##name##_editFrame" class="wpEditFrame" height="##height##" frameborder="0" onblur="##name##.safe=false;" onfocus="##name##.safe=true;"></iframe>
			</div>
			<div id="##name##_tab_two" style="display:none;"> 
				<textarea class="wpHtmlEditArea" style="height:##height2##px;" id="##name##" name="##original_name##" wrap="off">##htmlCode##</textarea>
			</div>
			<div id="##name##_tab_three" style="display:none;"> 
				<iframe ##secure##id="##name##_previewFrame" class="wpHtmlEditArea" style="height:##height3##px;" frameborder="0"></iframe>
			</div>
			<table id="##name##_tab_table" class="wpTabHolder" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr> 
					<td width="7" class="wpTabNoTab"><img src="##directory##images/spacer.gif" width="1" height="1" alt="" /></td>
					<!-- begin tab -->
					<!-- begin design -->
					<td id="##name##_designTab" class="wpTButtonUp" onMouseDown="wp_on_mouse_down_tab(this, ##name##)" onClick="##name##.showDesign();">&nbsp;<img src="##directory##images/normal.gif" width="10" height="10" alt="" />&nbsp;##design##&nbsp;&nbsp;</td>
					<!-- end design -->
					<!-- begin html -->
					<td id="##name##_sourceTab" class="wpTButtonDown" onMouseDown="wp_on_mouse_down_tab(this, ##name##)" onClick="##name##.showCode();">&nbsp;<img src="##directory##images/html.gif" width="10" height="10" alt="" />&nbsp;##html_code##&nbsp;&nbsp;</td>
					<!-- end html -->
					<!-- begin preview -->
					<td id="##name##_previewTab" class="wpTButtonDown" onMouseDown="wp_on_mouse_down_tab(this, ##name##)" onClick="##name##.showPreview();">&nbsp;<img src="##directory##images/preview.gif" width="10" height="10" alt="" />&nbsp;##preview##&nbsp;&nbsp;</td>
					<!-- end preview -->
					<!-- end tab -->
					<td width="100%" class="wpTabNoTab"><div class="wpStyled" align="right"><span id="##name##_moremessages">##br_tag##</span> &nbsp;
							<span id="##name##_messages" class="wpBorderMessage" onClick="wp_toggle_table_borders(##name##,this);" title="##toggle_guidelines##" onMouseOver="this.style.textDecoration='underline'" onMouseOut="this.style.textDecoration='none'"></span></div></td>
				</tr>
			</table>
			<!-- begin hidden stuff ---------------------------------------------------------------------------------------------------->
			<!-- begin ie50_remove -->
			<div id="##name##_hidden">
			<!-- standard context menu -->
			<div id="##name##_standardMenu" style="display:none"> 
				<div class="wpContextBorder"> 
					<table class="wpContextTable" style="height:##smenu_height##px;" border="0" cellpadding="0" cellspacing="0">
						<tr cid="cut" onClick="parent.wp_callFormatting(parent.wp_current_obj,'cut')" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/cut.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##cut##</td>
						</tr>
						<tr cid="cut" onClick="parent.wp_callFormatting(parent.wp_current_obj,'copy')" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/copy.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##copy##</td>
						</tr>
						<tr cid="paste" onClick="parent.wp_callFormatting(parent.wp_current_obj,'Paste')" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							  <td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/paste.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##paste##</td>
						</tr>
						<!-- begin pasteword -->
						<tr cid="insertimage" onClick="parent.wp_paste_word_html(parent.wp_current_obj,this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/pasteword.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##paste_word##</td>
						</tr>
						<!-- end pasteword -->
						<!-- begin link -->
						<tr cid="forecolor"> 
							<td class="wpContextCellOne"><img src="##directory##images/spacer.gif" width="1" height="1" alt="" /></td>
							<td align="right"><img style="background-color:threedshadow; margin: 3px 0px"  src="##directory##images/spacer.gif" width="200" height="1" alt="" /></td>
						</tr>
						<tr cid="createlink" onClick="parent.wp_##hyperlink_function2##" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/link.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##insert_hyperlink##</td>
						</tr>
						<!-- end link -->
						<!-- begin document -->
						<tr cid="createlink" onClick="parent.wp_open_document_window(parent.wp_current_obj,this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/doc_link.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##document_link##</td>
						</tr>
						<!-- end document -->
					</table>
				</div>
			</div>
			<!-- image context menu -->
			<div id="##name##_imageMenu" style="display:none"> 
				<div class="wpContextBorder"> 
					<table class="wpContextTable" style="height:##imenu_height##px;" border="0" cellpadding="0" cellspacing="0">
						<tr cid="cut" onClick="parent.wp_callFormatting(parent.wp_current_obj,'cut')" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/cut.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##cut##</td>
						</tr>
						<tr cid="cut" onClick="parent.wp_callFormatting(parent.wp_current_obj,'copy')" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/copy.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##copy##</td>
						</tr>
						<tr cid="paste" onClick="parent.wp_callFormatting(parent.wp_current_obj,'Paste')" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/paste.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##paste##</td>
						</tr>
						<!-- begin pasteword -->
						<tr cid="insertimage" onClick="parent.wp_paste_word_html(parent.wp_current_obj,this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/pasteword.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##paste_word##</td>
						</tr>
						<!-- end pasteword -->
						<!-- begin image -->
						<tr cid="forecolor"> 
							<td class="wpContextCellOne"><img src="##directory##images/spacer.gif" width="1" height="1" alt="" /></td>
							<td align="right"><img style="background-color:threedshadow; margin: 3px 0px"  src="##directory##images/spacer.gif" width="200" height="1" alt="" /></td>
						</tr>
						<tr cid="insertimage" onClick="parent.wp_open_image_window(parent.wp_current_obj,this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img class="wpDisabled" width="22" height="22" alt="" src="##directory##images/image.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##image_properties##</td>
						</tr>
						<!-- end image -->
						<!-- begin link -->
						<tr cid="forecolor"> 
							<td class="wpContextCellOne"><img src="##directory##images/spacer.gif" width="1" height="1" alt="" /></td>
							<td align="right"><img style="background-color:threedshadow; margin: 3px 0px"  src="##directory##images/spacer.gif" width="200" height="1" alt="" /></td>
						</tr>
						<tr cid="createlink" onClick="parent.wp_##hyperlink_function2##" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/link.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##insert_hyperlink##</td>
						</tr>
						<!-- end link -->
						<!-- begin document -->
						<tr cid="createlink" onClick="parent.wp_open_document_window(parent.wp_current_obj,this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/doc_link.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##document_link##</td>
						</tr>
						<!-- end document -->
					</table>
				</div>
			</div>
			<!-- boomark context menu -->
			<div id="##name##_bookmarkMenu" style="display:none"> 
				<div class="wpContextBorder"> 
					<table class="wpContextTable" style="height:##bmenu_height##px;" border="0" cellpadding="0" cellspacing="0">
						<tr cid="cut" onClick="parent.wp_callFormatting(parent.wp_current_obj,'cut')" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/cut.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##cut##</td>
						</tr>
						<tr cid="cut" onClick="parent.wp_callFormatting(parent.wp_current_obj,'copy')" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/copy.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##copy##</td>
						</tr>
						<tr cid="paste" onClick="parent.wp_callFormatting(parent.wp_current_obj,'Paste')" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/paste.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##paste##</td>
						</tr>
						<!-- begin pasteword -->
						<tr cid="insertimage" onClick="parent.wp_paste_word_html(parent.wp_current_obj,this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/pasteword.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##paste_word##</td>
						</tr>
						<!-- end pasteword -->
						<!-- begin bookmark -->
						<tr cid="forecolor"> 
							<td class="wpContextCellOne"><img src="##directory##images/spacer.gif" width="1" height="1" alt="" /></td>
							<td align="right"><img style="background-color:threedshadow; margin: 3px 0px"  src="##directory##images/spacer.gif" width="200" height="1" alt="" /></td>
						</tr>
						<tr cid="insertimage" onClick="parent.wp_open_bookmark_window(parent.wp_current_obj,this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img class="wpDisabled" width="22" height="22" alt="" src="##directory##images/bookmark.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##bookmark_properties##</td>
						</tr>
						<!-- end bookmark -->
					</table>
				</div>
			</div>
			<!-- table context menu -->
			<div id="##name##_tableMenu" style="display:none"> 
				<div class="wpContextBorder"> 
					<table class="wpContextTable" style="height:##tmenu_height##px;" border="0" cellpadding="0" cellspacing="0">
						<tr cid="cut" onClick="parent.wp_callFormatting(parent.wp_current_obj,'cut')" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/cut.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##cut##</td>
						</tr>
						<tr cid="cut" onClick="parent.wp_callFormatting(parent.wp_current_obj,'copy')" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/copy.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##copy##</td>
						</tr>
						<tr cid="paste" onClick="parent.wp_callFormatting(parent.wp_current_obj,'Paste')" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/paste.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##paste##</td>
						</tr>
						<!-- begin pasteword -->
						<tr cid="forecolor" onClick="parent.wp_paste_word_html(parent.wp_current_obj,this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/pasteword.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##paste_word##</td>
						</tr>
						<!-- end pasteword -->
						<!-- begin tbl -->
						<!-- begin edittable -->
						<tr cid="forecolor" > 
							<td class="wpContextCellOne"><img src="##directory##images/spacer.gif" width="1" height="1" alt="" /></td>
							<td align="right"><img style="background-color:threedshadow; margin: 3px 0px"  src="##directory##images/spacer.gif" width="240" height="1" alt="" /></td>
						</tr>
						<tr cid="forecolor" onClick="parent.wp_open_table_editor(parent.wp_current_obj,this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/edittable.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##table_properties##</td>
						</tr>
						<tr cid="forecolor" onClick="parent.wp_processRow(parent.wp_current_obj,'addabove',this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/insrowabove.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##add_row_above##</td>
						</tr>
						<tr cid="forecolor" onClick="parent.wp_processRow(parent.wp_current_obj,'addbelow',this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/insrowbelow.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##add_row_below##</td>
						</tr>
						<tr cid="forecolor" onClick="parent.wp_processColumn(parent.wp_current_obj,'addleft',this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/inscolleft.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##add_column_left##</td>
						</tr>
						<tr cid="forecolor" onClick="parent.wp_processColumn(parent.wp_current_obj,'addright',this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/inscolright.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##add_column_right##</td>
						</tr>
						<tr cid="forecolor" onClick="parent.wp_processRow(parent.wp_current_obj,'remove',this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/delrow.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##delete_row##</td>
						</tr>
						<tr cid="forecolor" onClick="parent.wp_processColumn(parent.wp_current_obj,'remove',this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/delcol.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##delete_column##</td>
						</tr>
						<tr cid="mergeright" onClick="parent.wp_mergeRight(parent.wp_current_obj,this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/mrgcellh.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##merge_right##</td>
						</tr>
						<tr cid="mergebelow" onClick="parent.wp_mergeDown(parent.wp_current_obj,this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/mrgcelld.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##merge_below##</td>

						</tr>
						<tr cid="unmergeright" onClick="parent.wp_unMergeRight(parent.wp_current_obj,this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/spltcellh.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##unmerge_right##</td>
						</tr>
						<tr cid="unmergebelow" onClick="parent.wp_unMergeDown(parent.wp_current_obj,this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/unmrgcelld.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##unmerge_below##</td>
						</tr>
						<!-- end edittable -->
						<!-- end tbl -->
						<!-- begin link -->
						<tr cid="forecolor" > 
							<td class="wpContextCellOne"><img src="##directory##images/spacer.gif" width="1" height="1" alt="" /></td>
							<td align="right"><img style="background-color:threedshadow; margin: 3px 0px"  src="##directory##images/spacer.gif" width="240" height="1" alt="" /></td>
						</tr>
						<tr cid="createlink" onClick="parent.wp_##hyperlink_function2##" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/link.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##insert_hyperlink##</td>
						</tr>
						<!-- end link -->
						<!-- begin document -->
						<tr cid="createlink" onClick="parent.wp_open_document_window(parent.wp_current_obj,this)" onMouseOver="parent.wp_menuover(this)" onMouseOut="parent.wp_menuout(this)"> 
							<td class="wpContextCellOne"><img width="22" height="22" alt="" src="##directory##images/doc_link.gif" /></td>
							<td class="wpContextCellTwo">&nbsp;##document_link##</td>
						</tr>
						<!-- end document -->
					</table>
				</div>
			</div>
			<!-- end ie50_remove -->
			<!-- drop-down menus -->
			<div id="##name##_font-menu" style="display:none"> 
			<div class="off" onClick="parent.wp_change_font(parent.wp_current_obj,'null');off(this)" onMouseOver="on(this)" onMouseOut="off(this)">##default##</div>
				##font_menu## 
			</div>
			<div id="##name##_size-menu" style="display:none">
				<div class="off" onClick="parent.wp_change_font_size(parent.wp_current_obj,'null');off(this)" onMouseOver="on(this)" onMouseOut="off(this)">##default##</div>
				##size_menu##
			</div>
			<div id="##name##_format-menu" style="display:none"> 
				##format_menu##
			</div>
			<div id="##name##_class-menu" style="display:none"> 
				<div class="off" onClick="parent.wp_change_class(parent.wp_current_obj,'wp_none');off(this)" onMouseOver="on(this)" onMouseOut="off(this)">##clear_styles##</div>
				##class_menu## </div>
			</div>
			<!-- end hidden stuff ----------------------------------------------------------------------------------------------->
		</td>
	</tr>
</table>
<script language="JavaScript" type="text/javascript">
<!--//
var ##name## = document.getElementById('##name##');
//-->
</script>
<noscript>
<p>##javascript_warning##</p>
</noscript>
