<?php /* Smarty version 2.6.19, created on 2010-07-25 13:49:34
         compiled from menu.people.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'router', 'menu.people.tpl', 3, false),array('function', 'hook', 'menu.people.tpl', 9, false),)), $this); ?>

		<ul class="menu">
			<li <?php if ($this->_tpl_vars['sMenuItemSelect'] == 'people'): ?>class="active"<?php endif; ?>><a href="<?php echo smarty_function_router(array('page' => 'people'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['people_menu_users']; ?>
</a>
				<?php if ($this->_tpl_vars['sMenuItemSelect'] == 'people'): ?>
					<ul class="sub-menu">
						<li <?php if ($this->_tpl_vars['sEvent'] == '' || $this->_tpl_vars['sEvent'] == 'good' || $this->_tpl_vars['sEvent'] == 'bad'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'people'), $this);?>
"><?php echo $this->_tpl_vars['aLang']['people_menu_users_all']; ?>
</a></div></li>
						<li <?php if ($this->_tpl_vars['sEvent'] == 'online'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'people'), $this);?>
online/"><?php echo $this->_tpl_vars['aLang']['people_menu_users_online']; ?>
</a></div></li>
						<li <?php if ($this->_tpl_vars['sEvent'] == 'new'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'people'), $this);?>
new/"><?php echo $this->_tpl_vars['aLang']['people_menu_users_new']; ?>
</a></div></li>
						<?php echo smarty_function_hook(array('run' => 'menu_people_people_item'), $this);?>

					</ul>
				<?php endif; ?>
			</li>
			<?php echo smarty_function_hook(array('run' => 'menu_people'), $this);?>

		</ul>