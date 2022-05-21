<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Arcadius | Home</title>
</head>
<body>

    <?php
        session_start();

        require('components/dbh.inc.php');
        require('components/functions.inc.php');
        require('components/require.php');
    ?>

    <div class="contents">



        <?php
            require('components/navbar.php');

            if (isset($_GET['user_id'])) {

                $profileId = $_GET['user_id'];
                $sql = "SELECT * FROM users WHERE id LIKE '$profileId'";
                $res = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($res)) {

                     $pp = $row['pp'];

                     $sub = "SELECT * FROM subs WHERE profile_id LIKE '$profileId'";
                     $subres = mysqli_query($conn, $sub);
                     $subcount = mysqli_num_rows($subres);

                     ?>

                     <div class="user-stats">

                        <div class="sub">
                            <p><?php echo $subcount; ?> Subscribers</p>
                            <form method="POST">
                                <button name="sub">Suscribe</button>
                            </form>
                        </div>

                        <div class="img">
                            <img src="assets/users/<?php echo $pp; ?>">
                            <p>@ambroiselebs</p>
                        </div>

                        <div class="posts">
                        <p>783 Posts</p>
                        <a><button>See all</button></a>
                        </div>


                     </div>

                     <?php


                }

                if (isset($_POST['sub'])) {
                    subscribe($_SESSION['user_id'], $_GET['user_id'], $conn);
                }

            } else {
                header("Location: index.php");
            }
        ?>



        <?php

        ?>


    </div>

</body>
</html>