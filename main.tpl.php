<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">    
	<title>Главная</title>
	
	<link rel="stylesheet" href="/css/style.css">

</head>
<body>
    <header class="header-main">
		<div class="container">
			<div class="logo">
				<img src="/images/logo.jpg" alt="logo"/>
			</div>
			<div class="header-buttons">
				<?php if(!$_SESSION): ?>
				<a href="login.tpl.php" class="log-in">Войти</a>
				<a href="register.tpl.php" class="register">Зарегистрироваться</a>
				<?php else: ?>
				<a href="handlers/logout.php" class="log-out">Выйти</a>
				<?php endif; ?>
			</div>
		</div>
    </header>
    <main>
		<div class="container">
			<h1>Товары.com</h1>
			<div class="goods__sort">
				<?php  
				if(is_null($sort)) {
					$sort = 'goods_id';
				} ?>
				<form name="sort" action="" method="POST">
				<select name="sort" class="goods__order">
					<option>Сортировать по:</option>
					<option value="goods_name">Наименование</option>
					<option value="price">Цена</option>
					<option value="created_at">Дата добавления</option>
					<option value="user_name">Автор</option>
				</select>
				<input type="submit" value="Сортировать" />
				</form>
			</div>
			<?php  
			$sort = $_POST['sort'];
			try {
				$db = new PDO('mysql:host=localhost; dbname=reviews1', 'root');
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = $db->prepare('SELECT g.goods_id, g.goods_name, g.picture, g.price, g.created_at, u.user_name'
				.' FROM goods g INNER JOIN users u ON g.user_id = u.user_id'
				.' ORDER BY '. $sort . ' ASC');
				$sql->execute();
				$data = $sql->fetchALL(PDO::FETCH_ASSOC);
				$sql = $db->prepare('SELECT g.goods_id, COUNT(r.review_id)'
				.' FROM goods g INNER JOIN reviews r ON g.goods_id = r.goods_id'
				.' GROUP BY(g.goods_id)');
				$sql->execute();
				$data_rev = $sql->fetchALL(PDO::FETCH_ASSOC);
			} catch (PDOException $err) {
				echo 'Error. Impossible to show goods: ' . $err->getMessage();
			}?>
			<?php if(!empty($data)) : ?>
			
			<table class="our-goods">			
			<tr>
				<td>Наименование товара</td>
				<td>Изображение</td>
				<td>Цена</td>
				<td>Добавлено</td>
				<td>Добавил</td>
				<td>Отзывов</td>
			</tr>
			<?php foreach($data as $key => $item): ?>
			<tr>
				<td>
					<a href="review.tpl.php?id=<?= $item['goods_id']; ?>"><?= $item['goods_name']; ?></a>
				</td>
				<td>
					<img class="goods__icon" src="<?= $item['picture']; ?>" alt="<?= $item['goods_name']; ?>">
				</td>
				<td><?= $item['price']; ?></td>
				<td><?= $item['created_at']; ?></td>
				<td><?= $item['user_name']; ?></td>
				<?php if(!empty($data_rev)) : ?>			
				<td>
					<?php foreach($data_rev as $rev): ?>
						<?php if($rev['goods_id'] == $item['goods_id']): ?>
						<?= $rev['COUNT(r.review_id)']; ?>
						<?php else: ?>
						<?= '';?>
						<?php endif; ?>
					<?php endforeach; ?>
				</td>			
				<?php endif; ?>
			</tr>	
			<?php endforeach; ?>		
			</table>
			<?php endif; ?>
			<?php if($_SESSION): ?>
				<div class="adding-googs">
					<a href="goods.tpl.php" class="page__btn">Добавить товар</a>
				</div>
			<?php endif; ?>
		</div>	
    </main>
    <footer>
		<div class="container"></div>
    </footer>
</body>
</html>
