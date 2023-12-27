<?php
    require "libs/vars.php";
    require "libs/functions.php";
    $id=$_GET["id"];
    if(deleteBlog($id)){
        $_SESSION['message']=$id." id numaralı blog silindi.";
        $_SESSION['type']="danger";

        header('location: admin-blogs.php');
    }else {
        echo "hata";
    }
    

?>
   