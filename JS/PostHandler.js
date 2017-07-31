

function UploadPost(){
    if(document.getElementById("status").value == ""
        || $("input[name='privacy']:checked").val()==null){
        return;
    }
    var formData = new FormData();
    formData.append("status", document.getElementById("status").value);
    formData.append("privacy", $("input[name='privacy']:checked").val());
    formData.append("loggedUser", document.getElementById("loggedUser").value);
    //set pics array
    var count = document.getElementById("pic[]").files.length;
    for (var i = 0; i < count; i++) {
        var file = document.getElementById('pic[]').files[i];
        formData.append("pic[]", file, file.name);
    }

    if(formData) {
        $.ajax({
            type: "POST",
            url: "UploadPost.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {

                if (data){
                    $('#feed').html(data);
                }
                else{
                    alert("Failed to upload your post.");
                }
            },
            async: false
        });
    }else{
        alert("Failed to upload your post.");
    }
}
