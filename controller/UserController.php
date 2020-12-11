<?php
/**
 * ETML
 * Auteur : Cindy Hardegger
 * Date: 22.01.2019
 * Controler pour gérer les clients
 */

class UserController extends Controller {

    /**
     * Permet de choisir l'action à effectuer
     *
     * @return mixed
     */
    public function display() {

        $action = $_GET['action'] . "Action";

        return call_user_func(array($this, $action));
    }

    /**
     * Affichage du formulaire du login
     *
     * @return string
     */
    private function loginFormAction() {

        $view = file_get_contents('view/page/restrictedPages/loginRegister/loginForm.php');
        
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Login utilisateur
     *
     */
    private function loginAction() {

        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        include_once($this->databasePath);
        $database = new Database();

        //Vérifie le connecteur
        $array = (array) $database;
        if($array["\0Database\0connector"] != NULL){
            $user = $database->getOneUser($username);
        }


        if(empty($user)){
            $_SESSION['errorLogin'] = true;
            $_SESSION['isConnected'] = false;
            header('location: index.php?controller=user&action=loginForm');
        }
        else if($user['usePassword'] == $_POST['password']){
            $_SESSION['errorLogin'] = false;
            $_SESSION['isConnected'] = true;
            $_SESSION['username'] = $user['usePseudo'];
            $_SESSION['rights'] = $user['useAdminRight'];
            header('location: index.php');
        }
        else{
            echo 'erreur mot de passe';
            $_SESSION['errorLogin'] = true;
            $_SESSION['isConnected'] = false;
            header('location: index.php?controller=user&action=loginForm');
        }

    }

    private function logoutAction() {
        session_destroy();
        header('location: index.php');
    }
}