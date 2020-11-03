<?php require_once("header.php"); ?>
<?php require_once("database.php"); ?>
<?php
if(!isset($_SESSION["type"])){
        ?>
        <script>
        alert('Vous devez être connecté');
        document.location.replace("login.php");
        </script>
        <?php
}
?>




<div class="container" >
        <div class="row">
                <h3 style="text-decoration: underline; margin-top:150px;margin-bottom: 50px">Liste des Articles </h3>
        </div>
</div>

<div class="container" >
        <div class="row" >

<?php
$db = Database::connect();
$db->exec("SET NAMES 'utf8'");
$statement = $db->prepare("SELECT * FROM article a, user_details u WHERE a.user_id = u.user_id ");
$statement->execute(array());
Database::disconnect();

// On affiche chaque entrée une à une
while ($donnees = $statement->fetch())
{ 
?>

<div class=" box col-sm-6 col-md-4" style="padding-left: 0px">        
        <div class="card card-article-liste" style=" border: 1px solid black;height: 545px">
                <img class="card-img-top mx-auto" src="images/Couvertures/<?php echo $donnees['Image'];?>" alt="Card image cap">
        <div class="card-body">
                <h5 class="card-title"><a href= "article-detail.php?idArticle=<?php echo $donnees['idArticle'];?>"> <?php if(strlen($donnees['Titre']) >10){  echo substr($donnees['Titre'],0,21)."...";} ?></a></h5>
                <p class="card-text wrapper-article"><?php if(strlen($donnees['Avis']) >50){  echo substr($donnees['Avis'],0,112)."...";} ?></p>
        <div class="text-white bg-secondary wrapper_user" >
                <img src="images/avatar/<?php echo $donnees['user_image']; ?>" alt="<?php echo $donnees['user_name']; ?>"> <span>Proposée par</span> <?php echo $donnees['user_name']; ?>
        </div>            
        </div>
        </div>
<br>
</div>               

<?php
}
?>

        </div>
</div> 

<?php require_once("footer.php"); ?>