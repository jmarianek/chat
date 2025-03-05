<?php
/*
    chat.php

    2024-12-11 - jmarianek - v1;
    2025-01-15 - jmarianek - prispevky pres sluzbu 
                             service/get_posts.php;
    2025-02-05 - jmarianek - obsluha submitu form. (nova zprava);
                           - refresh po 5s;
    
    TODO - osetrit neprihlaseneho uziv.

*/


require_once "layout/header.php";
require_once "funcs.php";
?>

<script src="js/funcs.js">
</script>

<h1>Chat - vítejte v místnosti</h1>
TODO - overit, ze uzivatel ma pravo na tuto mistnost<br/>

<?php
$rooms_id = $_GET["id"];
echo "id=$rooms_id".BR;

// obsluha submitu form. (nova zprava)
if (isset($_POST["msg"])) {
    // id mistnosti a obsah zpravy
    insert_post($id, $_POST["msg"]);
}

?>

<div id="id_posts">
Toto prepise js
</div>

<script>
function refreshPosts() {
    show_posts(<?php echo $rooms_id ?>);
}

setInterval(refreshPosts, 5000);
</script>


<form method="post">
<textarea name="msg" placeholder="Sem piste...">
</textarea>
<button>Odeslat</button>
</form>

<?php
require_once "layout/footer.php";
?>
