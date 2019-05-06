<?php

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

//получаем список лотов, открытых за последние 5 дней 
$lots_sql = "select l.name as lot_name, start_price, date_create, img, current_price, c.name as cat_name
			from lot l join categories c on l.category_id = c.id
			where date_create >= adddate(now(), interval - 5 day);";
$lot_result = mysqli_query($con, $lots_sql);
$suply = mysqli_fetch_all($lot_result, MYSQLI_ASSOC);


$is_auth = rand(0, 1);
$user_name = 'Владимир Сизанюк'; // укажите здесь ваше имя
$timezone = 'Europe/Moscow';
$locale = 'ru_RU';
?>