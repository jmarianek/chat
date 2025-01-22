<?php
/*
    reg.php
    Registrace

    2024-11-13 - jmarianek - vychozi verze
*/

require_once "layout/header.php";
require_once "funcs.php"; // pomocne funkce

?>

<h1>Chat - registrace</h1>

<?php
// pokud form method=POST je odeslan (submitovan)
// tak je napleno pole $_POST[nazev_pole]
// kde nazev pole je atr. name
if (isset($_POST["login"])) {
    echo "Formular odeslan, login=".$_POST["login"];
    if (insert_user2($_POST)) {
        echo "Uživatel úspěšně založen.".BR;
    } else {
        echo "Uživatele se nepovedlo založit.".BR;
    }
    exit; // dal nic, tj. form se nezobrazi
}

// napr. $_POST["login"]

// TODO - provest SQL prilaz INSERT...
// tj. mysqli_connect(), mysqli_query("insert...");

?>


<!--
id	int    NEMUSIM SE STARAT
name	varchar(20)  ANO
surname	varchar(50)  ANO
passwd	varchar(20)  ANO
login	varchar(20)  ANO
role	enum('admin','moderator','user')  VZDY user
blocked	enum('Y','N') NEMUSIM SE STARAT - def. N
avatar	varchar(50)  ANO
-->
<form method="POST">
<label for="id_login">*Login:</label>
<input id="id_login" name="login" maxlength="20" required>
<br/>
<label for="id_passwd">*Heslo:</label>
<input id="id_passwd" name="passwd" type="password" 
    maxlength="20" required>
<br/>
<label for="id_name">Jméno:</label>
<input id="id_name" name="name" maxlength="20">
<br/>
<label for="id_surname">Příjmení:</label>
<input id="id_surname" name="surname" maxlength="50">
<br/>
<label for="id_avatar">Avatar:</label>
<input id="id_avatar" name="avatar" type="file">
<br/>
<br/>
<input type="submit" value="Odeslat"/>
</form>


<?php
require_once "layout/footer.php";
?>