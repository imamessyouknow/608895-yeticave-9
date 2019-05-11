<?php

$is_auth = rand(0, 1);
$user_name = 'Владимир Сизанюк'; // укажите здесь ваше имя
$timezone = 'Europe/Moscow';
$locale = 'ru_RU';

date_default_timezone_set($timezone);
setlocale(LC_ALL, $locale);

//подсчет дат и интервалов
$curdate = date_create('now');
$tummdate = date_create('tomorrow');
$interval = date_diff($curdate, $tummdate);
$diff_format = date_interval_format($interval, '%H:%I');

//подключение к БД
$con = mysqli_connect("localhost", "root", "root","YetiCave");

if ($con == false) {
	print("Ошибка подключения к БД: " . mysqli_connect_error());
}
mysqli_options($con, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
mysqli_set_charset($con, "utf8");

//получаем список категорий и их символьных имен 
$categories_sql = "select name, symbol_code from categories;";
$cat_result = mysqli_query($con,$categories_sql);
$categories = mysqli_fetch_all($cat_result, MYSQLI_ASSOC);

//получаем список лотов, открытых за последние  N дней 
$lots_sql = "select l.name as lot_name, l.id, start_price, date_create, img, current_price, c.name as cat_name
			from lot l join categories c on l.category_id = c.id
			where date_create >= adddate(now(), interval - 30 day);";
$lot_result = mysqli_query($con, $lots_sql);
$suply = mysqli_fetch_all($lot_result, MYSQLI_ASSOC);

?>