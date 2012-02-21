{include file='header.tpl' menu='topic_action' showWhiteBack=true}


{literal}
<script language="JavaScript" type="text/javascript">
document.addEvent('domready', function() {
	new Autocompleter.Request.HTML($('topic_tags'), DIR_WEB_ROOT+'/include/ajax/tagAutocompleter.php?security_ls_key='+LIVESTREET_SECURITY_KEY, {
		'indicatorClass': 'autocompleter-loading', // class added to the input during request
		'minLength': 2, // We need at least 1 character
		'selectMode': 'pick', // Instant completion
		'multiple': true // Tag support, by default comma separated
	});
});
</script>
<style>
#content{width:100%!important;}
#linch_frame{display:none;padding:0 0 15px 0;}
#linch_frame img{max-width:895px!important;width:auto!important;height:auto!important;margin:0;}
#linch_help{display:none;color:#000;padding:10px 0 0 0;}
</style>
{/literal}


{if $oConfig->GetValue('view.tinymce')}
<script type="text/javascript" src="{cfg name='path.root.engine_lib'}/external/tinymce_3.2.7/tiny_mce.js"></script>

<script type="text/javascript">
{literal}
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_buttons1 : "lshselect,bold,italic,underline,strikethrough,|,bullist,numlist,|,undo,redo,|,lslink,unlink,lsvideo,lsimage,pagebreak,code",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	theme_advanced_resize_horizontal : 0,
	theme_advanced_resizing_use_cookie : 0,
	theme_advanced_path : false,
	object_resizing : true,
	force_br_newlines : true,
    forced_root_block : '', // Needed for 3.x
    force_p_newlines : false,
    plugins : "lseditor,safari,inlinepopups,media,pagebreak",
    convert_urls : false,
    extended_valid_elements : "embed[src|type|allowscriptaccess|allowfullscreen|width|height]",
    pagebreak_separator :"<cut>",
    media_strict : false,
    language : TINYMCE_LANG
});
{/literal}
</script>

