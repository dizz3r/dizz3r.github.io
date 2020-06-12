<?
include('include.php');

if (!empty($_GET['cut'])) {cut(0, 0, 400, 230); $status = 1;}

if (!empty($_GET['negative'])) {negativ(); $status = 1;}

if (!empty($_GET['grey'])) {grey(); $status = 1;}

if (!empty($_GET['bright'])) {changeBright($_GET['bright_num']); $status = 1;}

if (!empty($_GET['contrast'])) {changeContrast($_GET['contrast_num']); $status = 1;}

if (!empty($_GET['addnoise'])) {addNoise($_GET['noise_probability']); $status = 1;}

if (!empty($_GET['deletenoise'])) {deleteNoise(); $status = 1;}

if (!empty($_GET['laplas'])) {filterLaplas(); $status = 1;}

if (!empty($_GET['kirsh'])) {filterKirsh(); $status = 1;}

if (!empty($_GET['sobel'])) {filterSobel(); $status = 1;}

if (!empty($_GET['roberts'])) {filterRoberts(); $status = 1;}

if (!empty($_GET['gaus'])) {filterGaus(); $status = 1;}

if (!empty($_GET['binary'])) {binary(); $status = 1;}

if((!isset($status)) || ($status == 0))
{
	$status = 0;
}



?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="keywords" content="ключевые слова через запятую">
	<title>ОИ</title>
    <script src="https://cdn.anychart.com/js/latest/anychart-bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="main_style.css">
	<link rel="stylesheet" type="text/css" href="reset_style.css">

</head>
<body>
		<header>
			<nav>
				<form action="download_img.php" method="POST" ENCTYPE="multipart/form-data">
					<input type="file" name="userfile"/>
					<input type="submit" name="upload" value="Загрузить">
							<input type="submit" name=" " value="Сохранить">
				</form>

			</nav>

			<div id="logo">
				ПИ-17 / Мороз Юрий Иванович
			</div>
		</header>

		<main>
			<div id="settings">
					<div id="setting">
						<div>
							<form>
								<input type="button" name="save" value="Выбрать область обрезания" />
							</form>
						</div>
						<br>
						<div>
							<form action="" method="GET">

								<input type="submit" name="cut" value="Обрезать" />

							</form>
						</div>
					</div>

					<div id="setting">
						<form action="" method="GET">

							<input type="submit" name="negative" value="Негатив :)" />

						</form>
					</div>

                    <div id="setting">
                        <form action="" method="GET">

                            <input type="submit" name="binary" value="Бинаризация" />

                        </form>
                    </div>

					<div id="setting">
						<form action="" method="GET">

							<input type="submit" name="grey" value="Превратить в серое :(" />

						</form>
					</div>

					<div id="setting">
						<p>Изменить яркость (-255, 255)</p>
						<form action="" method="GET">
							<input type="text" name="bright_num" value="50" />
							<br>
							<input type="submit" name="bright" value="Изменить яркость" />
						</form>
					</div>

					<div id="setting">
						<p>Изменить контрастность (-100, 100)</p>
						<form action="" method="GET">
							<input type="text" name="contrast_num" value="50" />
							<br>
							<input type="submit" name="contrast" value="Изменить контрастность" />
						</form>
					</div>
					<div id="setting">
						<p>Добавить шумы (0.1, 0.9)</p>
						<form action="" method="GET">
							<input type="text" name="noise_probability" value="0.3" />
							<br>
							<input type="submit" name="addnoise" value="Добавить шум" />
						</form>
					</div>
					<div id="setting">
						<p>Размыть</p>
						<form action="" method="GET">
							<input type="submit" name="deletenoise" value="Добавить размытие" />
						</form>
					</div>
					<div id="setting">
						<p>Применить один из фильтров</p>
						<form action="" method="GET">
							<input type="submit" name="laplas" value="Фильтр Лапласа" />
						</form>
                        <form action="" method="GET">
                            <input type="submit" name="kirsh" value="Фильтр Кирша" />
                        </form>
                        <form action="" method="GET">
                            <input type="submit" name="sobel" value="Фильтр Собеля" />
                        </form>
                        <form action="" method="GET">
                            <input type="submit" name="roberts" value="Фильтр Робертса" />
                        </form>
                        <form action="" method="GET">
                            <input type="submit" name="gaus" value="Статистический метод" />
                        </form>
					</div>

			</div>

			<div id="content">
				<div id="picture1">
                    Загруженная картинка <br>
					<img src="image/picture.jpg" />
				</div>
				<?

				if ($status == 0)
				{
					echo '<div id="picture2">Надо обрезать изображение</div>';
				}

				if ($status == 1)
				{
					echo "<div id='picture2'> Вырезанная картинкак <br><img src='image/cropimage.jpg'/></div>";
				}

				?>

			</div>

		</main>

		<footer>
            <div id="red" class="graf"></div>
            <div id="green" class="graf"></div>
            <div id="blue" class="graf"></div>
            <div id="main" class="graf"></div>
		</footer>

</body>
</html>
<script>
    function getColor(color) {
        var color_data = 0;
        $.ajax({
            type: "GET",
            url: "/api/grafics.php",
            data: {color: color},
            dataType: "json",
            async: false,
            success: function (data){
                color_data = data;
            },
            error: function(){alert('Problem');}
        });

        return color_data;
    }
    anychart.onDocumentReady(function () {

        var data1 = eval(getColor(1));
        for(i=0; i<255; i++)
        {
            console.log(i+" "+data1[i]);
        }
        var data2 = eval(getColor(2));
        var data3 = eval(getColor(3));
        var data4 = eval(getColor(4));

        var r = anychart.column(data1);
        r.title("Красный");
        r.xAxis().title("Яркость");
        r.yAxis().title("Частота");
        r.container("red");
        r.barGroupsPadding(0);
        r.draw();

        var g = anychart.column(data2);
        g.title("Зелёный");
        g.xAxis().title("Яркость");
        g.yAxis().title("Частота");
        g.container("green");
        g.barGroupsPadding(0);
        g.draw();

        var b = anychart.column(data3);
        b.title("Синий");
        b.xAxis().title("Яркость");
        b.yAxis().title("Частота");
        b.container("blue");
        b.barGroupsPadding(0);
        b.draw();

        var a = anychart.column(data4);
        a.title("Общая");
        a.xAxis().title("Яркость");
        a.yAxis().title("Частота");
        a.container("main");
        a.barGroupsPadding(0);
        a.draw();
    });
</script>
