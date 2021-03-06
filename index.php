<?php
require "verify.php";

if (verify()["status"] === "success")
    header("Location: dash.php");

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png?v=2">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.min.css">
        <style>
            body {
                display: flex;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
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
        <form class="form-signin" method="post" action="user/login.php">
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
