<?
function changeImageSize($filename, $savepath, $ext, $neww, $newh)
{
    $idata = getimagesize($filename);
    $oldw = $idata[0];
    $oldh = $idata[1];
    $ext = strtolower($ext);
    $ratio = calkRatio($oldw, $oldh, $neww, $newh);
    if($ext =='jpg' or $ext =='jpeg') {
        $im = imagecreatefromjpeg($filename);
    }
    if ($im) {
        $dest=imagecreatetruecolor($oldw/$ratio,$oldh/$ratio);
        $white = ImageColorAllocate($dest, 255,255,255);
        imagefill($dest, 1, 1, $white);
        imagecopyresampled($dest, $im, 0, 0, 0, 0, $oldw/$ratio, $oldh/$ratio, $oldw, $oldh);
	    if($ext =='jpg' or $ext =='jpeg') {
            imageJPeG($dest, $savepath);
	    }
        imageDestroy($im);
        imageDestroy($dest);
        return true;
    }
    return false;
}

/*
функция вычисления коэффициента сжатия/растяжения исходного изображения
*/
function calkRatio($old_width, $old_height, $new_width, $new_height) {
	$ratiow = $old_width/$new_width;
	$ratioh = $old_height/$new_height;
	if ( $ratiow < 1 && $ratioh < 1 ) {
		if( $ratiow > $ratioh )
			{ $ratio = $ratiow; }
		else
			{ $ratio = $ratioh; }
	}
	elseif ( $ratiow > 1 && $ratioh > 1 ) {
		if( $ratiow < $ratioh ) { $ratio = $ratioh; }
		else { $ratio = $ratiow; }
	}
	elseif ( $ratiow > 1 && $ratioh == 1 ) {
		$ratio = $ratiow;
	}
	elseif ( $ratiow < 1 && $ratioh == 1 ) {
		$ratio = $ratioh;
	}
	elseif ( $ratiow >= 1 && $ratioh < 1 ) {
		$ratio = $ratiow;
	}
	elseif ( $ratiow <= 1 && $ratioh > 1 ) {
		$ratio = $ratioh;
	}
	elseif ( $ratiow == 1 && $ratioh == 1 ) {
		$ratio = 1;
	}
	return $ratio;
}

// функция обрезания изображения

function cut($x1, $y1, $x2, $y2)
{
	$im = imagecreatefromjpeg('image/picture.jpg');

	$im2 = imagecrop($im, ['x' => $x1, 'y' => $y1, 'width' => $x2, 'height' => $y2]);
	if ($im2 != FALSE)
	{
	 	imagejpeg($im2, 'example-cropped.jpg');
		changeImageSize('example-cropped.jpg', "image/cropimage.jpg", 'jpg', 450, 300);
		unlink('example-cropped.jpg');
	    imagedestroy($im2);
	}
	imagedestroy($im);
}

// функция преобразования в негатив
function negativ()
{
	$img = imagecreatefromjpeg('image/cropimage.jpg');

	$matrix = array (
	  array(0,0,0),
	  array(0,-1,0),
	  array(0,0,0)
	);

	imageconvolution($img, $matrix, 1, 256);
	imagejpeg($img, 'image/cropimage.jpg', 100);
}

function grey()
{
  // получаем размеры исходного изображения
  $imgSize = getimagesize('image/cropimage.jpg');
  $width = $imgSize[0];
  $height = $imgSize[1];
  // создаем новое изображение
  $img = imageCreate($width,$height);
  // задаем серую палитру для нового изображения
  for ($color = 0; $color <= 255; $color++) {
    imageColorAllocate($img, $color, $color, $color);
  }
  // создаем изображение из исходного
  $img2 = imageCreateFromJpeg('image/cropimage.jpg');
  // объединяем исходное изображение и серое
  imageCopyMerge($img,$img2,0,0,0,0, $width, $height, 100);
  // сохраняем изображение
  imagejpeg($img, 'image/cropimage.jpg');
  // очищаем память
  imagedestroy($img);
}

