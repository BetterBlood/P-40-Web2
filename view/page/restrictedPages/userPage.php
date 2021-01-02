<div class="container">

	<h2>
		<?php
			// redirection si l'utilisateur n'existe pas
			if (array_key_exists("isConnected", $_SESSION) && $_SESSION["isConnected"] && array_key_exists("usePseudo", $userProfile))
			{
                echo 'Page de profile de : ' . $userProfile['usePseudo'];
                $imageProfilLink = '"resources/image/Users/' . htmlspecialchars($userProfile['useImage']) . '"';
			}
			else 
			{
				header("Location: index.php?controller=user&action=loginForm");
			}
			
		?>
    </h2>

    <?php
        if (array_key_exists("isConnected", $_SESSION) && $_SESSION["isConnected"] && array_key_exists("usePseudo", $userProfile) && isset($selfPage) && $selfPage) 
        {
            //echo '<p class="text-white">DEBUG accès en modification ! </p>'; // DEBUG

            if (isset($modificationDone) && $modificationDone)
            {
                echo '<p class="text-white">modifications efféctuées </p>'; // DEBUG
                //sleep (3); // mmmm bof ptetre faire une page à part si on veut que cela s'affiche qu'une foi
                //var_dump($_POST); // DEBUG
            }
        }
        
    ?>
    
    <div class="text-white">
        <?php
        echo '<img style="width:100px;" src=' . $imageProfilLink . ' alt="image de profile">';
        
        if (isset($selfPage) && $selfPage)
        {

        echo '<form action="index.php?controller=user&action=profile&idUser=' . $userProfile["idUser"] . '" method="post" enctype="multipart/form-data">';
            ?>
            <input type="text" id="fileUpdate" name="fileUpdate" style="display: none;" value="true">
            <div class="form-group">
                <p>
                    <label for="image">Fichier à télécharger</label>
                    <input type="file" name="image" id="image" />
                    <input class="btn btn-primary mb-2" type="submit" value="Modifier" />
                    <?php
                    if (isset($imageEmpty) && $imageEmpty)
                    {
                        echo 'l\'image séléctionnée n\'est pas valide';
                    }
                    ?>
                </p>
            </div>
        </form>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-info" style="height: fit-content" data-toggle="modal" data-target="#modifPassword">modifier le mot de passe</button>
        
        <?php 
            if (isset($passwordModifFailed) && $passwordModifFailed)
            {
                ?>
                    <p>un problème est surevenu lors de la modification du mot de passe</p>
                <?php
            }
        ?>
            <!-- Modal -->
        <div class="modal fade" id="modifPassword" tabindex="-1" role="dialog" aria-labelledby="modifPasswordForm" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modifier le Mot de Passe</h5>
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <?php

                        echo '<form action="index.php?controller=user&action=profile&idUser=' . $userProfile["idUser"] . '" method="POST">';
                        ?>
                        <input type="text" id="modifPasswordForm" name="modifPasswordForm" style="display: none;" value="true">
                        <div class="modal-body">
                            
                            <div class="form-group col-md-4 mb-3 pt-n2 pb-n2">
                                <label for="usePassword">mot de passe</label>
                                <?php
                                    echo '<input type="password" class="form-control" name="usePassword" id="usePassword" placeholder="Amanda17" ' . 'value="" ';
                                    if (!$selfPage)
                                    {
                                        echo 'disabled="disabled"';
                                    }
                                    echo '>';
                                ?>
                            </div>

                            <div class="form-group col-md-4 mb-3">
                                <label for="confirmePassword">confirmation</label>
                                <?php
                                    echo '<input type="password" class="form-control" name="confirmePassword" id="confirmePassword" placeholder="Amanda17" ' . 'value="" ';
                                    if (!$selfPage)
                                    {
                                        echo 'disabled="disabled"';
                                    }
                                    echo '>';
                                ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Abandonner</button>
                            <button type="submit" class="btn btn-success">Enregistrer le mot de passe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        }
            if (isset($selfPage) && $selfPage)
            {
                echo '<form action="index.php?controller=user&action=profile&idUser=' . $userProfile["idUser"] . '" method="post">';
            }
        ?>

        <div class="form-row" style="height: fit-content">
            <div class="form-group col-md-4 mb-3">
                <label for="pseudo">Pseudo</label>
                <?php
                    echo '<input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="' . $userProfile["usePseudo"] . '" ' . 'value="' . $userProfile["usePseudo"] . '" ';
                    if (!$selfPage)
                    {
                        echo 'disabled="disabled"';
                    }
                    echo '>';
                ?>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label for="useFirstname">Prénom</label>
                <?php
                    echo '<input type="text" class="form-control" name="useFirstname" id="useFirstname" placeholder="' . $userProfile["useFirstname"] . '" ' . 'value="' . $userProfile["useFirstname"] . '" ';
                    if (!$selfPage)
                    {
                        echo 'disabled="disabled"';
                    }
                    echo '>';
                ?>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label for="useName">Nom</label>
                <?php
                    echo '<input type="text" class="form-control" name="useName" id="useName" placeholder="' . $userProfile["useName"] . '" ' . 'value="' . $userProfile["useName"] . '" ';
                    if (!$selfPage)
                    {
                        echo 'disabled="disabled"';
                    }
                    echo '>';
                ?>
            </div>
            
        </div>


        <div class="form-row" style="height: fit-content">
            
            <div class="form-group col-md-4 mb-3">
                <label for="mail">Mail</label>
                <?php
                    echo '<input type="email" class="form-control" name="mail" id="mail" placeholder="' . $userProfile["useMail"] . '" ' . 'value="' . $userProfile["useMail"] . '" ';
                    if (!$selfPage)
                    {
                        echo 'disabled="disabled"';
                    }
                    echo '>';

                ?>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label for="phone">Téléphone</label>
                <?php
                    echo '<input type="tel" class="form-control" name="phone" id="phone" placeholder="' . $userProfile["useTelephone"] . '" ' . 'value="' . $userProfile["useTelephone"] . '" ';
                    if (!$selfPage)
                    {
                        echo 'disabled="disabled"';
                    }
                    echo '>';
                ?>
            </div>

        </div>

        <?php
            if (isset($selfPage) && $selfPage)
            {
                ?>
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary mb-2">Enregistrer les modifications</button>
                </div>

                <?php
                echo '</form>';
            }

        ?>
    </div>

    <div class="d-flex">
        <div>
            <h2>Liste des Recettes de l'utilisateur</h2>
        </div>
        
        <div class="ml-auto mb-2">
            <?php
                if(isset($_SESSION['isConnected']) && $_SESSION["isConnected"] && isset($selfPage) && $selfPage)
                {
                    ?>
                        <a class="btn btn-success" href="index.php?controller=recipe&action=addRecipe">ajouter une recette</a>
                    <?php
                }
            ?>
        </div>
    </div>

    <div class="row">
        <table class="table table-striped table-dark">
        <tr>
            <th>nom</th> <!-- TODO : voir pour ajouter le bootstrap-->
            <th>temps de préparation</th>
            <th>difficulté</th>
            <th>note</th>
            <th>auteur</th>
            <th>détail</th>
        </tr>
        <?php
        // pour le tableau : "table table-striped"
            // Affichage de chaque client
            
            //var_dump($_SESSION);
            $startIndex = 0;
            if (array_key_exists("start", $_GET))
            {
                $startIndex = $_GET["start"];
            }

            foreach ($recipes as $recipe) {
                $user = $database->getOneUserById($recipe["idUser"]);

                echo '<tr>';
                    echo '<td>' . htmlspecialchars($recipe['recName']) . '</td>';
                    echo '<td>' . htmlspecialchars($recipe['recPrepTime']) . ' minutes</td>';
                    echo '<td>' . htmlspecialchars($recipe['recDifficulty']) . '</td>';
                    if (isset($recipe["recGrade"]))
                    {
                        echo '<td>' . htmlspecialchars($recipe['recGrade']) . '</td>';
                    }
                    else
                    {
                        echo '<td>pas encore notée</td>';
                    }
                    echo '<td>' . $user["usePseudo"] . '</td>';

                    if (array_key_exists("id", $_GET) && $_GET["id"] == $recipe["idRecipe"]) // affiche/masque les détail d'une recette
                    {
                        echo '<td><a href="index.php?controller=user&action=profile&idUser=' . $recipe["idUser"] . '&start=' . $startIndex . '"><img src="resources/image/icone/iconLoupe.png" alt="loupe" style="transform: scaleX(-1)";></a>';
                        if (isset($selfPage) && $selfPage)
                        {
                            echo '<a href="index.php?controller=recipe&action=editRecipe&id=' . htmlspecialchars($recipe['idRecipe']) . '"><img src="resources/image/icone/iconPencil.png" alt="crayon"</a>';
                        }
                        echo '</td>';
                    
                    }
                    else 
                    {
                        echo '<td><a href="index.php?controller=user&action=profile&idUser=' . $recipe["idUser"] . '&id=' . htmlspecialchars($recipe['idRecipe']) . '&start=' . $startIndex . '"><img src="resources/image/icone/iconLoupe.png" alt="loupe"></a>';
                        if (isset($selfPage) && $selfPage)
                        {
                            echo '<a href="index.php?controller=recipe&action=editRecipe&id=' . htmlspecialchars($recipe['idRecipe']) . '"><img src="resources/image/icone/iconPencil.png" alt="crayon"></a>';
                        }
                        echo '</td>';
                    }

                echo '</tr>';

                if (array_key_exists("id", $_GET) && htmlspecialchars($_GET["id"]) == htmlspecialchars($recipe['idRecipe'])) // les premiers détails de la recette sont divisé en 3 parties
                {
                    echo '<tr>';

                        // première partie : concerne la recette elle-même
                        $imageLink = '"resources/image/Recipes/' . htmlspecialchars($recipe['recImage']) . '"';
                        echo '<td COLSPAN="4">';
                            echo '<div class="card" style="width: 35rem;">';
                                echo '<img src=' . $imageLink . ' class="card-img-top d-block w-100" alt="image de profile du créateur de la recette">';
                                echo '<div class="card-body" style="color:black">';
                                    echo '<h5 class="card-title">Description :</h5>';
                                    echo '<p class="card-text">' . $recipe["recDescription"] . '</p>';

                                    if (array_key_exists("isConnected", $_SESSION) && $_SESSION["isConnected"])
                                    {
                                        echo '<a href="index.php?controller=recipe&action=detail&id=' . htmlspecialchars($recipe['idRecipe']) . '" class="btn btn-primary">Voir la recette</a>';
                                    }
                                    else
                                    {
                                        echo '<a href="index.php?controller=user&action=loginForm" class="btn btn-primary">Voir la recette</a>';

                                    }

                                echo '</div>';
                            echo '</div>';
                        echo '</td>';
                        //echo htmlspecialchars($recipe['recImage']);

                        // seconde partie : les information secondaire de la recette (avec la note la difficultée et le temps de préparation)
                        echo '<td>';
                            echo '<div class="card" style="width: 18rem;">';
                                echo '<div class="card-body" style="color:black">';
                                    echo '<h4 class="card-title">informations</h4>';

                                    echo '<p class="card-text"> note : ' . $recipe["recGrade"] . '  ';
                                    if (array_key_exists("isConnected", $_SESSION) && $_SESSION["isConnected"])
                                    {
                                        echo '<a href="index.php?controller=recipe&action=detail&id=' . htmlspecialchars($recipe['idRecipe']) . '" class="btn btn-success">Noter la recette</a>' . '</p>';
                                    }
                                    else
                                    {
                                        echo '<a href="index.php?controller=user&action=loginForm" class="btn btn-success">Login ?</a>';

                                    }

                                    echo '<p class="card-text"> difficulté : ' . $recipe["recDifficulty"] . '</p>';

                                    echo '<p class="card-text"> durrée de préparation :';
                                    echo '<br>' . $recipe["recPrepTime"] . ' minutes</p>';

                                    echo '<h5 class="card-title">liste d\'ingrédients :</h5>';

                                    echo '<p class="card-text">'; // affichage des ingrédients
                                    $ingredients = preg_split('/(,)/u', $recipe["recIngredientList"]);
                                    foreach ($ingredients as $ingredient)
                                    {
                                        echo '- ' . $ingredient . '<br>';
                                    }
                                    echo '</p>';
                                echo '</div>';
                            echo '</div>';


                            //echo $user["usePseudo"];
                            //var_dump($user);
                        echo '</td>';


                        // troisième partie : contient les premières informations du l'utilisateur
                        $imageProfilLink = '"resources/image/Users/' . htmlspecialchars($user['useImage']) . '"';
                        //echo '<img class="d-block w-50" src=' . $imageProfilLink . ' alt="image de profile du créateur de la recette">';
                    
                        echo '<td style="width:100px">';
                            echo '<div class="card" style="width: 18rem;">';
                                echo '<img src=' . $imageProfilLink . ' class="card-img-top" alt="image de profile du créateur de la recette">';
                                echo '<div class="card-body" style="color:black">';
                                    echo '<h5 class="card-title">' . $user["usePseudo"] . '</h5>';
                                    echo '<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>';
                                    if (array_key_exists("isConnected", $_SESSION) && $_SESSION["isConnected"])
                                    {
                                        echo '<a href="index.php?controller=user&action=profile&idUser=' . $user["idUser"] .  '" class="btn btn-warning">Voir l\'auteur</a>'; // TODO : lier a la page du créateur de la recette
                                    }
                                    else 
                                    {
                                        echo '<a href="index.php?controller=user&action=loginForm" class="btn btn-warning">Login ?</a>';
                                    }
                                    
                                echo '</div>';
                            echo '</div>';


                            //echo $user["usePseudo"];
                            //var_dump($user);
                        echo '</td>';
                    echo '</tr>';
                }
            }

            $realStartIndex = 0;
            $lengthRecipe = 5;
            $recipesNumber = 8;

            if (array_key_exists("recipesPerPage", $_SESSION))
            {
                $lengthRecipe = $_SESSION["recipesPerPage"];
            }

            if (array_key_exists("recipesNumber", $_SESSION))
            {
                $recipesNumber = $_SESSION["recipesNumber"];
            }

            if ($startIndex - $lengthRecipe < 0)
            {
                $realStartIndex = 0;
            }
            else
            {
                $realStartIndex = $startIndex - $lengthRecipe;
            }
        ?>
        
        </table>

        
    </div>
