<?php session_start();?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">    
    <title>Отзывы о товаре</title>

	<link rel="stylesheet" href="/css/style.css">

</head>
<body>
    <header class="header-main">
		<div class="container">
			<div class="logo">
				<a href="main.tpl.php" class="menu-item">
					<img src="/images/logo.jpg" alt="logo"/>
				</a>
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
			<?php 
			$goods_id = $_GET['id'];
			$_SESSION['goods_id'] = $goods_id;
			try {
				$db = new PDO('mysql:host=localhost; dbname=reviews1', 'root');
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = $db->prepare('SELECT goods_name, picture'
				.' FROM goods WHERE goods_id = \'' . $goods_id . '\'');
				$sql->execute();
				$data = $sql->fetchALL(PDO::FETCH_ASSOC);
				$sql = $db->prepare('SELECT AVG(rate)'
				.' FROM reviews'
				.' WHERE goods_id = \'' . $goods_id . '\'');
				$sql->execute();
				$data_pr = $sql->fetchALL(PDO::FETCH_ASSOC);
				$sql = $db->prepare('SELECT u.user_name, r.rate, r.comment, r.created_at'
				.' FROM reviews r INNER JOIN users u ON r.user_id = u.user_id'
				.'  WHERE r.goods_id = \'' . $goods_id . '\'');
				$sql->execute();
				$data_rev = $sql->fetchALL(PDO::FETCH_ASSOC);

			} catch (PDOException $err) {
				echo 'Error. Impossible to show goods: ' . $err->getMessage();
			}?>
			<?php if(!empty($data)): ?>
			<?php foreach($data as $el): ?>
            <span class="goods-name">
				<?= $el['goods_name']; ?>
			</span>
            <div class="goods-image">
                <img src="<?= $el['picture']; ?>" alt="<?= $el['goods_name']; ?>">
			</div>
			<?php endforeach; ?>
			<?php endif; ?>
			<?php if(!empty($data_pr)): ?>
			<?php foreach($data_pr as $pr): ?>
            <div class="av-rating">
                <span class="av-rating__label">Средняя оценка</span>
                <span class="av-rating__rate"><?= $pr['AVG(rate)']; ?></span>
			</div>
			<?php endforeach; ?>
			<?php endif; ?>			
            <div class="reviews">
                <h4>Отзывы о товаре</h4>
                <?php if($_SESSION): ?>
                    <div class="reviews__adding">
                        <h4>Добавить отзыв</h4>
						<div class="adding-reviews__form">
							<form action="handlers/review.php" class="reviews__adding-form" method="POST">
								<div class="input-field">
									<label>Комментарий</label>
									<input type="textarea" name="comment">
								</div>
								<div class="input-field">
									<label>Оценка</label>
									<input type="number" min=1 max=10 step=1 name="rate">
								</div>
								<div class="adding-googs">
									<button type="submit" class="page__btn">Добавить отзыв</button>
								</div>
							</form>
						</div>
                    </div>
				<?php endif; ?>
				<?php if($_SESSION): ?>
				<?php foreach($data_rev as $rev): ?>
                <div class="reviews__item">                    
                    <div class="reviews__author"><?= $rev['user_name']; ?></div>
                    <div class="reviews__comment">
                        <p><?= $rev['comment']; ?></p>
                    </div>
                    <div class="reviews__rate"><?= $rev['rate']; ?></div>
                    <div class="reviews__date"><?= $rev['created_at']; ?></div>
				</div>
				<?php endforeach; ?>
				<?php endif; ?>
            </div>
		</div>	
    </main>
    <footer>
		<div class="container"></div>
    </footer>
</body>
</html>