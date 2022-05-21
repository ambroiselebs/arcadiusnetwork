<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Arcadius | Home</title>
</head>
<body>

    <div class="content">


        <?php
            session_start();

            require('components/dbh.inc.php');
            require('components/navbar.php');
            require('components/functions.inc.php');

            if (isset($_COOKIE['email']) || isset($_COOKIE['password'])) {
                loginWithCookie($_COOKIE['email'], $_COOKIE['password'], $conn);
            }
        ?>

        <?php
        if (isset($_SESSION['user_id'])) {
            
            ?>

            <center><div class="logins">

            <div class="login">

                <p class="name">Login</p>
                
                <br><hr>

                <div class="login-form">

                    <form method="POST" enctype="multipart/form-data">

                        <div class="form-content">
                            <p>Email :</p>
                            <input type="text" name="logmail">

                            <br>

                            <p>Password :</p>
                            <input type="password" name="logpass">

                            <br><br><br><br><br><br>

                            <button name="log">Login</button>
                        </div>

                    </form>

                </div>

            </div>

            <div class="register">

                <p class="name">Register :</p>

                <br><hr>

                <div class="reg-form">


                    <form method="POST" enctype="multipart/form-data">


                        <div class="form-content">

                            <p>Username :</p>
                            <input type="text" name="reg-username">

                            <br>
                            
                            <p>Email :</p>
                            <input type="mail" name="reg-mail">

                            <br>

                            <p>Password :</p>
                            <input type="password" name="reg-pass">

                            <br><br><br>

                            <button name="reg">Register</button>

                        </div>


                    </form>


                </div>

            </div>



            </div></center>

            <?php

        } else {
            header("Location: profile.php");
        }
        ?>


    </div>

    <?php

        if (isset($_POST['reg'])) {

            createAnAccount($_POST['reg-username'], $_POST['reg-pass'], $_POST['reg-mail'], $conn);

        }

        if (isset($_POST['log'])) {

            login($_POST['logmail'], $_POST['logpass'], $conn);
            
        }

    ?>
    
</body>
</html>