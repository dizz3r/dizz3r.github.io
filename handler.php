<?
include('include.php');

if (!empty($_GET['cut'])) {
	echo "Успех<br>";
    cut(0, 0, 400, 230);
    echo '<a href="index.php?status=1">Обратно</a>';
}

if (!empty($_GET['negative'])) {
	echo "Успех<br>";
    negativ();
    echo '<a href="index.php?status=1">Обратно</a>';
}

if (!empty($_GET['grey'])) {
	echo "Успех<br>";
    grey();
    echo '<a href="index.php?status=1">Обратно</a>';
}

if (!empty($_GET['bright'])) {
	echo "Успех<br>";
    changeBright($_GET['bright_num']);
    echo '<a href="index.php?status=1">Обратно</a>';
}

if (!empty($_GET['contrast'])) {
	echo "Успех<br>";
    changeContrast($_GET['contrast_num']);
    echo '<a href="index.php?status=1">Обратно</a>';
}

if (!empty($_GET['addnoise'])) {
    echo "Успех<br>";
    addNoise($_GET['noise_probability']);
    echo '<a href="index.php?status=1">Обратно</a>';
}

if (!empty($_GET['deletenoise'])) {
    echo "Успех<br>";
    deleteNoise();
    echo '<a href="index.php?status=1">Обратно</a>';
}

if (!empty($_GET['laplas'])) {
    echo "Успех<br>";
    filterLaplas();
    echo '<a href="index.php?status=1">Обратно</a>';
}

if (!empty($_GET['kirsh'])) {
    echo "Успех<br>";
    filterKirsh();
    echo '<a href="index.php?status=1">Обратно</a>';
}

if (!empty($_GET['sobel'])) {
    echo "Успех<br>";
    filterSobel();
    echo '<a href="index.php?status=1">Обратно</a>';
}

if (!empty($_GET['gaus'])) {
    echo "Успех<br>";
    filterGaus();
    echo '<a href="index.php?status=1">Обратно</a>';
}


?>