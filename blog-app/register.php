<?php
    
    require "libs/vars.php";
    require "libs/functions.php";
    require "libs/ayar.php";    
    $username= $email= $password= $confirm_password ="";
    $username_err= $email_err= $password_err= $confirm_password_err ="";

    if(isset($_POST["register"])){

        if(empty(trim($_POST["username"]))){
            $username_err="username girmelisiniz.";
        }elseif(strlen(trim($_POST["username"])) < 5 or strlen(trim($_POST["username"])) > 15  ){
            $username_err="username 5-15 karakter arasında olmalıdır.";
        }elseif((!preg_match('/^[a-z\d_]{5,20}$/i', $_POST["username"]))){
            $username_err="username sadece rakam, harf ve alt çizgi karakterinden oluşmalıdır.";

        } else{

            $sql = "SELECT id FROM users WHERE username = ?";
            if($stmt = mysqli_prepare($connection, $sql)){
                $param_username = trim($_POST["username"]);
                mysqli_stmt_bind_param($stmt,"s",$param_username);
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);

                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $username_err="username daha önce alınmış.";
                    } else{
                        $username = $_POST["username"];
                    }
                }else{
                    echo mysqli_error($connection);
                    echo "hata oluştu";
                }
            }

            
        }


        if(empty(trim($_POST["email"]))){
            $email_err="email girmelisiniz.";
        }elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $email_err="hatali email girdiniz.";
        }else{
            $sql = "SELECT id FROM users WHERE email = ?";
            if($stmt = mysqli_prepare($connection, $sql)){
                $param_email = trim($_POST["email"]);
                mysqli_stmt_bind_param($stmt,"s",$param_email);
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);

                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $email_err="email daha önce alınmış.";
                    } else{
                        $email = $_POST["email"];
                    }
                }else{
                    echo mysqli_error($connection);
                    echo "hata oluştu";
                }
            }
        }


        if(empty(trim($_POST["password"]))){
            $password_err="password girmelisiniz.";
        }elseif(strlen($_POST["password"]) < 6){
            $password_err="password min. 6 karakter olmalıdır.";

        }
        else{
            $password = $_POST["password"];
        }


        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err="confirm_password girmelisiniz.";
        }else{
            $confirm_password = $_POST["confirm_password"];
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "parolalar uyuşmuyor.";
            }
        }


        if(empty($username_err) && empty($email_err) && empty($password_err)){
            $sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
            if($stmt = mysqli_prepare($connection, $sql)){
                $param_username = $username;
                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT);

                mysqli_stmt_bind_param($stmt,"sss",$param_username, $param_email, $param_password);

                if(mysqli_stmt_execute($stmt)){
                    header("location: login.php");
                } else{
                    echo mysqli_error($connection);

                    echo "hata oluştu";
                }

            }
        }
    }



?>
    <?php include "views/_header.php";?>
    <?php include "views/_navbar.php";?>

    <div class ="container">
        <div class = "  row justify-content-md-start" >
            <div class ="col-4">
            <div class="card" style="background-color: rgba(255,255,255,0)">

                <div class="col-12" >
                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid': ''?> " value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err?></span>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email"  name="email" id="email"class="form-control <?php echo (!empty($email_err)) ? 'is-invalid': ''?> " value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err?></span>

                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password"  name="password" id="password"class="form-control <?php echo (!empty($password_err)) ? 'is-invalid': ''?> "value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err?></span>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password"  name="confirm_password" id="confirm_password"class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid': ''?> "value="<?php echo $confirm_password; ?>">
                            <span class="invalid-feedback"><?php echo $confirm_password_err?></span>
                            

                        </div>
                        
                        <!-- <input type="submit" name="register" value ="submit" class="btn btn-dark justify-content-md-end"> -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-dark me-md-2" input type="submit" name="register" value ="submit">Submit</button>
                        </div>


                    </form>
                </div>            
            </div>
        </div>
    </div>
    <?php include "views/_footer.php";?>

    <!-- <div class="card mb-3">
                    <div class="row">
                        <div class="col-3"> 
                            <img class="img-fluid" src ="img/2.jpeg" alt="">

                        </div>
                        <div class="col-9"> 
                            <div class="card-body">
                                <h5 class="card-title"><?php echo "<a href=\"{$film1Url}\">{$filmler["2"]["Baslik"]}</a>" ?></h5>
                                <p class="card-text">
                                <?php 
                                        if(strlen($filmler["2"]["Ozet"])>limit){
                                            echo substr($filmler["2"]["Ozet"],0,200)."...";
                                        }
                                        else{
                                            echo $filmler["2"]["Ozet"];
                                        }
                                    
                                    ?>
                                    
                                <div>
                                    <?php
                                        if($filmler["2"]["YorumSayisi"]>0){
                                            echo "<span class=\"badge bg-primary\"> {$filmler["2"]["YorumSayisi"]} Yorum</span>";
                                        }
                                    ?>
                                    
                                    <span class="badge bg-primary">
                                        <?php
                                            if($filmler["2"]["BegeniSayisi"]>0){
                                                echo $filmler["2"]["BegeniSayisi"]." Beğeni";
                                            }
                                             
                                        ?>
                                    </span>
                                    
                                    <span class="badge bg-warning">
                                        <?php 
                                            if($filmler["2"]["VizyondaOD"]){
                                                echo "Vizyonda";
                                            }
                                            else{
                                                echo "Vizyonda Değil";
                                            }
                                        ?>
                                    </span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->