<?php require_once("header.php"); ?>
<?php require_once("database.php");
require_once("function.php") ?>
<?php
if(!empty($_GET['search_request'])) 
{
      $search_request = checkInput($_GET['search_request']);
}
?>
<?php

$db = Database::connect();
$db->exec("SET NAMES 'utf8'");
$articles = $db->prepare('SELECT product_titre, product_price, product_id FROM products WHERE product_titre');
$articles->execute(array());

if(isset($_GET['search_request']) AND !empty($_GET['search_request'])) {
   $articles = $db->prepare('SELECT product_titre, product_price, product_id  FROM products WHERE product_titre LIKE "%'.$search_request.'%"');
   $articles->execute(array());
   Database::disconnect();
}
?>
<div class="container" style="margin-top: 150px" >
<?php 
if($articles->rowCount($articles) > 0) { ?>
   <ul>
   <?php while($a = $articles->fetch()) { 
      ?> <h5> <?php echo  '<li>'.$a['product_titre'] . '</li>'?> </h5>
      <h5 style="margin-bottom: 470px"><?php  echo "<li><a href='product-detail.php?product_id=" . $a['product_id'] . "'> Lien vers le produit</a></li>" ; ?></h5>
   <?php } ?>
   </ul>
<?php } else { ?>
   <h5 style="margin-bottom: 470px"> Aucun résultat pour: <?= $search_request ?>...</h5>
<?php } 
?>
</div>

<?php require_once("footer.php"); ?>