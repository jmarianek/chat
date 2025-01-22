<?php
/*
    chat.php

    2024-12-11 - jmarianek - v1;
    2025-01-15 - jmarianek - prispevky pres sluzbu 
                             service/get_posts.php;
    
    TODO - osetrit neprihlaseneho uziv.

*/


require_once "layout/header.php";
require_once "funcs.php";
?>

<script src="js/funcs.js">
</script>

<h1>Chat - vítejte v místnosti</h1>
TODO - overit, ze uzivatel ma pravo na tuto mistnost<br/>
TODO - submit form.<br/>

<?php
$rooms_id = $_GET["id"];
echo "id=$rooms_id".BR;
?>

<div id="id_posts">
Toto prepise js
</div>

<script>
show_posts(<?php echo $rooms_id ?>);
</script>


<form method="post">
<textarea placeholder="Sem piste...">
</textarea>
<button>Odeslat</button>
</form>

<?php
require_once "layout/footer.php";
?>
