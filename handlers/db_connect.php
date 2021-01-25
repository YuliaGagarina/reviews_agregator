<?php

$db = new PDO('mysql:host=localhost; dbname=reviews1', 'root');
$table_users = "users";
$table_reviews = "reviews";
$table_goods = "goods";

try {
    $db = new PDO('mysql:host=localhost; dbname=reviews1', 'root');
    echo 'Connect to DB'. "\n";
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Error Handling

    $sql = "CREATE table $table_users(
        user_id INT NOT NULL AUTO_INCREMENT,
        user_name VARCHAR(45) NOT NULL,
        login VARCHAR(45) NOT NULL,
        password VARCHAR(45) NOT NULL,
        PRIMARY KEY (user_id))";
    $db->exec($sql);
    print("Created $table_users Table.\n");

    $sql = "CREATE table $table_goods(
        goods_id INT NOT NULL AUTO_INCREMENT,
        goods_name VARCHAR(45) NOT NULL,
        picture VARCHAR(45) NULL,
        price VARCHAR(45) 0,
        created_at TIMESTAMP (6) NOT NULL,
        user_id INT(11) NOT NULL,
        PRIMARY KEY (goods_id),
        FOREIGN KEY (user_id) REFERENCES $table_users (user_id))";
    $db->exec($sql);
    print("Created $table_goods Table.\n");

    $sql = "CREATE table $table_reviews(
        review_id INT NOT NULL AUTO_INCREMENT,
        review_name VARCHAR(45) NOT NULL,
        rate VARCHAR(45) NOT NULL,
        comment VARCHAR(45) NOT NULL,
        created_at TIMESTAMP(6) NOT NULL,
        user_id INT(11) NOT NULL,
        PRIMARY KEY (review_id),
        FOREIGN KEY (user_id) REFERENCES $table_users (user_id),
        FOREIGN KEY (goods_id) REFERENCES $table_goods (goods_id)
        )";
    $db->exec($sql);
    print("Created $table_reviews Table.\n");
} catch (PDOException $e) {
    echo $e->getMessage();
}

