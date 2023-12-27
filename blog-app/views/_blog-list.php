<?php  

    $categoryId = "";
    $keyword = "";
    $page = 1;

    if(isset($_GET["categoryid"]) && is_numeric($_GET["categoryid"])) $categoryId = $_GET["categoryid"];
    if(isset($_GET["q"])) $keyword = $_GET["q"];
    if(isset($_GET["page"]) && is_numeric($_GET["page"])) $page = $_GET["page"];

    $result = getBlogsByFilters($categoryId, $keyword, $page);
    
?>

<?php if (mysqli_num_rows($result["data"]) > 0): ?>

    <?php while($film = mysqli_fetch_assoc($result["data"])): ?>

        <?php if($film["isActive"]): ?>

            <div class="card mb-3"style="background-color: rgba(255,255,255,0)">
                <div class="row" >
                    
                    <div class="col-3" >
                        <img class="img-fluid" src="img/<?php echo $film["imageUrl"]?>"></img>
                    </div>
                    <div class="col-9" >
                        <div class="card-body" >                        
                            <h4 class="card-title" >
                                <a class="two" style="text-decoration: none;" href="blog-details.php?id=<?php echo $film["id"]?>"><?php echo $film["title"]?></a>
                            </h4>
                            <p style="" class="card-text"><?php echo kısaOzet($film,$limit,$film["short_description"]);?></p>
                        </div>
                    
                    </div>
                </div>
            </div>
        <?php endif; ?>

    <?php endwhile; ?>

<?php else: ?>

    <div class="alert alert-warning">
        Kategoriye ait olan blog bulunamadı.
    </div>

<?php endif; ?>

<?php if ($result["total_pages"]>1) :?>

<nav aria-label="Page navigation example">
  <ul class="pagination">
    <?php for($x=1; $x <= $result["total_pages"]; $x++):?>
    <li class="page-item <?php if($x== $page) echo "active"?>"><a class="page-link" href="
    
        <?php
            $url = "?page=".$x;
            if(!empty($categoryId)){
                $url .= "&categoryid=".$categoryId;
            }

            if(!empty ($keyword)){
                $url .= "&q=".$keyword;
            }
            echo $url;
        
        ?>
    
    "><?php echo $x; ?></a></li>
    <?php endfor; ?>
  </ul>
</nav>
<?php endif;?>