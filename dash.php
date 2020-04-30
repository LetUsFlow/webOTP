<?php
require "verify.php";

if (verify()["status"] === "error") header("Location: index.php");
$username = verify()["username"];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png?v=2">
        <link rel="stylesheet" href="assets/css/bootstrap.css">
        <style>
            .bold {
                font-weight: bold;
            }
            #status {
                height: 35pt;
                visibility: hidden;
            }
            header {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
            }

            #issuer {
                margin-top: -25px;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }
            #secret {
                margin-top: -25px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
        </style>
    </head>
    <body>


        <div class="container">
            <br>
            <header>
                <h3>Hello <?php echo $username; ?>!</h3>
                <div>
                    <a type="button" class="btn btn-danger" href="user/logout.php">Logout</a>
                    <button type="button" class="btn btn-info" id="reloadPage">Reload page</button>
                </div>
            </header>
            <br>


            <div id="app">
                <table class="table">
                    <tr><th>ID</th><th>Issuer</th><th>Code</th><th>Action</th></tr>
                    <tr v-for="entry in entries">
                        <td>{{ entry.id }}</td>
                        <td>{{ entry.issuer }}</td>
                        <td>{{ entry.code }}</td>
                        <td><a :href="'totp/removeKey.php?totpId=' + entry.id">Delete</a></td>
                    </tr>
                </table>
                <p>Codes update in <span class="bold">{{ secondsToUpdate }}</span> seconds. <img id="status" src="assets/img/loading.svg" alt="status"></p>
            </div>



            <form action="totp/addKey.php" method="get">
                <p><label for="issuer"></label><input type="text" id="issuer" name="issuer" placeholder="Issuer" class="form-control" required>
                <label for="secret"></label><input type="text" id="secret" name="secret" placeholder="Secret" class="form-control" required></p>
                <p><button class="btn btn-lg btn-success btn-block" type="submit">Add new secret key</button></p>
            </form>
            <form action="totp/genSecret.php" method="get" target="_blank">
                <p><label for="newissuer"></label><input type="text" id="newissuer" name="issuer" placeholder="Issuer" class="form-control" required></p>
                <p><button class="btn btn-lg btn-success btn-block" type="submit">Add new secret key</button></p>

            </form>


        </div>


        <script src="assets/js/vue.js"></script>
        <script src="assets/js/jquery-3.5.0.js"></script>
        <script>
            let app = new Vue({
                el: "#app",
                data: {
                    entries: [],
                    date: new Date(),
                    secondsToUpdate: 0
                },
                created() {
                    this.secondsToUpdate = (30 - this.currentSeconds()).toString();

                    $.get("getDate.php", (data) => {
                        this.date = new Date(data);
                    }).then(() => {
                        setInterval(() => {
                            this.date = new Date(this.date.getTime() + 1000);

                            if (this.currentSeconds() === 0) this.fetchCodes();
                            this.secondsToUpdate = (30 - this.currentSeconds()).toString();

                        }, 1000);
                    });
                    this.fetchCodes();
                },
                methods: {
                    fetchCodes() {
                        $("#status").attr("src", "assets/img/loading.svg").css("visibility", "visible");
                        $.get("totp/getCodes.php", (data) => {
                            this.entries = JSON.parse(data);

                            $("#status").attr("src", "assets/img/check.svg");
                            setTimeout(() => {
                                $("#status").css("visibility", "hidden");
                            }, 3500);
                        });
                    },
                    currentSeconds() {
                        return this.date.getSeconds() % 30;
                    }
                }
            });

            $("#reloadPage").click(() => {window.location = window.location;});
        </script>
    </body>
</html>
