<?php
//Permet de gérer le panier
class panier{

    private $DB;

    public function __construct($DB){
        //Vérification de l'éxistence de $_SESSION
        if(!isset($_SESSION)){
            session_start();
        }
        //Crétion d'un panier vide
        if(!isset($_SESSION['panier'])){
            $_SESSION['panier'] = array();
        }
        $this->DB = $DB;
        //Suppression d'un élément du panier
        if(isset($_GET['delPanier'])){
            $this->del($_GET['delPanier']);
        }
        //Calcul du nombre de produits dand le panier
        if(isset($_POST['panier']['quantity'])){
            $this->recalc();
        }
    }

    public function recalc(){
        foreach($_SESSION['panier'] as $product_id => $quantity){
            if(isset($_POST['panier']['quantity'][$product_id])){
                $_SESSION['panier'][$product_id] = $_POST['panier']['quantity'][$product_id];
            }
        }
    }
    public function count(){
        return array_sum($_SESSION['panier']);
    }
    public function total(){
            $total = 0;
            $ids = array_keys($_SESSION['panier']);
    if(empty($ids)){
        $product = array();
    }else{ 
        $product = $this->DB->query('SELECT * FROM products WHERE product_id IN ('.implode(',',$ids).')');
    }
    foreach($product as $product_book){
        $total += $product_book->product_price * $_SESSION['panier'][$product_book->product_id];
    }
    return $total;
        }
    public function add($product_id){
        if(isset($_SESSION['panier'][$product_id])){
                $_SESSION['panier'][$product_id]++;
        }else{
            $_SESSION['panier'][$product_id] = 1;
        }
    }
    public function del($product_id){
        unset($_SESSION['panier'][$product_id]);
    }

}