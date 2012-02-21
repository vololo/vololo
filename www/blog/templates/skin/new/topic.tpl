
			{assign var="oBlog" value=$oTopic->getBlog()}
			{assign var="oUser" value=$oTopic->getUser()}
			{assign var="oVote" value=$oTopic->getVote()}
			<!-- Topic -->
			<div class="topic">
				<div class="favorite {if $oUserCurrent}{if $oTopic->getIsFavourite()}active{/if}{else}fav-guest{/if}"><a href="#" onclick="lsFavourite.toggle({$oTopic->getId()},this,'topic'); return false;"></a></div>
				<h1 class="title">
					{if $oTopic->getPublish()==0}
						<img src="{cfg name='path.static.skin'}/images/topic_unpublish.gif" border="0" title="{$aLang.topic_unpublish}" width="16" height="16" alt="{$aLang.topic_unpublish}">
					{/if}
					{$oTopic->getTitle()|escape:'html'}
					{if $oTopic->getType()=='link'}
  						<img src="{cfg name='path.static.skin'}/images/link_url_big.gif" border="0" title="{$aLang.topic_link}" width="16" height="16" alt="{$aLang.topic_link}">
  					{/if}
				</h1>
				<ul class="action">
					<li><a href="{$oBlog->getUrlFull()}">{$oBlog->getTitle()|escape:'html'}</a>&nbsp;&nbsp;</li>
					{if $oUserCurrent and ($oUserCurrent->getId()==$oTopic->getUserId() or $oUserCurrent->isAdministrator() or $oBlog->getUserIsAdministrator() or $oBlog->getUserIsModerator() or $oBlog->getOwnerId()==$oUserCurrent->getId())}
  						<li class="edit"><a href="{cfg name='path.root.web'}/{$oTopic->getType()}/edit/{$oTopic->getId()}/" title="{$aLang.topic_edit}">{$aLang.topic_edit}</a></li>
  					{/if}
					{if $oUserCurrent and ($oUserCurrent->isAdministrator() or $oBlog->getUserIsAdministrator() or $oBlog->getOwnerId()==$oUserCurrent->getId())}
  						<li class="delete"><a href="{router page='topic'}delete/{$oTopic->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}" title="{$aLang.topic_delete}" onclick="return confirm('{$aLang.topic_delete_confirm}');">{$aLang.topic_delete}</a></li>
  					{/if}
				</ul>
				<div class="content">


			{if $oTopic->getType()=='question'}

    		<div id="topic_question_area_{$oTopic->getId()}">
    		{if !$oTopic->getUserQuestionIsVote()}
    			<ul class="poll-new">
				{foreach from=$oTopic->getQuestionAnswers() key=key item=aAnswer}
					<li><label for="topic_answer_{$oTopic->getId()}_{$key}"><input type="radio" id="topic_answer_{$oTopic->getId()}_{$key}" name="topic_answer_{$oTopic->getId()}"  value="{$key}" onchange="$('topic_answer_{$oTopic->getId()}_value').setProperty('value',this.value);"/> {$aAnswer.text|escape:'html'}</label></li>
				{/foreach}
					<li>
					<input type="submit"  value="{$aLang.topic_question_vote}" onclick="ajaxQuestionVote({$oTopic->getId()},$('topic_answer_{$oTopic->getId()}_value').getProperty('value'));">
					<input type="submit"  value="{$aLang.topic_question_abstain}"  onclick="ajaxQuestionVote({$oTopic->getId()},-1)">
					</li>
					<input type="hidden" id="topic_answer_{$oTopic->getId()}_value" value="-1">
				</ul>
				<span>{$aLang.topic_question_vote_result}: {$oTopic->getQuestionCountVote()}. {$aLang.topic_question_abstain_result}: {$oTopic->getQuestionCountVoteAbstain()}</span><br>
			{else}
				{include file='topic_question.tpl'}
			{/if}
			</div>
			<br>

    		{/if}
			{if $oTopic->getType()=='linch'}
{literal}
<style>
#content{width:100%!important;}
#sidebar{display:none!important;}
#linch_frame{display:none;}
#linch_frame img{display:block;max-width:895px!important;width:auto!important;height:auto!important;margin:0;}
#linch_bar{overflow:hidden;font-size:13px;padding:30px 0 20px 0;visibility:hidden;-moz-user-select:none;-o-user-select:none;-khtml-user-select:none;user-select:none;}
#linch_bar a{display:block;float:left;padding:2px 5px;margin:0 10px 0 0;outline:none;}
#linch_bar .cur{background:#EFF0D1;color:#000;text-decoration:none;}
#linch_bar .l_my{color:#fff;background:red;text-decoration:none;clear:both;margin:15px 0 0 0;font-weight:bold;}
#linch_form{display:none;}
</style>
{/literal}
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
linch_loaded = false;

