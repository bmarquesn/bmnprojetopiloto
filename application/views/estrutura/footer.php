<script type="text/javascript">var base_url = '<?php echo base_url(); ?>';</script>
<?php
//javascripts
$loadJQuery = array('src' => 'assets/js/jquery/jquery-2.1.1.js', 'type' => 'text/javascript');
$bootstrap = array('src' => 'assets/js/bootstrap/bootstrap.min.js', 'type' => 'text/javascript');
$jQueryUi = array('src' => 'assets/js/jquery/jquery-ui.min.js', 'type' => 'text/javascript');
$time_picker = array('src' => 'assets/js/jquery/jquery-ui-timepicker-addon.js', 'type' => 'text/javascript');
$prospects_functions = array('src' => 'assets/js/prospects_functions.js', 'type' => 'text/javascript');
echo script_tag($loadJQuery);
?>
<script>window.jQuery || document.write('<script src="'+base_url+'assets/js/jquery/jquery-2.1.1.js"><\/script>')</script>
<?php
echo script_tag($bootstrap);
echo script_tag($jQueryUi);
echo script_tag($time_picker);
echo script_tag($prospects_functions);
if(isset($scripts_js) && !empty($scripts_js)) {
	foreach($scripts_js as $key => $value) {
		$jsPersonalizado = array('src' => $value, 'type' => 'text/javascript');
		echo script_tag($jsPersonalizado);
	}
}
if(isset($temTableSorter) && !empty($temTableSorter)) {
	echo '<script>var temTableSorter=1;</script>';
} else {
	echo '<script>var temTableSorter=0;</script>';
}
if(isset($colorpicker) && !empty($colorpicker)) {
	$colorPicker = array('src' => 'assets/js/colorpicker/colorpicker.js', 'type' => 'text/javascript');
	$eye = array('src' => 'assets/js/colorpicker/eye.js', 'type' => 'text/javascript');
	$layout = array('src' => 'assets/js/colorpicker/layout.js', 'type' => 'text/javascript');
	$utils = array('src' => 'assets/js/colorpicker/utils.js', 'type' => 'text/javascript');
	echo script_tag($colorPicker);
	echo script_tag($eye);
	echo script_tag($layout);
	echo script_tag($utils);
}
if(isset($msg) && !empty($msg)) {
	echo "<script>
		$(function(){
			$('.alert.bg-danger').find('span').html('".$msg."');
			$('.alert.bg-danger').show('fast');
		});
	</script>";
}
?>