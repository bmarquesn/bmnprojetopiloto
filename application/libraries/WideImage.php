<?php
class WideImage {
	public function resize($url = null, $arquivo = null) {
		include("WideImage/helpers/common.php");
		require_once("WideImage/lib/WideImage.php");
		
		$image = LibWideImage::load($url.$arquivo)->resizeCanvas('100%', '100%', 0, 'center')->resize(500, null, 'fill', 'any');
		if($image->saveToFile($url.$arquivo) === null) {
			return true;
		} else {
			return false;
		}
	}
}
?>