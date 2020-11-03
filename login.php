<?php require_once("header.php"); ?>
<?php require_once('database.php');?>
<?php require_once('database.php');?>
<?php
if(isset($_SESSION["type"]))
        {
                header("location:index.php");   
        }
if (isset($_POST['submit'])) {

        $mail = checkInput($_POST["user_email"]);
        $password = checkInput($_POST["user_password"]);
}

$message = '';
if(isset($_POST["login"])){
        if(empty($_POST["user_email"]) || empty($_POST["user_password"])){
        $message = "<div class='alert alert-danger'>Les deux champs doivent être remplis</div>";
        }
        else{
                $db = Database::connect();
        $db->exec('SET NAMES utf8');
        $query = "SELECT * FROM user_details WHERE user_email = :user_email";
        $statement = $db->prepare($query);
        $statement->execute(array('user_email' => $_POST["user_email"]));
        $mail =  $_POST["user_email"];
        Database::disconnect();
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $count = $statement->rowCount();
                if($count > 0){
                $result = $statement->fetchAll();
                        foreach($result as $row){
                                if($row["user_status"] == 'Active'){
                                        if(password_verify($_POST["user_password"], $row["user_password"])){
                                        $_SESSION["type"] = $row["user_type"];
                                        $_SESSION["user_id"] = $row["user_id"];
                                        header("location: index1.php?user_id=".$row['user_id']);
                                        }else{
                                        $message = '<div class="alert alert-danger">Mot de passe invalide</div>';
                                        }
                                        }else{
                                        $message = '<div class="alert alert-danger">Votre compte a été désactivé. Merci de contacter l\administrateur</div>';
                                        }
                                }
                        }else{
                        $message = "<div class='alert alert-danger'>Email invalide</div>";
                }
        }else{echo 'Attention, présence de caractères invalides';}
        }
}
?>
<div class="container">
        <h2 style="text-align:center;margin-top: 150px; margin-bottom:50px">Epace d'authentification</h2>
                <div class="panel panel-default">
                        <form method="post">
                                <span class="text-danger"><?php echo $message; ?></span>
                                <div class="form-group">
                                <label>Email de l'utilisateur</label>
                                <input type="text" name="user_email" id="user_email" class="form-control" />
                        </div>
                        <div class="form-group">
                                <label>Mot de passe</label>
                                <input type="password" name="user_password" id="user_password" class="form-control" />
                        </div>
                        <div class="form-group">
                                <input style="margin-bottom: 120px" type="submit" name="login" id="login" class="btn btn-info" value="Envoyer" />
                        </div>
                        </form>
                        </div>
                </div>
</div>

<?php require_once("footer.php"); 