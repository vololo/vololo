<?php /* Smarty version 2.6.19, created on 2010-07-25 14:14:01
         compiled from actions/ActionLink/add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'hook', 'actions/ActionLink/add.tpl', 29, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('menu' => 'topic_action','showWhiteBack' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<?php echo '
<script language="JavaScript" type="text/javascript">
document.addEvent(\'domready\', function() {	
	new Autocompleter.Request.HTML($(\'topic_tags\'), DIR_WEB_ROOT+\'/include/ajax/tagAutocompleter.php?security_ls_key=\'+LIVESTREET_SECURITY_KEY, {
		\'indicatorClass\': \'autocompleter-loading\', // class added to the input during request
		\'minLength\': 2, // We need at least 1 character
		\'selectMode\': \'pick\', // Instant completion
		\'multiple\': true // Tag support, by default comma separated
	}); 
});
</script>
'; ?>



			<div class="topic" style="display: none;">
				<div class="content" id="text_preview"></div>
			</div>

			<div class="profile-user">
				<?php if ($this->_tpl_vars['sEvent'] == 'add'): ?>
					<h1><?php echo $this->_tpl_vars['aLang']['topic_link_create']; ?>
</h1>
				<?php else: ?>
					<h1><?php echo $this->_tpl_vars['aLang']['topic_link_edit']; ?>
</h1>
				<?php endif; ?>
				<form action="" method="POST" enctype="multipart/form-data">
					<?php echo smarty_function_hook(array('run' => 'form_add_topic_link_begin'), $this);?>

					<input type="hidden" name="security_ls_key" value="<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
" /> 
					
					<p><label for="blog_id"><?php echo $this->_tpl_vars['aLang']['topic_create_blog']; ?>
</label>
					<select name="blog_id" id="blog_id" onChange="ajaxBlogInfo(this.value);">
     					<option value="0"><?php echo $this->_tpl_vars['aLang']['topic_create_blog_personal']; ?>
</option>
     					<?php $_from = $this->_tpl_vars['aBlogsAllow']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['oBlog']):
?>
     						<option value="<?php echo $this->_tpl_vars['oBlog']->getId(); ?>
" <?php if ($this->_tpl_vars['_aRequest']['blog_id'] == $this->_tpl_vars['oBlog']->getId()): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['oBlog']->getTitle(); ?>
</option>
     					<?php endforeach; endif; unset($_from); ?>
     				</select></p>
					
     				<script language="JavaScript" type="text/javascript">
     					ajaxBlogInfo($('blog_id').value);
     				</script>
					
					<p><label for="topic_title"><?php echo $this->_tpl_vars['aLang']['topic_create_title']; ?>
:</label><br />
					<input type="text" id="topic_title" name="topic_title" value="<?php echo $this->_tpl_vars['_aRequest']['topic_title']; ?>
" class="w100p" /><br />
       				<span class="form_note"><?php echo $this->_tpl_vars['aLang']['topic_create_title_notice']; ?>
</span></p>

					<p><label for="topic_link_url"><?php echo $this->_tpl_vars['aLang']['topic_link_create_url']; ?>
:</label><br />
					<input type="text" id="topic_link_url" name="topic_link_url" value="<?php echo $this->_tpl_vars['_aRequest']['topic_link_url']; ?>
" class="w100p" /><br />
       				<span class="form_note"><?php echo $this->_tpl_vars['aLang']['topic_link_create_url_notice']; ?>
</span></p>
					
					<p><label for="topic_text"><?php echo $this->_tpl_vars['aLang']['topic_link_create_text']; ?>
:</label>
					<textarea name="topic_text" id="topic_text" rows="20"><?php echo $this->_tpl_vars['_aRequest']['topic_text']; ?>
</textarea></p>
					
					<p><label for="topic_tags"><?php echo $this->_tpl_vars['aLang']['topic_create_tags']; ?>
:</label><br />
					<input type="text" id="topic_tags" name="topic_tags" value="<?php echo $this->_tpl_vars['_aRequest']['topic_tags']; ?>
" class="w100p" /><br />
       				<span class="form_note"><?php echo $this->_tpl_vars['aLang']['topic_create_tags_notice']; ?>
</span></p>
												
					<p><label for="topic_forbid_comment"><input type="checkbox" id="topic_forbid_comment" name="topic_forbid_comment" class="checkbox" value="1" <?php if ($this->_tpl_vars['_aRequest']['topic_forbid_comment'] == 1): ?>checked<?php endif; ?>/> 
					&mdash; <?php echo $this->_tpl_vars['aLang']['topic_create_forbid_comment']; ?>
</label><br />
					<span class="form_note"><?php echo $this->_tpl_vars['aLang']['topic_create_forbid_comment_notice']; ?>
</span></p>

					<?php if ($this->_tpl_vars['oUserCurrent']->isAdministrator()): ?>
						<p><label for="topic_publish_index"><input type="checkbox" id="topic_publish_index" name="topic_publish_index" class="checkbox" value="1" <?php if ($this->_tpl_vars['_aRequest']['topic_publish_index'] == 1): ?>checked<?php endif; ?>/> 
						&mdash; <?php echo $this->_tpl_vars['aLang']['topic_create_publish_index']; ?>
</label><br />
						<span class="form_note"><?php echo $this->_tpl_vars['aLang']['topic_create_publish_index_notice']; ?>
</span></p>
					<?php endif; ?>
					<?php echo smarty_function_hook(array('run' => 'form_add_topic_link_end'), $this);?>

					<p class="buttons">
					<input type="submit" name="submit_topic_publish" value="<?php echo $this->_tpl_vars['aLang']['topic_create_submit_publish']; ?>
" class="right" />
					<input type="submit" name="submit_preview" value="<?php echo $this->_tpl_vars['aLang']['topic_create_submit_preview']; ?>
" onclick="$('text_preview').getParent('div').setStyle('display','block'); ajaxTextPreview('topic_text',true); return false;" />&nbsp;
					<input type="submit" name="submit_topic_save" value="<?php echo $this->_tpl_vars['aLang']['topic_create_submit_save']; ?>
" />
					</p>
				</form>

			</div>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
