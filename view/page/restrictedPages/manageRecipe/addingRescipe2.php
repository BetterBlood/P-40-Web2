<?php
    if (!array_key_exists("isConnected", $_SESSION) || !$_SESSION["isConnected"])
    {
        header("Location: index.php?controller=user&action=loginForm");
    }
?>

<div class="text-white">
    <h2>Page de modification de recette</h2>

    <form action="index.php?controller=recipe&action=editRecipe" method="post">



    </form>

</div>