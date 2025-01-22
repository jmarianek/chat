<?php
/*
get_posts.php
Vrati prispevky z dane mistnosti ve formatu JSON.
URL par.: rooms_id - rooms.id

2025-01-15 - jmarianek - v1

*/

header("Content-Type: application/json; charset=utf-8");

require_once "../funcs.php";

// overit v session ze prihl. uzivatel
// ma na mistnost narok (nebo jestli
// je mistnost pristupna vsem)


// TODO - vratit JSON z dat v DB
$rooms_id = $_GET["rooms_id"];
$sql = "
select id, login, msg, rooms_id
from view_posts
where rooms_id = $rooms_id";

// pripojeni k DB
$con = connect_db();

$sqlstat = mysqli_query($con, $sql);

// $output = "[";
$posts_arr = [];
while ($row = mysqli_fetch_assoc($sqlstat)) {
    /*
    if ($output != "[") {
        $output .= ",";
    }
    $output .= "{";
    $output .=  '"login":"'.$row["login"].'",';
    $output .=  '"msg":"'.$row["msg"].'"';
    $output .=  "}";
    */
    
    // pridame do pole dalsi zaznam z DB
    //$post_arr[] = $row;
    array_push($posts_arr, $row);

}

//$output .=  "]";
// echo $output;

echo json_encode($posts_arr);

/*
// testovaci JSON
echo '
{
    "jmeno": "Jan Novak",
    "vek": 30,
    "adresa": {
      "ulice": "Hlavní 123",
      "mesto": "Praha",
      "psc": "11000"
    },
    "telefon": "+420123456789",
    "email": "jan.novak@example.com"
  }
';
*/
?>