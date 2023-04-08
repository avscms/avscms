<html>
<header>
</header>
<body style="margin:0!important; padding:0!important;">
	<div id="flash-game" class="game-container">
		<center>
			<div class="text-danger">{t c='flash.not_available'}</div>
		</center>					
	</div>
	<script type="text/javascript" src="{$baseurl}/media/player/js/swfobject.js"></script>
	<script type='text/javascript'>
	var s1 = new SWFObject('{$relative}/media/games/swf/{$game.GID}.swf','flash-game','100%','100%','9');
	s1.addParam('allowfullscreen','true');
	s1.addParam('allowscriptaccess','always');
	s1.addParam('wmode','opaque');
	s1.write('flash-game');
	</script>
</body>
</html>
