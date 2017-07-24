

$(document).ready(function(){
    $("#search-box").keyup(function(){
        $.ajax({
            type: "POST",
            url: "GetUsers.php",
            data:'keyword='+$(this).val(),
            beforeSend: function(){
                $("#search-box").css("background","#FFF url(../Resources/Images/LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#suggesstion-box").show();
                $("#suggesstion-box").html(data);
                $("#search-box").css("background","#FFF");
            }
        });
    });
});

function selectFriend(val) {
    $("#search-box").val(val);
    $("#suggesstion-box").hide();
}
