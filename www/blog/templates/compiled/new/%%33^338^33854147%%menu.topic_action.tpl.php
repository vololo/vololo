<?php /* Smarty version 2.6.19, created on 2010-07-31 23:14:33
         compiled from menu.topic_action.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cfg', 'menu.topic_action.tpl', 4, false),array('function', 'router', 'menu.topic_action.tpl', 7, false),array('function', 'hook', 'menu.topic_action.tpl', 11, false),)), $this); ?>
		<ul class="menu">

			<li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'add'): ?>class="active"<?php endif; ?>>
				<a href="<?php echo smarty_function_cfg(array('name' => 'path.root.web'), $this);?>
/<?php if ($this->_tpl_vars['sMenuItemSelect'] == 'add_blog'): ?>topic<?php else: ?><?php echo $this->_tpl_vars['sMenuItemSelect']; ?>
<?php endif; ?>/add/"><?php echo $this->_tpl_vars['aLang']['topic_menu_add']; ?>
</a>
				<?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'add'): ?>
					<ul class="sub-menu" >
						<li <?php if ($this->_tpl_vars['sMenuItemSelect'] == 'topic'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'topic'), $this);?>
<?php echo $this->_tpl_vars['sMenuSubItemSelect']; ?>
/"><?php echo $this->_tpl_vars['aLang']['topic_menu_add_topic']; ?>
</a></div></li>
						<li <?php if ($this->_tpl_vars['sMenuItemSelect'] == 'question'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'question'), $this);?>
<?php echo $this->_tpl_vars['sMenuSubItemSelect']; ?>
/"><?php echo $this->_tpl_vars['aLang']['topic_menu_add_question']; ?>
</a></div></li>
						<li <?php if ($this->_tpl_vars['sMenuItemSelect'] == 'link'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'link'), $this);?>
<?php echo $this->_tpl_vars['sMenuSubItemSelect']; ?>
/"><?php echo $this->_tpl_vars['aLang']['topic_menu_add_link']; ?>
</a></div></li>
						<li <?php if ($this->_tpl_vars['sMenuItemSelect'] == 'linch'): ?>class="active"<?php endif; ?>><div><a href="<?php echo smarty_function_router(array('page' => 'linch'), $this);?>
<?php echo $this->_tpl_vars['sMenuSubItemSelect']; ?>
/"><?php echo $this->_tpl_vars['aLang']['topic_menu_add_linch']; ?>
</a></div></li>
						<?php echo smarty_function_hook(array('run' => 'menu_topic_action_add_item'), $this);?>

						<li ><div><a href="<?php echo smarty_function_router(array('page' => 'blog'), $this);?>
add/"><font color="Red"><?php echo $this->_tpl_vars['aLang']['blog_menu_create']; ?>
</font></a></div></li>
					</ul>
				<?php endif; ?>
			</li>

			<li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'saved'): ?>class="active"<?php endif; ?>>
				<a href="<?php echo smarty_function_router(array('page' => 'topic'), $this);?>
saved/"><?php echo $this->_tpl_vars['aLang']['topic_menu_saved']; ?>
</a>
				<?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'saved'): ?>
					<ul class="sub-menu" >
						<?php echo smarty_function_hook(array('run' => 'menu_topic_action_saved_item'), $this);?>

					</ul>
				<?php endif; ?>
			</li>

			<li <?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'published'): ?>class="active"<?php endif; ?>>
				<a href="<?php echo smarty_function_router(array('page' => 'topic'), $this);?>
published/"><?php echo $this->_tpl_vars['aLang']['topic_menu_published']; ?>
</a>
				<?php if ($this->_tpl_vars['sMenuSubItemSelect'] == 'published'): ?>
					<ul class="sub-menu" >
						<?php echo smarty_function_hook(array('run' => 'menu_topic_action_published_item'), $this);?>

					</ul>
				<?php endif; ?>
			</li>
			<?php echo smarty_function_hook(array('run' => 'menu_topic_action'), $this);?>

		</ul>



