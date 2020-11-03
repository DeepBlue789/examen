<?php

//Création de la classe
class Database
{
    //Variables de connexion
    private static $dbHost = "localhost";
    private static $dbName = "testing2";
    private static $dbUsername = "root";
    private static $dbUserpassword = "";
    //variable pour accéder à la fonction connect()
    private static $connection = null;
    
    //La fonction va retourner la connexion
    public static function connect()
    {
        if(self::$connection == null)
        {
            // Essai de connexion
            try
            {
            self::$connection = new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName , self::$dbUsername, self::$dbUserpassword);
            }
            //Si la connexion ne marche pas, afficher un message d'erreur
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
        return self::$connection;
    }
    
    //La fonction va annuler la connexion
    public static function disconnect()
    {
        self::$connection = null;
    }

}
?>
