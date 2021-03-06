<?php

/**
 * Auteur : Pierre Morand,  Jeremiah Steiner
 * Date: 13.11.2020
 * contient les méthode permettant d'accèder a la database
 */

include './data/config.php';

class Database {

    // Variable de classe
    private $connector;
    
    /**
     * Connexion à la DB par PDO
     */
    public function __construct()
    {
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
    private function querySimpleExecute($query)
    {
        $req = $this->connector->query($query);

        return $req;
    }

    /**
     * Execute une requête
     *
     * @param string $query
     * @param string $binds
     * @return PDOStatement
     */
    private function queryPrepareExecute($query, $binds)
    {
        $req = $this->connector->prepare($query);

        if(isset($binds))
        {
            foreach($binds as $bind)
            {
                $req->bindValue($bind['marker'], $bind['input'], $bind['type']);
            }
        }

        $req->execute();

        return $req;
    }

    /**
     * Transforme en tableau associatif les données
     *
     * @param PDOStatement $req
     * @return PDOStatement
     */
    private function formatData($req)
    {
        return $req->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * vider la requete
     *
     * @param PDOStatement $req
     * @return void
     */
    private function unsetData($req)
    {
        $req->closeCursor();
    }

    /**
     * ferme la connexion
     *
     * @param PDOStatement $req
     * @return void
     */
    private function closeConnection($req)
    {
        $this->connector = null; // NOTE : à checker si les deux lignes sont nécessaires => ba merci pour le module 151.... 
    }








    /**
     * compte les recettes
     *
     * @return int
     */
    public function CountRecipes()
    {
        $req = $this->queryPrepareExecute('SELECT Count(idRecipe) FROM t_recipe', null);// appeler la méthode pour executer la requète
        $recipes = $this->formatData($req);
        return $recipes[0]['Count(idRecipe)'];
    }

    /**
     * vérifie si la recette existe
     *
     * @param int $idRecipe
     * @return bool
     */
    public function RecipeExist($idRecipe)
    {
        $req = $this->queryPrepareExecute('SELECT * FROM t_recipe', null);// appeler la méthode pour executer la requète

        $recipes = $this->formatData($req);// appeler la méthode pour avoir le résultat sous forme de tableau

        foreach($recipes as $recipe)
        {
            if ($recipe["idRecipe"] == $idRecipe)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * récupère tous les recettes de la database
     *
     * @param int $start
     * @param int $length
     * @return array
     */
    public function getAllRecipes($start = 0, $length = 5)
    { 
        $req = $this->queryPrepareExecute('SELECT * FROM t_recipe LIMIT '.  $start . ', ' . $length , null);// appeler la méthode pour executer la requète

        $recipes = $this->formatData($req);// appeler la méthode pour avoir le résultat sous forme de tableau

        $this->unsetData($req);

        return $recipes;// retour tous les recettes
    }

    /**
     * permet d'obtenir une recette spécifique
     *
     * @param int $id
     * @return array
     */
    public function getOneRecipe($id)
    {
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
        $querry = 'SELECT * FROM t_recipe ORDER BY recGrade DESC LIMIT 1';

        $req = $this->queryPrepareExecute($querry, null);

        $recipes = $this->formatData($req);

        $this->unsetData($req);

        return $recipes[0];
    }

    /**
     * obtient la recette la plus facile
     *
     * @return array
     */
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
     * @param array $recipe
     * @return void
     */
    public function insertRecipe($recipe)
    {
        $values = array(
            1 => array(
                'marker' => ':recName',
                'input' => $recipe["recName"],
                'type' => PDO::PARAM_STR
            ),
            2 => array(
                'marker' => ':recIngredientList',
                'input' => $recipe["recIngredientList"],
                'type' => PDO::PARAM_STR
            ),
            3 => array(
                'marker' => ':recDescription',
                'input' => $recipe["recDescription"],
                'type' => PDO::PARAM_STR
            ),
            4 => array(
                'marker' => ':recPreparation',
                'input' => $recipe["recPreparation"],
                'type' => PDO::PARAM_STR
            ),
            5 => array(
                'marker' => ':recPrepTime',
                'input' => (int)$recipe["recPrepTime"],
                'type' => PDO::PARAM_INT
            ),
            6 => array(
                'marker' => ':recDifficulty',
                'input' => (int)$recipe["recDifficulty"],
                'type' => PDO::PARAM_INT
            ),
            7 => array(
                'marker' => ':recGrade',
                'input' => null,
                'type' => PDO::PARAM_NULL // TODO : problème ici on a un float pas un int ???? ça marche quand même ou pas ?
            ),
            8 => array(
                'marker' => ':recImage',
                'input' => 'defaultRecipePicture.jpg',
                'type' => PDO::PARAM_STR
            ),
            9 => array(
                'marker' => ':recDate',
                'input' => $recipe["recDate"],
                'type' => PDO::PARAM_STR
            ),
            10 => array(
                'marker' => ':idUser',
                'input' => (int)$recipe["idUser"],
                'type' => PDO::PARAM_INT
            ),
            11 => array(
                'marker' => ':recCategory',
                'input' => $recipe["recCategory"],
                'type' => PDO::PARAM_STR
            )
        );

        $query =   'INSERT INTO t_recipe (recName, recCategory, recIngredientList, recDescription, recPreparation, recPrepTime, recDifficulty, recGrade, recImage, recDate, idUser)
                    VALUES (:recName, :recCategory, :recIngredientList, :recDescription, :recPreparation, :recPrepTime, :recDifficulty, :recGrade, :recImage, :recDate, :idUser)';

        $req = $this->queryPrepareExecute($query, $values);

        $this->unsetData($req);
    }

    /**
     * permet d'obtenir la date et l'heure du moment
     *
     * @return string
     */
    public function getDate()
    {
        $query = 'SELECT DATE_FORMAT(now(), "%Y-%m-%d-%H-%i-%s") AS currentTime';
        $req = $this->queryPrepareExecute($query, null);
        $date = $this->formatData($req);
        return $date[0];
    }

    /**
     * permet d'obtenir les recette liées a un utilisateur
     *
     * @param int $userId
     * @return array
     */
    public function getRecipesByUserId($userId)
    {
        $req = $this->queryPrepareExecute('SELECT * FROM t_recipe WHERE idUser = '. $userId , null);// appeler la méthode pour executer la requète

        $recipes = $this->formatData($req);// appeler la méthode pour avoir le résultat sous forme de tableau

        $this->unsetData($req);

        return $recipes;// retour tous les recettes
    }

    /**
     * permet de modifier une recette
     *
     * @param array $recipe
     * @return void
     */
    public function editRecipe($recipe)
    {
        $values = array(
            1 => array(
                'marker' => ':recName',
                'input' => $recipe["recName"],
                'type' => PDO::PARAM_STR
            ),
            2 => array(
                'marker' => ':recIngredientList',
                'input' => $recipe["recIngredientList"],
                'type' => PDO::PARAM_STR
            ),
            3 => array(
                'marker' => ':recDescription',
                'input' => $recipe["recDescription"],
                'type' => PDO::PARAM_STR
            ),
            4 => array(
                'marker' => ':recPreparation',
                'input' => $recipe["recPreparation"],
                'type' => PDO::PARAM_STR
            ),
            5 => array(
                'marker' => ':recPrepTime',
                'input' => $recipe["recPrepTime"],
                'type' => PDO::PARAM_INT
            ),
            6 => array(
                'marker' => ':recDifficulty',
                'input' => $recipe["recDifficulty"],
                'type' => PDO::PARAM_INT
            ),
            7 => array(
                'marker' => ':recGrade',
                'input' => $recipe["recGrade"],
                'type' => PDO::PARAM_INT // TODO : problème ici on a un float pas un int ???? ça marche quand même ou pas ?
            ),
            8 => array(
                'marker' => ':recImage',
                'input' => $recipe["recImage"],
                'type' => PDO::PARAM_STR
            ),
            9 => array(
                'marker' => ':recDate',
                'input' => $recipe["recDate"],
                'type' => PDO::PARAM_STR
            ),
            10 => array(
                'marker' => ':idUser',
                'input' => $recipe["idUser"],
                'type' => PDO::PARAM_INT
            )
        );

        $query =   'UPDATE t_recipe SET 
                    recName = :recName, recIngredientList = :recIngredientList, recDescription = :recDescription,
                    recPreparation = :recPreparation, recPrepTime = :recPrepTime, recDifficulty = :recDifficulty,
                    recGrade = :recGrade, recImage = :recImage, recDate = :recDate, idUser = :idUser
                    WHERE idRecipe = ' . $recipe["idRecipe"];

        $req = $this->queryPrepareExecute($query, $values);

        $this->unsetData($req);
    }

    /**
     * supprime une recette
     *
     * @param int $idRecipe
     * @return void
     */
    public function deleteRecipe($idRecipe)
    {
        $values = array(
            1 => array(
                'marker' => ':idRecipe',
                'input' => $idRecipe,
                'type' => PDO::PARAM_STR
            )
        );

        $query = 'DELETE FROM t_recipe WHERE t_recipe.idRecipe = :idRecipe';

        $req = $this->queryPrepareExecute($query, $values);

        $this->unsetData($req);
    }

    /**
     * permet d'obtenir toutes les notations d'une recette
     *
     * @param int $idRecipe
     * @return array
     */
    public function getAllRatingsForThisRecipe($idRecipe)
    {
        $req = $this->queryPrepareExecute('SELECT * FROM t_rating LEFT JOIN t_user ON t_rating.idUser = t_user.idUser WHERE t_rating.idRecipe = ' . $idRecipe, null);// appeler la méthode pour executer la requète

        $ratings = $this->formatData($req);// appeler la méthode pour avoir le résultat sous forme de tableau

        $this->unsetData($req);

        return $ratings;// retour toute les évaluations de la recette
    }

    /**
     * permet de savoir si un utilisateur a déjà noté la recette
     *
     * @param int $idUser
     * @param int $idRecipe
     * @return bool
     */
    public function userAlreadyRateThisRecipe($idUser, $idRecipe)
    {
        $ratings = $this->getAllRatingsForThisRecipe($idRecipe);

        foreach($ratings as $rating)
        {
            if ($rating["idUser"] == $idUser)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * ajoute une évaluation
     *
     * @param int $idUser
     * @param int $idRecipe
     * @param int $grade
     * @param string $comment
     * @return void
     */
    public function insertRating($idUser, $idRecipe, $grade, $comment)
    {
        $query = "INSERT INTO t_rating (ratGrade, ratComment, idRecipe, idUser) VALUES (:ratGrade, :ratComment, :idRecipe, :idUser)";

        //Binds des valeurs
        $values = array(
            0 => array(
                'marker' => ':ratGrade',
                'input' => $grade,
                'type' => PDO::PARAM_INT
            ),
            1 => array(
                'marker' => ':ratComment',
                'input' => $comment,
                'type' => PDO::PARAM_STR
            ),
            2 => array(
                'marker' => ':idRecipe',
                'input' => $idRecipe,
                'type' => PDO::PARAM_STR
            ),
            3 => array(
                'marker' => ':idUser',
                'input' => $idUser,
                'type' => PDO::PARAM_STR
            )
        );

        $req = $this->queryPrepareExecute($query, $values);
        $this->unsetData($req);
    }

    /**
     * permet de modifier une évaluation
     *
     * @param int $idUser
     * @param int $idRecipe
     * @param int $ratGrade
     * @param string $ratComment
     * @return void
     */
    public function editRating($idUser, $idRecipe, $ratGrade, $ratComment)
    {
        $idRating = -1;
        $values = array();
        $query = "";

        if ($ratGrade < 1)
        {
            $idRating = $this->getRatingIdByRecipeIdAndUserId($idRecipe, $idUser);

            $values = array(
                1 => array(
                    'marker' => ':idRating',
                    'input' => $idRating,
                    'type' => PDO::PARAM_INT
                )
            );
            
            $query = 'DELETE FROM t_rating WHERE t_rating.idRating = :idRating';
        }
        else
        {
            $values = array(
                1 => array(
                    'marker' => ':idUser',
                    'input' => $idUser,
                    'type' => PDO::PARAM_INT
                ),
                2 => array(
                    'marker' => ':idRecipe',
                    'input' => $idRecipe,
                    'type' => PDO::PARAM_INT
                ),
                3 => array(
                    'marker' => ':ratGrade',
                    'input' => $ratGrade,
                    'type' => PDO::PARAM_INT
                ),
                4 => array(
                    'marker' => ':ratComment',
                    'input' => $ratComment,
                    'type' => PDO::PARAM_STR
                )
            );
            
            $query =   'UPDATE t_rating SET 
                idUser = :idUser, idRecipe = :idRecipe, ratGrade = :ratGrade, ratComment = :ratComment
                WHERE idUser = :idUser AND idRecipe = :idRecipe';
        }
        
        $req = $this->queryPrepareExecute($query, $values);

        $this->unsetData($req);
    }

    /**
     * Undocumented function
     *
     * @param int $idRecipe
     * @param int $idUser
     * @return int
     */
    public function getRatingIdByRecipeIdAndUserId($idRecipe, $idUser)
    {
        $values = array(
            1 => array(
                'marker' => ':idUser',
                'input' => $idUser,
                'type' => PDO::PARAM_INT
            ),
            2 => array(
                'marker' => ':idRecipe',
                'input' => $idRecipe,
                'type' => PDO::PARAM_INT
            )
        );

        $query = 'SELECT idRating FROM t_rating WHERE idUser = :idUser AND idRecipe = :idRecipe';
        $req = $this->queryPrepareExecute($query, $values);
        $idRating = $this->formatData($req);
        $this->unsetData($req);

        return $idRating[0]["idRating"];
    }







    /**
     * Récupère tous les noms d'utilisateur
     * @return array
     */
    public function getAllUsernames(){

        $query = "SELECT usePseudo FROM t_user";
        $req = $this->queryPrepareExecute($query, null);
        $usernames = $this->formatData($req);
        $this->unsetData($req);
        return $usernames;
    }

    /**
     * Récupère les données d'un utilisateur par l'username
     * @param $username
     * @return array
     */
    public function getOneUser($username){

        $query = "SELECT * FROM t_user WHERE usePseudo = :username";
        
        $values = array(
            0 => array(
                'marker' => ':username',
                'input' => $username,
                'type' => PDO::PARAM_STR
            )
        );

        $req = $this->queryPrepareExecute($query, $values);
        $user = $this->formatData($req);

        $this->unsetData($req);

        return $user;
    }

    /**
     * Récupère les données d'un utilisateur par son id
     * @param $username
     * @return array
     */
    public function getOneUserById($userId){

        $query = "SELECT * FROM t_user WHERE idUser = '$userId'";
        $req = $this->queryPrepareExecute($query, null);
        $userArray = $this->formatData($req);
        $user = $userArray[0];
        $this->unsetData($req);
        return $user;
    }

    /**
     * Ajoute un utilisateur
     * @param $username
     */
    public function insertUser($username, $firstName, $lastName, $password){

        $query = "INSERT INTO t_user (usePseudo, useFirstName, useName, usePassword) VALUES (:username, :firstName, :lastName, :setPassword)";

        //Binds des valeurs
        $values = array(
            0 => array(
                'marker' => ':username',
                'input' => $username,
                'type' => PDO::PARAM_STR
            ),
            1 => array(
                'marker' => ':setPassword',
                'input' => $password,
                'type' => PDO::PARAM_STR
            ),
            2 => array(
                'marker' => ':firstName',
                'input' => $firstName,
                'type' => PDO::PARAM_STR
            ),
            3 => array(
                'marker' => ':lastName',
                'input' => $lastName,
                'type' => PDO::PARAM_STR
            )
        );

        $req = $this->queryPrepareExecute($query, $values);
        $this->unsetData($req);
    }

    /**
     * vérifie dans la database si l'id utilisateur existe
     *
     * @param int $idUser
     * @return bool
     */
    public function userExist($idUser)
    {
        $req = $this->queryPrepareExecute('SELECT * FROM t_user', null);// appeler la méthode pour executer la requète

        $users = $this->formatData($req);// appeler la méthode pour avoir le résultat sous forme de tableau

        foreach($users as $user)
        {
            if ($user["idUser"] == $idUser)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * permet de modifier un utilisateur
     *
     * @param array $user
     * @return void
     */
    public function updateUser($user){

        if (isset($user["useImage"]))
        {
            $values = array(
                1 => array(
                    'marker' => ':useImage',
                    'input' => $user["useImage"],
                    'type' => PDO::PARAM_STR
                ),
                2 => array(
                    'marker' => ':id',
                    'input' => $user["idUser"],
                    'type' => PDO::PARAM_INT
                )
            );

            $query = 'UPDATE t_user SET useImage = :useImage WHERE idUser = :id';
        }
        else if (isset($user["usePassword"]))
        {
            $values = array(
                1 => array(
                    'marker' => ':usePassword',
                    'input' => $user["usePassword"],
                    'type' => PDO::PARAM_STR
                ),
                2 => array(
                    'marker' => ':id',
                    'input' => $user["idUser"],
                    'type' => PDO::PARAM_INT
                )
            );

            $query = 'UPDATE t_user SET usePassword = :usePassword WHERE idUser = :id';
        }
        else
        {
            $values = array(
                1 => array(
                    'marker' => ':usePseudo',
                    'input' => $user["usePseudo"],
                    'type' => PDO::PARAM_STR
                ),
                2 => array(
                    'marker' => ':useFirstname',
                    'input' => $user["useFirstname"],
                    'type' => PDO::PARAM_STR
                ),
                3 => array(
                    'marker' => ':useName',
                    'input' => $user["useName"],
                    'type' => PDO::PARAM_STR
                ),
                4 => array(
                    'marker' => ':useMail',
                    'input' => $user["useMail"],
                    'type' => PDO::PARAM_STR
                ),
                5 => array(
                    'marker' => ':useTelephone',
                    'input' => $user["useTelephone"],
                    'type' => PDO::PARAM_STR
                ),
                6 => array(
                    'marker' => ':id',
                    'input' => $user["idUser"],
                    'type' => PDO::PARAM_INT
                )
            ); 

            $query =   'UPDATE t_user SET 
                        usePseudo = :usePseudo, useFirstname = :useFirstname, useName = :useName, useMail = :useMail, useTelephone = :useTelephone
                        WHERE idUser = :id';
        }

        $req = $this->queryPrepareExecute($query, $values);

        $this->unsetData($req);
    }
}
?>