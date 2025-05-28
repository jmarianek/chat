<?php
// zahajime session - pro vsechny stranky pouzivajici
// header.php
session_start();

require_once "funcs.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat</title>
<link rel="stylesheet" href="css/style.css"/>
<link rel="stylesheet" href="css/jquery.dataTables.min.css"/>
<script src="js/jquery.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
</head>
<body>
    
<!-- navigacni menu -->
<header class="navmenu">
<span><a href="users.php">Uživatelé</a></span>
<span><a href="rooms.php">Místnosti</a></span>

<?php
if (is_logged_in()) {
    // uzivatel je prihlasen
    echo "<span>".$_SESSION["login"].' ';
    // odkaz pro odhlaseni, pouzije session_destroy(); 
    echo "<a href='logout.php'>Odhlásit</a>";
    echo "</span>";
} else {
    echo '<span><a href="login.php">Přihlásit</a></span>';
}

?>

</header>