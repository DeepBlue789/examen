<?php require_once("header.php"); 
require_once("database.php");
require_once("function.php");?>
<?php

if(!empty($_GET['product_id'])) 
{
    $id = checkInput($_GET['product_id']);
}

$db = Database::connect();
$db->exec('SET NAMES utf8');
$statement = $db->prepare("SELECT * FROM products WHERE product_id = ?");
$statement->execute(array($id));
$item = $statement->fetch();
Database::disconnect();
    
?>


<div class="container" style="margin-top: 150px">
    <div class="row">
    <!-- Colonne de gauche -->
        <div class="col-md-6">
        <h1><strong>Informations</strong></h1>
        <br>
            <form>
                <div class="form-group">
                    <label>Nom:</label><?php echo '  '.$item['product_titre'];?>
                </div>
                <div class="form-group">
                    <label>Description:</label><?php echo '  '.$item['product_resume'];?>
                </div>
                <div class="form-group">
                    <label>Prix:</label><?php echo '  '.number_format((float)$item['product_price'], 2, '.', ''). ' €';?>
                </div>
                <div class="form-group">
                    <label>Catégorie:</label><?php echo '  '.$item['product_auteur'];?>
                </div>
                <div class="form-group">
                    <label>Image:</label><?php echo '  '.$item['product_image'];?>
                </div>
          </form>
          <br>
                <div class="form-actions">
                    <a class="btn btn-primary" href="gestion.php"> Retour</a>
                </div>
        </div> 
        <!-- Colonne de droite -->
        <div class="col-md-6">
            <div class="thumbnail">
                <img src="<?php echo 'images/Couvertures/'.$item['product_image'];?>" alt="...">
                  <div class="caption">
                    <h4><?php echo $item['product_titre'];?></h4>
                    <!-- fonction pour avoir deux chiffres après la virgule -->
                    <div class="price"><?php echo number_format((float)$item['product_price'], 2, '.', ''). ' €';?></div>
                  </div>
            </div>
        </div>
    </div>
</div>   
<?php require_once("footer.php"); ?>

