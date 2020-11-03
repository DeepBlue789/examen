<?php require_once("header.php"); ?>
<?php require_once('database.php');
require_once('function.php');?>
<?php
//Je récupère l'id avec le get ensuite il le stocke dans le formulaire
if(!empty($_GET['product_id'])) 
{
        $id = checkInput($_GET['product_id']);
}

if(!empty($_POST)) 
{
        $id = checkInput($_POST['product_id']);
        $db = Database::connect();
        $statement = $db->prepare("DELETE FROM products WHERE product_id = ?");
        $statement->execute(array($id));
        Database::disconnect();
        header("Location: index.php"); 
}

?>
<div class="container" style="margin-top: 80px">
        <div class="row">
                <h1 style="margin-top: 80px"><strong>Supprimer un livre</strong></h1></div>
                <div class="row">
                        <form class="form" action="delete.php" role="form" method="post">
                                <!-- Les élements input de type hidden permettent aux développeurs web d'inclure des données qui ne peuvent pas être vues ou modifiées lorsque le formulaire est envoyé. Cela permet par exemple d'envoyer l'identifiant d'une commande ou un jeton de sécurité unique. Les champs de ce type sont invisibles sur la page  -->
                                <input type="hidden" name="product_id" value="<?php echo $id;?>"/>
                                <p class="alert alert-danger" style="margin-top: 50px;margin-bottom: 50px">Etes vous sur de vouloir supprimer ?</p>
                                        <div class="form-actions" style="margin-bottom: 150px">
                                                <button type="submit" class="btn btn-warning">Oui</button>
                                                <a class="btn btn-default" href="index.php">Non</a>
                                        </div>
                        </form>
        </div>
</div>   

<?php require_once("footer.php"); ?>
