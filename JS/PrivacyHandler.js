const PRIVATE = "Private";
const PUBLIC = "Public";

function ChangePrivacy(postId, newPrivacy) {
    $.ajax({
        type: "POST",
        url: "UpdatePostPrivacy.php",
        data: {
            PostId : postId,
            Privacy: newPrivacy
        },
        success: function (data) {

            /**Revert*/
            if (data === "Failed"){
                if(newPrivacy===PRIVATE){
                    var checked = PUBLIC;
                    var unchecked = PRIVATE;
                }else{
                    var checked = PRIVATE;
                    var unchecked = PUBLIC;
                }

                document.getElementById(checked + "Radio_" + postId).checked = true;
                document.getElementById(checked + "lbl_" + postId).className = "btn btn-primary btn-sm active";

                document.getElementById(unchecked + "Radio_" + postId ).checked = false;
                document.getElementById(unchecked + "lbl_" + postId).className = "btn btn-primary btn-sm";
                document.getElementById(unchecked + "lbl_" + postId).blur();
                alert("Failed to change post Privacy.");
            }
        }

    });
}