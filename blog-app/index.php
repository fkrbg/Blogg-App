<?php
    
    require "libs/vars.php";

    require "libs/functions.php";




?>
    <?php include "views/_header.php";?>
    <?php include "views/_navbar.php";?>

    <div class ="container" >
        <div class = " row" >
            <div class ="col-3" >
                <?php include "views/_menu.php";?>
            </div>
            <div class ="col-9">
                <?php 
                    $result = getHomePageBlogs();
                ?>
                <?php if(mysqli_num_rows($result)>0):?>

                    <?php while($film = mysqli_fetch_assoc($result)):?>

                        <div class="card mb-3">
                        <div class="row">
                            <div class="col-3"> 
                                
                            </div>
                        </div>
                        </div>
                        <div class="card mb-3" style="background-color: rgba(255,255,255,0)">
                            <div class="row">
                                <div class="col-3"> 
                                    <img class="img-fluid" src ="img/<?php echo $film["imageUrl"]?>">
                                </div>
                                <div class="col-9"> 
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <a class="two" style="text-decoration: none; color: ;"href="blog-details.php?id=<?php echo $film["id"]?>"><?php echo $film["title"]?> 
                                            </a>
                                        </h4>
                                        <p class="card-text">
                                            <?php echo kısaOzet($film,$limit,$film["short_description"]);?>
                                        </p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                                

                    <?php endwhile; ?>
                <?php else:?>
                    <div class="div alert alert-warning">
                        Kategoriye ait blog bulunamadı.
                    </div>
                <?php endif;?>

                
            </div>
        </div>
    </div>
    <?php include "views/_footer.php";?>

   