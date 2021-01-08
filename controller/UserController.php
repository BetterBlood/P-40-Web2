<?php
/**
 * ETML
 * Auteur : Arthur Wallef, Pierre Morand & Jeremiah Steiner
 * Date: 25.12.2020
 * Controler pour gérer les clients
 */

include_once("model/Database.php");

class UserController extends Controller 
{
    /**
     * Permet de choisir l'action à effectuer
     *
     * @return mixed
     */
    public function display() 
    {
        $action = "loginFormAction";

        $database = new Database();

        // gestion des erreurs de lien
        if (!array_key_exists("action", $_GET))
        {
            $action = "loginFormAction";
        }
        else
        {
            switch($_GET["action"])
            {
                case "loginForm":
                case "login":
                case "logout":
                case "registerForm":
                case "register":
                    $action = $_GET['action'] . "Action";
                    break;

                case "profile":
                    if (array_key_exists("idUser", $_GET) && $database->userExist($_GET["idUser"]))
                    {
                        $action = $_GET['action'] . "Action";
                    }
                    else 
                    {
                        $action = "loginFormAction";
                    }
                    break;

                default :
                    $action = "loginFormAction";
                    break;
            }
        }

        return call_user_func(array($this, $action));
    }

    /**
     * Affichage du formulaire du login
     *
     * @return string
     */
    private function loginFormAction() 
    {
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
    private function loginAction() 
    {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

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
        else if(password_verify($password, $user['usePassword'])){
            $_SESSION['errorLogin'] = false;
            $_SESSION['isConnected'] = true;
            $_SESSION['username'] = $user['usePseudo'];
            $_SESSION['idUser'] = $user['idUser'];
            header('location: index.php');
        }
        else{
            $_SESSION['errorLogin'] = true;
            $_SESSION['isConnected'] = false;
            header('location: index.php?controller=user&action=loginForm');
        }

    }

    /**
     * gère la déconnexion
     *
     * @return void
     */
    private function logoutAction() 
    {
        session_destroy();
        header('location: index.php');
    }

    /**
     * Affichage du formulaire d'enregistrement
     *
     * @return string
     */
    private function registerFormAction() 
    {
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
    private function registerAction()
    {
        $error = false;
        //Vérification de l'existence des champs
        if(key_exists("username", $_POST) && key_exists("firstName", $_POST) && key_exists("lastName", $_POST) && key_exists("password1", $_POST) && key_exists("password2", $_POST)){
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
                //TODO : si le temps le permet : vérification
                $username = htmlspecialchars($_POST['username']);
                $firstName = htmlspecialchars($_POST['firstName']);
                $lastName = htmlspecialchars($_POST['lastName']);
                $password = htmlspecialchars($_POST['password1']);
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                include_once($this->databasePath);
                $database = new Database();

                //Vérifie le connecteur
                $array = (array) $database;
                if($array["\0Database\0connector"] != NULL){
                    
                    $database->insertUser($username, $firstName, $lastName, $hashed_password);
                    $_SESSION['isConnected'] = false;
                    //$_SESSION['username'] = $username;
                    //$_SESSION['idUser'] = $user['idUser']; // l'id n'existe pas puisque il n'y a pas de get du dernier user ajouter a la database
                    header('location: index.php'); // redirection vers l'index
                    //rediriger vers une page de confirmation/erreur
                }
            }
        }
    }

    /**
     * permet d'accèder à la page de profile de l'utilisateur
     *
     * @return string
     */
    private function profileAction()
    {
        $database = new Database();

        $userProfile = array();
        $user = array();
        $view = "";
        $selfPage = false;
        $modificationDone = false;

        // errors
        $passwordModifFailed = false;
        $imageEmpty = false;
        

        if (array_key_exists("idUser", $_GET) && $database->userExist($_GET["idUser"]))
        {
            $recipes = $database->getRecipesByUserId($_GET["idUser"]);
            $userProfile = $database->getOneUserById($_GET["idUser"]);
            $view = file_get_contents('view/page/restrictedPages/userPage.php');

            if (array_key_exists("idUser", $_SESSION) && $_SESSION["idUser"] == $_GET["idUser"])
            {
                $selfPage = true;

                if (isset($_POST) && !empty($_POST))
                {
                    // TODO : si le temps le permet : vérification du form 
                    
                    $user["idUser"] = $_SESSION["idUser"];

                    if (array_key_exists("fileUpdate", $_POST)) // form just pour update l'image
                    {
                        if (!empty($_FILES["image"]["name"]) && $_FILES["image"]["name"] != "" && $this->extensionOk($_FILES["image"]["name"])) // vérifie qu'il y a bien un fichier de séléctionné // TODO : si le temps le permet : gérer fichier vide (!= "" ne fonctionne pas)
                        {
                            if ($userProfile["useImage"] != "defaultUserPicture.png" && file_exists("resources/image/Users/" . $userProfile["useImage"]))
                            {
                                unlink("resources/image/Users/" . $userProfile["useImage"]); // suppression de l'ancienne image
                            }

                            $image = "";
                            $imgName = date("YmdHis") . "_" . $_FILES["image"]["name"];

                            switch (pathinfo($imgName, PATHINFO_EXTENSION))
                            {
                                case "PNG":
                                case "png":
                                    $image = imagecreatefrompng($_FILES["image"]["tmp_name"]); // prépare la compression
                                    break;
            
                                case "JPG":
                                case "jpg":
                                    $image = imagecreatefromjpeg($_FILES["image"]["tmp_name"]); // prépare la compression
                                    break;
                                
                                case "GIF":
                                case "gif":
                                    $image = imagecreatefromgif($_FILES["image"]["tmp_name"]); // prépare la compression
                                    break;
                                default:
                                    break;
                            }
            
                            imagejpeg($image, "resources/image/Users/" . $imgName, 75); // compression de l'image 

                            //move_uploaded_file($_FILES["image"]["tmp_name"], "resources/image/Users/" . $imgName);

                            $userProfile["useImage"] = $imgName;
                            $user["useImage"] = $imgName;
                        }
                        else 
                        {
                            $imageEmpty = true;
                        }
                    }
                    else if (array_key_exists("modifPasswordForm", $_POST)) // gère la modification du password
                    {
                        if (array_key_exists("usePassword", $_POST) && array_key_exists("confirmePassword", $_POST))
                        {
                            if ($_POST["usePassword"] === $_POST["confirmePassword"]) // TODO : si le temps le permet : ajouter des validation pour le mot de passe
                            {
                                $user["usePassword"] = password_hash($_POST["usePassword"], PASSWORD_DEFAULT);
                            }
                            else
                            {
                                $passwordModifFailed = true;
                            }
                        }
                        else
                        {
                            $passwordModifFailed = true;
                        }
                    }
                    else 
                    {
                        // TODO : si le temps le permet : faire la vérification de champ (ptetre faire une méthode, étant donné que l'on doit aussi l'utiliser pour l'inscription)
                        $user["usePseudo"] = $_POST["pseudo"];
                        $user["useFirstname"] = $_POST["useFirstname"];
                        $user["useName"] = $_POST["useName"];
                        $user["useMail"] = $_POST["mail"];
                        $user["useTelephone"] = $_POST["phone"]; 

                    }

                    if (!$passwordModifFailed && !$imageEmpty) // NOTE : (à vérifier à la fin du projet) ajouter les autre erreur ici afin que cela ne modifie pas la database s'il y a une erreur de form
                    {
                        $modificationDone = true;
                        $database->updateUser($user);
                        $userProfile = $database->getOneUserById($_SESSION["idUser"]); // permet d'afficher directement les modifications
                    }

                    $view = file_get_contents('view/page/restrictedPages/userPage.php');
                }
            }
        }
        else if (array_key_exists("idUser", $_SESSION))
        {
            $recipes = $database->getRecipesByUserId($_SESSION["idUser"]);
            $userProfile = $database->getOneUserById($_SESSION["idUser"]);
            $view = file_get_contents('view/page/restrictedPages/userPage.php');
            $selfPage = false;

            if (array_key_exists("idUser", $_GET) && array_key_exists("idUser", $_SESSION) && $_GET["idUser"] == $_SESSION["idUser"])
            {
                $selfPage = true;
            }
        }
        else 
        {
            $userProfile = null;
            $view = file_get_contents('view/page/restrictedPages/loginRegister/loginForm.php');
        }

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

}