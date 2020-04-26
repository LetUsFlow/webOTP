<?php
require "user.php";
$data = checkUser(getPDOObject());
if ($data["status"]) header("Location: dash.php");

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            body {
                display: flex;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }
            .form-signin {
                text-align: center;
                width: 100%;
                max-width: 330px;
                padding: 15px;
                margin: auto;
            }
            .form-signin .form-control {
                position: relative;
                box-sizing: border-box;
                height: auto;
                padding: 10px;
                font-size: 16px;
            }
            .form-signin .form-control:focus {
                z-index: 2;
            }
            .form-signin input[type="text"] {
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }
            .form-signin input[type="password"] {
                margin-top: -17px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
        </style>
    </head>
    <body>
        <form class="form-signin" method="post" action="dash.php">
            <h3 class="font-weight-bold">LetUsFlow.net webOTP</h3>
            <h3 class="font-weight-normal">Please sign in</h3>
            <label for="username" class="sr-only">Username</label>
            <p><input type="text" id="username" class="form-control" placeholder="Username" name="username" required autofocus></p>
            <label for="password" class="sr-only">Password</label>
            <p><input type="password" id="password" class="form-control" placeholder="Password" name="password" required></p>
            <p><button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button></p>
        </form>
    </body>
</html>