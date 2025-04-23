<?php

/*
    rooms.php

    2024-12-04 - jmarianek - v1;
    TODO - osetrit neprihlaseneho uziv.

*/


require_once "layout/header.php";
require_once "funcs.php";
?>

<h1>Chat - místnosti</h1>
TODO
<ul>
<li>Pro hosta zobrazit verejne mistnosti
<li>Pro prihl. uzivatele navic ty jeho
<li>Proklik do dane mistnosti
</ul>

<?php
// vyber seznamu mistnosti
$sql = "
select id, name, public, descr
from rooms
where public = 'Y'
"
// pokud prihlasen pridame i neverejne
.(isset($_SESSION["logged_in"]) ? " or public = 'N'" : "");

// pripojeni k DB
$con = connect_db();

$sqlstat = mysqli_query($con, $sql);

echo "<table>\n";
while ($row = mysqli_fetch_array($sqlstat)) {
    // tr($row);
    echo "<tr>";
    $id = $row["id"];
    echo "<td>$id</td>";
    echo "<td><a href='chat.php?id=$id'>"
        .$row["name"]
        ."</a></td>";
    echo "<td>".$row["descr"]."</td>";
    echo "</tr>\n";
}
echo "</table>\n";

?>


<?php
require_once "layout/footer.php";
?>