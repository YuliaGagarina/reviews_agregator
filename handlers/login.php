<?php

session_start ();
/**
 * установить соединение с БД
 * проверить, есть ли в бд такой юзер
 * если нету - сообщить о том, что такого нету и предложить перейти на страницу регистрации
 * если есть - записать его данные в файл сессии
 * 
 * 
 */

if (empty ($_POST)) {
	// исключение echo 'Invalid data';
	return;
}
$login = $_POST ['login'];
$password = $_POST ['password'];

try {
	$db = new PDO('mysql:host=localhost; dbname=reviews1', 'root');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = $db->prepare('SELECT user_id FROM users WHERE login = \'' . $login . '\''
	.'AND password = \'' . $password . '\'');
	$sql->execute();
	$user_id = $sql->fetchALL(PDO::FETCH_ASSOC);
	if(!$user_id){		
		$message = 'Зарегистрируйтесь, пожалуйста!';
	} 	else {
		$sql = $db->prepare('SELECT user_name FROM users WHERE user_id = \'' . $user_id . '\'');
		$sql->execute();
		$user_name =  $sql->fetchALL(PDO::FETCH_ASSOC);
		$user = [
			'user_id' => $user_id,
			'login'   => $login,
			'password' => $password,
			'username' => $user_name,
			];
	}

	$_SESSION['user'] = $user;
	header ('Location: /main.tpl.php');
	$_SESSION['reg_message'] = $message;

} catch (PDOException $err) {
	echo 'Error. Impossible to add user: ' . $err->getMessage();
}


