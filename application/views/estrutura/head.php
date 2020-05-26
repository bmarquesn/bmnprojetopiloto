<title>.: Bruno Marques Nogueira - Gerente - Desenvolvedor - Projetos - Web :.</title>
<?php
//to search engines
$meta = array(
	array('name' => 'X-UA-Compatible', 'content' => 'IE=edge,chrome=1', 'type' => 'equiv'),
	array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'),
	array('name' => 'description', 'content' => 'Prospect, apresentação do profissional Bruno Marques Nogueira: Gerente - Desenvolvedor - Projetos - Web'),
	array('name' => 'author', 'content' => 'Bruno Marques Nogueira'),
	array('name' => 'cache-control', 'content' => 'no-cache', 'type' => 'equiv'),
	array('name' => 'content-language', 'content' => 'pt-br', 'type' => 'equiv'),
	array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
	array('name' => 'copyright', 'content' => '&copy; '.date('Y').' BrunoNogueira'),
	array('name' => 'expires', 'content' => 'Mon, 22 Jul 2002 11:12:01 GMT', 'type' => 'equiv'),
	array('name' => 'keywords', 'content' => 'gerente, desenvolvedor, programador, projetos, web, banco de dados, jquery, javascript, css, html, php, sql, avançado'),
	array('name' => 'pragma', 'content' => 'no-cache', 'type' => 'equiv'),
	array('name' => 'robots', 'content' => 'all'),
	array('name' => 'googlebot', 'content' => 'noarchive'),
);
echo meta($meta);

//styles
echo link_tag('assets/css/bootstrap/bootstrap.min.css');
echo link_tag('assets/css/bootstrap/bootstrap.responsive.css');
echo link_tag('assets/css/bootstrap/ie10-viewport-bug-workaround.css');
echo link_tag('assets/css/bootstrap/navbar-fixed-top.css');
echo link_tag('assets/css/jquery/jquery-ui.min.css');
echo link_tag('assets/css/jquery/jquery-ui.structure.min.css');
echo link_tag('assets/css/jquery/jquery-ui-timepicker-addon.css');
echo link_tag('assets/css/prospects.css');
echo link_tag('assets/css/menu_topo.css');
$page_icon = array(
	'rel' => 'shortcut icon',
	'type' => 'image/x-icon',
	'href' => 'assets/img/bruno_icon_page.ico',
);
echo link_tag($page_icon);
if(isset($link_css) && !empty($link_css)) {
	foreach($link_css as $key => $value) {
		echo link_tag($value);
	}
}
if(isset($colorpicker) && !empty($colorpicker)) {
	echo link_tag('assets/css/colorpicker/colorpicker.css');
	//echo link_tag('assets/css/colorpicker/layout.css');
}
?>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<!--[if IE]>
  <script type="text/javascript">
  (function(){
		var html5elmeents = "address|article|aside|audio|canvas|command|datalist|details|dialog|figure|figcaption|footer|header|hgroup|keygen|mark|meter|menu|nav|progress|ruby|section|time|video".split('|');
		  for(var i = 0; i < html5elmeents.length; i++){
				document.createElement(html5elmeents[i]);
			}
		}
  )();
  </script>
<![endif]-->