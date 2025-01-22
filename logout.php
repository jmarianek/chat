<?php
/*
    logout.php
    Odhlaseni

    2024-11-20 - jmarianek - vychozi verze
*/

require_once "layout/header.php";

// zruseni sezeni - smazani hodnot v $_SESSION[]
session_destroy();

?>

<h1>Chat - odhlášení</h1>
Byl jste úspěšně odhlášen.
<script>
setTimeout("location.href='login.php'", 2000);
</script>

<?php
require_once "layout/footer.php";
?>


