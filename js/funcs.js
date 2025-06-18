/**
 * Vlozi (DOM operace) do html elementu s id posts_id
 * prispevky ziskane sluzbou service/get_posts.php?rooms_id=
 * @param room_id Id mistnosti
 */
function show_posts(room_id)
{
    let allPostsDiv = document.getElementById("posts");

    // volani sluzby 
    // http://localhost/4r/chat/service/get_posts.php?rooms_id=
    $.get("http://localhost/4r/chat/service/get_posts.php?rooms_id="
           + room_id, function(data)
    {
        // zakomentovano - jQuery provedl parsovani interne
        //let posts = JSON.parse(data);
        
        allPostsDiv.innerHTML = "";
        for (let post of data) {
            let postDiv = document.createElement("div");
            postDiv.classList.add("post")

            let postAuthor = document.createElement("p");
            let postMsg = document.createElement("p");
            let postDate = document.createElement("p");

            postAuthor.textContent = post.login;
            postAuthor.classList.add("post-author")
            postMsg.textContent = post.msg;
            postMsg.classList.add("post-msg")
            postDate.textContent = post.date;
            postDate.classList.add("post-date")

            postDiv.append(postAuthor, postMsg, postDate)
            // postDiv.className = "post";
            // postDiv.innerHTML = 
            //     "<small>" + post.login + "</small><br/>"
            //     + post.msg;
            allPostsDiv.appendChild(postDiv);
        }

    });

}
