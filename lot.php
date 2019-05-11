<?php

require_once('helpers.php');
require_once('functions-data/data.php');
require_once('functions-data/svs_functions.php');

if (isset($_GET['id'])) {
		$lot_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
	} else {
		http_response_code(404);
	}

	if (!$lot_id) {
		header("Location: http://localhost:8070/");
	}

$lot_by_id = 
	'select l.name as lot_name, start_price, date_create,' .
	'date_end, img, current_price, description, c.name as cat_name
	 from lot l join categories c on l.category_id = c.id
	 where l.id = ' . $lot_id;

$lot_info = mysqli_query($con, $lot_by_id);
if (!$lot_info) {
		$query_err = mysqli_error($con);
		print('Ошибка MySQL: ' . $query_err);
	}

$lotbyid_array = mysqli_fetch_assoc($lot_info);

//условный формат таймера
$time_left_class = 'lot-item__timer timer';
if (date_interval_format($interval,'%H') < 1) {
		$time_left_class = 'lot-item__timer timer timer--finishing';
	}

$lot_content = include_template('lot_template.php',
	[
	'lot_info' => $lotbyid_array, 
	'date_diff' => $diff_format,
	'timer_class' => $time_left_class,
	'categories' => $categories
	]
);

print($lot_content);
