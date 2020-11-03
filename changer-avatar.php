<?php require_once("header.php"); ?>
<?php require_once("database.php");
require_once("function.php"); ?>
<?php


if(!empty($_GET['user_id'])) 
{
        $user_id = checkInput($_GET['user_id']);
}
if(isset($user_id) AND $user_id > 0 AND $user_id != $_SESSION['user_id'] || !isset($user_id) OR empty($user_id))  {
        ?>
        <script>
                alert('Cette page est inaccessible');
        document.location.replace("login.php");
        </script>
        <?php
}

$imageError = $image = "";

if(!empty($_FILES)) 
{
$image              = checkInput($_FILES["user_image"]["name"]);
$imagePath          = 'photos/avatar/'. basename($image);
$imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
$isSuccess          = true;
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
        if($_FILES["user_image"]["size"] > 500000) 
        {
                $imageError = "Le fichier ne doit pas depasser les 500KB";
                $isUploadSuccess = false;
        }
        if($isUploadSuccess) 
        {
                if(!move_uploaded_file($_FILES["user_image"]["tmp_name"], $imagePath)) 
                {
                        $imageError = "Il y a eu une erreur lors de l'upload";
                        $isUploadSuccess = false;
                } 
        } 
}
if (($isSuccess && $isImageUpdated && $isUploadSuccess)) 
{ 
        $db = Database::connect();
        $db->exec('SET NAMES utf8');
        if($isImageUpdated)
        {
                $statement = $db->prepare("UPDATE user_details  set user_image = ? WHERE user_id  = ?");
                $statement->execute(array($image,$user_id));
        }
        Database::disconnect();
        header("Location: index.php");
}
else if($isImageUpdated && !$isUploadSuccess)
{
        $db = Database::connect();
        $db->exec('SET NAMES utf8');
        $statement = $db->prepare("SELECT * FROM user_details where user_id = ?");
        $statement->execute(array($user_id));
        $item = $statement->fetch();
        $image          = $item['user_image'];
        Database::disconnect();        
        }
}
        else 
        {
                $db = Database::connect();
                $db->exec('SET NAMES utf8');
                $statement = $db->prepare("SELECT * FROM user_details where user_id = ?");
                $statement->execute(array($user_id));
                $item = $statement->fetch();
                $image          = $item['user_image'];
                Database::disconnect();        
        }
?>



<div class="container">
        <div class="row">
                <div class="col-sm-6">
                        <h1 style="margin-top:150px;margin-bottom: 110px"><strong>Modifier avatar</strong></h1>
                        <br>
                                <form class="form" action="<?php echo 'changer-avatar.php?user_id='.$user_id;?>" role="form" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                                <label for="user_image">Image:</label>
                                                <p><?php echo $image;?></p>
                                                <label for="user_image">Sélectionner une nouvelle image:</label>
                                                <input type="file" id="user_image" name="user_image"> 
                                                <span class="help-inline"><?php echo $imageError;?></span>
                                        </div>
                                        <br>
                                        <div class="form-actions">
                                                <button type="submit" class="btn btn-success"> Modifier</button>
                                                <a class="btn btn-primary" href="index.php"> Retour</a>
                                        </div>
                                </form>
                </div>
                        <div class="col-sm-6 site">
                                <div class="thumbnail">
                                        <img style="margin-top:150px;margin-bottom: 170px" src="<?php echo 'images/avatar/'.$image;?>" alt="...">
                                </div>
                        </div>
        </div>
</div>   


<?php require_once("footer.php"); ?>
