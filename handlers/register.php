<?php

session_start ();
/**
 * X установить соединение с бд
 * X проверить на наличие такого юзера
 * X внести данные в БД
 * X записать данные в сессию
 * X перейти на главную
 */

if (empty ($_POST)) {
	// исключение 
	echo 'Вы не указали свои данные';
	return;
}

$table = 'users';
$user_name = $_POST['user_name'];
$login = $_POST ['login'];

if($_POST ['password'] === $_POST['password_check']) {
	$password = $_POST ['password'];
	$pass_check = $_POST['password_check'];
}

try {
	$db = new PDO('mysql:host=localhost; dbname=reviews1', 'root');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = $db->prepare('SELECT user_id FROM users WHERE login = \'' . $login . '\''
	.'AND password = \'' . $password . '\'');
	$sql->execute();
	$check = $sql->fetchALL(PDO::FETCH_ASSOC);
	if(!$check){
		$sql = $db->prepare('INSERT INTO users (user_name, login, password)' 
		.'VALUES (\'' . $user_name .'\', \'' . $login . '\', \'' . $password .'\')');
		$sql->execute();
		$user_id = $db->lastInsertId();
		$message = 'Вы были успешно зарегистрированы!';
	} 
	else {
		$user_id = $check;
		$message = 'Вы уже зарегистрированы!';
	}
	
	$user = [
		'user_id' => $user_id,
		'login' => $user_name,
		'password' => $password,
		'username' => $user_name,
		];

	$_SESSION['user'] = $user;
	$_SESSION['reg_message'] = $message;
} catch (PDOException $err) {
	echo 'Error. Impossible to add user: ' . $err->getMessage();
}
