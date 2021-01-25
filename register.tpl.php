<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">    
    <title>Главная</title>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
		</div>
    </header>
    <main>
		<div class="container">
			<div class="login-form">
                <form action="/handlers/register.php" method="POST">
                <div class="form-content">
                <div class="input-field">
                <label>Ваше имя</label>
                <input type="text" name="user_name">
                </div>
                <div class="input-field">
                <label>Логин</label>
                <input type="text" name="login">
                </div>
                <div class="input-field">
                <label>Пароль</label>
                <input type="password" name="password">
                </div>
                <div class="input-field">
                <label>Повторите пароль</label>
                <input type="password" name="password_check">
                </div>
                <div class="adding-googs">
                <button type="submit" class="page__btn">Зарегистрироваться</button>
                </div>
                </form>
            </div>
        </div>	
    </main>
    <footer>
		<div class="container"></div>
    </footer>
</body>
</html>