<?php

namespace App;

class Upload{

	public static function one( $fileName , $saveAs , $output ){

		if (file_exists($output.$saveAs)) {
			unlink($output.$saveAs);
		}
		
		move_uploaded_file($fileName['tmp_name'][0] , $output.$saveAs);
	}
}