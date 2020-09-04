<?php/*
require_once 'articles.class.php';
$articles = new Articles();
// По умолчанию новости так как при пустом запросе загружается раздел новости страницы главная
// Потом содержимое может изменяться с помощью запросов, поэтому page может изменяться в зависимости от страницы без перезагрузки
$page = 'news';
// Вот здесь как раз проверяется гет запрос и меняется page если он есть в гет запросе
if (filter_input(INPUT_GET, 'page') !== null) {
    $page = filter_input(INPUT_GET, 'page');
}

$mainpage='';
if (filter_input(INPUT_GET, 'mainpage') !== null) {
    $mainpage = filter_input(INPUT_GET, 'mainpage');
}

if ($page == 'news') {
    $group = '';
    if (filter_input(INPUT_GET, 'group') !== null) {
        $group = filter_input(INPUT_GET, 'group');
    }
} else if ($page == 'interview') {

    $author = '0';
    if (filter_input(INPUT_GET, 'author') !== null) {
        $author = intval(filter_input(INPUT_GET, 'author'));
    }
}*/
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Printing Technology - Настольная книга полиграфиста</title>
        <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
        <link rel="manifest" href="/images/favicon/site.webmanifest">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.2">
        <meta name="format-detection" content="telephone=no">
        <meta name="keywords" content="Printing Tecnologies">
        <meta name="description" content="Printing Tecnologies">

        <script src="//code.jquery.com/jquery-latest.js"></script> 
        <link href="//fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet" type="text/css">
        <link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700" rel="stylesheet" type="text/css">        
        <link rel="stylesheet" type="text/css" href="style/style.css">

        
    </head>
    <body>
        <?php
        require_once 'blocks/header.php';
        ?>
      
        <div class="systemMessageOverlay">
            <div class="systemMessage">
                <div class="systemMessageText" id="systemMessageText">Текст сообщения</div>
                <div class="systemCloseButton" onclick="closeSystemMessage()">Понятно</div>
            </div>
        </div>
       

        <?php
        require 'blocks/footer.php';
        ?>

    </body>

</html>
