		{hook run='content_end'}
		</div>
		<!-- /Content -->
		{if !$bNoSidebar}
			{include file='sidebar.tpl'}
		{/if}
		
	</div>

	<!-- Footer -->
	<div id="footer">
		<div class="right">
			Работает на <a href="http://livestreet.ru" title="Перейти на сайт livestreet.ru">«LiveStreet»</a><br />
			<a href="{router page='page'}about/">{$aLang.page_about}</a>
		</div>
		<!--LiveInternet counter--><script type="text/javascript">document.write("<a href='http://www.liveinternet.ru/click' target=_blank><img src='//counter.yadro.ru/hit?t25.6;r" + escape(document.referrer) + ((typeof(screen)=="undefined")?"":";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?screen.colorDepth:screen.pixelDepth)) + ";u" + escape(document.URL) +";i" + escape("Жж"+document.title.substring(0,80)) + ";" + Math.random() + "' border=0 width=88 height=15 alt='' title='LiveInternet: показано число посетителей за сегодня'><\/a>")</script><!--/LiveInternet-->
	</div>
	<!-- /Footer -->

</div>
{hook run='body_end'}
</body>
</html>
