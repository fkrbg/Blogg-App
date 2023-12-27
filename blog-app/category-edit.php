<?php
    
    require "libs/vars.php";
    require "libs/functions.php";

    $id=$_GET["id"];
    $result = getCategoryById($id);
    $selectedcategory = mysqli_fetch_assoc($result);

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $categoryname=$_POST["categoryname"];
        $isActive=isset($_POST["isActive"]) ? 1 : 0 ;
        if (editCategory($id, $categoryname,$isActive)){
            $_SESSION['message']=$categoryname." isimli kategori güncellendi.";
            $_SESSION['type']="success";

            header('location: admin-categories.php');
        } else {
            echo "hata";
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
                        <form method="POST">
                            <div class="mb-3">
                                <label for="categoryname" class="form-label">title</label>
                                <input for="text" class="form-control" name="categoryname" id="categoryname" value="<?php echo $selectedcategory["name"]?>">

                            </div>
                            
                            <div class="form- check mb-3">
                                <label for="isActive" class="form-chech-label">is active</label>
                                <input type="checkbox" class="form-check-input" name="isActive" id="isActive" <?php if( $selectedcategory["isActive"] ) {echo "checked";}?>>
                            </div>


                            <input type="submit" value ="submit" class="btn btn-primary">


                        </form>
                    </div>
                
                </div>
                
            </div>
        </div>
    </div>
    <?php include "views/_footer.php";?>
