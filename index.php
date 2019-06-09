<?php

require_once ( 'helpers.php' );
require_once ( 'functions-data/data.php' );
require_once ( 'functions-data/svs_functions.php' );

//условный формат
$time_left_class = 'lot__timer timer';
if (date_interval_format ($interval, '%H') < 1) {
    $time_left_class = 'lot__timer timer timer--finishing';
}

$page_content = include_template (
    'index.php',
    [
        'categories' => $categories,
        'suply' => $suply,
        'diff_format' => $diff_format,
        'time_left_class' => $time_left_class
    ]
);

$layout_content = include_template (
    'layout.php',
    [
        'content' => $page_content,
        'title' => 'YetiCave - Главная',
        'categories' => $categories,
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]
);

print( $layout_content );