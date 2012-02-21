<?php /* Smarty version 2.6.19, created on 2010-07-25 14:09:41
         compiled from header_top.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'header_top.tpl', 7, false),array('function', 'hook', 'header_top.tpl', 9, false),array('function', 'cfg', 'header_top.tpl', 25, false),)), $this); ?>
	<!-- Header -->
	<?php if (! $this->_tpl_vars['oUserCurrent']): ?>	
	<div style="display: none;">
	<div class="login-popup" id="login-form">
		<div class="login-popup-top"><a href="#" class="close-block" onclick="return false;"></a></div>
		<div class="content">
			<form action="<?php echo smarty_function_router(array('page' => 'login'), $this);?>
" method="POST">
				<h3><?php echo $this->_tpl_vars['aLang']['user_authorization']; ?>
</h3>
				<?php echo smarty_function_hook(array('run' => 'form_login_popup_begin'), $this);?>

				<div class="lite-note"><a href="<?php echo smarty_function_router(array('page' => 'registration'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['registration_submit']; ?>
</a><label for=""><?php echo $this->_tpl_vars['aLang']['user_login']; ?>
</label></div>
				<p><input type="text" class="input-text" name="login" tabindex="1" id="login-input"/></p>
				<div class="lite-note"><a href="<?php echo smarty_function_router(array('page' => 'login'), $this);?>
reminder/" tabindex="-1"><?php echo $this->_tpl_vars['aLang']['user_password_reminder']; ?>
</a><label for=""><?php echo $this->_tpl_vars['aLang']['user_password']; ?>
</label></div>
				<p><input type="password" name="password" class="input-text" tabindex="2" /></p>
				<?php echo smarty_function_hook(array('run' => 'form_login_popup_end'), $this);?>

				<div class="lite-note"><button type="submit" onfocus="blur()"><span><em><?php echo $this->_tpl_vars['aLang']['user_login_submit']; ?>
</em></span></button><label for="" class="input-checkbox"><input type="checkbox" name="remember" checked tabindex="3" ><?php echo $this->_tpl_vars['aLang']['user_login_remember']; ?>
</label></div>
				<input type="hidden" name="submit_login">
			</form>
		</div>
		<div class="login-popup-bottom"></div>
	</div>
	</div>
	<?php endif; ?>
	
	<div id="header">
		<h1><a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
">ВОЛОЛО</a></h1>
		
		<ul class="nav-main">
			<li><a href="/">Сайт</a></li>
			<li <?php if ($this->_tpl_vars['sMenuHeadItemSelect'] == 'blog'): ?>class="active"<?php endif; ?>><a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['blogs']; ?>
</a></li>
			<li <?php if ($this->_tpl_vars['sMenuHeadItemSelect'] == 'people'): ?>class="active"<?php endif; ?>><a href="<?php echo smarty_function_router(array('page' => 'people'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['people']; ?>
</a></li>
			<?php echo smarty_function_hook(array('run' => 'main_menu'), $this);?>

		</ul>
		
		<?php if ($this->_tpl_vars['oUserCurrent']): ?>
		<div class="profile">
			<a href="<?php echo $this->_tpl_vars['oUserCurrent']->getUserWebPath(); ?>
" class="avatar"><img src="<?php echo $this->_tpl_vars['oUserCurrent']->getProfileAvatarPath(48); ?>
" alt="<?php echo $this->_tpl_vars['oUserCurrent']->getLogin(); ?>
" /></a>
			<ul>
				<li><a href="<?php echo $this->_tpl_vars['oUserCurrent']->getUserWebPath(); ?>
" class="author"><?php echo $this->_tpl_vars['oUserCurrent']->getLogin(); ?>
</a> (<a href="<?php echo smarty_function_router(array('page' => 'login'), $this);?>
exit/?security_ls_key=<?php echo $this->_tpl_vars['LIVESTREET_SECURITY_KEY']; ?>
"><?php echo $this->_tpl_vars['aLang']['exit']; ?>
</a>)</li>
				<li>
					<?php if ($this->_tpl_vars['iUserCurrentCountTalkNew']): ?>
						<a href="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
" class="message" id="new_messages" title="<?php echo $this->_tpl_vars['aLang']['user_privat_messages_new']; ?>
"><?php echo $this->_tpl_vars['iUserCurrentCountTalkNew']; ?>
</a> 
					<?php else: ?>
						<a href="<?php echo smarty_function_router(array('page' => 'talk'), $this);?>
" class="message-empty" id="new_messages">&nbsp;</a>
					<?php endif; ?>
					<?php echo $this->_tpl_vars['aLang']['user_settings']; ?>
 <a href="<?php echo smarty_function_router(array('page' => 'settings'), $this);?>
profile/" class="author"><?php echo $this->_tpl_vars['aLang']['user_settings_profile']; ?>
</a> | <a href="<?php echo smarty_function_router(array('page' => 'settings'), $this);?>
tuning/" class="author"><?php echo $this->_tpl_vars['aLang']['user_settings_tuning']; ?>
</a> 
				</li>
				<li><?php echo $this->_tpl_vars['aLang']['user_rating']; ?>
 <strong><?php echo $this->_tpl_vars['oUserCurrent']->getRating(); ?>
</strong></li>
				<?php echo smarty_function_hook(array('run' => 'userbar_item'), $this);?>

			</ul>
		</div>
		<?php else: ?>
		<div class="profile guest">
			<a href="<?php echo smarty_function_router(array('page' => 'login'), $this);?>
" onclick="return showLoginForm();"><?php echo $this->_tpl_vars['aLang']['user_login_submit']; ?>
</a> <?php echo $this->_tpl_vars['aLang']['or']; ?>
 
			<a href="<?php echo smarty_function_router(array('page' => 'registration'), $this);?>
" class="reg"><?php echo $this->_tpl_vars['aLang']['registration_submit']; ?>
</a>
		</div>
		<?php endif; ?>
		
		
	</div>
	<!-- /Header -->