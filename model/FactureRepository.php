<?php
/**
 * ETML
 * Auteur : Cindy Hardegger
 * Date: 22.01.2019
 * Recueil des méthodes permettant de charger les données pour les clients
 */

include_once 'Entity.php';

class FactureRepository implements Entity {

    /**
     * Récupérer tous les clients
     *
     * @return array
     */
    public function findAll() {

        include './data/invoices.php';

        return $invoices;
    }

    /**
     * Find One entry
     *
     * @param $idProduct
     *
     * @return array
     */
    public function findOne($idInvoice) {

        include './data/invoices.php';
        
        $factureCurrent = array();

        // Boucler sur tous les clients et sélectionner seulement celui que l'on veut afficher
        foreach($invoices as $facture) {

            if($invoices['idInvoice'] == $idInvoice){
                $factureCurrent = $facture;
            }
        }

        return $factureCurrent;
    }


}