function changeBright($bright)
{
	$img = imagecreatefromjpeg('image/cropimage.jpg');
	imagefilter($img, IMG_FILTER_BRIGHTNESS, $bright); // arg3 can be -255 to +255
	imagejpeg($img, 'image/cropimage.jpg');
	imagedestroy($img);
}

function changeContrast($contrast)
{
	$img = imagecreatefromjpeg('image/cropimage.jpg');
	imagefilter($img, IMG_FILTER_CONTRAST, $contrast); // arg3 can be -255 to +255
	imagejpeg($img, 'image/cropimage.jpg');
	imagedestroy($img);
}

function addNoise($probability)
{
	$im = imagecreatefromjpeg('image/cropimage.jpg');
	$imgSize = getimagesize('image/cropimage.jpg');
	$width = $imgSize[0];
	$height = $imgSize[1];

	$probability *= 10;
	$array = [
		0 => 'no',
		1 => 'no',
		2 => 'no',
		3 => 'no',
		4 => 'no',
		5 => 'no',
		6 => 'no',
		7 => 'no',
		8 => 'no',
		9 => 'no'
	];

	for ($i = 0; $i < $probability; $i++)
	{
		$array[$i] = 'yes';
	}

		for ($x = 0; $x <= $width; $x++)
		{
			for ($y = 0; $y <= $height; $y++)
			{
				$rand_array = array_rand($array, 1);
					if( $array[$rand_array] == 'yes')
					{
						$rgb = imagecolorat($im, $x, $y);
						$colors = imagecolorsforindex($im, $rgb);

						$black_or_white = rand(1, 2);

						if ($black_or_white == 1)
						{
							$color = imageColorAllocate($im, 0, 0, 0);
						}

						if ($black_or_white == 2)
						{
							$color = imageColorAllocate($im, 255, 255, 255);
						}

						imageSetPixel($im, $x, $y, $color);
					}
			}
		}

	imagejpeg($im, 'image/cropimage.jpg');
}

function deleteNoise()
{
	$img=imagecreatefromjpeg('image/cropimage.jpg');
	$emboss = array(array(1/16,2/16,1/16), array(2/16,4/16,2/16), array(1/16,2/16,1/16));
	        // calculate the sharpen divisor
	$divisor = array_sum(array_map('array_sum', $emboss));
	imageconvolution($img, $emboss, $divisor, 0);
    imagejpeg($img, 'image/cropimage.jpg');
}

function filterLaplas()
{
	$image = imagecreatefromjpeg('image/cropimage.jpg');

	$emboss = array(array(-1, -2, -1), array(-2, 12, -2), array(-1, -2, -1));
	imageconvolution($image, $emboss, 1, 127);
	imagejpeg($image, 'image/cropimage.jpg');
}

function filterKirsh()
{
	$image = imagecreatefromjpeg('image/cropimage.jpg');

	$emboss = array(array(5, 5, -5), array(-3, 0, -3), array(-3, -3, -3));
	imageconvolution($image, $emboss, 1, 127);
	imagejpeg($image, 'image/cropimage.jpg');
}

function filterSobel()
{
	$image = imagecreatefromjpeg('image/cropimage.jpg');

	$emboss = array(array(-1, -2, -1), array(0, 0, 0), array(1, 2, 1));
	imageconvolution($image, $emboss, 1, 127);
	imagejpeg($image, 'image/cropimage.jpg');
}

function filterRoberts()
{
	$image = imagecreatefromjpeg('image/cropimage.jpg');

	$emboss = array(array(-1, -1, -1), array(0, 0, 0), array(1, 1, 1));
	imageconvolution($image, $emboss, 1, 127);
	imagejpeg($image, 'image/cropimage.jpg');
}

function filterGaus()
{
	$image = imagecreatefromjpeg('image/cropimage.jpg');

	$emboss = array(
		array(-1.2, -1, -1.2),
		array(-1, 20, -1),
		array(-1.2, -1, -1.2));
	imageconvolution($image, $emboss, 1, 127);
	imagejpeg($image, 'image/cropimage.jpg');
}

