<?php require_once("header.php"); ?> 
<?php
if(isset($_SESSION["type"])){
   
}else{
   ?>
   <script>
      alert('Vous devez être connecté');
   document.location.replace("login.php");
   </script>
   <?php
}
?>
<div class="container">
      <h2 style="margin-top:50px">Nouvel article</h2>
         <form action="insertionArticle.php" method="POST" enctype="multipart/form-data"> 
               <p>Nom de l'oeuvre: <input type="text" name="titre" /></p> 
               <p>Nom de l'auteur: <input type="text" name="auteur" /></p> 
               <p>Commentaire: <br /><textarea id="textarea-article" name="commentaire" rows="10" cols="50"></textarea></p> 
               <input type="hidden" name="MAX_FILE_SIZE" value="2097152"> 
               <p>Choisissez une photo avec une taille inférieure à 2 Mo.</p> 
               <input type="file" name="photo" id="article-submit"> 
               <br /><br /> 
               <input type="submit" name="ok" value="Envoyer"> 
         </form> 
</div>
<?php require_once("footer.php"); ?> 


