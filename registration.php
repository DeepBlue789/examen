<?php require_once("header.php"); 
require_once("database.php"); 
require_once("function.php"); 

if(isset($_SESSION["type"]))
        {
                header("location:index.php");   
        }

?>

<div class="container" style="margin-top: 150px; margin-bottom: 120px">
	<div class="row mx-auto" style="justify-content: center">
		<div class="col-md-6 col-md-offset-3" style="text-align:center">
		<span class="logo1">Livres & Co</span><br><br>

<?php

$msg = "";
	if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])
	&& !empty($_POST['cPassword']) ){ 
			if (isset($_POST['submit'])) {

							$name = checkInput($_POST['name']);
							$email = checkInput($_POST['email']);
							$password = checkInput($_POST['password']);
							$cPassword = checkInput($_POST['cPassword']);

	$db = Database::connect();
	$db->exec("SET NAMES 'utf8'");		
	$query = $db->prepare("SELECT user_id FROM user_details WHERE user_name = ? "); 
	$query->execute(array($name));
	Database::disconnect();
					//Vérification de la disponibilité du pseudo
					if($query->rowCount($query) == 1) 
					{
					echo 'Ce pseudo est déjà utilisé'; 
					}else{ 
					//Interdiction des  caractères spéciaux
					if(preg_match("^[a-zA-Z]{1,20}[0-9]{0,3}$^", $name))
					{	
					//Vérification du mot de passe et de sa confirmation			
					if ($password != $cPassword)
							$msg = "Le mot de passe est invalide";
					else{
							$hash = password_hash($password, PASSWORD_BCRYPT);
							$db = Database::connect();
							$db->exec("SET NAMES 'utf8'");	
							$statement = $db->prepare("INSERT INTO user_details 
							(user_name,user_email,user_password, user_type, user_status, user_image) 
							VALUES (? , ? , ? , 'user', 'Active', 'photo-profil.jpg')");
							$statement->execute(array($name, $email,$hash));
							Database::disconnect();
							$msg = "Félicitation vous êtes enregistré !";
						}				
					}else{ echo 'Attention, vous avez utilisé des caractères interdits';}
				}
					}else{
				echo 'Merci de bien vouloir remplir les champs indiqués';
			}
		}
?>
<!--Affichage du message -->
<?php if ($msg != "") echo $msg . "<br><br>"; ?>

						<form method="post" action="#" style="margin-top: 20px">
								<input class="form-control" minlength="3" name="name" placeholder="Nom..."><br>
								<input class="form-control" name="email" type="email" placeholder="Email..."><br>
								<input class="form-control" minlength="5" name="password" type="password" placeholder="Mot de passe..."><br>
								<input class="form-control" minlength="5" name="cPassword" type="password" placeholder="Confirme mot de passe..."><br>
								<input class="btn btn-primary" name="submit" type="submit" value="Enregistrement..."><br>
						</form>

				</div>
		</div>
</div>
	<?php require_once("footer.php"); 