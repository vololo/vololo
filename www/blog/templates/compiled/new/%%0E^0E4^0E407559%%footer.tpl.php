<?php /* Smarty version 2.6.19, created on 2010-07-25 22:29:26
         compiled from footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'hook', 'footer.tpl', 1, false),array('function', 'router', 'footer.tpl', 14, false),)), $this); ?>
		<?php echo smarty_function_hook(array('run' => 'content_end'), $this);?>

		</div>
		<!-- /Content -->
		<?php if (! $this->_tpl_vars['bNoSidebar']): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'sidebar.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>
		
	</div>

	<!-- Footer -->
	<div id="footer">
		<div class="right">
			Работает на <a href="http://livestreet.ru" title="Перейти на сайт livestreet.ru">«LiveStreet»</a><br />
			<a href="<?php echo smarty_function_router(array('page' => 'page'), $this);?>
about/"><?php echo $this->_tpl_vars['aLang']['page_about']; ?>
</a>
		</div>
		<!--LiveInternet counter--><script type="text/javascript">document.write("<a href='http://www.liveinternet.ru/click' target=_blank><img src='//counter.yadro.ru/hit?t25.6;r" + escape(document.referrer) + ((typeof(screen)=="undefined")?"":";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?screen.colorDepth:screen.pixelDepth)) + ";u" + escape(document.URL) +";i" + escape("Жж"+document.title.substring(0,80)) + ";" + Math.random() + "' border=0 width=88 height=15 alt='' title='LiveInternet: показано число посетителей за сегодня'><\/a>")</script><!--/LiveInternet-->
	</div>
	<!-- /Footer -->

</div>
<?php echo smarty_function_hook(array('run' => 'body_end'), $this);?>

</body>
</html>