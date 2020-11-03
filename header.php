<?php require_once("session.php");
require_once("_header.php");?>

<!DOCTYPE html>
<html lang="fr">
    <head>
    <title>Livres&Co</title>
    <link rel="icon" type="image/png" href="images1.ico" sizes="32x32" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css" type="text/css">
    </head>
<body>


<!-- Menu -->
<header class="navbar-fixed-top cbp-af-header my-header">
            <nav class="navbar navbar-expand-lg navbar-light bg-light main-nav">
            <a class="navbar-brand col-md-2" href="index.php" style="padding:0px"><span class="logo">Livres & Co</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-alt"></i>  S'identifier
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="registration.php">S'enregistrer</a>
          <a class="dropdown-item" href="login.php">Se connecter</a>
          <?php
          if(isset($_SESSION['user_id'])){ ?>
        <a class="dropdown-item" href="index1.php?user_id=<?php echo $_SESSION['user_id']; ?>"> Espace membre</a>
        <?php
          }else{
            ?>
            <a class="dropdown-item" href="index1.php">Espace membre</a>
            <?php
          }
          ?>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-book"></i>  Articles
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="article.php">Ajouter un article</a>
        <a class="dropdown-item" href="liste-articles.php">Liste des articles</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-shopping-cart"></i>  Achats
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="liste_products.php">liste des produits</a>
          <a class="dropdown-item" href="panier.php">Panier</a>
          <div style="margin-left: 5px" class="dropdown-divider"></div>
          <?php if(!empty($_SESSION['panier'])){?>
          <div class="container" style="margin-left: 5px">
          Produits
              <span id="count"><?php echo $panier->count(); ?></span><br>
          total
              <span style="padding: 10px" id="total"><?php echo number_format($panier->total(),2,',',' '); ?></span>
        </div>
        <?php
        } ?>
        </div>
      </li>
    </ul>
    <?php
    if(isset($_SESSION['user_id'])){?>
    <form class="form-inline my-2 my-lg-0" action = "search-bar.php" method = "get">
      <input class="form-control mr-sm-2" type="search" name = "search_request" placeholder="Recherche...">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Recherche</button>
    </form>
    <?php }else{?>
<form class="form-inline my-2 my-lg-0" action = "login.php" method = "get">
<input class="form-control mr-sm-2" type="search" name = "search_request" placeholder="Recherche...">
<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Recherche</button>
</form>
<?php
    }?>
  </div>
</nav>
</header>
