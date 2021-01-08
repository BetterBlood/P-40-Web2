<?php
/**
 * Auteur : Cindy Hardegger, Jeremiah Steiner
 * Date: 22.01.2019, 27.12.2020
 * Contrôleur principal
 */

abstract class Controller {

    protected $databasePath;

    /**
     * constructeur de Controller (initialise le $databasePath)
     */
    public function __construct() {
        $this->databasePath = "model/Database.php";
    }

    /**
     * Méthode permettant d'appeler l'action
     *
     * @return mixed
     */
    public function display() 
    {
        $page = $_GET['action'] . "Display";

        $this->$page();
    }

    /**
     * permet de vérifier que l'extension du fichier passé en param est une image (gif, png ou jpg)
     *
     * @param string $imageName
     * @return bool si $imageName a une extension correspondante
     */
    protected function extensionOk($imageName)
    {
        $extensionIsOk = false;
        $ext = pathinfo($imageName, PATHINFO_EXTENSION);

        switch ($ext)
        {
            case "PNG":
            case "png":
            case "JPG":
            case "jpg":
            case "GIF":
            case "gif":
                $extensionIsOk = true; // remplacer en return true; ?
                break;
                
            default:
                $extensionIsOk = false; // remplacer en return false; ?
                break;
        }

        return $extensionIsOk;
    }
    
}