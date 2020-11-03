<?php require_once("header.php");
require_once("_header.php");

if(!isset($_SESSION["type"])){
        ?>
        <script>
        alert('Vous devez être connecté');
        document.location.replace("login.php");
        </script>
        <?php
}
?>


<div class="container" style="margin-top:150px">
        <div class="row">
        
        <?php $product = $DB->query('SELECT * FROM products ORDER BY product_id');?>
<?php foreach ( $product as $product_book):?>

        <div class="card mb-3" style="max-width: 540px;margin-right:5px">
                <div class="row no-gutters">
                        <div class="col-md-4">
                                <img src="images/Couvertures/<?php echo $product_book->product_image; ?>" class="card-img" alt="Image de couverture">
                        </div>
                        <div class="col-md-8">
                                <div class="card-body">
                                <h5 class="card-title"><a href= "product-detail.php?product_id=<?php echo 
                                $product_book->product_id;?>"><?php echo $product_book->product_titre; ?></a><br>
                                <?php echo $product_book->product_auteur; ?></h5>
                                <p class="card-text"> 
                                <?php if(strlen($product_book->product_resume) >50){  echo substr($product_book->product_resume,0,112)."...";}?>.</p>
                                <p class="card-text"><small class="text-muted">Price :
                                        <?php echo number_format($product_book->product_price,2,',','') ?>€</small></p>
                                <p><a class="addPanier" href="addPanier.php?product_id=<?php echo $product_book->product_id; ?>">Ajouter au panier</a>
                                </div>
                        </div>
                </div>
        </div>

<?php endforeach ?>

        </div>
</div>


<?php require_once("footer.php"); 