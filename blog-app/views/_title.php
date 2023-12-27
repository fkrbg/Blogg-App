<?php
    $ozet=count(getData()["categories"])." kategoride ".count(getData()["movies"])." film listelenmiştir";

?>

<h1 class ="mb-4"></h1>
<h1 class ="mb-4"><?php echo baslik?></h1>
<p class ="lead">
    <?php
        echo $ozet
    ?>
</p>