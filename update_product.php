<?php require_once("header.php"); ?>
<?php require_once('database.php');
require_once('function.php');?>
<?php
if(!empty($_GET['product_id'])) 
{
        $id = checkInput($_GET['product_id']);
}

$auteurError = $titreError = $priceError = $resumeError = $imageError = $auteur = $titre = $price = $resume = $image = "";

if(!empty($_POST)) 
{
        $auteur               = checkInput($_POST['product_auteur']);
        $titre                = checkInput($_POST['product_titre']);
        $price                = checkInput($_POST['product_price']);
        $resume               = checkInput($_POST['product_resume']); 
        $image                = checkInput($_FILES["product_image"]["name"]);
        $imagePath            = 'photos/'. basename($image);
        $imageExtension       = pathinfo($imagePath,PATHINFO_EXTENSION);
        $isSuccess            = true;    

if(empty($auteur)) 
{
        $auteurError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
}
if(empty($titre)) 
{
        $titreError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
} 
if(empty($price)) 
{
        $priceError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
}          
if(empty($resume)) 
{
        $resumeError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
}
if(empty($image)) // le input file est vide, ce qui signifie que l'image n'a pas ete update
{
        $isImageUpdated = false;
}
        else
        {
                $isImageUpdated = true;
                $isUploadSuccess = true;
                if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) 
                {
                        $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
                        $isUploadSuccess = false;
                }
                if(file_exists($imagePath)) 
                {
                        $imageError = "Le fichier existe deja";
                        $isUploadSuccess = false;
                }
                if($_FILES["product_image"]["size"] > 500000) 
                {
                        $imageError = "Le fichier ne doit pas depasser les 500KB";
                        $isUploadSuccess = false;
                }
                if($isUploadSuccess) 
                {
                        if(!move_uploaded_file($_FILES["product_image"]["tmp_name"], $imagePath)) 
                        {
                                $imageError = "Il y a eu une erreur lors de l'upload";
                                $isUploadSuccess = false;
                        } 
                } 
        } 
        
if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) 
{ 
        $db = Database::connect();
        $db->exec('SET NAMES utf8');
                if($isImageUpdated)
                {
                        $statement = $db->prepare("UPDATE products  set product_auteur = ?, product_titre = ?, product_price = ?, product_resume = ?, product_image = ? WHERE product_id  = ?");
                        $statement->execute(array($auteur,$titre,$price,$resume,$image,$id));
                }
                else
                {
                        $statement = $db->prepare("UPDATE products  set product_auteur = ?, product_titre = ?, product_price = ?, product_resume = ? WHERE product_id  = ?");
                        $statement->execute(array($auteur,$titre,$price,$resume,$id));
                }
                Database::disconnect();
                header("Location: index.php");
                }
                else if($isImageUpdated && !$isUploadSuccess)
                {
                        //En cas d'erreur dans l'upload de l'image, les données sont réinitialisées
                        $db = Database::connect();
                        $db->exec('SET NAMES utf8');
                        $statement = $db->prepare("SELECT * FROM products WHERE product_id = ?");
                        $statement->execute(array($id));
                        $item = $statement->fetch();
                        $image          = $item['product_image'];
                        Database::disconnect();           
                }
}
else 
{
        $db = Database::connect();
        $db->exec('SET NAMES utf8');
        $statement = $db->prepare("SELECT * FROM products WHERE product_id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $auteur           = $item['product_auteur'];
        $titre            = $item['product_titre'];
        $price            = $item['product_price'];
        $resume           = $item['product_resume'];
        $image            = $item['product_image'];
        Database::disconnect();
}

?>

<div class="container" style="margin-top:100px">
        <div class="row">
                <div class="col-md-6">
                        <h1><strong>Modifier un item</strong></h1>
                        <br>
                <form class="form" action="<?php echo 'update_product.php?product_id='.$id;?>" role="form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                                <label for="product_auteur">Nom:
                                <input type="text" class="form-control" id="product_auteur" name="product_auteur"  value="<?php echo $auteur;?>">
                                <span class="help-inline"><?php echo $auteurError;?></span>
                        </div>
                        <div class="form-group">
                                <label for="product_titre">Titre:
                                <input type="text" class="form-control" id="product_titre" name="product_titre"  value="<?php echo $titre;?>">
                                <span class="help-inline"><?php echo $titreError;?></span>
                        </div>
                        <div class="form-group">
                        <label for="product_price">Prix: (en €)
                                <input type="number" step="0.01" class="form-control" id="product_price" name="product_price"  value="<?php echo number_format((float)$price, 2, '.', '');?>">
                                <span class="help-inline"><?php echo $priceError;?></span>
                        </div>
                        <div class="form-group">
                        <label for="product_resume">Resume: 
                                <input type="text" class="form-control" id="product_resume" name="product_resume"  value="<?php echo $resume;?>">
                                <span class="help-inline"><?php echo $resumeError;?></span>
                        </div>
                        <div class="form-group">
                                <label for="product_image">Image:</label>
                                <p><?php echo $image;?></p>
                                <label for="product_image">Sélectionner une nouvelle image:</label>
                                <input type="file" id="product_image" name="product_image"> 
                                <span class="help-inline"><?php echo $imageError;?></span>
                        </div>
                        <br>
                        <div class="form-actions">
                                <button type="submit" class="btn btn-success"> Modifier</button>
                                <a class="btn btn-primary" href="index.php"> Retour</a>
                        </div>
                </form>
                </div>
                        <div class="col-md-6 site">
                                <div class="thumbnail">
                                <img src="<?php echo 'images/Couvertures/'.$image;?>" alt="...">
                                        <div class="price"><?php echo number_format((float)$price, 2, '.', ''). ' €';?>
                                        </div>
                                        <div class="caption">
                                                <h4><?php echo $auteur;?></h4>
                                                <p><?php echo $titre;?></p>
                                        </div>
                                </div>
                        </div>
        </div>
</div>   

<?php require_once("footer.php"); ?>