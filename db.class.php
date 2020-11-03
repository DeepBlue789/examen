<?php
class DB{

    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'testing2';
    private $db;

    //Permet de déterminer les paramètres que prendra cette fonction
    //J'aurai une classe qui aura une configuration par défaut mais qui pourra aussi me servir si j'ai envie de me connecter à plusieurs bases de données
    public function __construct($host = null, $username = null, $password = null, $database = null){
        if($host != null){
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
            $this->database = $database;
        }

        try{ 
        $this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 
        'SET NAMES UTF8', PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        }catch(PDOException $e){
            die('Impossible de se connecter à la base de données');
        }
    }

    //Méthode permettant de faire des requêtes préparées
        public function query($sql, $data = array()){
            $req =$this->db->prepare($sql);
            $req->execute($data);
            return $req->fetchAll(PDO::FETCH_OBJ);
        }
}