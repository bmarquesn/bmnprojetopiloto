<?php echo doctype('html5'); ?>
<html lang="pt-br">
	<head>
		<?php require_once(APPPATH.'views/estrutura/head.php'); ?>
	</head>
	<body>
		<?php require_once(APPPATH.'views/estrutura/menu_topo.php'); ?>
		<div class="container">
			<?php require_once($pagina_atual.'.php'); ?>
		</div>
		<?php require_once(APPPATH.'views/estrutura/assinatura_site.php'); ?>
		<?php require_once(APPPATH.'views/estrutura/footer.php'); ?>
	</body>
</html>