jQuery(function() {
	var url = $1('#linch_url').val();
	if (url) {
		$1('#linch_frame').html('Загрузка картинки линча').slideDown(200, function() {
			var i1 = new Image();
			i1.onerror = function() {
				$1('#linch_frame').html('Ошибка загрузки картинки линча').slideDown(200);
			};
			i1.onload = function() {
				$1('#linch_frame').html('<img src="' + url + '" id="linch" alt="" />').slideDown(400, function() {
					$1('#linch_bar').css('visibility', 'visible');
				});
				$1('#linch_bar .l_original').click(function() {
					if (!linch_confirm()) return false;
					$1('#linch_bar .l_my').html('линчевать');
					$1('#linch_bar a').removeClass('cur');
					$1(this).addClass('cur');
					$1('#linch').linch_remove();
					return false;
				});
				$1('.linch_data').each(function() {
					$1('#linch_bar').append('<a href="#">' + $1(this).attr('id') + '</a>').find('a:last').attr('name', $1(this).attr('id')).click(function() {
						if (!linch_confirm()) return false;
						$1('#linch_bar .l_my').html('линчевать');
						$1('#linch_bar a').removeClass('cur');
						$1(this).addClass('cur');
						linch_init($1('textarea#' + $1(this).attr('name')).val());
						return false;
					});
				});
				if ($1('#linch_login').attr('name')) $1('#linch_bar').append('<a href="#" class="l_my">линчевать</a>').find('a:last').click(function() {
					if ($(this).hasClass('cur')) {
						var data = $1('#linch').linch_get();
						$1('textarea#linch_udata').val($1.toJSON(data ? data : []));
						$1('#linch_form').submit();
					}
					else {
						$1('#linch_bar a').removeClass('cur');
						$1(this).addClass('cur').html('сохранить');
						linch_minit($1('textarea#' + $1('#linch_login').val()).val());
					}
					return false;
				})
			};
			i1.src = url;
		});
	}
	else $1('#linch_frame').html('Ошибка загрузки картинки линча').slideDown(200);
});

function linch_confirm() {
	return $1('#linch_bar .l_my').hasClass('cur')
		? confirm('Вы не сохранили изменения в линче. Продолжить?')
		: true;
}

function linch_init(data) {
	if (data) {
		var d = $1.evalJSON(data);
		d = $1.evalJSON(d);
		$1('#linch').linch_remove();
		$1('#linch').linch({
			'data': (d ? d : []),
			'mode': 'show',
			'color': [
			    {
				    title: 'Красота',
				    color: '#eec1a0',
				    selected: true
				},
				{
				    title: 'Техника',
				    color: '#99b5ea',
				    selected: true
				},
				{
				    title: 'Реклама',
				    color: '#79e571',
				    selected: true
				}
			],
			'color_show': true
		});
		linch_loaded = true;
	};
}

function linch_minit(data) {
	if (data) {
		d = $1.evalJSON(data);
		d = $1.evalJSON(d);
	}
	else d = [];
	$1('#linch').linch_remove();
	$1('#linch').linch({
		'data': (d ? d : []),
		'color': [
		    {
			    title: 'Красота',
			    color: '#eec1a0',
			    selected: true
			},
			{
			    title: 'Техника',
			    color: '#99b5ea',
			    selected: true
			},
			{
			    title: 'Реклама',
			    color: '#79e571',
			    selected: true
			}
		],
		'color_show': true
	});
}

