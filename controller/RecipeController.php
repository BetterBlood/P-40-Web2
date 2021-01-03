<?php

use function PHPSTORM_META\elementType;

/**
 * ETML
 * Auteur : Moi
 * Date: 02.10.2020
 * Controler pour gérer les recettes
 */

//include_once 'model/RecetteRepository.php'; // ça je crois balek il va falloir enlever mais vérifier avant

class RecipeController extends Controller {

    /**
     * Permet de choisir l'action à effectuer
     *
     * @return mixed
     */
    public function display() {

        $action = $_GET['action'] . "Action";

        $action = "listAction";

        include_once($this->databasePath);
        $database = new Database();

        if (!array_key_exists("action", $_GET))
        {
            $action = "listAction";
        }
        else 
        {
            switch($_GET["action"])
            {
                case "list":
                case "rate":
                    $action = $_GET["action"] . "Action";
                    break;
                    
                case "detail":
                    if (array_key_exists("id", $_GET) && $database->RecipeExist($_GET["id"]) && array_key_exists("isConnected", $_SESSION) && $_SESSION["isConnected"])
                    {
                        $action = $_GET["action"] . "Action";
                    }
                    else
                    {
                        $action = "listAction";
                    }
                    break;

                case "addRecipe":
                    if (array_key_exists("isConnected", $_SESSION) && $_SESSION["isConnected"])
                    {
                        $action = $_GET["action"] . "Action";
                    }
                    else
                    {
                        $action = "listAction";
                    }
                    break;

                case "deleteRecipe":
                case "editRecipe":
                    if (array_key_exists("id", $_GET) && $database->RecipeExist($_GET["id"]) && array_key_exists("isConnected", $_SESSION) && $_SESSION["isConnected"])
                    {
                        $action = $_GET["action"] . "Action";
                    }
                    else
                    {
                        $action = "listAction";
                    }
                    break;

                default:
                    $action = "listAction";
                    break;
            }
        }

        // Appelle une méthode dans cette classe (ici, ce sera le nom + action (ex: listAction, detailAction, ...))
        return call_user_func(array($this, $action));
    }

    /**
     * Rechercher les données et les passe à la vue (en liste)
     *
     * @return string
     */
    private function listAction() {

        // Instancie le modèle et va chercher les informations

        include_once($this->databasePath);
        $database = new Database();

        $startIndex = 0;
        $lengthRecipe = 20; // UTIL : modifier si on veut pouvoir modifier le nombre de recette affichée
        $_SESSION["recipesPerPage"] = $lengthRecipe;

        if (array_key_exists("start", $_GET) && $_GET["start"] > 0) // si le paramettre de start n'est pas négatif
        {
            $this->normalizeStartIndex($startIndex, $database, $lengthRecipe); // permet de trouver le startindex optimal
        }
        else
        {
            $_GET["start"] = 0;
        }

        $recipes = $database->getAllRecipes($startIndex, $lengthRecipe);

        // Charge le fichier pour la vue
        $view = file_get_contents('view/page/recipe/list.php');


        // Pour que la vue puisse afficher les bonnes données, il est obligatoire que les variables de la vue puisse contenir les valeurs des données
        // ob_start est une méthode qui stoppe provisoirement le transfert des données (donc aucune donnée n'est envoyée).
        ob_start();
        // eval permet de prendre le fichier de vue et de le parcourir dans le but de remplacer les variables PHP par leur valeur (provenant du model)
        eval('?>' . $view);//*/
        // ob_get_clean permet de reprendre la lecture qui avait été stoppée (dans le but d'afficher la vue)
        $content = ob_get_clean();

        return $content;
    }

