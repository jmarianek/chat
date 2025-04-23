<?php
/*
    userdet.php
    Detail uzivatele

    2024-12-18 - jmarianek - vychozi verze

*/

require_once "layout/header.php";
require_once "const.php";
require_once "dbcfg.php";
require_once "funcs.php";

// pokud nejde o admina, pak chybove hlaseni a exit
if ($_SESSION["admin"] != true) {
    echo "Nejste admin".BR;
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = connect_db();

    $id = $_POST["user_id"];
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $login = $_POST["login"];
    $role = $_POST["role"];
    if (isset($_POST["blocked"])) {
        $blocked = "Y";
    } else {
        $blocked = "N";
    }

    $sql = "UPDATE users SET name = ?, surname = ?, login = ?, role = ?, blocked = ?\n"
          ."WHERE id = ?";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $name, $surname, $login, $role, $blocked, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Udaje byly uspesne upraveny.";

    } else {
        echo "Udaje se nepodarilo upravit.";
    }
}

?>

<h1>Detail uživatele</h1>
TODO - odblokovani, povoleni pristupu do mistnosti, ...

<?php

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


$sql = "
SELECT name, surname, login, role, blocked, created
FROM users
WHERE id=".$_GET["id"];

$con = connect_db();
$sqlstat = mysqli_query($con, $sql);

$rows = mysqli_fetch_array($sqlstat);

echo "Jmeno: ". $rows["name"].BR;
echo "Prijmeni: ". $rows["surname"].BR;
echo "Login: ". $rows["login"].BR;
echo "Role: ". $rows["role"].BR;
echo "Zablokovan: ";
if ($rows["blocked"] == "Y") {
    echo "ANO";
} else {
    echo "NE";
}
echo BR;

echo "Vytvoren: ". $rows["created"].BR;
?>

<dialog>
    <form method="post">
        <input type="hidden" name="user_id" value="<?php echo $_GET["id"] ?>" />
        <label for="name">Jmeno:</label>
        <input id="name" name="name" type="text" value="<?php echo $rows["name"] ?>" />
        <br />
        <label for="surname">Prijmeni:</label>
        <input id="surname" name="surname" type="text" value="<?php echo $rows["surname"] ?>" />
        <br />
        <label for="login">Login:</label>
        <input id="login" name="login" type="text" value="<?php echo $rows["login"] ?>" required />
        <br />
        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <?php
            foreach (["user", "moderator", "admin"] as $role) {
                echo '<option value="'. $role. '"';
                if ($role == $rows["role"]) {
                    echo 'selected';
                }
                echo '>'. ucfirst($role). '</option>';
            }
            ?>
        </select>
        <br />
        <label for="blocked">Zablokovan:</label>
        <input id="blocked" name="blocked" type="checkbox" <?php echo yes_no_to_bool($rows["blocked"]) ? "checked" : "" ?> />
        <br />
        <input type="submit" value="Ulozit" />
    </form>
    <button id="closeBtn" autofocus>Zrusit</button>
</dialog>
<button id="openBtn">Upravit uzivatele</button>

<script>
// https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/dialog

const dialog = document.querySelector("dialog");
const showButton = document.querySelector("dialog + #openBtn");
const closeButton = document.querySelector("dialog #closeBtn");

showButton.addEventListener("click", () => {
  dialog.showModal();
});

closeButton.addEventListener("click", () => {
  dialog.close();
});
</script>

