<?php
/*
    funcs.php
    Pomocne funkce pro Chat.

    2024-11-20 - jmarianek - connect_db();
                           - insert_user();
    2024-11-27 - jmarianek - check_user();
                           - is_admin();
                           - oprava connect_db();
    2024-12-04 - jmarianek - check_user() - pouziti md5();
                           - tr();
    2025-04-09 - jmarianek - insert_post(id, msg);
                           - get_user_id();
                        
*/

require_once "const.php";


/**
 * Pripoji se k DB dle dbcfg.php
 * a vrati spojeni, nebo chybu.
 */
function connect_db() {
    require "dbcfg.php";
    $con = mysqli_connect($server, $login, $passwd, $schema);

    // kontrola pripojeni k DB
    if (!$con) {
        return mysqli_connect_error();
    }

    return $con;
}


/**
 * Vlozi do DB predaneho uzivatele.
 * @param $user_data Obsahuje $_POST[] odesl. formulare.
 * @return Hodnota true - ok, false - chyba.
 */
function insert_user($user_data) {
    $con = connect_db();

    $login = $user_data["login"];
    $passwd = md5($user_data["passwd"]);
    $name = $user_data["name"];
    $surname = $user_data["surname"];

    $sql = "INSERT INTO users(login, passwd, name, surname)\n"
          ."VALUES(?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $login, $passwd, $name, $surname);

    if (mysqli_stmt_execute($stmt)) {
        return true;
    }

    return false;
}


/**
 * Vlozi zpravu do dane mistnosti.
 * Vezme se id prihlaseneho uzivatele.
 * @param room_id Id mistnosti
 * @param msg Obsah zpravy
 * @return True ok, false chyba.
 */
function insert_post($room_id, $msg) {
    // kontrola ze je uziv. prihlasen
    if (!is_logged_in()) return false;

    $user_id = get_user_id($_SESSION["login"]);

    $con = connect_db();
    // osetrime potencialne nebezpecne uziv. vstupy
    // pomoci prepared statement
    
    $sql = "insert into posts(users_id, rooms_id, msg)\n"
          ."values(?, ?, ?)";
    echo BR."$user_id, $room_id, $msg";
    echo BR.$sql;

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "iis",
        $user_id, $room_id, $msg);
    if (mysqli_stmt_execute($stmt)) {
        return true;
    }
    return false;
}


/**
 * Proveri, ze predany uziv. $user_data["login"],
 * $user_data["passwd"] v DB existuje a heslo sedi.
 * @return True existuje a heslo sedi, false jinak.
 */
function check_user($user_data) {
    $login = $user_data["login"]; // form. pole login
    $passwd = $user_data["passwd"]; // form. pole passwd

    $con = connect_db();

    $sql = "SELECT id FROM users WHERE "
          ."login = ? "
          ."AND passwd = md5(?)";

    $stmt = mysqli_prepare($con, $sql);
    $stmt->bind_param('ss', $login, $passwd);
    $stmt->execute();

    // pokud zaznam najdeme, pak je to admin
    $result = $stmt->get_result();
    if (!$result) {
        // chyba
        exit;
    }

    if (mysqli_fetch_assoc($result)) {
        // vracen zaznam
        return true;
    }

    return false;
}


/**
 * Pro login vrati id uzivatele
 */
function get_user_id($login) {
    // TODO: pouzit bind_param !!!

    // // ziskame spojeni do DB
    // $con = connect_db();    
    // $sql = "select id from users where login = '"
    //       .mysqli_real_escape_string($con, $login)."'";
    // $sqlstat = mysqli_query($con, $sql);
    // if ($row = mysqli_fetch_assoc($sqlstat)) {
    //     // vracen zaznam
    //     return $row["id"];
    // }

    $con = connect_db();

    $sql = "SELECT id FROM users WHERE "
          ."login = ?";

    $stmt = mysqli_prepare($con, $sql);
    $stmt->bind_param('s', $login);
    $stmt->execute();

    // pokud zaznam najdeme, pak je to admin
    $result = $stmt->get_result();
    if (!$result) {
        // chyba
        exit;
    }

    if ($row = mysqli_fetch_assoc($result)) {
        // vracen zaznam
        echo $row["id"];
        return $row["id"];
    }

    return false;
}


function is_logged_in() {
    return isset($_SESSION["login"]);
}


function is_admin() {
    if (!is_logged_in()) {
        return false;
    }

    $con = connect_db();

    $login = $_SESSION["login"];

    $sql = "SELECT id FROM users WHERE "
          ."login = ? "
          ."AND role = 'admin'";

    $stmt = mysqli_prepare($con, $sql);
    $stmt->bind_param('s', $login);
    $stmt->execute();

    // pokud zaznam najdeme, pak je to admin
    $result = $stmt->get_result();
    if (!$result) {
        // chyba
        exit;
    }

    if (mysqli_fetch_assoc($result)) {
        // vracen zaznam
        return true;
    }

    return false;
}


/**
 * Da na vystup radek html tabulky obsahujici pole $arr.
 * @param $arr pole hodnot
 */
function tr($arr) {
    echo "<tr>";
    foreach ($arr as $cell) {
        echo "<td>".$cell."</td>";
    }
    echo "</tr>\n";
}


function yes_no_to_bool($var) {
    switch ($var) {
        case "Y":
            return true;
            break;
        case "N":
            return false;
            break;
    }
}


?>