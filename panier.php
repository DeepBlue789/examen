<?php require_once("header.php");?>
<?php require_once("_header.php");

if(!isset($_SESSION["type"])){
    ?>
    <script>
    alert('Vous devez être connecté');
    document.location.replace("login.php");
    </script>
    <?php
}
?>

<form method="post" action="panier.php">       
    <div class="container" style="margin-top:150px">
        <div class="row">
        <?php
//permet de récupérer les clefs du tableau         
$ids = array_keys($_SESSION['panier']);
//Si le tableau des ids est vide, le tableau envoyé est vide
if(empty($ids)){
    $product = array();
    ?> <h5 style="margin-bottom:100px;margin-top: 100px"> <?php echo 'Votre panier est vide...'; ?></h5><?php
}else{ 
    $product = $DB->query('SELECT * FROM products WHERE product_id IN ('.implode(',',$ids).')');
}
foreach($product as $product_book):
?>

<div class="card mb-3" style="max-width: 540px;margin-right:5px">
    <div class="row no-gutters">
        <div class="col-md-4">
            <img src="images/Couvertures/<?php echo $product_book->product_image; ?>" class="card-img" alt="...">
        </div>
    <div class="col-md-8">
        <div class="card-body">
            <h5 class="card-title" style="height:70px"><?php echo $product_book->product_titre; ?></h5>
            <h5><?php echo $product_book->product_auteur; ?></h5>
            <!-- Valeur récupérer lors de l'envoi du formulaire -->
            <p><input type="text" name="panier[quantity][<?php echo $product_book->product_id; ?>]"  value="<?php echo $_SESSION['panier'][$product_book->product_id] ?>"> Quantity :</p>
            <p class="card-text"><?php if(strlen($product_book->product_resume) >50){  echo substr($product_book->product_resume,0,112)."...";}?>.</p>
            <p class="card-text"><small class="text-muted">Price : <?php echo number_format($product_book->product_price,2,',','') ?>€</small></p>
            <p><a href="panier.php?delPanier=<?php echo $product_book->product_id; ?>"><i class="fas fa-trash-alt"></i> Supprimer le produit</a>
        </div>
    </div>
    </div>
<input type="submit" value="Recalculer">
</form>
</div>
<?php endforeach; ?>
</div>

    <div class="row">
    <a style="margin: 50px auto" class="btn btn-primary" href="liste_products.php"> Accéder à la liste des livres</a>
    </div>
</div>




<?php require_once("footer.php");?>