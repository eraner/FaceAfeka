

function UploadPost(){
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
                document.writeln(data);
                // alert(data);
            }
        });
    }else{
        alert("wrong");
    }
}
