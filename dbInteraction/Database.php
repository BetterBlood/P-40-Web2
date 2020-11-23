<?php

/**
 * Auteur : Jeremiah Steiner
 * Date: 13.11.2020
 * contient les méthode permettant d'accèder a la database
 */

include 'config.php';

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
     * simple requette
     *
     * @param [type] $query
     * @return void
     */
    private function querySimpleExecute($query){

        $req = $this->connector->query($query); // requette

        return $req;
    }

    /**
     * Undocumented function
     *
     * @param [type] $query
     * @param [type] $binds
     * @return PDOStatement
     */
    private function queryPrepareExecute($query, $binds){
        
        // TODO: permet de pr�parer, de binder et d�ex�cuter une requ�te (select avec where ou insert, update et delete)
        $req = $this->connector->prepare($query); // requette
        $req->execute();

        return $req;
    }

    /**
     * Undocumented function
     *
     * @param [type] $req
     * @return void
     */
    private function formatData($req){

        return $req->fetchALL(PDO::FETCH_ASSOC); // transformation en tableau associatif
    }

    /**
     * détrui le connector
     */
    private function unsetData($req){

        $this->connector = null;
        $req->closeCursor();
        unset($this->connector);
    }

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
     * ajoute une recette a la base de donnée
     *
     * @param [type] $recipe
     * @return void
     */
    public function insertRecipe($recipe){

        // TODO : remplir
    }


    // + tous les autres m�thodes dont vous aurez besoin pour la suite ( ... etc)
 }


?>