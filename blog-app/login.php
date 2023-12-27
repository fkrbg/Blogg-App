<?php
    
    require "libs/vars.php";
    require "libs/ayar.php";
    require "libs/functions.php";

    if(isLoggedin()){
        header ("location: profile.php");
        exit;
    }
    
    $username= $password="";
    $username_err= $password_err=$login_err="";

    if(isset($_POST["login"])){

        if(empty(trim($_POST["username"]))){
            $username_err="username girmelisiniz.";
        }else{
            $username = trim($_POST["username"]);
        }

        if(empty(trim($_POST["password"]))){
            $password_err="password girmelisiniz.";
        }else{
            $password = trim($_POST["password"]);
        }

        if(empty($username_err) && empty($password_err)){
            $sql = "SELECT id, username, password, user_type FROM users WHERE username = ?";
            if($stmt = mysqli_prepare($connection,$sql)){
                $param_username = $username;
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_store_result($stmt);

                    if(mysqli_stmt_num_rows($stmt) == 1){
                        mysqli_stmt_bind_result($stmt, $id,$username, $hashed_password,$user_type);
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $hashed_password)){

                                $_SESSION["loggedin"]=true;
                                $_SESSION["id"]=true;
                                $_SESSION["username"]=$username;
                                $_SESSION["user_type"]=$user_type;
                                header("location: profile.php");
                            }else {
                                $login_err = "yanlış parola girdiniz.";

                            }
                        }
                    }else {
                        $login_err = "yanlış username girdiniz.";
                    }
                }else{
                    $login_err = "bilinmeyen hata oluştu";
                }
                mysqli_stmt_close($stmt);
            }
        }

        mysqli_close($connection);
    }


?>
    <?php include "views/_header.php";?>
    <?php include "views/_navbar.php";?>
    
    <div class ="container" style="padding: 0%;">

    <?php
        if(!empty($login_err)){
            echo '<div class ="alert alert-danger">'.$login_err.'</div>';
        }
    
    ?>  
        <div class = " row justify-content-md-center"  >
            <div class ="col-md-auto">
            <div class="card" style="background-color: rgba(255,255,255,0)">

                <div class="col align-self-start" style="background-color: rgba(255,255,255,0)">
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid': ''?> " value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err?></span>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password"  name="password" id="password"class="form-control <?php echo (!empty($password_err)) ? 'is-invalid': ''?> "value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err?></span>
                        </div>
                        
                        <!-- <input type="submit" name="login" value ="submit" class="btn btn-dark"> -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-dark me-md-2" type="submit" name="login" value ="submit">Submit</button>
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