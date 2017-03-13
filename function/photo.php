<?php
	function create_url($type)
	{
		$url = '../montage/'.uniqid().$type;
		return ($url);
	}

	function decode_data($data)
	{
		$data = str_replace('data:image/png;base64,', '', $data);
		$data = str_replace(' ', '+', $data);
		$data = base64_decode($data);
		return ($data);
	}	

	function new_dir($dir)
	{
		if (!file_exists($dir))
			mkdir($dir);
	}

 	function write_to_file($file, $str)
 	{
 		$handle = fopen($file, 'x');
		fwrite($handle, $str);
		fclose($handle);
 	}

 	function get_extention($image)
 	{
 		strtolower($image);
 		if (preg_match('/.png/', $image))
			$extention = ".png";
		if (preg_match('/.jpeg/', $image))	
			$extention = ".jpeg";
		if (preg_match('/.jpg/', $image))	
			$extention = ".jpg";
		if (preg_match('/.gif/', $image))	
			$extention = ".gif";
		return ($extention);
 	}
 	function write_png_to_photo($source, $photo)
 	{
		$source = imagecreatefrompng($source);
		$largeur_source = imagesx($source);
		$hauteur_source = imagesy($source);
		imagealphablending($source, true);
		imagesavealpha($source, true);
		$type = get_extention($photo);
		if ($type == ".png")
			$destination = imagecreatefrompng($photo);
		if ($type == ".jpeg" || $type == '.jpg')	
			$destination = imagecreatefromjpeg($photo);
		if ($type == ".gif")
			$destination = imagecreatefromgif($photo);
		$largeur_destination = imagesx($destination);
		$hauteur_destination = imagesy($destination);
		$destination_x = ($largeur_destination - $largeur_source) / 8;
		$destination_y =  ($hauteur_destination - $hauteur_source) / 3;
		imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);
		if ($type == ".png")
			imagepng($destination, $photo);
		if ($type == ".jpeg" || $type == '.jpg')	
			imagejpeg($destination, $photo);
		if ($type == ".gif")
			imagegif($destination, $photo);
		imagedestroy($source);
		imagedestroy($destination);
	}

	function redimension_image($img)
	{
		$file = $img;
		$x = 400;
		$y = 300;
		$size = getimagesize($file);
		if ($size)
		{
			if ($size['mime']=='image/jpeg' )
			{
				$img_big = imagecreatefromjpeg($file);
				$img_new = imagecreate($x, $y);
				$img_mini = imagecreatetruecolor($x, $y)
				or $img_mini = imagecreate($x, $y);
				imagecopyresized($img_mini,$img_big,0,0,0,0,$x,$y,$size[0],$size[1]);
				imagejpeg($img_mini,$file );
			}
			elseif ($size['mime']=='image/png' )
			{
				$img_big = imagecreatefrompng($file);
				$img_new = imagecreate($x, $y);
				$img_mini = imagecreatetruecolor($x, $y)
				or $img_mini = imagecreate($x, $y);
				imagecopyresized($img_mini,$img_big,0,0,0,0,$x,$y,$size[0],$size[1]);
				imagepng($img_mini,$file );
			}
			elseif ($size['mime']=='image/gif' )
			{
				$img_big = imagecreatefromgif($file);
				$img_new = imagecreate($x, $y);
				$img_mini = imagecreatetruecolor($x, $y)
				or $img_mini = imagecreate($x, $y);
				imagecopyresized($img_mini,$img_big,0,0,0,0,$x,$y,$size[0],$size[1]);
				imagegif($img_mini,$file );
			}
		}
	}
?>