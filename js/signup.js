$passwordValid = false;
$password = $('.password');
$error = $('#error');
$signup = $('#signup');

$signup.submit(function (e) {
    e.preventDefault();

    var dataForm = $('#signup').serialize();
    //var dataForm = { first: "yo", last: "yo", email: "me", number: "eh" };
    $.post("query/register.php", dataForm, function (data) {

    }).done(function (result) {
        console.log(result);
        if (result == "success") {
            window.location.href = "workspace.php";
        }else{
            $error.text(result);
            $error.fadeIn("slow");
            setTimeout(function(){
                $error.fadeOut("fast");
            },3000);
        }
    });
});

$(document).on("submit", "form#reset-password", function(e){
    e.preventDefault();
    var password = $('#password').val();
    $.post("query/resetPass.php", {"pass" : password}).done(function (result) {
        if(result){
            console.log(result);
            $("#reset-password").remove();
            $('#reset-success').text("Your password has been successfully reset");
        }else{
            console.log("false");
        }
    })
});

$password.blur(function(){
    $first = $('#password').val();
    $second = $('#confirm').val();
    if($second != ""){
        $equal = $first == $second;
        $length = $first.length >= 8;
        $passwordValid = $equal && $length;

        if($passwordValid){
            $password.css("color", "white").css("background-color", "green");
            $error.fadeOut("fast");
        }else{
            if($equal){
                $error.text("Password isn't greater than 8 characters");
            }else{
                $error.text("Passwords don't match");
            }
            $error.fadeIn("slow");
            $password.css("color", "white").css("background-color", "red");
        }
    }
});
