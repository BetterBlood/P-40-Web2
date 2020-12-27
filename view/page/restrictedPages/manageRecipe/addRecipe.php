






<?php
    if (!array_key_exists("isConnected", $_SESSION) || !$_SESSION["isConnected"])
    {
        header("Location: index.php?controller=user&action=loginForm");
    }
?>

<div class="text-white">
    <h2>Page d'ajout de recette</h2>
    <p>coucou</p>

    <form action="index.php?controller=recipe&action=editRecipe" method="post">
        <!-- je pense qu'on va faire pointer dirrectement vers la page de modification en métant un champs spécifique dans le form pour dire qu'on vient en création -->



    </form>

</div>