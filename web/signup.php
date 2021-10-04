<?php
    if(isset($_POST['signup_submit']))
    {
        require 'connect.php';
        $email = mysqli_real_escape_string($conn, $_POST['email']); //gia na mhn boroun na valoun sql commands sto form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $passwordConfirm = $_POST['passwordConfirm'];
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $character = preg_match('@[/\W/]@', $password);

        if(empty($email) || empty($username) || empty($password) || empty($passwordConfirm)){
            header("Location: ./register.php?error=emptyfields&email=".$email."&username=".$username); //an xeahastei kapoio pedio, na mhn hreiastei na valei xana ta upoloipa
            exit();
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
            header("Location: ./register.php?error=invalidmailandusername"); // an to email einai swsto kai to username
            exit();
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header("Location: ./register.php?error=invalidmail"); //an to email einai swsto
            exit();
        }
        else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
            header("Location: ./register.php?error=invalidusername"); //an to username einai swsto
            exit();
        }
        else if(!$uppercase || !$lowercase || !$number || !$character || strlen($password) < 8){ //an o kwdikos einai swstos
            header("Location: ./register.php?error=wrongpassword");
            exit();
        }
        else if($password !== $passwordConfirm){
            header("Location: ./register.php?error=passwordsdontmatch");
        }
        else{
            $sql = "SELECT username FROM users WHERE username =? OR user_email =?"; //elegxos an uparxei to username h to email
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)){ //elegxos gia la8os sthn sql
                header("Location: ./register.php?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "ss", $username, $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $result = mysqli_stmt_num_rows($stmt);
                if ($result > 0){
                    header("Location: ./register.php?error=usernameoremailtaken");
                    exit();
                }
                else{

                    $sql = "INSERT INTO users (user_email, username, user_pwd) VALUES (?, ?, ?);";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){ //elegxos gia la8os sthn sql
                        header("Location: ./register.php?error=sqlerror");
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($stmt, "sss", $email, $username, $password);
                        mysqli_stmt_execute($stmt);
                        header("Location: ./login.php?register=newuser"); //Redirect στο login για το νεο χρήστη.
                        exit();
                    }
                }
            }
        }
    }
    else{
       header("Location: ./index.html?error=unauthorisedaccess");
       exit();
    }