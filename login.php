<?php
/*
    login.php
    Prihlaseni

    2024-10-23 - jmarianek - vychozi verze
    2024-11-06 - jmarianek - prace se session
    2024-11-13 - jmarianek - registrace;
    2024-11-20 - jmarianek - volani check_user();
*/


require_once "layout/header.php";
require_once "funcs.php";
?>

<h1>Chat - přihlášení</h1>
<form method="POST">
<label for="login">Login:</label>
<input required id="id_login" name="login" type="text"/>
<br/>
<label for="passwd">Heslo:</label>
<input required id="id_passwd" name="passwd" type="password"/>
<br/>
<input type="submit" value="Přihlásit"/>
</form>

<?php
// TODO - zkontrolovat uspesne prihlaseni
// tj. 1. jestli zadal existujici login (v DB)
//     2. a odpovidajici spravne heslo
// Pak kdyz prihlasen, tak naplnime session.

// kdyz form. odeslan a zadany spravne prihl. udaje
if (isset($_POST["login"]) && check_user($_POST))
{
    // uspesne prihlaseni
    $_SESSION["logged_in"] = true;
    $_SESSION["login"] = $_POST["login"]; 
    // dotahneme roli uzivatele z DB
    $_SESSION["admin"] = is_admin($_POST["login"]); 
    echo "<script>location.href='index.php'</script>";
} else {
    echo "Neuspesne prihlaseni".BR;
}

?>

<div>
Nemáte ještě účet?
<a href="reg.php">Zaregistrujte se</a>
</div>

<?php
require_once "layout/footer.php";
?>