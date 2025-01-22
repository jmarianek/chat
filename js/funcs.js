/**
 * Vlozi (DOM operace) do html elementu s id posts_id
 * prispevky ziskane sluzbou service/get_posts.php?rooms_id=
 * @param room_id Id mistnosti
 */
function show_posts(room_id)
{
    let allPostsDiv = document.getElementById("id_posts");
    allPostsDiv.innerHTML = "";

    // volani sluzby 
    // http://localhost/4r/chat/service/get_posts.php?rooms_id=
    $.get("http://localhost/4r/chat/service/get_posts.php?rooms_id="
           + room_id, function(data)
    {
        // zakomentovano - jQuery provedl parsovani interne
        //let posts = JSON.parse(data);

        console.log(data);
        
        for (let post of data) {
            console.log(post.id + ' ' + post.msg);
            let postDiv = document.createElement("div");
            postDiv.className = "post";
            postDiv.innerHTML = post.msg;
            allPostsDiv.appendChild(postDiv);
        }

    });

     
}