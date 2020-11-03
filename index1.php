<?php require_once("header.php"); ?>
<?php require_once("database.php");
require_once("function.php")
?>
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


if(!isset($_SESSION["user_id"]) OR !isset($_SESSION["type"]))
        {
                header("location:login.php");           
        }  

$db = Database::connect();
$db->exec("SET NAMES 'utf8'");
$user_id = htmlentities($_GET['user_id'], ENT_QUOTES);
if(isset($user_id) AND $user_id > 0 AND $user_id = $_SESSION['user_id']) {
        $getid = intval($user_id);
        $connexion = $db->prepare('SELECT * FROM user_details WHERE user_id = ?');
        $connexion -> execute(array($getid));
        Database::disconnect();
        $profil = $connexion->fetch();
}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<div class="container">
<h2 style="text-align:center;margin-top: 150px; margin-bottom:50px">Espace membre</h2>
<div class="row">
        <div style="margin-bottom:40px">
                <a href="logout.php">Logout</a>
        </div>
        </div>
<?php
        if($_SESSION["type"] == "user" && $_SESSION["user_id"] == $user_id ){ 
                echo '<div style="margin-bottom: 40px"><h2>Bonjour ' . $profil['user_name'] .'</h2></div>';?>
                <h5 style="margin-bottom: 40px"><a href="changer-avatar.php?user_id=<?php echo $_SESSION['user_id']; ?>">Changer d'avatar</a></h5>
                <h5 style="margin-bottom: 40px"><a href="liste-article-membre.php?user_id=<?php echo $_SESSION['user_id']; ?>">Liste de vos articles</a></h5>
                <a  class="btn btn-primary" href="index.php"> Retour</a>
                <?php
        }
        else
        {
                if($_SESSION["type"] !== "master" OR $_SESSION["user_id"] !== $user_id )
                {
                        ?> <h5 style="margin-top:50px; margin-bottom: 50px"> <?php echo 'Cette page est inaccessible'; ?></h5>
                        <a style="margin-top:50px; margin-bottom: 150px" class="btn btn-primary" href="index.php"> Retour</a> <?php
                }else{ 
?>
        <div class="panel panel-default">
                <div class="panel-heading">User Status Details</div>
                <div class="panel-body">
                <span id="message"></span>
                <div class="table-responsive" id="user_data">
                </div>
                <h5 style="margin-bottom: 50px;margin-top:50px"><a href="gestion.php">Gestion des produits</a></h5>
                <h5 style="margin-bottom: 50px;margin-top:50px"><a href="changer-avatar.php?user_id=<?php echo $_SESSION['user_id']; ?>">Changer d'avatar</a></h5>
                <h5 style="margin-bottom: 200px"><a href="liste-article-membre.php?user_id=<?php echo $_SESSION['user_id']; ?>">Liste de vos articles</a></h5>
<script>
        $(document).ready(function(){     
        load_user_data();

        function load_user_data()
        {
        let action = 'fetch';
        $.ajax({
        url:'action.php',
        method:'POST',
        data:{action:action},
        success:function(data)
        {
                $('#user_data').html(data);
        }
        });
        }
        
        $(document).on('click', '.action', function(){
        let user_id = $(this).data('user_id');
        let user_status = $(this).data('user_status');
        let action = 'change_status';
        $('#message').html('');
        if(confirm("Are you Sure you want to change status of this User?"))
        {
        $.ajax({
                url:'action.php',
                method:'POST',
                data:{user_id:user_id, user_status:user_status, action:action},
                success:function(data)
                {
                if(data != '')
                {
                load_user_data();
                $('#message').html(data);
                }
                }
        });
        }
        else
        {
        return false;
        }
        });
        
        });
</script>
        </div>
        </div>
<?php
        }   
}
?>
</div>
<?php require_once("footer1.php"); ?>