{/literal}
</script>
				<noindex>
				<form method="post" id="linch_form" action="{router page='linch'}save/{$oTopic->getId()}/?security_ls_key={$LIVESTREET_SECURITY_KEY}"><input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /><textarea name="linch_data" id="linch_udata" style="display:none;"></textarea></form>
  				{foreach from=$oTopic->getLinchDatas() item=datas name=datas_list}
					<textarea class="linch_data" style="display:none;" id="{$datas->getLogin()}">{$datas->getData()}</textarea>
				{/foreach}

  				<input id="linch_url" style="display:none;" value="{$oTopic->getLinchUrl()}" />
  				<input id="linch_login" style="display:none;" value="{if $oUserCurrent}{$oUserCurrent->getLogin()}{else}$oUser->getLogin(){/if}" name="{if $oUserCurrent}1{/if}" />
  				<div id="linch_frame"></div>
  				<div id="linch_bar">
  					<a href="#" class="l_original cur">оригинал</a>
  				</div>
				</noindex>
  			{/if}
					{$oTopic->getText()}
				</div>
				<ul class="tags">
					{foreach from=$oTopic->getTagsArray() item=sTag name=tags_list}
						<li><a href="{router page='tag'}{$sTag|escape:'html'}/">{$sTag|escape:'html'}</a>{if !$smarty.foreach.tags_list.last}, {/if}</li>
					{/foreach}
				</ul>
				<ul class="voting {if $oVote || ($oUserCurrent && $oTopic->getUserId()==$oUserCurrent->getId())|| strtotime($oTopic->getDateAdd())<$smarty.now-$oConfig->GetValue('acl.vote.topic.limit_time')}{if $oTopic->getRating()>0}positive{elseif $oTopic->getRating()<0}negative{/if}{/if} {if !$oUserCurrent || $oTopic->getUserId()==$oUserCurrent->getId() || strtotime($oTopic->getDateAdd())<$smarty.now-$oConfig->GetValue('acl.vote.topic.limit_time')}guest{/if} {if $oVote} voted {if $oVote->getDirection()>0}plus{elseif $oVote->getDirection()<0}minus{/if}{/if}">
					<li class="plus"><a href="#" onclick="lsVote.vote({$oTopic->getId()},this,1,'topic'); return false;"></a></li>
					<li class="total" title="{$aLang.topic_vote_count}: {$oTopic->getCountVote()}">{if $oVote || ($oUserCurrent && $oTopic->getUserId()==$oUserCurrent->getId()) || strtotime($oTopic->getDateAdd())<$smarty.now-$oConfig->GetValue('acl.vote.topic.limit_time')} {if $oTopic->getRating()>0}+{/if}{$oTopic->getRating()} {else} <a href="#" onclick="lsVote.vote({$oTopic->getId()},this,0,'topic'); return false;">&mdash;</a> {/if}</li>
					<li class="minus"><a href="#" onclick="lsVote.vote({$oTopic->getId()},this,-1,'topic'); return false;"></a></li>
					<li class="date">{date_format date=$oTopic->getDateAdd()}</li>
					{if $oTopic->getType()=='link'}
						<li class="link"><a href="{router page='link'}go/{$oTopic->getId()}/" title="{$aLang.topic_link_count_jump}: {$oTopic->getLinkCountJump()}">{$oTopic->getLinkUrl(true)}</a></li>
					{/if}
					<li class="author"><a title="{if $oUser->getStudia()}Из студии {$oUser->getStudia()}{/if}" href="{$oUser->getUserWebPath()}">{$oUser->getLogin()}</a></li>
					{hook run='topic_show_info' topic=$oTopic}
				</ul>
			{hook run='topic_show_end' topic=$oTopic}
			</div>
			<!-- /Topic -->