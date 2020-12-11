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
            $userArray = $database->getOneUser($username);
            $user = $userArray[0];
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
            header('location: index.php');
        }
        else{
            $_SESSION['errorLogin'] = true;
            $_SESSION['isConnected'] = false;
            header('location: index.php?controller=user&action=loginForm');
        }

    }

    private function logoutAction() {
        session_destroy();
        header('location: index.php');
    }

    /**
     * Affichage du formulaire d'enregistrement
     *
     * @return string
     */
    private function registerFormAction() {

        $view = file_get_contents('view/page/restrictedPages/loginRegister/registerForm.php');
        
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Création d'un utilisateur
     *
     */
    private function registerAction(){

        $error = false;
        //Vérification de l'existence des champs
        if(key_exists("username", $_POST) && key_exists("firstName", $_POST) && key_exists("lastName", $_POST) && key_exists("password1", $_POST) && key_exists("password1", $_POST)){
            //Vérification des champs
            if ((htmlspecialchars($_POST['username']) == "" || !preg_match('/^[A-Za-z\d]*(-[A-Za-z\d]*)*$/',htmlspecialchars($_POST['username']))))
            {
                $error = true;
                echo 'Nom dutilisateur non conforme<br>';
            }
            if (($_POST['password1'] != $_POST['password2']))
            {
                $error = true;
                echo 'Les mots de passe ne sont pas identiques<br>';
            }

            if($error == false){
                //TODO vérification
                $username = htmlspecialchars($_POST['username']);
                $firstName = htmlspecialchars($_POST['firstName']);
                $lastName = htmlspecialchars($_POST['lastName']);
                $password = htmlspecialchars($_POST['password1']);
                
                include_once($this->databasePath);
                $database = new Database();

                //Vérifie le connecteur
                $array = (array) $database;
                if($array["\0Database\0connector"] != NULL){
                    
                    $database->insertUser($username, $firstName, $lastName, $password);
                    $_SESSION['isConnected'] = true;
                    $_SESSION['username'] = $username;
                    header('location: index.php');
                    //TODO
                    //rediriger vers une page de confirmation/erreur
            }
        }


        }
    }
}