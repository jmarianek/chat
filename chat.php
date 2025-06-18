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
$room_id = $_GET["id"];
echo "id=$room_id".BR;

// zjistit zdali mistnost existuje
if (!room_exists($room_id)) {
    echo "Mistnost neexistuje";
    exit();
}

// obsluha submitu form. (nova zprava)
if (isset($_POST["msg"])) {
    // id mistnosti a obsah zpravy
    insert_post($room_id, $_POST["msg"]);
}

?>

<div id="flex-container">
    <div id="posts">
    Nacitani prispevku...
    </div>

    <script>
    function refreshPosts() {
        show_posts(<?php echo $room_id ?>);
    }

    refreshPosts();
    setInterval(refreshPosts, 5000);
    </script>


    <form method="post" id="post-form">
        <textarea name="msg" placeholder="Sem piste..."></textarea>
        <button>Odeslat</button>
    </form>
</div>

<?php
require_once "layout/footer.php";
?>
