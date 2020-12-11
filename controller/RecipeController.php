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

        // Appelle une méthode dans cette classe (ici, ce sera le nom + action (ex: listAction, detailAction, ...))
        return call_user_func(array($this, $action)); // permet d'appeler listAction() (ligne 31)
    }

    /**
     * Rechercher les données et les passe à la vue (en liste)
     *
     * @return string
     */
    private function listAction() {

        // Instancie le modèle et va chercher les informations

        include_once("model/Database.php");
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
     * Rechercher les données et les passe à la vue (en détail)
     *
     * @return string
     */
    private function detailAction() {

        include_once("model/Database.php");
        $database = new Database();

        $recipe = $database->getOneRecipe($_GET['id']);

        $view = file_get_contents('view/page/recipe/detail.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;

    }

    /**
     * vérifie le nombre du get
     *
     * @param [type] $get
     * @param [type] $lengthRecipe
     * @return void
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