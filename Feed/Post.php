<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../CSS/css.css" rel="stylesheet" type='text/css'/>
    <title>Document</title>
</head>
<body>
<div class="login-style">
    <form action="/UploadPost.php">
        <table>
            <tr><td><h1>Your Post</h1></td></tr>
            <tr>
                <td><textarea name="status" placeholder="Enter your status here" rows="10" cols="30"></textarea></td>
            </tr>
            <!--TODO:Multiple pictures -->
            <tr>
                <td><input type="file" name="pic" accept="image/*"></td>
            </tr>
            <table>
                <tr>
                    <td><input type="radio" name="privacy" value="Public" required>Public</td>
                    <td><input type="radio" name="privacy" value="Private">Private</td>
                </tr>
            </table>
            <tr>
                <td><input type="submit" value="Post Now!"></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>

