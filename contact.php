<?php require_once("header.php"); ?>
<?php


//index.php


use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

$error = '';
$name = '';
$email = '';
$subject = '';
$message = '';

function clean_text($string)
{
 $string = trim($string);
 $string = stripslashes($string);
 $string = htmlspecialchars($string);
 return $string;
}

if(isset($_POST["submit"]))
{
 if(empty($_POST["name"]))
 {
  $error .= '<p><label class="text-danger">Veuillez rentrer votre nom</label></p>';
 }
 else
 {
  $name = clean_text($_POST["name"]);
  if(!preg_match("/^[a-zA-Z ]*$/",$name))
  {
   $error .= '<p><label class="text-danger">Seul les lettres et les espaces sont autorisés</label></p>';
  }
 }
 if(empty($_POST["email"]))
 {
  $error .= '<p><label class="text-danger">Veuillez rentrer votre mail</label></p>';
 }
 else
 {
  $email = clean_text($_POST["email"]);
  if(!filter_var($email, FILTER_VALIDATE_EMAIL))
  {
   $error .= '<p><label class="text-danger">Le format du mail est invalide</label></p>';
  }
 }
 if(empty($_POST["subject"]))
 {
  $error .= '<p><label class="text-danger">Le sujet est obligatoire</label></p>';
 }
 else
 {
  $subject = clean_text($_POST["subject"]);
 }
 if(empty($_POST["message"]))
 {
  $error .= '<p><label class="text-danger">Le message est obligatoire</label></p>';
 }
 else
 {
  $message = clean_text($_POST["message"]);
 }
 if($error == '')
 {
    $mail = new PHPMailer(true);
  $mail->IsSMTP();        //Sets Mailer to send message using SMTP
  $mail->Host = 'smtp.gmail.com';  //Sets the SMTP hosts
  $mail->Port = '587';        //Sets the default SMTP server port
  $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
  $mail->Username = 'lotier77@gmail.com' ;//     Sets SMTP username
  $mail->Password = 'tierlo77';// Sets SMTP password
  $mail->SMTPSecure = 'tls';       //Sets connection prefix. Options are "", "ssl" or "tls"
  $mail->From = $_POST["email"];     //Sets the From email address for the message
  $mail->FromName = $_POST["name"];    //Sets the From name of the message
  $mail->AddAddress('lotier77@gmail.com', 'lotier');//Adds a "To" address
  $mail->AddCC($_POST["email"], $_POST["name"]); //Adds a "Cc" address
  $mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
  $mail->IsHTML(true);       //Sets message type to HTML    
  $mail->Subject = $_POST["subject"];    //Sets the Subject of the message
  $mail->Body = $_POST["message"];    //An HTML or plain text message body
  if($mail->Send())        //Send an Email. Return true on success or false on error
  {
   $error = '<label class="text-success">Merci pour votre mail</label>';
  }
  else
  {
   $error = '<label class="text-danger">Il y a une erreur</label>';
  }
  $name = '';
  $email = '';
  $subject = '';
  $message = '';
 }
}

?>
<?php require_once("header.php"); ?>
  <br />
  <div class="container" id="contact-container-page" style="margin-top: 150px; margin-bottom:80px">
   <div class="row">
    <div class="col-md-8" style="margin:0 auto; float:none;">
     <h3 style="text-align: center">Formulaire de contact</h3>
     <br />
     <?php echo $error; ?>
     <form method="POST">
      <div class="form-group">
       <label>Votre nom</label>
       <input type="text" name="name" placeholder="Votre nom..." class="form-control" value="<?php echo $name; ?>" />
      </div>
      <div class="form-group">
       <label>Votre mail</label>
       <input type="text" name="email" class="form-control" placeholder="Votre mail..." value="<?php echo $email; ?>" />
      </div>
      <div class="form-group">
       <label>Votre objet</label>
       <input type="text" name="subject" class="form-control" placeholder="Votre objet..." value="<?php echo $subject; ?>" />
      </div>
      <div class="form-group">
       <label>Votre message</label>
       <textarea name="message" class="form-control" placeholder="Votre message..."><?php echo $message; ?></textarea>
      </div>
      <div class="form-group">
      <input type="text" name="captcha"/>
       <input type="submit" name="submit"  value="Submit" class="btn btn-info" />
       <img src="captcha.php" onclick="this.src='captcha.php?' + Math.random();" alt="captcha" style="cursor:pointer;">
      </div>
     </form>
    </div>
   </div>
  </div>
  <?php require_once("footer.php"); ?>