

function SendLikesAjax(postID){
    $.ajax({
        type: "POST",
        url: "SetLike.php",
        data: {
            postID: postID ,
            likeUnlike: document.getElementById("like"+postID).innerHTML
        },

        success: function(data){
            if(data == "-1"){
                alert("Something happened. couldn't like");
                return;
            }
            document.getElementById("like"+postID).innerHTML =
                ((document.getElementById("like"+postID).innerHTML == "Like") ? "Unlike" : "Like");
            $("#numOfLikes"+postID).html(data);
        }
    });
}

