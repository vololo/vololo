<?php /* Smarty version 2.6.19, created on 2010-07-25 13:49:34
         compiled from actions/ActionPeople/sidebar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('insert', 'block', 'actions/ActionPeople/sidebar.tpl', 42, false),)), $this); ?>
			
			<div class="block stat nostyle">
				<h1><?php echo $this->_tpl_vars['aLang']['user_stats']; ?>
</h1>
				
				<div class="gender">
					<ul id="chart_users_data">
						<li><?php echo $this->_tpl_vars['aLang']['user_stats_all']; ?>
: <?php echo $this->_tpl_vars['aStat']['count_all']; ?>
</li>
						<li><div class="mark" style="background: #70aae0;"></div><?php echo $this->_tpl_vars['aLang']['user_stats_active']; ?>
: <span><?php echo $this->_tpl_vars['aStat']['count_active']; ?>
</span></li>
						<li class="last"><div class="mark" style="background: #ff68cf;"></div><?php echo $this->_tpl_vars['aLang']['user_stats_noactive']; ?>
: <span><?php echo $this->_tpl_vars['aStat']['count_inactive']; ?>
</span></li>
					</ul>
					<div class="chart">						
						<div id="chart_users_area"></div>	
						<?php echo '
						<script language="JavaScript" type="text/javascript">
							window.addEvent(\'domready\', function(){
								new PieChart($(\'chart_users_data\'),$(\'chart_users_area\'),{index:1});
							});
						</script>
						'; ?>
					
					</div>
				</div>
				
				<div class="gender">
					<ul id="chart_gender_data">
						<li><div class="mark" style="background: #70aae0;"></div><?php echo $this->_tpl_vars['aLang']['user_stats_sex_man']; ?>
: <span><?php echo $this->_tpl_vars['aStat']['count_sex_man']; ?>
</span></li>
						<li><div class="mark" style="background: #ff68cf;"></div><?php echo $this->_tpl_vars['aLang']['user_stats_sex_woman']; ?>
: <span><?php echo $this->_tpl_vars['aStat']['count_sex_woman']; ?>
</span></li>
						<li class="last"><div class="mark" style="background: #c5c5c5;"></div><?php echo $this->_tpl_vars['aLang']['user_stats_sex_other']; ?>
: <span><?php echo $this->_tpl_vars['aStat']['count_sex_other']; ?>
</span></li>
					</ul>
					<div class="chart">						
						<div id="chart_gender_area"></div>	
						<?php echo '
						<script language="JavaScript" type="text/javascript">
							window.addEvent(\'domready\', function(){
								new PieChart($(\'chart_gender_data\'),$(\'chart_gender_area\'),{index:2});
							});
						</script>
						'; ?>
					
					</div>
				</div>
			</div>
			
			<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'block', 'block' => 'tagsCountry')), $this); ?>

			
			<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');
echo smarty_core_run_insert_handler(array('args' => array('name' => 'block', 'block' => 'tagsCity')), $this); ?>