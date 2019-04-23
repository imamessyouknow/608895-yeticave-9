<?php

require_once('helpers.php');
require_once('functions-data/data.php');
require_once('functions-data/svs_functions.php');

date_default_timezone_set($timezone);
setlocale(LC_ALL, $locale);

//подсчет дат и интервалов
$curdate = date_create('now');
$tummdate = date_create('tomorrow');
$interval = date_diff($curdate, $tummdate);
$diff_format = date_interval_format($interval, '%H:%I');

//условный формат
$time_left_class = 'lot__timer timer';
if (date_interval_format($interval,'%H') < 1) {
	$time_left_class = 'lot__timer timer timer--finishing';
}

$page_content = include_template('index.php', ['categories' => $categories, 'suply' => $suply, 'objects_names' => $objects_names, 'diff_format' => $diff_format, 'time_left_class' => $time_left_class]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'YetiCave - Главная', 'categories' => $categories, 'is_auth' => $is_auth, 'user_name' => $user_name]);

print($layout_content);
?>


