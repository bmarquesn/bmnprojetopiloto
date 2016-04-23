<?php echo doctype('html5'); ?>
<html lang="pt-br">
	<head>
		<?php require_once('estrutura/head.php'); ?>
	</head>
	<body>
		<?php require_once('estrutura/menu_topo.php'); ?>
		<div class="container">
			<h1><?php echo $titulo_pagina; ?></h1>
			<p>Para saber mais sobre o PHPDoc em <a href="https://en.wikipedia.org/wiki/PHPDoc" title="from Wikipedia" target="_blank">(from Wikipedia)</a></em>.</p>
			<p>Clique no botão abaixo <strong>'create docs'</strong>. Depois clique em <strong>'Clique aqui para visualizar a documentação'</strong></p>
			<iframe src="/bmnprojetopiloto/PHPDocumentor/index.html?time=<?php echo time(); ?>" class="frame_phpDoc" style="border:0;padding:0;margin:0;"></iframe> 
			<?php require_once('estrutura/assinatura_site.php'); ?>
		</div>
		<?php require_once('estrutura/footer.php'); ?>
	</body>
</html>