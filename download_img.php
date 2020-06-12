<?php
include('include.php');

$uploadfile = "image/img.jpg";
$realuploadfile = "image/picture.jpg";

// В данной строке самое важное - проверяем загружается ли изображение (а может вредоносный код?)
// И проходит ли изображение по весу. В нашем случае до 512 Кб
if($_FILES['userfile']['size'] != 0 )
{
// Указываем максимальный вес загружаемого файла. Сейчас до 512 Кб
  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
	{
	echo "Файл загружен.</b>";
	}
	else
	{
	echo "Файл не загружен, вернитеcь и попробуйте еще раз";
	}
}
else
{
  echo "Размер файла не должен превышать 512Кб";
}

changeImageSize($uploadfile, $realuploadfile, 'jpg', 450, 300);
echo '<br><a href="index.php?status=0">Вернуться назад</a>';

?>