{else}
	{include file='window_load_img.tpl' sToLoad='topic_text'}
{/if}
<link rel="stylesheet" type="text/css" href="{cfg name='path.root.site'}/g/img/jquery/ui/themes/smoothness/ui.all.css" />
<script type="text/javascript" src="{cfg name='path.root.site'}/g/js/raphael.js"></script>
<script type="text/javascript" src="{cfg name='path.root.site'}/g/js/jquery/jquery.js"></script>
<script type="text/javascript" src="{cfg name='path.root.site'}/g/js/jquery/jquery.json.js"></script>
<script type="text/javascript" src="{cfg name='path.root.site'}/g/js/jquery/ui/ui.core.js"></script>
<script type="text/javascript" src="{cfg name='path.root.site'}/g/js/jquery/ui/ui.widget.js"></script>
<script type="text/javascript" src="{cfg name='path.root.site'}/g/js/jquery/ui/ui.mouse.js"></script>
<script type="text/javascript" src="{cfg name='path.root.site'}/g/js/jquery/ui/ui.draggable.js"></script>
<script type="text/javascript" src="{cfg name='path.root.site'}/g/js/jquery/ui/ui.resizable.js"></script>
<script type="text/javascript" src="{cfg name='path.root.site'}/g/js/jquery/jquery.linch.js?1"></script>
<script type="text/javascript">
{literal}
jQuery.noConflict();
$1 = jQuery;
jQuery(function() {
	var linched = false;
	var old_data;
	$1('#linch_help_link').click(function() {
		if ($1('#linch_help').css('display') == 'none') $1('#linch_help').css('display', 'block');
		else $1('#linch_help').css('display', 'none');
		return false;
	});
	$1('#linch_form').submit(function() {
		var data = $1('#linch').linch_get();
		if (data.length > 0) {
			$1('#topic_linch').val($1.toJSON(data));
			linched = true;
		}
		if (!linched) {
			alert('Вы еще не линчевали картинку');
			return false;
		}
	});
	$1('#topic_linch_url').val($1('#topic_linchurl').val());
	$1('#linch_load').click(function() {
		var url = $1('#topic_linch_url').val();
		if ($1.trim(url).length == 0) {
			alert('Введите URL картинки для линча');
			return;
		}
		if (!/^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url)) {
			alert('Неверный URL картинки для линча');
			return;
		}
		if ($1('#linch').length) {
			var data = $1('#linch').linch_get();
			if (data.length && !confirm('Если вы продолжите, ваш текущий линч будет удален.\nПродолжить?')) return;
		}
		var i1 = new Image();
		i1.onerror = function() {
			$1('#topic_linch_url').attr('disabled', false);
			$1('#linch_load').attr('disabled', false).val($1('#linch_load').data('oldval'));
			alert('Не удалось загрузить картинку для линча');
		};
		i1.onload = function() {
			$1('#topic_linchurl').val(this.src);
			$1('#topic_linch_url').attr('disabled', false);
			$1('#linch_load').attr('disabled', false).val($1('#linch_load').data('oldval'));
			src = this.src;
			$1('#topic_linch').val('');
			$1('#linch_frame').slideUp(200, function() {
				$1('#linch').remove();
				$1(this).html('<img src="' + src + '" id="linch" alt="" />').slideDown(400, function() {
					var d = null;
					if (old_data) {
						d = $1.evalJSON(old_data);
						d = $1.evalJSON(d);
					}
					$1('#linch').linch({
						'data': (d ? d : []),
						'color': [
						    {
							    title: 'Красота',
							    color: '#eec1a0'
							},
							{
							    title: 'Техника',
							    color: '#99b5ea'
							},
							{
							    title: 'Реклама',
							    color: '#79e571'
							}
						],
						'color_show': true
					});
					old_data = null;
				});
			});
		};
		i1.src = url;
		$1('#topic_linch_url').attr('disabled', true);
		$1('#linch_load').data('oldval', $1('#linch_load').val()).attr('disabled', true).val('Идет загрузка картинки..');
	});
	var old_data = $1('#topic_linch').val();
	if (old_data) $1('#linch_load').click();
});
{/literal}
</script>
			<div class="topic" style="display: none;">
				<div class="content" id="text_preview"></div>
			</div>

			<div class="profile-user">
				{if $sEvent=='add'}
					<h1>{$aLang.topic_linch_create}</h1>
				{else}
					<h1>{$aLang.topic_linch_edit}</h1>
				{/if}
				<form id="linch_form" action="" method="POST" enctype="multipart/form-data">
					{hook run='form_add_topic_topic_begin'}
					<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" />

					<p><label for="blog_id">{$aLang.topic_create_blog}</label>
					<select name="blog_id" id="blog_id" onChange="ajaxBlogInfo(this.value);">
     					<option value="0">{$aLang.topic_create_blog_personal}</option>
     					{foreach from=$aBlogsAllow item=oBlog}
     						<option value="{$oBlog->getId()}" {if $_aRequest.blog_id==$oBlog->getId()}selected{/if}>{$oBlog->getTitle()}</option>
     					{/foreach}
     				</select></p>

     				<script language="JavaScript" type="text/javascript">
     					ajaxBlogInfo($('blog_id').value);
     				</script>

					<p><label for="topic_title">{$aLang.topic_create_title}:</label><br />
					<input type="text" id="topic_title" name="topic_title" value="{$_aRequest.topic_title}" class="w100p" /><br />
       				<span class="form_note">{$aLang.topic_create_title_notice}</span>
					</p>

					<p><label for="topic_title">{$aLang.topic_create_linch}:</label><br />
					<input type="text" id="topic_linch_url" name="topic_linch_url" value="" class="w100p" /><br />
       				<input type="hidden" id="topic_linchurl" name="topic_linchurl" value="{$_aRequest.topic_linchurl}" />
       				<textarea style="display:none;" id="topic_linch" name="topic_linch">{$_aRequest.topic_linch}</textarea>
       				<input type="button" id="linch_load" value="Загрузить картинку и начать линч" /><br />
       				<span class="form_note">{$aLang.topic_create_linch_notice}</span>
					</p>

					<div id="linch_frame"></div>

					<div>{if !$oConfig->GetValue('view.tinymce')}<div class="note">{$aLang.topic_create_text_notice}</div>{/if}<label for="topic_text">{$aLang.topic_create_text}:</label>
					{if !$oConfig->GetValue('view.tinymce')}
            			<div class="panel_form">
							<select onchange="lsPanel.putTagAround('topic_text',this.value); this.selectedIndex=0; return false;" style="width: 91px;">
            					<option value="">{$aLang.panel_title}</option>
            					<option value="h4">{$aLang.panel_title_h4}</option>
            					<option value="h5">{$aLang.panel_title_h5}</option>
            					<option value="h6">{$aLang.panel_title_h6}</option>
            				</select>
            				<select onchange="lsPanel.putList('topic_text',this); return false;">
            					<option value="">{$aLang.panel_list}</option>
            					<option value="ul">{$aLang.panel_list_ul}</option>
            					<option value="ol">{$aLang.panel_list_ol}</option>
            				</select>
	 						<a href="#" onclick="lsPanel.putTagAround('topic_text','b'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/bold_ru.gif" width="20" height="20" title="{$aLang.panel_b}"></a>
	 						<a href="#" onclick="lsPanel.putTagAround('topic_text','i'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/italic_ru.gif" width="20" height="20" title="{$aLang.panel_i}"></a>
	 						<a href="#" onclick="lsPanel.putTagAround('topic_text','u'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/underline_ru.gif" width="20" height="20" title="{$aLang.panel_u}"></a>
	 						<a href="#" onclick="lsPanel.putTagAround('topic_text','s'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/strikethrough.gif" width="20" height="20" title="{$aLang.panel_s}"></a>
	 						&nbsp;
	 						<a href="#" onclick="lsPanel.putTagUrl('topic_text','{$aLang.panel_url_promt}'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/link.gif" width="20" height="20"  title="{$aLang.panel_url}"></a>
	 						<a href="#" onclick="lsPanel.putQuote('topic_text'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/quote.gif" width="20" height="20" title="{$aLang.panel_quote}"></a>
	 						<a href="#" onclick="lsPanel.putTagAround('topic_text','code'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/code.gif" width="30" height="20" title="{$aLang.panel_code}"></a>
	 						<a href="#" onclick="lsPanel.putTagAround('topic_text','video'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/video.gif" width="20" height="20" title="{$aLang.panel_video}"></a>

	 						<a href="#" onclick="showImgUploadForm(); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/img.gif" width="20" height="20" title="{$aLang.panel_image}"></a>
	 						<a href="#" onclick="lsPanel.putText('topic_text','<cut>'); return false;" class="button"><img src="{cfg name='path.static.skin'}/images/panel/cut.gif" width="20" height="20" title="{$aLang.panel_cut}"></a>
	 					</div>
	 				{/if}
					<textarea name="topic_text" id="topic_text" rows="20">{$_aRequest.topic_text}</textarea></div>

					<p><label for="topic_tags">{$aLang.topic_create_tags}:</label><br />
					<input type="text" id="topic_tags" name="topic_tags" value="{$_aRequest.topic_tags}" class="w100p" /><br />
       				<span class="form_note">{$aLang.topic_create_tags_notice}</span></p>

					<p><label for="topic_forbid_comment"><input type="checkbox" id="topic_forbid_comment" name="topic_forbid_comment" class="checkbox" value="1" {if $_aRequest.topic_forbid_comment==1}checked{/if}/>
					&mdash; {$aLang.topic_create_forbid_comment}</label><br />
					<span class="form_note">{$aLang.topic_create_forbid_comment_notice}</span></p>

					{if $oUserCurrent->isAdministrator()}
						<p><label for="topic_publish_index"><input type="checkbox" id="topic_publish_index" name="topic_publish_index" class="checkbox" value="1" {if $_aRequest.topic_publish_index==1}checked{/if}/>
						&mdash; {$aLang.topic_create_publish_index}</label><br />
						<span class="form_note">{$aLang.topic_create_publish_index_notice}</span></p>
					{/if}

					{hook run='form_add_topic_topic_end'}
					<p class="buttons">
					<input type="submit" name="submit_topic_publish" value="{$aLang.topic_create_submit_publish}" class="right" />
					<input type="submit" name="submit_topic_save" value="{$aLang.topic_create_submit_save}" />
					</p>
				</form>

			</div>


{include file='footer.tpl'}

