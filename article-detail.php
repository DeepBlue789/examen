<?php require_once("header.php"); ?>
<?php require_once("database.php");
require_once("function.php"); ?>

<div class="container" style="margin-top:150px">
        <div class="row" >

<?php
if(!empty($_GET['idArticle'])) 
{
        $idArticle = checkInput($_GET['idArticle']);
        $idArticle = intval($idArticle);
}
if(!is_int($idArticle) || !isset($idArticle) OR empty($idArticle))  {

        ?>
        <script>
                alert('Cette page est inaccessible');
        document.location.replace("index.php");
        </script>
        <?php
}

$db = Database::connect();
$db->exec("SET NAMES 'utf8'");
$statement = $db->prepare("SELECT * FROM article a, user_details u WHERE a.user_id = u.user_id AND idArticle = ? ");
$statement->execute(array($idArticle));
Database::disconnect();
// On affiche chaque entrée une à une



if(isset($_GET['idArticle']) AND !empty ( $_GET [ 'idArticle' ])){ 

while ($donnees = $statement->fetch()) 
{ 

?>
<div class="col-md-6">
        <img class="card-img-top rounded mx-auto d-block image-article-detail" src="images/Couvertures/<?php echo $donnees['Image'];?>" alt="Illustration recette"/>
</div>

<div class="col-md-6">
        <h1 style=" margin-top:20px"><strong>Informations</strong></h1>
        <br>
        <h5><span style="text-decoration: underline"><?php echo $donnees['Titre']; ?></span></h5>
        <p><?php  echo $donnees['auteur']; ?></p><br>
        <p><?php  echo $donnees['Avis']; ?></p><br>
        <div style="margin-bottom: 50px">
        <img src="images/avatar/<?php echo $donnees['user_image']; ?>" style="width: 10%" alt="<?php echo $donnees['user_name']; ?>"> Proposée par <?php echo $donnees['user_name']; ?>
        </div>
        <a class="btn btn-primary" href="liste-articles.php"> Accéder à la liste de tous les articles</a>
</div>

<?php
}

}
?>

        </div>
</div> 

<?php require_once("footer.php"); ?>