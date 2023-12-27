<?php
    
    require "libs/vars.php";
    require "libs/functions.php";

    $categoryname = "";
    $categoryname_err = "";
    
    if($_SERVER["REQUEST_METHOD"]=="POST"){


        $input_categoryname=trim($_POST["categoryname"]);

        if(empty($input_categoryname)){
            $categoryname_err="categoryname boş geçilemez.";
        }else if (strlen($input_categoryname)>150){
            $categoryname_err = "categoryname için çok fazla karakter girdiniz.";
        }
        
        else{
            $categoryname=control_input($input_categoryname);
        }


        if(empty($categoryname_err)){
            if (createCategory($categoryname)){
                $_SESSION['message']=$categoryname." isimli kategori eklendi.";
                $_SESSION['type']="success";
                header('location: admin-categories.php');
            } else { 
                echo "hata";
            }
        }
        
        
    }

?>
    <?php include "views/_header.php";?>
    <?php include "views/_navbar.php";?>

    <div class ="container my-3">
        <div class = " row" >
            <div class ="col-3">
                <?php include "views/_menu.php"?>
            </div>
            <div class ="col-9">
                
                <div class="card">

                    <div class="card body">
                        <form action="category-create.php" method="POST">
                            <div class="mb-3">
                                <label for="categoryname" class="form-label">title</label>
                                <input for="text" name="categoryname" id="categoryname" class="form-control <?php echo(!empty($categoryname_err))? 'is-invalid': ''?>" value="<?php echo $categoryname;?>" ></input>
                                <span class="invalid-feedback"><?php echo $categoryname_err?></span>
                            </div>
                            

                            <input type="submit" value ="submit" class="btn btn-primary">


                        </form>
                    </div>
                
                </div>
                
            </div>
        </div>
    </div>
    <?php include "views/_footer.php";?>

    
                  