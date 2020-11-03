<?php require_once("header.php"); ?>
<?php require_once("database.php");
require_once("function.php") ?>

<div class="container" style="margin-top:150px">
        <div class="row" >

<?php
if(!empty($_GET['product_id'])) 
{
        $id = checkInput($_GET['product_id']);
}

$db = Database::connect();
$db->exec("SET NAMES 'utf8'");
$statement = $db->prepare("SELECT * FROM products WHERE product_id = ? ");
$statement->execute(array($id));
Database::disconnect();

// On affiche chaque entrée une à une
if(isset($_GET['product_id']) AND !empty ( $_GET [ 'product_id' ])){ 

while ($donnees = $statement->fetch()) 
{ 

?>                                          
<div class="col-md-6">
        <img class="card-img-top rounded mx-auto d-block image-article-detail" 
        src="images/Couvertures/<?php echo $donnees['product_image'];?>" alt="Illustration livre"/>
</div>

<div class="col-md-6">
        <h1><strong>Informations</strong></h1>
        <br>
        <h5><span style="text-decoration: underline"><?php echo $donnees['product_titre']; ?></span></h5>
        <p><?php  echo $donnees['product_auteur']; ?></p><br>
        <p><?php  echo number_format((float)$donnees['product_price'], 2, '.', ''). ' ' . '€' ; ?></p><br>
        <p><?php  echo $donnees['product_resume']; ?></p><br>
        <a class="btn btn-primary" href="liste_products.php"> Accéder à la liste des livres</a>
</div>

<?php
}

}
?>

        </div>
</div> 

<?php require_once("footer.php"); ?>