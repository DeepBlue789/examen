<?php require_once("header.php"); ?>
<?php require_once("database.php"); 
 require_once("function.php");?>

<?php
if(!empty($_GET['user_id'])) 
{
        $user_id = checkInput($_GET['user_id']);
}
$user_id = intval($user_id);
if(isset($user_id) AND $user_id > 0 AND $user_id != $_SESSION['user_id'] || !isset($user_id) OR empty($user_id) || !is_int($user_id))  {
        ?>
        <script>
                alert('Cette page est inaccessible');
        document.location.replace("login.php");
        </script>
        <?php
}
?>

<div class="container admin">
        <div class="row">
        <h1 style="margin: 150px auto 80px auto"><strong>Liste de vos articles</strong></h1>
        </div>  
        <div class="row">
<?php
$db = Database::connect();
$db->exec("SET NAMES 'utf8'");
$reponse = $db->prepare("SELECT * FROM article a, user_details u WHERE a.user_id = u.user_id AND a.user_id = ?");
$reponse->execute(array($user_id));
Database::disconnect();
// On affiche chaque entrée une à une
if($reponse->rowCount($reponse) > 0) 
					{

while ($donnees = $reponse->fetch())
{ 
?>
        <div class="col-md-4" style="margin-top: 50px">     
                <div class="card card-article-liste" >
                                <img class="card-img-top mx-auto" src="images/Couvertures/<?php echo $donnees['Image'];?>" alt="Card image cap">
                                        <div class="card-body" style="height:120px">
                                                <h5 class="card-title" style="height:35px"><a href= "article-detail.php?idArticle=<?php echo  $donnees['idArticle'];?>"> <span><?php echo $donnees['Titre']; ?> </span></a></h5>  
                                                <p class="card-text"><?php if(strlen($donnees['Avis']) >50){  echo substr($donnees['Avis'],0,112)."...";} ?></p>
                                                        <div class="text-white bg-secondary wrapper-avatar">
                                                                <img  src="images/avatar/<?php echo $donnees['user_image']; ?>" alt="<?php echo $donnees['user_name']; ?>"> Proposée par <?php echo $donnees['user_name']; ?>
                                                        </div>            
                                        </div>
                </div>
        </div>

<?php
}
}else{?> <h5 style="margin-top: 80px;margin-bottom: 368px"><?php echo 'Vous n\'avez pas encore publiez d\'article...';} ?></h5> <?php
?>
<br>
</div> 

</div>
</div>


<?php require_once("footer.php"); ?>