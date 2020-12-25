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

                    if (isset($_POST) && !empty($_POST))
                    {
                        echo '<p>modifications efféctuées </p>'; // DEBUG
                        //sleep (3); // mmmm bof ptetre faire une page à part si on veut que cela s'affiche qu'une foi
                        //var_dump($_POST); // DEBUG
                    }
                }
			}
			else 
			{
				header("Location: index.php?controller=user&action=loginForm");
			}
			
		?>
    </h2>
    
    <div class="text-white">

        <?php
        echo '<form action="index.php?controller=user&action=profile&id=' . $userProfile["idUser"] . '" method="post" enctype="multipart/form-data">';
            ?>
            <input type="text" id="fileUpdate" name="fileUpdate" style="display: none;" value="true">
            <div class="form-group">
                <p>
                    <label for="image">Fichier à télécharger</label>
                    <input type="file" name="image" id="image" />
                    <input class="btn btn-info mb-2" type="submit" value="Envoyer" />
                </p>
            </div>
        </form>

        <?php
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

        <div class="form-row" style="height: fit-content">
            <div class="form-group col-md-4 mb-3">
                <label for="usePassword">usePassword</label>
                <?php
                    echo '<input type="password" class="form-control" name="usePassword" id="usePassword" placeholder="' . $userProfile["usePassword"] . '" ' . 'value="' . $userProfile["usePassword"] . '" ';
                    if (!$selfPage)
                    {
                        echo 'disabled="disabled"';
                    }
                    echo '>';
                ?>
            </div>

            <div class="form-group col-md-4 mb-3">
                <label for="confirmePassword">confirmePassword</label>
                <?php
                    echo '<input type="password" class="form-control" name="confirmePassword" id="confirmePassword" placeholder="' . $userProfile["usePassword"] . '" ' . 'value="' . $userProfile["usePassword"] . '" ';
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
                <label for="useFirstname">useFirstname</label>
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
                <label for="useName">useName</label>
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