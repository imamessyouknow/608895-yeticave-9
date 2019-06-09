<?php
require_once ( 'helpers.php' );
require_once ( 'functions-data/data.php' );
//определение обязательных полей
$required_fields = [
    'lot-name',
    'category',
    'message',
    'lot-rate',
    'lot-step',
    'lot-date'
];
$lots = [];
//если форма отправленна, то
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

//записываю значения обязательных полей в специальный массив
    for($i = 0; $i < count ($required_fields); ++$i) {
        $lots[$required_fields[$i]] = $_POST[$required_fields[$i]] ?? '';
    }
//определяю переменные для проверки и массив ошибок
    $errors = [];
    $lot_start_price = $lots['lot-rate'];
    $lot_rate_step = trim($lots['lot-step']);

//простая проверка пусто нет
    foreach($required_fields as $key) {
        if ( empty($lots[$key]) ) {
            $errors[$key] = 'Сорян, но поле обязательно к заполнению';
            $errors_class[$key] = 'form__item--invalid';
        }
    }

//проверка корректности цены
    if ( !empty($lot_start_price) ) {
        if ( !is_numeric ($lot_start_price) ) {
            $errors['lot-rate'] = 'Мы принимаем только деньги...';
        } else if ( $lot_start_price <= 0 ) {
            $errors['lot-rate'] = 'К сожалению, это коммерческий проект.';
        }
    }
//проверка корректности даты
    if ( is_date_valid ($lots['lot-date']) ) {
        $lot_end_date = date_create ($lots['lot-date']);
        $lot_interval = date_diff ($curdate, $lot_end_date);
        $lot_days_to_end = date_interval_format ($lot_interval, '%D');
    }

    if ( !empty($lot_days_to_end) ) {
        if ( $lot_days_to_end < 1 ) {
            $errors['lot-date'] = 'Возможно, вы пропустите хорошую ставку!';
        }
    }
//проверка корректности шага ставки
    if ( !empty($lot_rate_step) ) {
        if ( (string) (int) $lot_rate_step !== $lot_rate_step ) {
            $errors['lot-step'] = 'Определите корректный шаг ставки! Он должен быть целым числом';
        }
    }
//проверка корректности загруженного файла
    if ( !empty($_FILES['lot-img']['name']) ) {
        $tmp_name = $_FILES['lot-img']['tmp_name'];
        $path = $_FILES['lot-img']['name'];
        $file_inf = finfo_open (FILEINFO_MIME_TYPE);
        $file_type = finfo_file ($file_inf, $tmp_name);
        if ( $file_type !== 'image/png' and $file_type !== 'image/jpeg' and $file_type !== 'image/jpg' ) {
            $errors['lot-img'] = 'Добавьте пожалуйста фотографию лота в формате png или jpeg';
        } else {
            move_uploaded_file ($tmp_name, 'uploads/' . $path);
            $lots['lot-img'] = 'uploads/' . $path;
        }
    } else {
        $errors['lot-img'] = 'Вы не загрузили файл';
    }

//если есть ошибки, то
    if ( count ($errors) ) {

        $page_content = include_template (
            'add-lot.php',
            [
                'lots' => $lots,
                'errors' => $errors,
                'categories' => $categories,
                'required_fields' => $required_fields
            ]);
//если нет, то
    } else {

        $get_category_id_sql = "select id   
                                from categories     
                                where name = ?";

        $cat_result = db_get_prepare_stmt ($con, $get_category_id_sql, [ $lots['category'] ]);
        mysqli_stmt_execute ($cat_result);
        $result = mysqli_stmt_get_result ($cat_result);
        $lot_category = mysqli_fetch_assoc ($result);

        $lot_insert_sql = 'insert into lot (name, 
                                            description, 
                                            img, 
                                            start_price, 
                                            date_end, 
                                            rate_step, 
                                            author_id,  
                                            category_id) 
                            values (?,?,?,?,?,?,?,?)';

        $name = $lots['lot-name'];
        $descr = $lots['message'];
        $img = $lots['lot-img'];
        $date_end = $lots['lot-date'];
        $author_id = rand (2, 3);
        $category_id = $lot_category['id'];


        $stmt = mysqli_prepare ($con, $lot_insert_sql);
        mysqli_stmt_bind_param ($stmt, 'sssdsiii', $name, $descr, $img, $lot_start_price, $date_end, $lot_rate_step, $author_id, $category_id);
        $res = mysqli_stmt_execute ($stmt);

        if ( !$res ) {
            var_dump (mysqli_error ($con));
        }

        if ( $res ) {
            $last_id = mysqli_insert_id ($con);
            $new_lot_url = "http://localhost:8070/lot.php?id=" . $last_id;
            header ("Location: " . $new_lot_url);
        }

    }
//если форма не отправленна, а открыта, то
} else {
    $page_content = include_template (
        'add-lot.php',
        [
            'required_fields' => $required_fields,
            'categories' => $categories
        ]);
}
//вывод
print( $page_content );