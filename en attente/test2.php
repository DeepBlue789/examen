<?php

    require 'database.php';

    if(!empty($_GET['product_id'])) 
    {
        $id = checkInput($_GET['product_id']);
    }

   $imageError  = $image = "";

    if(!empty($_POST)) 
    {
        $name               = checkInput($_POST['product_auteur']);
        $description        = checkInput($_POST['product_titre']);
        $price              = checkInput($_POST['product_price']);
        $category           = checkInput($_POST['product_resume']); 
        $image              = checkInput($_FILES["product_image"]["name"]);
        $imagePath          = 'images/'. basename($image);
        $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
        $isSuccess          = true;
       
        if(empty($name)) 
        {
            $nameError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($description)) 
        {
            $descriptionError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        } 
        if(empty($price)) 
        {
            $priceError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        } 
         
        if(empty($category)) 
        {
            $categoryError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($image)) // le input file est vide, ce qui signifie que l'image n'a pas ete update
        {
            $isImageUpdated = false;
        }
        else
        {
            $isImageUpdated = true;
            $isUploadSuccess =true;
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
                $statement = $db->prepare("UPDATE product  set product_auteur = ?, product_titre = ?, product_price = ?, product_resume = ?, product_image = ? WHERE product_id  = ?");
                $statement->execute(array($name,$description,$price,$category,$image,$id));
            }
            else
            {
                $statement = $db->prepare("UPDATE product  set product_auteur = ?, product_titre = ?, product_price = ?, product_resume = ? WHERE product_id  = ?");
                $statement->execute(array($name,$description,$price,$category,$id));
            }
            Database::disconnect();
            header("Location: index.php");
        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
            $db = Database::connect();
            $db->exec('SET NAMES utf8');
            $statement = $db->prepare("SELECT * FROM product where product_id = ?");
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
        $statement = $db->prepare("SELECT * FROM product where product_id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $name           = $item['product_auteur'];
        $description    = $item['product_titre'];
        $price          = $item['product_price'];
        $category       = $item['product_resume'];
        $image          = $item['product_image'];
        Database::disconnect();
      
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Burger Code</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    
    <body>
         <div class="container admin">
            <div class="row">
                <div class="col-sm-6">
                    <h1><strong>Modifier un item</strong></h1>
                    <br>
                    <form class="form" action="<?php echo 'test2.php?product_id='.$id;?>" role="form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="product_auteur">Nom:
                            <input type="text" class="form-control" id="product_auteur" name="product_auteur" placeholder="Nom" value="<?php echo $name;?>">
                            <span class="help-inline"><?php echo $nameError;?></span>
                        </div>
                        <div class="form-group">
                            <label for="product_titre">Description:
                            <input type="text" class="form-control" id="product_titre" name="product_titre" placeholder="Description" value="<?php echo $description;?>">
                            <span class="help-inline"><?php echo $descriptionError;?></span>
                        </div>
                        <div class="form-group">
                        <label for="product_price">Prix: (en €)
                            <input type="number" step="0.01" class="form-control" id="product_price" name="product_price" placeholder="Prix" value="<?php echo $price;?>">
                            <span class="help-inline"><?php echo $priceError;?></span>
                        </div>


                        <div class="form-group">
                        <label for="product_resume">Resume: 
                            <input type="text" class="form-control" id="product_resume" name="product_resume" placeholder="resume" value="<?php echo $category;?>">
                            <span class="help-inline"><?php echo $categoryError;?></span>
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
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                            <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                       </div>
                    </form>
                </div>
                <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="<?php echo 'images/'.$image;?>" alt="...">
                        <div class="price"><?php echo number_format((float)$price, 2, '.', ''). ' €';?></div>
                          <div class="caption">
                            <h4><?php echo $name;?></h4>
                            <p><?php echo $description;?></p>
                          </div>
                    </div>
                </div>
            </div>
        </div>   
    </body>
</html>