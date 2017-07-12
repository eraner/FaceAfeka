<!doctype html>
<html lang="en">
<head>
    <link href="../CSS/css.css" rel='stylesheet' type='text/css' />
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <!--Start login-style -->
    <div class="login-style">
        <h1>Sign Up</h1>
        <form action="signup_handler.php" method="POST">
            <input type="text" name="username" placeholder="Username" required/>
            <input type="password" name="password" placeholder="Password" required/>
            <input type="password" name="rePassword" placeholder="Repeat Password" required/>
            <div class="submit">
                <input type="submit" value="Register" >
            </div>
        </form>
    </div>
    <!--End login-style -->
</body>
</html>