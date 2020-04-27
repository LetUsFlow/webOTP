<?php
/**
 * >> webOTP <<
 * >> dash.php <<
 * (c) Florentin Schäfer 2020
 */

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png?v=2">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

        <style>
            .bold {
                font-weight: bold;
            }
        </style>
    </head>
    <body>


        <div class="container">
            <div id="app">
                <table class="table">
                    <tr><th>ID</th><th>Issuer</th><th>Code</th><th>Action</th></tr>
                    <tr v-for="code in codes">
                        <td>id</td>
                        <td>issuer</td>
                        <td>{{ code }}</td>
                        <td>action</td>
                    </tr>
                </table>
                <p>Codes update in <span class="bold">{{ secondsToUpdate }}</span> seconds. <img id="status" src="" alt="status"></p>
            </div>
        </div>


        <script src="../assets/js/vue.js"></script>
        <script src="../assets/js/jquery-3.5.0.js"></script>
        <script>
            let app = new Vue({
                el: "#app",
                data: {
                    codes: [],
                    date: new Date(),
                    secondsToUpdate: 0
                },
                created() {
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
                        $.get("getCodes.php", (data) => {
                            this.codes = JSON.parse(data);
                        })
                    },
                    currentSeconds() {
                        return this.date.getSeconds() % 30;
                    }
                }
            });
        </script>
    </body>
</html>
