<!DOCTYPE html>
<html>
    <head>
        <title>Mommyfy</title>
        <link rel="apple-touch-icon" sizes="180x180" href="/mommyfy/media/images/icons/coins.svg">
        <link rel="icon" type="image/png" sizes="32x32" href="/mommyfy/media/images/icons/coins.svg">
        <link rel="icon" type="image/png" sizes="16x16" href="/mommyfy/media/images/icons/coins.svg">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.2">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="stylesheet" type="text/css" href="style/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="style/bootstrap-grid.css">
        <script src="js/jquery-3.5.1.js"></script>
        <script src="js/jquery.maskedinput.js"></script>
        <script src="js/bootstrap.bundle.js"></script>
		<script src="js/bootstrap.js"></script>
    </head>
    <body>
        <div class="container">
        	<select name="" id="">
        		<option value="" id="optionTitle" disabled selected>Выберите страну</option>
        		<option value="" id="optionRussia">Россия</option>
        	</select>
        	<input type="text" id="code">
        	<input type="text" id="phone">
        </div>
        <script>
        	$("#code").mask("+9999", {placeholder: "+" });
        </script>
    </body>
</html>
