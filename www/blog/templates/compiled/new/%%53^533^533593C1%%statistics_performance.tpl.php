<?php /* Smarty version 2.6.19, created on 2010-07-25 13:49:02
         compiled from statistics_performance.tpl */ ?>
<?php if ($this->_tpl_vars['bIsShowStatsPerformance'] && $this->_tpl_vars['oUserCurrent'] && $this->_tpl_vars['oUserCurrent']->isAdministrator()): ?>
	<div class="stat-performance">
		<h2>Statistics performance</h2>
		
		<table>
			<tr>
				<td>
					<h4>MySql</h4>
					query: <strong><?php echo $this->_tpl_vars['aStatsPerformance']['sql']['count']; ?>
</strong><br />
					time: <strong><?php echo $this->_tpl_vars['aStatsPerformance']['sql']['time']; ?>
</strong>
				</td>
				<td>
					<h4>Cache</h4>
					query: <strong><?php echo $this->_tpl_vars['aStatsPerformance']['cache']['count']; ?>
</strong><br />
					&mdash; set: <strong><?php echo $this->_tpl_vars['aStatsPerformance']['cache']['count_set']; ?>
</strong><br />
					&mdash; get: <strong><?php echo $this->_tpl_vars['aStatsPerformance']['cache']['count_get']; ?>
</strong><br />
					time: <strong><?php echo $this->_tpl_vars['aStatsPerformance']['cache']['time']; ?>
</strong>
				</td>
				<td>
					<h4>PHP</h4>	
					time load modules: <strong><?php echo $this->_tpl_vars['aStatsPerformance']['engine']['time_load_module']; ?>
</strong><br />
					full time: <strong><?php echo $this->_tpl_vars['iTimeFullPerformance']; ?>
</strong>
				</td>
			</tr>
		</table>
	</div>
<?php endif; ?>