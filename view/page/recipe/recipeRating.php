
<div class="container">
    <?php
        if(array_key_exists("id", $_GET))
        {
            if ($_GET["id"] != -1)
            {
                echo '<div class="text-white">merci pour votre participation</div>';
                echo '<a href="index.php?controller=recipe&action=detail&id=' . $_GET["id"] . '">retour à la recette</a>';
            }
            else
            {
                echo "une erreur est survenue";
                echo '<a href="index.php?controller=recipe&action=list">retour à la liste des recettes</a>';
            }
        }
        else
        {
            echo "une erreur est survenue";
            echo '<a href="index.php?controller=recipe&action=list">retour à la liste des recettes</a>';
        }
    ?>
</div>