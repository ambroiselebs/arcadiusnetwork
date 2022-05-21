<?php

require('components/dbh.inc.php');

function createAnAccount($selectUsername, $selectPassword, $selectEmail, $data) {

    //Select All users to check if a user already exist with this username/email
    $sql = "SELECT * FROM users WHERE username LIKE '$selectUsername' OR email LIKE '$selectEmail'";
    $res = mysqli_query($data, $sql);
    $check = mysqli_num_rows($res);

    //Check if there is 1 result
    if ($check > 0) {
        //A user already exist
        echo "<h1>Account already exist</h1>";
    } else {
        //create the account

        //Hash the password
        $hashPassword = password_hash($selectPassword, PASSWORD_DEFAULT);

        try {
            
            //Upload account info to the database
            $data->query("INSERT INTO users (id, username, email, password, pp) VALUES (null, '$selectUsername', '$selectEmail', '$hashPassword', 'none')");

            echo "<h1>OK</h1>";

        } catch (mysqli_sql_exception $e) { echo "<h1>Error</h1>"; }
    }

}

function login($username, $password, $data) {


    //Select All users that correspond to the suername in the text field
    $sql = "SELECT * FROM users WHERE email LIKE '$username'";
    $res = mysqli_query($data, $sql);

    while ($row = mysqli_fetch_assoc($res)) {


        //Check if the password is good
        $hashPassword = $row['password'];

        if (password_verify($password, $hashPassword)) {

            //set the Session/Cookie
            $id = $row['id'];
            $cUsername = $row['username'];
            $cPassword = $password;
            $email = $row['email'];
            $pp = $row['pp'];

            //-------------------------------//

            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $cUsername;
            $_SESSION['password'] = $cPassword;
            $_SESSION['email'] = $email;
            $_SESSION['pp'] = $pp;

            //Set a cookie for one mounth

            setcookie("email", $email, time()+2592000, "/");
            setcookie("password", $cPassword, time()+2592000, "/");

            //Echo a message
            echo "<h1>LOG!</h1>";

        } else {
            echo "<h1>Wrong password</h1>";
        }


    }


}

function loginWithCookie($email, $password, $data) {

    //Check if a user exist
    $sql = "SELECT * FROM users WHERE email LIKE '$email'";
    $res = mysqli_query($data, $sql);

    while ($row = mysqli_fetch_assoc($res)) {

        $hashPassword = $row['password'];

        if (password_verify($password, $hashPassword)) {

            //set the Session/Cookie
            $id = $row['id'];
            $cUsername = $row['username'];
            $cPassword = $password;
            $email = $row['email'];
            $pp = $row['pp'];

            //-------------------------------//

            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $cUsername;
            $_SESSION['password'] = $cPassword;
            $_SESSION['email'] = $email;
            $_SESSION['pp'] = $pp;

        }

    }

}

function subscribe($user_id, $profile_id, $data) {

    //Check if the user is connected
    if (isset($_SESSION['user_id'])) {


        //Check if the user is already suscribe
        $sql = "SELECT * FROM subs WHERE user_id LIKE '$user_id' AND profile_id LIKE '$profile_id'";
        $res = mysqli_query($data, $sql);
        $check = mysqli_num_rows($res);

        if($check > 0) {
            echo "<h1>Already suscribe</h1>";
        } else {

            //Check if the user try tu sub to his own account
            if ($user_id == $profile_id) {
                echo "<h1>Can't suscribe to your own account</h1>";
            } else {

                //Suscribe to the account
                try {

                    $data->query("INSERT INTO subs (id, user_id, profile_id) VALUES (null, '$user_id', '$profile_id')");

                    echo "<h1>OK</h1>";

                } catch (mysqli_sql_exception $e) { echo "<h1>Error</h1>"; }

            }

        }
    }

}