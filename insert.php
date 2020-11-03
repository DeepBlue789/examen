<?php require_once("header.php"); ?>
<?php require_once('database.php');
require_once('function.php');?>
<?php

/*Création de toutes les variables qui vont donner les messages d'erreur et toutes les variables qui vont donner les valeurs
Elles sont initinialiser à rien du tout car il s'agit du premier passage*/
$auteurError = $titreError = $priceError = $resumeError = $imageError = $auteur = $titre = $price = $resume = $image = "";

if(!empty($_POST)) 
{
        $auteur             = checkInput($_POST['product_auteur']);
        $titre              = checkInput($_POST['product_titre']);
        $price              = checkInput($_POST['product_price']);
        $resume             = checkInput($_POST['product_resume']); 
        $image              = checkInput($_FILES["product_image"]["name"]);
        $imagePath          = 'photos/Couvertures/'. basename($image);
        $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);//Cette constante donne l'extension de l'image
        $isSuccess          = true;
        $isUploadSuccess    = false;

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
if(empty($image)) 
{
        $imageError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
}
else
{
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
        
        if($isSuccess && $isUploadSuccess) 
        {
                $db = Database::connect();
                $db->exec("SET NAMES 'utf8'");
                $statement = $db->prepare("INSERT INTO products (product_auteur,product_titre,product_price,product_resume,product_image) values(?, ?, ?, ?, ?)");
                $statement->execute(array($auteur,$titre,$price,$resume,$image));
                Database::disconnect();
                header("Location: index.php");
        }
}

?>

<div class="container">
        <div class="row">
        <h1 style="margin-top: 150px;margin-bottom:50px;text-align:center"><strong>Ajouter un item</strong></h1>
        </div>
        <div class="row">
                <form class="form" action="insert.php" role="form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                                <label for="product_auteur">Auteur:</label>
                                <input type="text" class="form-control input-insert" id="product_auteur" name="product_auteur" placeholder="Nom de l'auteur...">
                                <span class="help-inline"><?php echo $auteurError;?></span>
                        </div>
                        <div class="form-group">
                                <label for="product_titre">Titre:</label>
                                <input type="text" class="form-control" id="product_titre" name="product_titre" placeholder="Titre du livre...">
                                <span class="help-inline"><?php echo $titreError;?></span>
                        </div>
                        <div class="form-group">
                                <label for="product_price">Prix: (en €)</label>
                                <input type="number" step="0.01" class="form-control" id="product_price" name="product_price" placeholder="Prix du livre..." >
                                <span class="help-inline"><?php echo $priceError;?></span>
                        </div>
                        <div class="form-group">
                                <label for="product_resume">Description:</label>
                                <input type="text" class="form-control" id="product_resume" name="product_resume" placeholder="Résume du livre..." >
                                <span class="help-inline"><?php echo $resumeError;?></span>
                        </div>
                        <div class="form-group">
                                <label for="product_image">Sélectionner une image:</label>
                                <input type="file" id="product_image" name="product_image"> 
                                <span class="help-inline"><?php echo $imageError;?></span>
                        </div>
                        <br>
                        <div class="form-actions">
                                <button type="submit" class="btn btn-success"> Ajouter</button>
                                <a class="btn btn-primary" href="index.php"> Retour</a>
                        </div>
                </form>
        </div>
</div>  
        

<?php require_once("footer.php"); ?>