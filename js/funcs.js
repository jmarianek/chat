/**
 * Vlozi (DOM operace) do html elementu s id posts_id
 * prispevky ziskane sluzbou service/get_posts.php?rooms_id=
 * @param room_id Id mistnosti
 */
function show_posts(room_id)
{
    let div = document.getElementById("id_posts");
    // volani sluzby 
    // http://localhost/4r/chat/service/get_posts.php?rooms_id=
    $.get("http://localhost/4r/chat/service/get_posts.php?rooms_id="
           + room_id, function(data) {
        console.log(data);
        // TODO json encode + DOM operace
        div.innerHTML = data;
    });

     
}