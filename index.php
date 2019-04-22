<?php

require_once('helpers.php');
require_once('functions-data/data.php');
require_once('functions-data/svs_functions.php');

$page_content = include_template('index.php', ['categories' => $categories, 'suply' => $suply, 'objects_names' => $objects_names]);
$layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'YetiCave - Главная', 'categories' => $categories, 'is_auth' => $is_auth, 'user_name' => $user_name]);

print($layout_content);
?>


