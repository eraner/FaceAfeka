


function UploadComment(postID) {
    var loggedUser = document.getElementById("loggedUser").value;
    var comment = document.getElementById("comment_"+postID).value;

    if(comment == "" || loggedUser == ""){
        return;
    }
    
    $.ajax({
        type: "POST",
        url: "UploadComment.php",
        dataType: 'json',
        cache: false,
        data: {loggedUser:loggedUser,
                postID: postID,
                comment: comment},
        success:function (data) {
            document.getElementById("comment_"+postID).value = "";
            $("#CommentsSection_"+postID).html(data.post);
            $("#comment-header_"+postID).html(data.commentsHeader);
            return false;
        }
        
        
    });
}