    /**
     * permet d'ajouter ou de modifier sa note pour une recette
     *
     * @param int $idRecipe
     * @return void
     */
    private function rateAction() // TODO : finir cette méthode
    {
        // TODO : vérifier l'intégrité des données (genre que la note est bien >= à 1 et <= 5, et commentaire pas vide)
        include_once($this->databasePath);
        $database = new Database();

        $recipe = array();
        $ratings = array();
        $idRecipe = -1;
        $ratGrade = -1;
        $ratComment = "noComment";

        if (array_key_exists("id", $_GET))
        {
            $idRecipe = $_GET["id"];
            $recipe = $database->getOneRecipe($idRecipe);
            $ratings = $database->getAllRatingsForThisRecipe($idRecipe);
        }

        if (array_key_exists("ratGrade", $_POST))
        {
            $ratGrade = $_POST["ratGrade"];
        }
        if (array_key_exists("ratComment", $_POST))
        {
            $ratComment = $_POST["ratComment"];
        }
        

        // ajouter (ou modifier) la note de l'utilisateur dans la database (on a son id en variable de session)
        if (array_key_exists("idUser", $_SESSION) && $database->userAlreadyRateThisRecipe($_SESSION["idUser"], $idRecipe))
        {
            // on modifie la note de l'utilisateur
                // récupérer l'id du rating correspondant // pas obligé en fait
                // le modifier dans la base de 
            $database->editRating($_SESSION["idUser"], $idRecipe, $ratGrade, $ratComment);
            $ratings = $database->getAllRatingsForThisRecipe($idRecipe);
        }
        else if (array_key_exists("idUser", $_SESSION))
        {
            // on ajoute la note au rating avec l'id de la recette et de l'user
            $database->insertRating($_SESSION["idUser"], $idRecipe, $ratGrade, $ratComment);
            $ratings = $database->getAllRatingsForThisRecipe($idRecipe);
        }

        if (count($ratings) >= 1) // racalcul la note de la recette et l'inscrit dans sa table // mais je ne sais pas pk ça marche pas...
        {
            $totGrades = 0;
            
            foreach($ratings as $rating)
            {
                $totGrades += (float)$rating["ratGrade"];
            }

            $recipe["recGrade"] = (float)($totGrades/count($ratings));
        }
        else
        {
            $recipe["recGrade"] = null;
        }

        // l'inscrir dans la table de recette
        $database->editRecipe($recipe);

        // charger la page de détail de la recette
        $view = file_get_contents('view/page/recipe/recipeRating.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Rechercher les données et les passe à la vue (en détail)
     *
     * @return string
     */
    private function detailAction() {

        include_once($this->databasePath);
        $database = new Database();

        $recipe = $database->getOneRecipe($_GET['id']);
        $recipeCreator = $database->getOneUserById($recipe["idUser"]);

        $ratings = $database->getAllRatingsForThisRecipe($recipe["idRecipe"]);

        $alreadyRate = false;
        $userGrade = 2.5;

        foreach($ratings as $rating) // vérifie si l'utilisateur a déjà noté cette recette, si oui attribut la note a la variable $userGrade
        {
            if ($rating["idUser"] == $_SESSION["idUser"])
            {
                $alreadyRate = true;
                $userGrade = $rating["ratGrade"];
                $userComment = $rating["ratComment"];
            }
        }

        $view = file_get_contents('view/page/recipe/detail.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * permet d'ajouter une recette
     *
     * @return string
     */
    private function addRecipeAction()
    {
        include_once($this->databasePath);
        $database = new Database();
        
        $firstPart = true;

        if (isset($_POST["recipeCreation1"]))
        {
            $firstPart = false;
            $firstPartError = false;
            $_SESSION["recipe"] = array();
            $_SESSION["recipe"]["recName"] = "";
            $_SESSION["recipe"]["recCategory"] = "";
            $_SESSION["recipe"]["recPrepTime"] = -1;
            $_SESSION["recipe"]["recDifficulty"] = -1;
            $_SESSION["recipe"]["recDescription"] = "";
            
            
            if (array_key_exists("recName", $_POST) && trim($_POST["recName"]) != "" && strlen($_POST["recName"]) <= 100 && strlen($_POST["recName"]) > 1) // 2 charactère minimum
            {
                $_SESSION["recipe"]["recName"] = $_POST["recName"];
            }
            else
            {
                $firstPart = true;
                $firstPartError = true;
            }

            if (array_key_exists("recCategory", $_POST) && trim($_POST["recCategory"]) != "" && strlen($_POST["recCategory"]) <= 100 && strlen($_POST["recCategory"]) > 4) // 5 charactère minimum
            {
                $_SESSION["recipe"]["recCategory"] = $_POST["recCategory"];
            }
            else
            {
                $firstPart = true;
                $firstPartError = true;
            }

            if (array_key_exists("recPrepTime", $_POST) && trim($_POST["recPrepTime"]) != "" && (int)$_POST["recPrepTime"] >= 10)
            {
                $_SESSION["recipe"]["recPrepTime"] = $_POST["recPrepTime"];
            }
            else
            {
                $firstPart = true;
                $firstPartError = true;
            }

            if (array_key_exists("recDifficulty", $_POST) && trim($_POST["recDifficulty"]) != "" && (int)$_POST["recDifficulty"] >= 1 && (int)$_POST["recDifficulty"] <= 5)
            {
                $_SESSION["recipe"]["recDifficulty"] = $_POST["recDifficulty"];
            }
            else
            {
                $firstPart = true;
                $firstPartError = true;
            }

            if (array_key_exists("recDescription", $_POST) && trim($_POST["recDescription"]) != "" && strlen($_POST["recDescription"]) <= 255 && strlen($_POST["recDescription"]) > 4) // 5 charactère minimum
            {
                $_SESSION["recipe"]["recDescription"] = $_POST["recDescription"];
            }
            else
            {
                $firstPart = true;
                $firstPartError = true;
            }
            
            
        }

        if (isset($_POST["recipeCreation2"]))
        {
            $firstPart = false;
            $secondPartError = false;
            $recipe = array();

            $recipe["idUser"] = $_SESSION["idUser"];
            $recipe["recName"] = $_SESSION["recipe"]["recName"];
            $recipe["recCategory"] = $_SESSION["recipe"]["recCategory"];
            $recipe["recPrepTime"] = (int)$_SESSION["recipe"]["recPrepTime"];
            $recipe["recDifficulty"] = (int)$_SESSION["recipe"]["recDifficulty"];
            $recipe["recDescription"] = $_SESSION["recipe"]["recDescription"];

            $ingredients = "";

            if (isset($_POST["numberOfIngredients"]))
            {
                $numberOfIngredients = $_POST["numberOfIngredients"];

                for ($i = 0; $i < $numberOfIngredients; $i++)
                {
                    if (isset($_POST["nbrIngredient" . ($i + 1)]) && trim($_POST["nbrIngredient" . ($i + 1)]) != "" && isset($_POST["ingredient" . ($i + 1)]) && strlen(trim($_POST["ingredient" . ($i + 1)])) >= 1)
                    {
                        $ingredients .= $_POST["nbrIngredient" . ($i + 1)] . ' x '; // TODO : [pas obligatoire] on pourrait faire une modif ici (mais il faudrait ajouter un champ au form (unity) et faire un if pour savoir quelle unitée est séléctionnée et faire une autre table ? => bof....)
                    }
                    else
                    {
                        continue;
                    }

                    if (isset($_POST["ingredient" . ($i + 1)]) && trim($_POST["ingredient" . ($i + 1)]) != "")
                    {
                        $ingredients .= $_POST["ingredient" . ($i + 1)];

                        if ($i != $numberOfIngredients - 1)
                        {
                            $ingredients .= ',';
                        }
                    }
                }

                if (trim($ingredients) == "" || empty($ingredients) || strlen($ingredients) > 255 || strlen($ingredients) < 5) // "1 x n" 5 charactères minimum
                {
                    $secondPartError = true;
                }
            }
            
            $recipe["recIngredientList"] = $ingredients;


            $preparationStep = "";

            if (isset($_POST["numberOfstep"]))
            {
                $numberOfstep = $_POST["numberOfstep"];

                for ($i = 0; $i < $numberOfstep; $i++)
                {

                    if (isset($_POST["step" . ($i + 1)]))
                    {
                        $preparationStep .= $_POST["step" . ($i + 1)];

                        if ($i != $numberOfstep - 1)
                        {
                            $preparationStep .= ',';
                        }
                    }
                }

                if (trim($preparationStep) == "" || empty($preparationStep) || strlen($preparationStep) > 255 || strlen($preparationStep) < 5) // 5 aussi comme minimum (c'est arbitraire)
                {
                    $secondPartError = true;
                }
            }
            
            $recipe["recPreparation"] = $preparationStep;
            
            $date = $database->getDate();
            $recipe["recDate"] = $date["currentTime"];
            $recipe["recImage"] = "defaultRecipePicture.jpg";
            
            $nextId = $database->getNextRecipeId(); // récupération du prochain id
            
            $recipe["idRecipe"] = $nextId;

            if (!$secondPartError)
            {
                $database->insertRecipe($recipe); // insertion de la recette dans la base de donnée
            }


            $recipe = $database->getLastRecipe(); //get la recette pour la page edit (où l'on peut ajouter une image) (on a besoin de l'id)

            if (!$secondPartError)
            {
                $view = file_get_contents('view/page/restrictedPages/manageRecipe/editRecipe.php');
            }
            else
            {
                $view = file_get_contents('view/page/restrictedPages/manageRecipe/addRecipe.php');
            }
        }
        else
        {
            $view = file_get_contents('view/page/restrictedPages/manageRecipe/addRecipe.php');
        }
        

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * permet de modifier une recette
     *
     * @return string
     */
    private function editRecipeAction()
    {
        include_once($this->databasePath);
        $database = new Database();

        $recipe = $database->getOneRecipe($_GET["id"]);

        $imageEmpty = false;

        if (array_key_exists("fileUpdate", $_POST)) // modification de l'image
        {
            if(!empty($_FILES["image"]["name"]) && $this->extensionOk($_FILES["image"]["name"])) // TODO : faire de meilleures vérifications (ex: nom de fichier trop long... )
            {
                if ($recipe["recImage"] != "defaultRecipePicture.jpg" && file_exists("resources/image/Recipes/" . $recipe["recImage"]))
                {
                    unlink("resources/image/Recipes/" . $recipe["recImage"]); // suppression de l'ancienne image
                }
                
                $imgName = date("YmdHis") . "_" . $_FILES["image"]["name"];
                move_uploaded_file($_FILES["image"]["tmp_name"], "resources/image/Recipes/" . $imgName);
                $recipe["recImage"] = $imgName;
                
                $database->editRecipe($recipe);
            }
            else
            {
                $imageEmpty = true;
            }
        }

        $view = file_get_contents('view/page/restrictedPages/manageRecipe/editRecipe.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * permet de supprimer une recette
     *
     * @return string
     */
    private function deleteRecipeAction()
    {
        include_once($this->databasePath);
        $database = new Database();

        if ($database->RecipeExist($_GET["id"]))
        {
            $recipe = $database->getOneRecipe($_GET["id"]);

            if ($recipe["recImage"] != "defaultRecipePicture.jpg" && file_exists("resources/image/Recipes/" . $recipe["recImage"]))
            {
                unlink("resources/image/Recipes/" . $recipe["recImage"]); // suppression de l'ancienne image
            }

            if ($recipe["idUser"] == $_SESSION["idUser"])
            {
                $database->deleteRecipe($_GET["id"]); // suppression dans la base de donnée
            }
        }

        // redirection vers la page d'accueil
        $lastRecipe = $database->getLastRecipe();
        $bestRecipe = $database->getBestRecipe();
        $easiestRecipe = $database->getEasiestRecipe();

        //tester si la valeur existe si elle n'existe pas ou est incorect on la set a 0
        if (!array_key_exists('image', $_GET) || $_GET['image'] < 0 || $_GET['image'] > 2)
        {
            $_GET['image'] = 0;
        }

        $view = file_get_contents('view/page/home/carousel.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * vérifie le nombre du get
     *
     * @param int $get
     * @param int $lengthRecipe
     * @return int
     */
    private function normalize($get, $lengthRecipe)
    {
        //var_dump($get - $lengthRecipe);

        if ($get%$lengthRecipe != 0) // si le get n'est pas un nombre parfait au sens qu'il donne une page précise et pas une page entre-deux
        {
            return $get - $get%$lengthRecipe;
        }
        else
        {
            return $get;
        }
    }

    /**
     * permet de rendre l'index de départ rond par rapport au nombre de page et au nombre de recette par page <etc class=""></etc>
     *
     * @param int $startIndex 
     * @param [type] $database
     * @param int $lengthRecipe
     * @return void
     */
    private function normalizeStartIndex(&$startIndex, $database, $lengthRecipe)
    {
        $recipeNumber = $database->CountRecipes();
        $_SESSION["recipesNumber"] = $recipeNumber;

        if ($recipeNumber > $_GET["start"]) // si le paramettre n'est ni trop grand ni trop petit
        {
            //$startIndex = $_GET["start"];
            $startIndex = $this->normalize($_GET["start"], $lengthRecipe);
        }
        else if ($_GET["start"] == $recipeNumber)
        {
            $startIndex = $_GET["start"] - $lengthRecipe;
        }
        else
        {
            //$startIndex = $recipeNumber - ($lengthRecipe - $recipeNumber%$lengthRecipe);
            if ($lengthRecipe == $recipeNumber)
            {
                $startIndex = 0;
            }
            else if ($lengthRecipe == 1)
            {
                $startIndex = $recipeNumber - $recipeNumber%$lengthRecipe - 1;
            }
            else if ($_GET["start"] == PHP_INT_MAX)
            {
                if ($recipeNumber%$lengthRecipe == 0) // s'il y a pil le meme nombre de recette
                {
                    $startIndex = $recipeNumber - ($lengthRecipe - $recipeNumber%$lengthRecipe);
                }
                else // s'il y a plus de recette
                {
                    $startIndex = $recipeNumber - $recipeNumber%$lengthRecipe;
                }
            }
            else
            {
                $startIndex = $recipeNumber - $recipeNumber%$lengthRecipe;
            }
        }

        $_GET["start"] = $startIndex;
    }
}