function checkRed()
{
$image = imagecreatefromjpeg('../image/cropimage.jpg');
	$total = 0;
	$array = [];
	for ($i=0; $i<255; $i++)
	{
		$array[$i] = 0;
	}
$width=ImageSX($image);
$height=ImageSY($image);

	for ($x=0; $x<$width; $x++) {
		for ($y=0; $y<$height; $y++) {
			$rgb = ImageColorAt($image,$x,$y);
			$total = ($rgb>>16) & 0xFF;
			$array[$total] ++;
		}
	}
	$array = deleteNull($array);
	$red_array = json_encode($array);
	return $red_array;
}

function checkGreen()
{
	$image = imagecreatefromjpeg('../image/cropimage.jpg');
	$total = 0;
	$array = [];
	for ($i=0; $i<255; $i++)
	{
		$array[$i] = 0;
	}
	$width=ImageSX($image);
	$height=ImageSY($image);

	for ($x=0; $x<$width; $x++) {
		for ($y=0; $y<$height; $y++) {
			$rgb = ImageColorAt($image,$x,$y);
			$total = ($rgb>>8) & 0xFF;
			$array[$total] ++;
		}
	}
	$array = deleteNull($array);
	$green_array = json_encode($array);
	return $green_array;
}

function checkBlue()
{
	$image = imagecreatefromjpeg('../image/cropimage.jpg');
	$total = 0;
	$array = [];
	for ($i=0; $i<255; $i++)
	{
		$array[$i] = 0;
	}
	$width=ImageSX($image);
	$height=ImageSY($image);

	for ($x=0; $x<$width; $x++) {
		for ($y=0; $y<$height; $y++) {
			$rgb = ImageColorAt($image,$x,$y);
			$total = $rgb & 0xFF;
			$array[$total] ++;
		}
	}
	$array = deleteNull($array);
	$blue_array = json_encode($array);
	return $blue_array;
}

function checkMain()
{
	$image = imagecreatefromjpeg('../image/cropimage.jpg');
	$total = 0;
	$array = [];
	for ($i=0; $i<255; $i++)
	{
		$array[$i] = 0;
	}
	$width=ImageSX($image);
	$height=ImageSY($image);

	for ($x=0; $x<$width; $x++) {
		for ($y=0; $y<$height; $y++) {
			$rgb = ImageColorAt($image,$x,$y);
			$red = ($rgb>>16) & 0xFF;
			$green = ($rgb>>8) & 0xFF;
			$blue = $rgb & 0xFF;
			$total = (0.3*$red) + (0.59*$green) + (0.11*$blue);
			$array[(int)$total] ++;
		}
	}

	$array = deleteNull($array);

	$main_array = json_encode($array);
	return $main_array;
}

function deleteNull($array)
{
	$right_array=[];
	for($i=0; $i<255; $i++)
	{
		if($array[$i] == NULL)
		{
			$right_array[$i] = 0;
		}
		else
		{
			$right_array[$i] = $array[$i];
		}
	}

	return $right_array;
}

function binary()
{
	$image = imagecreatefromjpeg('image/cropimage.jpg');
	$width=ImageSX($image);
	$height=ImageSY($image);
	$black = imageColorAllocate($image, 0, 0, 0);
	$white = imageColorAllocate($image, 255, 255, 255);
	for ($x=0; $x<$width; $x++) {
		for ($y=0; $y<$height; $y++) {
			$rgb = ImageColorAt($image,$x,$y);
			$red = ($rgb>>16) & 0xFF;
			$green = ($rgb>>8) & 0xFF;
			$blue = $rgb & 0xFF;
			if(($red > 128)&&($green>128)&&($blue>128)){imageSetPixel($image, $x, $y, $black);}
			else{imageSetPixel($image, $x, $y, $white);}
		}
	}
	imagejpeg($image, 'image/cropimage.jpg');
}

?>
