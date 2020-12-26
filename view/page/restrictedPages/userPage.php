<div class="container">

	<h2>
		<?php
			// redirection si l'utilisateur n'existe pas
			if (array_key_exists("isConnected", $_SESSION) && $_SESSION["isConnected"] && array_key_exists("usePseudo", $userProfile))
			{
                echo 'Page de profile de : ' . $userProfile['usePseudo'];

                if (isset($selfPage) && $selfPage) 
                {
                    echo '<p>DEBUG accès en modification ! </p>'; // DEBUG

                    if (isset($modificationDone) && $modificationDone)
                    {
                        echo '<p>modifications efféctuées </p>'; // DEBUG
                        //sleep (3); // mmmm bof ptetre faire une page à part si on veut que cela s'affiche qu'une foi
                        //var_dump($_POST); // DEBUG
                    }
                }
                $imageProfilLink = '"resources/image/Users/' . htmlspecialchars($userProfile['useImage']) . '"';
			}
			else 
			{
				header("Location: index.php?controller=user&action=loginForm");
			}
			
		?>
    </h2>
    
    <div class="text-white">
        <?php
        echo '<img style="width:100px;" src=' . $imageProfilLink . ' alt="image de profile">';
        
        if (isset($selfPage) && $selfPage)
        {

        
        echo '<form action="index.php?controller=user&action=profile&id=' . $userProfile["idUser"] . '" method="post" enctype="multipart/form-data">';
            ?>
            <input type="text" id="fileUpdate" name="fileUpdate" style="display: none;" value="true">
            <div class="form-group">
                <p>
                    <label for="image">Fichier à télécharger</label>
                    <input type="file" name="image" id="image" />
                    <input class="btn btn-primary mb-2" type="submit" value="Modifier" />
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
        <div class="modal fade" id="modifPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modifier le Mot de Passe</h5>
                        
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <?php

                        echo '<form action="index.php?controller=user&action=profile&id=' . $userProfile["idUser"] . '" method="POST">';
                        ?>
                        <input type="text" id="modifPassword" name="modifPassword" style="display: none;" value="true">
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
                echo '<form action="index.php?controller=user&action=profile&id=' . $userProfile["idUser"] . '" method="post">';
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