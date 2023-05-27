<?php
    session_start();
    require("database.php");
    $errMessage = array();
?>

<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
        <title>Login</title>
    </head>
    <style>
      #intro {
        background-image: url("image/logo.png");
        height: 100vh;
      }

    </style>
    <body>
    <?php
            if(isset($_POST['username']) && isset($_POST['password'])){
                
                $password = hash("sha256", $_POST['password']);

                $q = $db->prepare("SELECT * FROM users WHERE username= :username AND password= :password");
                $q->execute(array('username'=>$_POST['username'], 'password'=>$password));

                $results = $q->fetch(); 

                if(isset($results[0])){
                    $_SESSION['ID'] = $results[0];
                    $_SESSION['USERNAME'] = $results[1];
                    $_SESSION['PASSWORD'] = $results[2];
                    $_SESSION['LOGGED'] = true;

                    header("Location: index.php"); 
                       exit();
                }else{
                    $errMessage = "Kullanıcı adı veya şifre yanlış!";
                    
                }
            }

        ?>
        <div id="intro" class="bg-image shadow-2-strong">
            <div class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.8);">
                <div class="container">
                    <div class="row justify-content-center">
                    <?php  
                if (!empty($errMessage)) {
                    echo "<div class='alert alert-danger text-center' role='alert'>
                        $errMessage
                        </div>";
                }
                ?>
                        <div class="col-xl-5 col-md-8">
                            <form class="bg-white  rounded-5 shadow-5-strong p-5" method="POST">
                                <div class="form-floating mb-3">
                                    <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                                    <label for="floatingInput">Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                    <label for="floatingPassword">Password</label>
                                </div>
                                <div class="d-grid gap-2 mb-3">
                                    <button class="btn btn-primary btn-lg" type="submit">Log In</button>
                                </div>
                                <a href="signup.php" class="link-primary">Hesap oluşturmak için tıklayınız</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
