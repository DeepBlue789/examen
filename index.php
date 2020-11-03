<?php require_once("header.php"); 
require_once("database.php"); 
?>

<!------------------------------------------------------------- PARALLAX IMAGE ------------------------------------------------->

<div class="parallax"></div>

<!------------------------------------------------------------- LOGO ------------------------------------------------->

<div class="container-fluid">
    <div class="row" id="row-logo1">
        <div class="col-md-12" id ="wrapper-logo1">
            <span class="logo1">Livres & Co</span>
        </div>
    </div>
</div> 

<!------------------------------------------------------------- SELLING CONDITIONS ------------------------------------------------->

<div class="container">
    <div class="row">
        <div class="col-md-4 selling-conditions" style="text-align: center">
            <i class="fas fa-truck fa-2x"></i>
            <p>Livraison gratuite</p>
            <p>Partout dans le monde et peu importe le montant de votre panier</p>
        </div>
        <div class="col-md-4 selling-conditions" style="text-align: center">
            <i class="fas fa-headset fa-2x"></i>
            <p> SAV en anglais et en français</p>
            <p>Ouvert du lundi au vendredi</p>
        </div>
        <div class="col-md-4 selling-conditions" style="text-align: center">
            <i class="fas fa-reply fa-2x"></i>
            <p>Satisfait ou remboursé</p>
            <p>Remboursement intégral dans les 30 jours après réception</p>
        </div>
    </div>
</div>

<!------------------------------------------------------------- TITLE ------------------------------------------------->

<div class="container">
    <div class="row">
        <h3 class="title">Événements à venir </h3>
    </div>
</div>

<!------------------------------------------------------------- CAROUSEL ------------------------------------------------->

<div class="container">
    <div class="row">
        <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="images/evenement/riga.jpg" alt="First slide"><br>
                    <h4 class="title-event"><span style="text-decoration: underline">Salon du livre</span> : Riga du 5 au 8 juin 2019</h4>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="images/evenement/bucarest.jpg" alt="Third slide"><br>
                    <h4 class="title-event"><span style="text-decoration: underline">Salon du livre</span> : Bucarest du 18 au 26 août 2019</h4>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="images/evenement/varsovie.jpg" alt="Third slide"><br>
                    <h5 class="title-event"><span style="text-decoration: underline">Salon du livre</span> : Varsovie du 20 au 22 août 2019</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!------------------------------------------------------------- TITLE ------------------------------------------------->

<div class="container">
    <div class="row">
        <h3 class="title">Les derniers offres </h3>
</div>
</div>


<!------------------------------------------------------------- CARDS PRODUCTS ------------------------------------------------->

<div class="container">
    <div class="row" >

<?php
$db = Database::connect();
$db->exec("SET NAMES 'utf8'");
// Requête d'affichage
$statement = $db->prepare("SELECT * FROM products ORDER BY product_id DESC LIMIT 3 ");
$statement->execute(array());
Database::disconnect();
// On affiche chaque entrée une à une dans la limite de 3
while ($donnees = $statement->fetch())
{ 
?>

        <div class="col-md-4"> 
        <div class="row">    
            <div class="card card-product" >
            
                <img class="card-img-top mx-auto" src="images/Couvertures/<?php echo $donnees['product_image'];?>" alt="Card image cap">
                
                    <div class="card-body" style="height:120px">
                        <h5 class="card-title" style="height:40px"><a href= "product-detail.php?product_id=<?php echo  $donnees['product_id'];?>"> <span><?php echo $donnees['product_titre']; ?> </span></a></h5>  
                        <p class="card-text"><?php if(strlen($donnees['product_resume']) >10){  echo substr($donnees['product_resume'],0,116)."...";} ?></p>
                            <div class="text-white bg-secondary wrapper-price" >
                                Prix : <?php echo $donnees['product_price']; ?> €
                            </div>            
                    </div>
                    </div>  
            </div>
        </div>

<?php
}
?>

    </div>
</div>


<!------------------------------------------------------------- TITLE ------------------------------------------------->
<div class="container" style="margin-bottom: 80px">
    <div class="row">
        <h3 class="title">Dernier article publié </h3>
    </div>
</div>
<!------------------------------------------------------------- CARDS ARTICLE ------------------------------------------------->
<div class="container">
    <div class="row" >

<?php
$db = Database::connect();
$db->exec("SET NAMES 'utf8'");
// Requête d'affichage
$statement = $db->prepare("SELECT * FROM article a, user_details u WHERE a.user_id = u.user_id ORDER BY a.date DESC LIMIT 1 ");
$statement->execute(array());
Database::disconnect();
// On affiche chaque entrée une à une dans la limite de 1
while ($donnees = $statement->fetch())
{ 
?>
                
        <div class="card card-article">
            <div class="row no-gutters">
                <div class="col-md-4">
                    
                    <img class="card-image mx-auto image-article" src="images/Couvertures/<?php echo $donnees['Image'];?>" alt="Image article">
                    
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><a href= "article-detail.php?idArticle=<?php echo  $donnees['idArticle'];?>"> <span><?php echo $donnees['Titre']; ?> </span></a></h5>  
                        <p class="card-text" style="height: 160px" ><?php if(strlen($donnees['Avis']) >10){  echo substr($donnees['Avis'],0,210)."...";} ?></p>       
                            <div class="card-footer">
                                <img  src="images/avatar/<?php echo $donnees['user_image']; ?>" style="width: 10%; border-radius:100%" alt="<?php echo $donnees['user_name']; ?>"> Proposée par <?php echo $donnees['user_name']; ?>
                            </div>          
                    </div>
                </div>
            </div>
        </div>

<?php
}
?>

    </div>
</div>

<!------------------------------------------------------------- FOOTER ------------------------------------------------->
<?php require_once("footer.php"); 

