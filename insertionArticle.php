<?php require_once("header.php"); ?>
<?php require_once('database.php');?>
<?php require_once('function.php');?>
<div class="container-fluid" style="margin-top: 150px">
      <div class="row">

<?php
$titre = checkInput($_POST['titre']);
$auteur = checkInput($_POST['auteur']);
$commentaire = checkInput($_POST['commentaire']);
$image = checkInput($_FILES['photo']['name']);
$id = checkInput($_SESSION['user_id']);



if ($_FILES['photo']['error']) {  
      switch ($_FILES['photo']['error']){  
            case 1: // UPLOAD_ERR_INI_SIZE  
                  echo "La taille du fichier est plus grande que la limite autorisée par le serveur (paramètre upload_max_filesize du fichier php.ini).";  
                  break;  
            case 2: // UPLOAD_ERR_FORM_SIZE  
                  echo "La taille du fichier est plus grande que la limite autorisée par le formulaire (paramètre post_max_size du fichier php.ini)."; 
                  break;  
            case 3: // UPLOAD_ERR_PARTIAL  
                  echo "L'envoi du fichier a été interrompu pendant le transfert."; 
                  break;  
            case 4: // UPLOAD_ERR_NO_FILE  
                  echo "La taille du fichier que vous avez envoyé est nulle."; 
                  break;  
      }  
}  
else {  
//s'il n'y a pas d'erreur alors $_FILES['nom_du_fichier']['error'] 
//vaut 0  
echo "Aucune erreur dans le transfert du fichier.<br />"; 
      if ((isset($_FILES['photo']['name'])&&($_FILES['photo']['error'] == UPLOAD_ERR_OK))) { 
            $chemin_destination = 'photos/Couvertures/'; 
            //déplacement du fichier du répertoire temporaire (stocké 
            //par défaut) dans le répertoire de destination 
            move_uploaded_file($_FILES['photo']['tmp_name'], $chemin_destination.$_FILES['photo']['name']); 
            echo "Le fichier ".$_FILES['photo']['name']." a été copié dans le répertoire photos"; 
      } 
      else { 
            echo "Le fichier n'a pas pu être copié dans le répertoire photos."; 
      } 
} 
$db = Database::connect();
$db->exec('SET NAMES utf8');
$requete= $db->prepare("INSERT INTO article (Titre, auteur, date, Avis, Image, user_id) VALUES (?, ?,'".date("Y-m-d H:i:s")."', ? , ? , ?)"); 
$requete->execute(array($titre,$auteur,$commentaire, $image, $id)); 
Database::disconnect(); 
if ($requete->rowCount($requete) > 0) { 
      echo "<br />Ajout du commentaire réussi.<br /><br />"; 
} 
else { 
      echo "<br />Le commentaire n'a pas pu être ajouté.<br /><br />"; 
}
?> 
</div>
      <div class="row">
<a style="margin-bottom: 350px" href="article.php" >retour à la page d'ajout d'articles</a> 
</div>
</div>

<?php require_once("footer.php"); ?>