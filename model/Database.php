<?php

/**
 * Auteur : Jeremiah Steiner
 * Date: 13.11.2020
 * contient les méthode permettant d'accèder a la database
 * TODO : plugin : PHP DocBlocker
 */

include 'data/config.php';

class Database {

    // Variable de classe
    private $connector;
    
    /**
     * Connexion à la DB par PDO
     */
    public function __construct(){
        $dbName = $GLOBALS['MM_CONFIG']['database']['dbName'];
        $user = $GLOBALS['MM_CONFIG']['database']['username'];
        $password = $GLOBALS['MM_CONFIG']['database']['password'];
        $charset = $GLOBALS['MM_CONFIG']['database']['charset'];
        $host = $GLOBALS['MM_CONFIG']['database']['host'];
        $port = $GLOBALS['MM_CONFIG']['database']['port'];

        $this->connector = new PDO("mysql:host=$host;port=$port;dbname=$dbName;charset=$charset" , $user, $password);
    }

    /**
     * Execute une requête simple
     *
     * @param [type] $query
     * @return void
     */
    private function querySimpleExecute($query){

        $req = $this->connector->query($query);

        return $req;
    }

    /**
     * Execute une requête
     *
     * @param [type] $query
     * @param [type] $binds
     * @return PDOStatement
     */
    private function queryPrepareExecute($query, $binds){
        
        $req = $this->connector->prepare($query);
        $req->execute();

        return $req;
    }

    /**
     * Transforme en tableau associatif les données
     *
     * @param [type] $req
     * @return void
     */
    private function formatData($req){

        return $req->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * vider la requete
     *
     * @param [type] $req
     * @return void
     */
    private function unsetData($req){
        
        $req->closeCursor();
    }

    // Termine la liaison avec la BD
    // TODO à checker si les deux lignes sont nécessaires
    private function closeConnection($req){

        $this->connector = null;
        unset($this->connector);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function CountRecipes()
    {
        $req = $this->queryPrepareExecute('SELECT Count(idRecipe) FROM t_recipe', null);// appeler la méthode pour executer la requète
        $recipes = $this->formatData($req);
        return $recipes[0]['Count(idRecipe)'];
    }

    /**
     * récupère tous les recettes de la database
     *
     * @return void
     */
    public function getAllRecipes($start = 0, $length = 5){
        
        $req = $this->queryPrepareExecute('SELECT * FROM t_recipe LIMIT '.  $start . ', ' . $length , null);// appeler la méthode pour executer la requète

        $recipes = $this->formatData($req);// appeler la méthode pour avoir le résultat sous forme de tableau

        $this->unsetData($req);

        return $recipes;// retour tous les recettes
    }

    /**
     * permet d'obtenir une recette spécifique
     *
     * @param [type] $id
     * @return void
     */
    public function getOneRecipe($id){

        $req = $this->queryPrepareExecute('SELECT * FROM t_recipe WHERE idRecipe = ' . $id, null); // appeler la méthode pour executer la requète

        $recipes = $this->formatData($req);// appeler la méthode pour avoir le résultat sous forme de tableau

        $this->unsetData($req);

        return $recipes[0];// retour la première valeur du tableau (il ne contient qu'une recette)
    }

    /**
     * retourn la recette la plus récente
     *
     * @return array
     */
    public function getLastRecipe()
    {
        //example : SELECT ChampDate FROM table ORDER BY ChampDate DESC LIMIT 1
        $querry = 'SELECT * FROM t_recipe ORDER BY idRecipe DESC LIMIT 1';

        $req = $this->queryPrepareExecute($querry, null);

        $recipes = $this->formatData($req);

        $this->unsetData($req);

        return $recipes[0];
    }

    /**
     * Retourne la recette avec la meilleure note
     *
     * @return array
     */
    public function getBestRecipe()
    {
        $querry = 'SELECT * FROM t_recipe ORDER BY recNote DESC LIMIT 1';

        $req = $this->queryPrepareExecute($querry, null);

        $recipes = $this->formatData($req);

        $this->unsetData($req);

        return $recipes[0];
    }

    public function getEasiestRecipe()
    {
        $querry = 'SELECT * FROM t_recipe ORDER BY recDifficulty LIMIT 1';

        $req = $this->queryPrepareExecute($querry, null);

        $recipes = $this->formatData($req);

        $this->unsetData($req);

        return $recipes[0];
    }

    /**
     * ajoute une recette a la base de donnée
     *
     * @param [type] $recipe
     * @return void
     */
    public function insertRecipe($recipe){

        // TODO : remplir
    }

    /**
     * Récupère tous les noms d'utilisateur
     * @return $usernames
     */
    public function getAllUsernames(){

        $query = "SELECT usePseudo FROM t_user";
        $req = $this->queryPrepareExecute($query, null);
        $usernames = $this->formatData($req);
        $this->unsetData($req);
        return $usernames;
    }

    /**
     * Récupère les données d'un utilisateur
     * @param $username
     * @return $user
     */
    public function getOneUser($username){

        $query = "SELECT * FROM t_user WHERE usePseudo = '$username'";
        $req = $this->queryPrepareExecute($query, null);
        $userArray = $this->formatData($req);
        $user = $userArray[0];
        $this->unsetData($req);
        return $user;
    }

    /**
     * Récupère les données d'un utilisateur
     * @param $username
     * @return $user
     */
    public function getOneUserById($userId){

        $query = "SELECT * FROM t_user WHERE idUser = '$userId'";
        $req = $this->queryPrepareExecute($query, null);
        $userArray = $this->formatData($req);
        $user = $userArray[0];
        $this->unsetData($req);
        return $user;
    }
 }


?>