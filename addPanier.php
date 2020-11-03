<?php
session_start();
require '_header.php';
$json = array('error' => true);
if(isset($_GET['product_id'])){
$product_book = $DB->query('SELECT product_id FROM products WHERE product_id=:product_id', array('product_id' =>$_GET['product_id']));
if(empty($product_book)){
    $json['message'] ="Ce produit n\'existe pas";
}
$panier->add($product_book[0]->product_id);
$json['error'] = false;
$json['total'] = number_format($panier->total(),2,',',' ');
$json['count'] = $panier->count();
$json['message'] = 'Le produit a bien été ajouté à votre panier';
}else{
    $json['message'] ="Vous n\avez pas sélectionné de produits à ajouter au panier";
}
echo json_encode($json);
?>