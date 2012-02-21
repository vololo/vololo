<?php /* Smarty version 2.6.19, created on 2010-08-05 13:08:11
         compiled from topic.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'topic.tpl', 10, false),array('function', 'router', 'topic.tpl', 23, false),array('function', 'date_format', 'topic.tpl', 223, false),array('function', 'hook', 'topic.tpl', 228, false),array('modifier', 'escape', 'topic.tpl', 12, false),)), $this); ?>

			<?php $this->assign('oBlog', $this->_tpl_vars['oTopic']->getBlog()); ?>
			<?php $this->assign('oUser', $this->_tpl_vars['oTopic']->getUser()); ?>
			<?php $this->assign('oVote', $this->_tpl_vars['oTopic']->getVote()); ?>
			<!-- Topic -->
			<div class="topic">
				<div class="favorite <?php if ($this->_tpl_vars['oUserCurrent']): ?><?php if ($this->_tpl_vars['oTopic']->getIsFavourite()): ?>active<?php endif; ?><?php else: ?>fav-guest<?php endif; ?>"><a href="#" onclick="lsFavourite.toggle(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,this,'topic'); return false;"></a></div>
				<h1 class="title">
					<?php if ($this->_tpl_vars['oTopic']->getPublish() == 0): ?>
						<img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/topic_unpublish.gif" border="0" title="<?php echo $this->_tpl_vars['aLang']['topic_unpublish']; ?>
" width="16" height="16" alt="<?php echo $this->_tpl_vars['aLang']['topic_unpublish']; ?>
">
					<?php endif; ?>
					<?php echo ((is_array($_tmp=$this->_tpl_vars['oTopic']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>

					<?php if ($this->_tpl_vars['oTopic']->getType() == 'link'): ?>
  						<img src="<?php echo smarty_function_cfg(array('name' => 'path.static.skin'), $this);?>
/images/link_url_big.gif" border="0" title="<?php echo $this->_tpl_vars['aLang']['topic_link']; ?>
" width="16" height="16" alt="<?php echo $this->_tpl_vars['aLang']['topic_link']; ?>
">
  					<?php endif; ?>
				</h1>
				<ul class="action">
					<li><a href="<?php echo $this->_tpl_vars['oBlog']->getUrlFull(); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['oBlog']->getTitle())) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a>&nbsp;&nbsp;</li>
					<?php if ($this->_tpl_vars['oUserCurrent'] && ( $this->_tpl_vars['oUserCurrent']->getId() == $this->_tpl_vars['oTopic']->getUserId() || $this->_tpl_vars['oUserCurrent']->isAdministrator() || $this->_tpl_vars['oBlog']->getUserIsAdministrator() || $this->_tpl_vars['oBlog']->getUserIsModerator() || $this->_tpl_vars['oBlog']->getOwnerId() == $this->_tpl_vars['oUserCurrent']->getId() )): ?>
  						<li class="edit"><a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
/<?php echo $this->_tpl_vars['oTopic']->getType(); ?>
/edit/<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
/" title="<?php echo $this->_tpl_vars['aLang']['topic_edit']; ?>
"><?php echo $this->_tpl_vars['aLang']['topic_edit']; ?>
</a></li>
  					<?php endif; ?>
					<?php if ($this->_tpl_vars['oUserCurrent'] && ( $this->_tpl_vars['oUserCurrent']->isAdministrator() || $this->_tpl_vars['oBlog']->getUserIsAdministrator() || $this->_tpl_vars['oBlog']->getOwnerId() == $this->_tpl_vars['oUserCurrent']->getId() )): ?>
  						<li class="delete"><a href="<?php echo smarty_function_router(array('page' => 'topic'), $this);?>
delete/<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
/?security_ls_key=<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" title="<?php echo $this->_tpl_vars['aLang']['topic_delete']; ?>
" onclick="return confirm('<?php echo $this->_tpl_vars['aLang']['topic_delete_confirm']; ?>
');"><?php echo $this->_tpl_vars['aLang']['topic_delete']; ?>
</a></li>
  					<?php endif; ?>
				</ul>
				<div class="content">


			<?php if ($this->_tpl_vars['oTopic']->getType() == 'question'): ?>

    		<div id="topic_question_area_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
">
    		<?php if (! $this->_tpl_vars['oTopic']->getUserQuestionIsVote()): ?>
    			<ul class="poll-new">
				<?php $_from = $this->_tpl_vars['oTopic']->getQuestionAnswers(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['aAnswer']):
?>
					<li><label for="topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
_<?php echo $this->_tpl_vars['key']; ?>
"><input type="radio" id="topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
_<?php echo $this->_tpl_vars['key']; ?>
" name="topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
"  value="<?php echo $this->_tpl_vars['key']; ?>
" onchange="$('topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
_value').setProperty('value',this.value);"/> <?php echo ((is_array($_tmp=$this->_tpl_vars['aAnswer']['text'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</label></li>
				<?php endforeach; endif; unset($_from); ?>
					<li>
					<input type="submit"  value="<?php echo $this->_tpl_vars['aLang']['topic_question_vote']; ?>
" onclick="ajaxQuestionVote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,$('topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
_value').getProperty('value'));">
					<input type="submit"  value="<?php echo $this->_tpl_vars['aLang']['topic_question_abstain']; ?>
"  onclick="ajaxQuestionVote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,-1)">
					</li>
					<input type="hidden" id="topic_answer_<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
_value" value="-1">
				</ul>
				<span><?php echo $this->_tpl_vars['aLang']['topic_question_vote_result']; ?>
: <?php echo $this->_tpl_vars['oTopic']->getQuestionCountVote(); ?>
. <?php echo $this->_tpl_vars['aLang']['topic_question_abstain_result']; ?>
: <?php echo $this->_tpl_vars['oTopic']->getQuestionCountVoteAbstain(); ?>
</span><br>
			<?php else: ?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'topic_question.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>
			</div>
			<br>

    		<?php endif; ?>
			<?php if ($this->_tpl_vars['oTopic']->getType() == 'linch'): ?>
<?php echo '
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
'; ?>

<link rel="stylesheet" type="text/css" href="<?php echo smarty_function_cfg(array('name' => 'path.root.site'), $this);?>
/g/img/jquery/ui/themes/smoothness/ui.all.css" />
<script type="text/javascript" src="<?php echo smarty_function_cfg(array('name' => 'path.root.site'), $this);?>
/g/js/raphael.js"></script>
<script type="text/javascript" src="<?php echo smarty_function_cfg(array('name' => 'path.root.site'), $this);?>
/g/js/jquery/jquery.js"></script>
<script type="text/javascript" src="<?php echo smarty_function_cfg(array('name' => 'path.root.site'), $this);?>
/g/js/jquery/jquery.json.js"></script>
<script type="text/javascript" src="<?php echo smarty_function_cfg(array('name' => 'path.root.site'), $this);?>
/g/js/jquery/ui/ui.core.js"></script>
<script type="text/javascript" src="<?php echo smarty_function_cfg(array('name' => 'path.root.site'), $this);?>
/g/js/jquery/ui/ui.widget.js"></script>
<script type="text/javascript" src="<?php echo smarty_function_cfg(array('name' => 'path.root.site'), $this);?>
/g/js/jquery/ui/ui.mouse.js"></script>
<script type="text/javascript" src="<?php echo smarty_function_cfg(array('name' => 'path.root.site'), $this);?>
/g/js/jquery/ui/ui.draggable.js"></script>
<script type="text/javascript" src="<?php echo smarty_function_cfg(array('name' => 'path.root.site'), $this);?>
/g/js/jquery/ui/ui.resizable.js"></script>
<script type="text/javascript" src="<?php echo smarty_function_cfg(array('name' => 'path.root.site'), $this);?>
/g/js/jquery/jquery.linch.js?1"></script>
<script type="text/javascript">
<?php echo '
jQuery.noConflict();
$1 = jQuery;
linch_loaded = false;

jQuery(function() {
	var url = $1(\'#linch_url\').val();
	if (url) {
		$1(\'#linch_frame\').html(\'Загрузка картинки линча\').slideDown(200, function() {
			var i1 = new Image();
			i1.onerror = function() {
				$1(\'#linch_frame\').html(\'Ошибка загрузки картинки линча\').slideDown(200);
			};
			i1.onload = function() {
				$1(\'#linch_frame\').html(\'<img src="\' + url + \'" id="linch" alt="" />\').slideDown(400, function() {
					$1(\'#linch_bar\').css(\'visibility\', \'visible\');
				});
				$1(\'#linch_bar .l_original\').click(function() {
					if (!linch_confirm()) return false;
					$1(\'#linch_bar .l_my\').html(\'линчевать\');
					$1(\'#linch_bar a\').removeClass(\'cur\');
					$1(this).addClass(\'cur\');
					$1(\'#linch\').linch_remove();
					return false;
				});
				$1(\'.linch_data\').each(function() {
					$1(\'#linch_bar\').append(\'<a href="#">\' + $1(this).attr(\'id\') + \'</a>\').find(\'a:last\').attr(\'name\', $1(this).attr(\'id\')).click(function() {
						if (!linch_confirm()) return false;
						$1(\'#linch_bar .l_my\').html(\'линчевать\');
						$1(\'#linch_bar a\').removeClass(\'cur\');
						$1(this).addClass(\'cur\');
						linch_init($1(\'textarea#\' + $1(this).attr(\'name\')).val());
						return false;
					});
				});
				if ($1(\'#linch_login\').attr(\'name\')) $1(\'#linch_bar\').append(\'<a href="#" class="l_my">линчевать</a>\').find(\'a:last\').click(function() {
					if ($(this).hasClass(\'cur\')) {
						var data = $1(\'#linch\').linch_get();
						$1(\'textarea#linch_udata\').val($1.toJSON(data ? data : []));
						$1(\'#linch_form\').submit();
					}
					else {
						$1(\'#linch_bar a\').removeClass(\'cur\');
						$1(this).addClass(\'cur\').html(\'сохранить\');
						linch_minit($1(\'textarea#\' + $1(\'#linch_login\').val()).val());
					}
					return false;
				})
			};
			i1.src = url;
		});
	}
	else $1(\'#linch_frame\').html(\'Ошибка загрузки картинки линча\').slideDown(200);
});

function linch_confirm() {
	return $1(\'#linch_bar .l_my\').hasClass(\'cur\')
		? confirm(\'Вы не сохранили изменения в линче. Продолжить?\')
		: true;
}

function linch_init(data) {
	if (data) {
		var d = $1.evalJSON(data);
		d = $1.evalJSON(d);
		$1(\'#linch\').linch_remove();
		$1(\'#linch\').linch({
			\'data\': (d ? d : []),
			\'mode\': \'show\',
			\'color\': [
			    {
				    title: \'Красота\',
				    color: \'#eec1a0\',
				    selected: true
				},
				{
				    title: \'Техника\',
				    color: \'#99b5ea\',
				    selected: true
				},
				{
				    title: \'Реклама\',
				    color: \'#79e571\',
				    selected: true
				}
			],
			\'color_show\': true
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
	$1(\'#linch\').linch_remove();
	$1(\'#linch\').linch({
		\'data\': (d ? d : []),
		\'color\': [
		    {
			    title: \'Красота\',
			    color: \'#eec1a0\',
			    selected: true
			},
			{
			    title: \'Техника\',
			    color: \'#99b5ea\',
			    selected: true
			},
			{
			    title: \'Реклама\',
			    color: \'#79e571\',
			    selected: true
			}
		],
		\'color_show\': true
	});
}

'; ?>

</script>
				<form method="post" id="linch_form" action="<?php echo smarty_function_router(array('page' => 'linch'), $this);?>
save/<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
/?security_ls_key=<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
"><input type="hidden" name="security_ls_key" value="<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" /><textarea name="linch_data" id="linch_udata" style="display:none;"></textarea></form>
  				<?php $_from = $this->_tpl_vars['oTopic']->getLinchDatas(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['datas_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['datas_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['datas']):
        $this->_foreach['datas_list']['iteration']++;
?>
					<textarea class="linch_data" style="display:none;" id="<?php echo $this->_tpl_vars['datas']->getLogin(); ?>
"><?php echo $this->_tpl_vars['datas']->getData(); ?>
</textarea>
				<?php endforeach; endif; unset($_from); ?>

  				<input id="linch_url" style="display:none;" value="<?php echo $this->_tpl_vars['oTopic']->getLinchUrl(); ?>
" />
  				<input id="linch_login" style="display:none;" value="<?php if ($this->_tpl_vars['oUserCurrent']): ?><?php echo $this->_tpl_vars['oUserCurrent']->getLogin(); ?>
<?php else: ?>$oUser->getLogin()<?php endif; ?>" name="<?php if ($this->_tpl_vars['oUserCurrent']): ?>1<?php endif; ?>" />
  				<div id="linch_frame"></div>
  				<div id="linch_bar">
  					<a href="#" class="l_original cur">оригинал</a>
  				</div>
  			<?php endif; ?>
					<?php echo $this->_tpl_vars['oTopic']->getText(); ?>

				</div>
				<ul class="tags">
					<?php $_from = $this->_tpl_vars['oTopic']->getTagsArray(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tags_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tags_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['sTag']):
        $this->_foreach['tags_list']['iteration']++;
?>
						<li><a href="<?php echo smarty_function_router(array('page' => 'tag'), $this);?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['sTag'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
/"><?php echo ((is_array($_tmp=$this->_tpl_vars['sTag'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</a><?php if (! ($this->_foreach['tags_list']['iteration'] == $this->_foreach['tags_list']['total'])): ?>, <?php endif; ?></li>
					<?php endforeach; endif; unset($_from); ?>
				</ul>
				<ul class="voting <?php if ($this->_tpl_vars['oVote'] || ( $this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oTopic']->getUserId() == $this->_tpl_vars['oUserCurrent']->getId() ) || strtotime ( $this->_tpl_vars['oTopic']->getDateAdd() ) < time()-$this->_tpl_vars['oConfig']->GetValue('acl.vote.topic.limit_time')): ?><?php if ($this->_tpl_vars['oTopic']->getRating() > 0): ?>positive<?php elseif ($this->_tpl_vars['oTopic']->getRating() < 0): ?>negative<?php endif; ?><?php endif; ?> <?php if (! $this->_tpl_vars['oUserCurrent'] || $this->_tpl_vars['oTopic']->getUserId() == $this->_tpl_vars['oUserCurrent']->getId() || strtotime ( $this->_tpl_vars['oTopic']->getDateAdd() ) < time()-$this->_tpl_vars['oConfig']->GetValue('acl.vote.topic.limit_time')): ?>guest<?php endif; ?> <?php if ($this->_tpl_vars['oVote']): ?> voted <?php if ($this->_tpl_vars['oVote']->getDirection() > 0): ?>plus<?php elseif ($this->_tpl_vars['oVote']->getDirection() < 0): ?>minus<?php endif; ?><?php endif; ?>">
					<li class="plus"><a href="#" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,this,1,'topic'); return false;"></a></li>
					<li class="total" title="<?php echo $this->_tpl_vars['aLang']['topic_vote_count']; ?>
: <?php echo $this->_tpl_vars['oTopic']->getCountVote(); ?>
"><?php if ($this->_tpl_vars['oVote'] || ( $this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oTopic']->getUserId() == $this->_tpl_vars['oUserCurrent']->getId() ) || strtotime ( $this->_tpl_vars['oTopic']->getDateAdd() ) < time()-$this->_tpl_vars['oConfig']->GetValue('acl.vote.topic.limit_time')): ?> <?php if ($this->_tpl_vars['oTopic']->getRating() > 0): ?>+<?php endif; ?><?php echo $this->_tpl_vars['oTopic']->getRating(); ?>
 <?php else: ?> <a href="#" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,this,0,'topic'); return false;">&mdash;</a> <?php endif; ?></li>
					<li class="minus"><a href="#" onclick="lsVote.vote(<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
,this,-1,'topic'); return false;"></a></li>
					<li class="date"><?php echo smarty_function_date_format(array('date' => $this->_tpl_vars['oTopic']->getDateAdd()), $this);?>
</li>
					<?php if ($this->_tpl_vars['oTopic']->getType() == 'link'): ?>
						<li class="link"><a href="<?php echo smarty_function_router(array('page' => 'link'), $this);?>
go/<?php echo $this->_tpl_vars['oTopic']->getId(); ?>
/" title="<?php echo $this->_tpl_vars['aLang']['topic_link_count_jump']; ?>
: <?php echo $this->_tpl_vars['oTopic']->getLinkCountJump(); ?>
"><?php echo $this->_tpl_vars['oTopic']->getLinkUrl(true); ?>
</a></li>
					<?php endif; ?>
					<li class="author"><a title="<?php if ($this->_tpl_vars['oUser']->getStudia()): ?>Из студии <?php echo $this->_tpl_vars['oUser']->getStudia(); ?>
<?php endif; ?>" href="<?php echo $this->_tpl_vars['oUser']->getUserWebPath(); ?>
"><?php echo $this->_tpl_vars['oUser']->getLogin(); ?>
</a></li>
					<?php echo smarty_function_hook(array('run' => 'topic_show_info','topic' => $this->_tpl_vars['oTopic']), $this);?>

				</ul>
			<?php echo smarty_function_hook(array('run' => 'topic_show_end','topic' => $this->_tpl_vars['oTopic']), $this);?>

			</div>
			<!-- /Topic -->