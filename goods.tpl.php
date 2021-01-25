<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">    
    <title>Товар</title>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="/css/style.css">

</head>
<body>
    <header class="header-main">
		<div class="container">
        <a href="main.tpl.php" class="menu-item">
          <img src="/images/logo.jpg" alt="logo"/>
        </a>

			<div class="header-buttons">
				<a href="/handlers/logout.php" class="log-out">Выйти</a>
			</div>
		</div>
    </header>
    <main>
		<div class="container">
      <span class="form-heading">Добавить товар</span>
        <div class="adding-goods__form">
            <form action="handlers/goods.php" method="POST">
              <div class="form-content">
                <div class="input-field">
                <label>Наименование товара</label>
            <input type="text" name="goods_name">
            </div>
            <div class="input-field">
            <label>Изображение (URL-адрес)</label>
            <input type="text" name="goods_image">
            </div>
            <div class="input-field">
            <label>Цена</label>
            <input type="text" name="goods_price">
            </div>
            <div class="input-disabled-field">
            <label>Добавлено:</label>
            <span>Дата добавления</span>
            </div>
            <div class="input-disabled-field">
            <label>Автор:</label>
            <span>Автор</span>
            </div>
            <div class="adding-googs">
            <button type="submit" class="page__btn">Добавить товар</button>
            </div>
            </div>
            </form>
          </div>
    </div>
	
    </main>
    <footer>
		<div class="container">
        </div>
    </footer>
</body>
</html>