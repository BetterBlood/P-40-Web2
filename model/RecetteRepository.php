<?php
/**
 * ETML
 * Auteur : Cindy Hardegger
 * Date: 22.01.2019
 * Recueil des méthodes permettant de charger les données pour les clients
 */

include_once 'Entity.php';

class RecetteRepository implements Entity {

    /**
     * Récupérer tous les clients
     *
     * @return array
     */
    public function findAll() {

        include './data/recettes.php';

        return $recettes;
    }

    /**
     * Find One entry
     *
     * @param $idProduct
     *
     * @return array
     */
    public function findOne($idInvoice) {

        include './data/recettes.php';
        
        $recetteCurrent = array();

        // Boucler sur tous les clients et sélectionner seulement celui que l'on veut afficher
        foreach($recettes as $recette) {

            if($recettes['idInvoice'] == $idInvoice){ // TODO : modifier les 2 idInvoice en fonction de ce qu'on mets dans le fichier "recettes" de data (base de donnée ?)
                $recetteCurrent = $recette;
            }
        }

        return $recetteCurrent;
    }


}