<?php require_once("header.php"); ?>
<?php require_once('database.php');?>



<div class="container" >
        <div class="row">
        <h3 style="text-decoration: underline">Liste des articles </h3>
        </div>
</div>

<div class="container" >
<div class="row" >

<?php
$db = Database::connect();
$db->exec("SET NAMES 'utf8'");
$reponse = $db->prepare("SELECT * FROM article a, user_details u WHERE a.user_id = u.user_id");
$reponse->execute(array());
Database::disconnect();

while ($donnees = $reponse->fetch())
{ 
?>

<div class=" box col-sm-6 col-md-4" style="padding-left: 0px">
                
        <div class="card" style=" border: 1px solid black;height: 445px">
                <img class="card-img-top" src="photos/<?php echo $donnees['Image'];?>" alt="image livre"/>
        <div class="card-body" >
                <?php echo $donnees['Titre']; ?></span></a></h5>
                <p class="card-text"><?php if(strlen($donnees['Avis']) >50){  echo substr($donnees['Avis'],0,142)."...";} ?></p>
        <div class="text-white bg-secondary " >
                <?php echo $donnees['user_name']; ?>
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
