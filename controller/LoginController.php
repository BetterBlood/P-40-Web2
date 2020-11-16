<?php
/**
 * ETML
 * Auteur : Cindy Hardegger
 * Date: 22.01.2019
 * Controler pour gérer les clients
 */

class LoginController extends Controller {

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
     * Display facture Action
     *
     * @return string
     */
    private function loginAction() {

        $view = file_get_contents('view/page/restrictedPages/loginRegister/loginForm.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
}