<?php /* Smarty version 2.6.19, created on 2010-07-25 13:51:05
         compiled from menu.settings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'menu.settings.tpl', 4, false),array('function', 'hook', 'menu.settings.tpl', 9, false),)), $this); ?>
		<ul class="menu">
		
			<li <?php if ($this->_tpl_vars['sMenuItemSelect'] == 'settings'): ?>class="active"<?php endif; ?>>
				<a href="<?php echo smarty_function_router(array('page' => 'settings'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['settings_menu']; ?>
</a>
				<?php if ($this->_tpl_vars['sMenuItemSelect'] == 'settings'): ?>
					<ul class="sub-menu" >
						<li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'profile'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'settings'), $this);?>
profile/"><?php echo $this->_tpl_vars['aLang']['settings_menu_profile']; ?>
</a></div></li>						
						<li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'tuning'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'settings'), $this);?>
tuning/"><?php echo $this->_tpl_vars['aLang']['settings_menu_tuning']; ?>
</a></div></li>
						<?php echo smarty_function_hook(array('run' => 'menu_settings_settings_item'), $this);?>

					</ul>
				<?php endif; ?>
			</li>
			
			<?php if ($this->_tpl_vars['oConfig']->GetValue('general.reg.invite')): ?>
			<li <?php if ($this->_tpl_vars['sMenuItemSelect'] == 'invite'): ?>class="active"<?php endif; ?>>
				<a href="<?php echo smarty_function_router(array('page' => 'settings'), $this);?>
invite/"><?php echo $this->_tpl_vars['aLang']['settings_menu_invite']; ?>
</a>
				<?php if ($this->_tpl_vars['sMenuItemSelect'] == 'invite'): ?>
					<ul class="sub-menu" >
						<?php echo smarty_function_hook(array('run' => 'menu_settings_invite_item'), $this);?>

					</ul>
				<?php endif; ?>
			</li>
			<?php endif; ?>		
			<?php echo smarty_function_hook(array('run' => 'menu_settings'), $this);?>

		</ul>
		
		
		
