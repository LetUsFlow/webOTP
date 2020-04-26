<?php
require "user.php";


$data = checkUser(getPDOObject());
if ($data["status"]) $username = $data["username"];
else {
    header("Location: index.php?{$data["reason"]}");
}
$db = getPDOObject();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png?v=2">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
            body {
                background-color: #f5f5f5;
            }
            header {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
            }
            input[type="text"] {
                margin-bottom: 0;
                margin-top: 0;
            }
            #userinput {
                /*max-width: 330px;*/
                display: flex;
                flex-direction: row;
                justify-content: space-between;
            }
            #userinput > * {
                width: 45%;
            }
            .form-totpinput .form-control:focus {
                position: relative;
                z-index: 2;
            }
            #issuer {
                margin-top: -25px;
            }
            #issuer2 {
                margin-top: -25px;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }
            #secret {
                margin-top: -25px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
            #time {
                font-weight: bold;
            }
            #status {
                height: 35pt;
                visibility: hidden;
            }

            @media only screen and (max-width: 767px) { /* Ab 768px wird der Container von Bootstrap umgeschaltet */
                #userinput {
                    flex-direction: column;
                }
                header {
                    flex-direction: column;
                }
                #userinput > * {
                    width: auto;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <br>
            <header>
                <?php
                echo "<h3>Hello {$username}!</h3>";
                ?>
                <div>
                    <a type="button" class="btn btn-danger" href="user.php?logout">Logout</a>
                    <button type="button" class="btn btn-info" id="reloadPage">Reload page</button>
                </div>
            </header>
            <br>


                <?php
                $res = $db->query("SELECT * FROM totp WHERE username='$username'");

                if ($res->rowCount() != 0) {
                    echo "<table class=\"table\">" .
                    "<tr><th>Id</th><th>Issuer</th><th>Code</th><th>Action</th></tr>";
                }

                foreach ($res as $row) {
                    echo "<tr>";

                    echo "<td>" . $row["totpId"] . "</td>";
                    echo "<td>" . $row["issuer"] . "</td>";
                    echo "<td class=\"code\"></td>";
                    echo "<td><a href=\"removeKey.php?totpId=" . $row["totpId"] . "\">Delete</a></td>";

                    echo "</tr>";
                }

                if ($res->rowCount() != 0) {
                    echo "</table>";
                }
                else {
                    echo "No TOTP-Accounts found!<br><br><br>";
                }

                ?>


            <br>
            <p>Codes update in <span id="time">0</span> seconds. <img id="status" src="">
            <!--<button id="refresh" >Update codes</button>--></p>

            <br>
            <div id="userinput">
                <form class="form-totpinput" action="totp/genSecretAdvanced.php" method="get" target="_blank">
                    <input type="hidden" name="user" value="<?php echo $username ?>" required>
                    <p><label for="issuer"></label>
                        <input type="text" id="issuer" name="issuer" placeholder="Issuer" class="form-control" value="LetUsFlow webOTP" required></p>
                    <p><button class="btn btn-lg btn-success btn-block" type="submit">Generate new secret key</button></p>
                </form>
                <form class="form-totpinput" action="totp/addKey.php" method="get">
                    <label for="issuer2"></label>
                        <input type="text" id="issuer2" name="issuer" placeholder="Issuer" class="form-control" value="LetUsFlow webOTP" required>
                    <p><label for="secret"></label>
                        <input type="text" id="secret" name="secret" placeholder="Secret" class="form-control" required></p>
                    <p><button class="btn btn-lg btn-success btn-block" type="submit">Add new secret key</button></p>
                </form>


                <br>
            </div>
        </div>


        <script
                src="https://code.jquery.com/jquery-3.4.1.min.js"
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
                crossorigin="anonymous"></script>
        <script>
            let time = document.getElementById("time");
            document.getElementById("reloadPage").addEventListener("click", () => { window.location = window.location; });
            let date;

            $.get("getDate.php", (data) => {
                date = new Date(data);

                setInterval(() => {
                    date.setSeconds(date.getSeconds()+1);
                }, 1000);

            }).then(() => {

                time.innerHTML = (30 - currentSeconds()).toString();
                updateCodes();

                setInterval(() => {
                    let s = currentSeconds();

                    time.innerHTML = (30 - s).toString();
                    if (s === 0) {
                        updateCodes();
                    }

                }, 1000);
            });




            function currentSeconds() {
                let seconds = date.getSeconds();
                return seconds % 30;

            }

            function updateCodes () {

                let codeContainers = document.getElementsByClassName("code");
                let status = document.getElementById("status");

                status.setAttribute("src", "assets/img/loading.svg");
                status.style.visibility = "visible";

                $.get("getCodes.php", (data) => {


                    let codes = data.split(",");

                    codes.forEach((code, i) => {

                        codeContainers[i].innerHTML = code;

                    });

                    status.setAttribute("src", "assets/img/check.svg");
                    setTimeout(() => {
                        status.style.visibility = "hidden";
                    }, 3500);

                });


            }


        </script>
    </body>

</html>


