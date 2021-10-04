<?php
if(isset($_POST['login_submit'])){
    require 'connect.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)){
        header("Location: ./login.php?error=emptyfields");
        exit();
    }
        else{
            $sql = "SELECT * FROM users WHERE username =?"; //Έλεγχος αν υπάρχει το όνομα
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ./login.php?error=sqlerror");
                exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt, "s", $username);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if($row = mysqli_fetch_assoc($result)){
                        if ($_POST['password'] === $row['user_pwd']){ //Έλεγχος του κωδικού αν είναι σωστός σύμφωνα με τη βάση
                            session_start();
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['user_id'] = $row['user_id'];
                            $_SESSION['user_role'] = $row['user_role'];
							$_SESSION['password'] = $row['user_pwd'];
							$_SESSION['email'] = $row['user_email'];
                            header("Location: ./login.php?login=success");
                            if($row['user_role'] == 1){
                                header("Location: ./Administrator/admindashboard.php?login=admin"); //Σελίδα για ανακατεύθυνση για τον διαχειριστή
                                exit();
                            }
                            else{
                                header("Location: ./User/client.php?login=user"); //Σελίδα για ανακατεύθυνση για τον απλό user
                                exit();
                            }
                        }
                        else{
                            header("Location: ./login.php?error=wrongpassword");
                            exit();
                        }  
                    }
                    else{
                        header("Location: ./login.php?error=usernotfound");
                    exit();
                    }
                }
            }
    }
    else{
    header("Location: ./index.html?error=unauthorisedaccess");
    exit();
    }
?>