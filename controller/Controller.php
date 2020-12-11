<?php
/**
 * Auteur : Cindy Hardegger
 * Date: 22.01.2019
 * Contrôleur principal
 */

abstract class Controller {

    protected $databasePath;

    public function __construct() {
        $this->databasePath = "model\Database.php";
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
    
}