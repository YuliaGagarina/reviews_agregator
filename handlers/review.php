<?php 

session_start ();

/**
 * открыть соединение с бд
 * записать данные в бд
 * выдать сообщение 
 * 
 * 
 */

if (empty ($_POST)) {
	// исключение 
	echo 'Вы не написали свой отзыв';
	return;
}

$comment = $_POST['comment'];
$rate = $_POST['rate'];
if(!empty($_SESSION['user'])) {
    foreach($_SESSION['user']['user_id'] as $el) {
        if($el['user_id']) {
            $user_id = $el['user_id'];
        } 
    }
}
$date = date("Y-m-d");
$goods_id = $_SESSION['goods_id'];
try {
	$db = new PDO('mysql:host=localhost; dbname=reviews1', 'root');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = $db->prepare('SELECT user_name FROM users WHERE user_id = \'' . $user_id . '\'');
	$sql->execute();
    $user_data = $sql->fetchALL(PDO::FETCH_ASSOC);
    $sql = $db->prepare('INSERT INTO reviews (rate, comment, created_at, user_id, goods_id)' 
    .'VALUES (\'' . $rate .'\', \'' . $comment . '\', \'' 
    . $date . '\', \'' . $user_id . '\', \'' . $goods_id . '\')');
    $sql->execute();
    $goods_id = $db->lastInsertId();
    foreach($user_data as $el) {
        if($el['user_name']){
            $user_name = $el['user_name'];
        }
    }
    header ('Location: /review.tpl.php');
	
} catch (PDOException $err) {
	echo 'Error. Impossible to add user: ' . $err->getMessage();
}
