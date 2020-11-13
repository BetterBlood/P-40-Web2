<?php
/**
 * ETML
 * Auteur : Moi
 * Date: 02.10.2020
 * Controler pour gérer les fcatures
 */

include_once 'model/RecetteRepository.php';

class RecetteController extends Controller {

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
        $factureRepository = new RecetteRepository();
        $invoices = $factureRepository->findAll(); // est utiliser a la ligne 45

        // Charge le fichier pour la vue
        $view = file_get_contents('view/page/recette/list.php');


        // Pour que la vue puisse afficher les bonnes données, il est obligatoire que les variables de la vue puisse contenir les valeurs des données
        // ob_start est une méthode qui stoppe provisoirement le transfert des données (donc aucune donnée n'est envoyée).
        ob_start();
        // eval permet de prendre le fichier de vue et de le parcourir dans le but de remplacer les variables PHP par leur valeur (provenant du model)
        eval('?>' . $view);
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

        $factureRepository = new RecetteRepository();
        $facture = $factureRepository->findOne($_GET['id']);

        $view = file_get_contents('view/page/recette/detail.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;

    }
}