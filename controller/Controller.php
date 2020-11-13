<?php
/**
 * Auteur : Cindy Hardegger
 * Date: 22.01.2019
 * Contrôleur principal
 */

abstract class Controller {

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

    // méthode d'acces a la base de donné ?
    /**
     * méthode permettant d'accèder a la base de donné
     *
     * @param bool $fullTable
     * @param integer $id
     * @param string $input
     * @param integer $indexStart
     * @param integer $numberOfElement
     * @return void
     */
    public function DBGetRectettes($fullTable, $id = 0, $indexStart = 0, $numberOfElement = 5)
    {
        $result = ""; // TODO : modifier le type de resulte (je pense un tableau)

        try
        {
            $connector = new PDO('mysql:host=localhost;dbname=db_web2;charset=utf8', 'root', 'root'); //connection // TODO : modifier le login et password !!!

            if ($fullTable)
            {
                $req = $connector->query('SELECT * FROM t_recettes'); // get la table en entier // TODO : revoir le nom de la table ptetre pas la bonne

                // ptetre ici : (pas sur)
                //$req = $connector->prepare('SELECT * FROM Table WHERE id = :varId'); // TODO :(voir pour ptetre mettre ailleurs) LIMIT indexStart = :varIndSta, numberOfElement = :varNum'
            }
            else
            {
                $req = $connector->prepare('SELECT * FROM Table WHERE id = :varId'); // TODO :(voir pour ptetre mettre ailleurs) LIMIT indexStart = :varIndSta, numberOfElement = :varNum'

                $req->bindValue('varId', $id, PDO::PARAM_INT);
                //$req->bindValue('varIndSta', $indexStart, PDO::PARAM_INT);
                //$req->execute('varNum', $numberOfElement, PDO::PARAM_INT);
            }

            $result = $req->fetchALL(PDO::FETCH_ASSOC);

            //$req->closeCursor(); // je sais pas s'il faut le mettre ici ou dans le finally (genre s'il y a une erreur)
            
        }
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
        finally
        {
            $req->closeCursor();
            $connector = null;
            unset($connector);
        }

        return $result;
    }
    
}