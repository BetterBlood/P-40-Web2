<?php
/**
 * ETML
 * Auteur : Cindy Hardegger
 * Date: 22.01.2019
 * Controler pour gérer les pages classiques
 */

class HomeController extends Controller {

    /**
     * Dispatch current action
     *
     * @return mixed
     */
    public function display() {

        $action = "indexAction";

        if (!array_key_exists("action", $_GET))
        {
            $action = "indexAction";
        }
        else 
        {
            switch($_GET["action"])
            {
                case "index":
                case "contact":
                case "check":
                    $action = $_GET["action"] . "Action";
                    break;

                default:
                    $action = "indexAction";
                    break;
            }
        }

        return call_user_func(array($this, $action));
    }

    /**
     * Display Index Action
     *
     * @return string
     */
    private function indexAction() {

        include_once($this->databasePath);
        $database = new Database();

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
     * Display Contact Action
     *
     * @return string
     */
    private function contactAction() {

        $view = file_get_contents('view/page/home/contact.php');


        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Check Form action
     *
     * @return string
     */
    private function checkAction() {
        // j'ai gardé cette partie juste pour l'estetique visuel du site //

        $lastName = htmlspecialchars($_POST['lastName']);
        $firstName = htmlspecialchars($_POST['firstName']);
        $answer = htmlspecialchars($_POST['answer']);

        $view = file_get_contents('view/page/home/resume.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
}