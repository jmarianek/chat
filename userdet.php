<?php
/*
    userdet.php
    Detail uzivatele

    2024-12-18 - jmarianek - vychozi verze

*/
?>

<?php
require_once "layout/header.php";
require_once "const.php";
require_once "dbcfg.php";
?>

<h1>Detail uživatele</h1>
TODO - odblokovani, povoleni pristupu do mistnosti, ...

<?php

// pokud nejde o admina, pak chybove hlaseni a exit
if ($_SESSION["admin"] != true) {
    echo "Nejste admin".BR;
    exit;
}


/*
id int AI PK 
name varchar(20) 
surname varchar(50) 
passwd varchar(32) 
login varchar(20) 
role enum('admin','moderator','user') 
blocked enum('Y','N') 
avatar varchar(50) 
created datetime 
age int
*/


// pripojeni k DB
$con = mysqli_connect($server, $login, $passwd, $schema);

// kontrola pripojeni k DB
if (!$con) {
    echo "Chyba:".mysqli_error($con).BR;
    exit; // ukonceni vykonavani skriptu php
}
$sql = "
select name, surname, login, role, blocked, 
    created
from users
where id=".$_GET["id"];

//echo $sql;

$result = mysqli_query($con, $sql);
if (!$result) {
    echo "Chyba:".mysqli_error($con).BR;
    exit; // ukonceni vykonavani skriptu php
}
// zobrazeni informaci o uziv.
if ($row = mysqli_fetch_assoc($result)) {
    echo "Jméno: ".$row["name"].BR;
    echo "Příjmení: ".$row["surname"].BR;
    echo "Login: ".$row["login"].BR;
    echo "Role: ".$row["role"].BR;
    echo "Zablokován: ".$row["blocked"].BR;
    echo "Vytvořen: ".$row["created"].BR;
}
?>

<button>Povolit mistnost</button>
<button>Odblokovat</button>
<button>Reset hesla</button>

<?
require_once "layout/footer.php";
?>

