<?php /* Smarty version 2.6.19, created on 2012-02-22 00:17:51
         compiled from block.stream.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'hook', 'block.stream.tpl', 12, false),)), $this); ?>
<noindex>
			<div class="block stream">

				<div class="tl"><div class="tr"></div></div>
				<div class="cl"><div class="cr">
					
					<h1><?php echo $this->_tpl_vars['aLang']['block_stream']; ?>
</h1>
					
					<ul class="block-nav">						
						<li><strong></strong><a href="#" id="block_stream_topic" onclick="lsBlockStream.toggle(this,'topic_stream'); return false;"><?php echo $this->_tpl_vars['aLang']['block_stream_topics']; ?>
</a></li>
						<li class="active"><a href="#" id="block_stream_comment" onclick="lsBlockStream.toggle(this,'comment_stream'); return false;"><?php echo $this->_tpl_vars['aLang']['block_stream_comments']; ?>
</a><em></em></li>
						<?php echo smarty_function_hook(array('run' => 'block_stream_nav_item'), $this);?>

					</ul>					
					
				<div class="block-content">
					<?php echo '
						<script language="JavaScript" type="text/javascript">
						var lsBlockStream;
						window.addEvent(\'domready\', function() { 
							lsBlockStream=new lsBlockLoaderClass();
						});
						</script>
					'; ?>
					
					
					<?php echo $this->_tpl_vars['sStreamComments']; ?>


					</div>
				</div></div>
				<div class="bl"><div class="br"></div></div>
			</div>
</noindex>