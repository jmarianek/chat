<?php
/*
    users.php
    Sprava uzivatelu

    2024-10-23 - jmarianek - vychozi verze
    2024-11-06 - jmarianek - prace se session
    2024-12-18 - jmarianek - detail uziv.;

*/
?>
<script>
$(document).ready(function() {
    $("table").dataTable();
});
</script>

<?php
require_once "layout/header.php";
require_once "const.php";
require_once "dbcfg.php";

function gen_tr($rec)
{
    echo "<tr>\n";
    echo "<td>"
        ."<a href='userdet.php?id=".$rec["id"]."'>"
        .$rec["id"]."</a>"
        ."</td>\n";
    echo "<td>"
        ."<a href='userdet.php?id=".$rec["id"]."'>"
        .$rec["login"]."</a>"
        ."</td>\n";
    echo "<td>".$rec["role"]."</td>\n";
    echo "<td>".$rec["name"]."</td>\n";
    echo "</tr>\n";
}

?>

<h1>Chat - uživatelé</h1>
TODO - administrace uzivatelu, jen pro admina<br/>

<?php

// zobrazime informaci o prihl. uzivateli
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
   echo "Přihlášen: ".$_SESSION["login"].BR.BR;
}


// pokud nejde o admina, pak chybove hlaseni a exit
if ($_SESSION["admin"] != true) {
    echo "Nejste admin".BR;
    exit;
}


// pripojeni k DB
$con = mysqli_connect($server, $login, $passwd, $schema);

// kontrola pripojeni k DB
if (!$con) {
    echo "Chyba:".mysqli_error($con).BR;
    exit; // ukonceni vykonavani skriptu php
}

// SQL dotaz na vsechny uzivatele
$sql = "SELECT id, login, role, name, surname from USERS";
// vykonani dotazu - mysqli_query nad spojenim do DB
$result = mysqli_query($con, $sql);
if (!$result) {
    echo "Chyba:".mysqli_error($con).BR;
    exit; // ukonceni vykonavani skriptu php
}

// prevzeti vracenych zaznamu
echo "<table>\n";
echo "<thead>";
echo "<th>id</th><th>login</th><th>role</th><th>name</th>";
echo "</thead>\n";
echo "<tbody>";
while ($rec = mysqli_fetch_assoc($result))
{
    gen_tr($rec);
}
echo "</tbody>";
echo "</table>\n";

// uzavreni spojeni do DB
mysqli_close($con);

?>




<?php
require_once "layout/footer.php";
?>