<?php

session_start ();

/**
 * установить соединение с бд
 * добавить товар, выдать сообщение
 * вернуть на главную
 * 
 * 
 */

// var_dump($_SESSION);
if (empty ($_POST)) {
	// исключение 
	echo 'Вы не указали данные по товару';
	return;
}

$goods_name = $_POST['goods_name'];
$goods_image = $_POST['goods_image'];
$goods_price = $_POST['goods_price'];
if(!empty($_SESSION['user'])) {
    foreach($_SESSION['user']['user_id'] as $el) {
        if($el['user_id']) {
            $user_id = $el['user_id'];
        } 
    }
}
$date = date("Y-m-d");

try {
	$db = new PDO('mysql:host=localhost; dbname=reviews1', 'root');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = $db->prepare('SELECT user_name FROM users WHERE user_id = \'' . $user_id . '\'');
	$sql->execute();
    $user_data = $sql->fetchALL(PDO::FETCH_ASSOC);
    $sql = $db->prepare('INSERT INTO goods (goods_name, picture, price, created_at, user_id)' 
    .'VALUES (\'' . $goods_name .'\', \'' . $goods_image . '\', \'' 
    . $goods_price . '\', \'' . $date . '\', \'' . $user_id . '\')');
    $sql->execute();
    $goods_id = $db->lastInsertId();
    // $message = 'Товар был успешно добавлен!';
    foreach($user_data as $el) {
        if($el['user_name']){
            $user_name = $el['user_name'];
        }
    }

    header ('Location: /main.tpl.php');
	
} catch (PDOException $err) {
	echo 'Error. Impossible to add user: ' . $err->getMessage();
}
