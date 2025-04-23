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
function connect_db()
{
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
function insert_user($user_data)
{
    $con = connect_db();
    // osetrime potencialne nebezpecne uziv. vstupy
    $login = mysqli_real_escape_string($con,
        $user_data["login"]);
    $passwd = mysqli_real_escape_string($con,
        $user_data["passwd"]);

    $sql = "insert into users(login, passwd)\n"
          ."values('".$login."', '"
                     .$passwd."')";
    echo BR.$sql;
    if (mysqli_query($con, $sql)) {
        return true;
    }
    return false;
}


/**
 * Vlozi do DB predaneho uzivatele.
 * @param $user_data Obsahuje $_POST[] odesl. formulare.
 * @return Hodnota true - ok, false - chyba.
 */
function insert_user2($user_data)
{
    $con = connect_db();
    // osetrime potencialne nebezpecne uziv. vstupy
    // pomoci prepared statement
    
    $sql = "insert into users(login, passwd)\n"
          ."values(?, ?)";
    echo BR.$sql;

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss",
        $user_data["login"], $user_data["passwd"]);
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
function insert_post($room_id, $msg)
{
    // kontrola ze je uziv. prihlasen
    if (!$_SESSION["logged_in"]) return false;

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
function check_user($user_data)
{
    $login = $user_data["login"]; // form. pole login
    $passwd = $user_data["passwd"]; // form. pole passwd
    // ziskame spojeni do DB
    $con = connect_db();
    // zjistime jestli sedi login a heslo
    $sql = "select id from users where "
          ."login = '$login' "
          // v DB je passwd uz md5 zakodovan
          ."and passwd = md5('$passwd')";
    // pokud zaznam najdeme, pak ok
    $sqlstat = mysqli_query($con, $sql);
    if (mysqli_fetch_assoc($sqlstat)) {
        // vracen zaznam
        return true;
    }

    return false;
}





/**
 * Pro login vrati id uzivatele
 */
function get_user_id($login)
{
    // ziskame spojeni do DB
    $con = connect_db();    
    $sql = "select id from users where login = '"
          .mysqli_real_escape_string($con, $login)."'";
    $sqlstat = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($sqlstat)) {
        // vracen zaznam
        return $row["id"];
    }

}






function is_admin($login)
{
    // ziskame spojeni do DB
    $con = connect_db();
    // zjistime jestli sedi login a heslo
    $sql = "select id from users where "
          ."login = '$login' "
          ."and role = 'admin'";
    // pokud zaznam najdeme, pak je to admin
    $sqlstat = mysqli_query($con, $sql);
    if (mysqli_fetch_assoc($sqlstat)) {
        // vracen zaznam
        return true;
    }

    return false;
}



/**
 * Da na vystup radek html tabulky obsahujici pole $arr.
 * @param $arr pole hodnot
 */
function tr($arr)
{
    echo "<tr>";
    foreach ($arr as $cell) {
        echo "<td>".$cell."</td>";
    }
    echo "</tr>\n";
}


?>