
<div class="container">
<?php

if(array_key_exists("id", $_GET))
{
    if ($_GET["id"] != -1)
    {
        echo '<div class="text-white">merci pour votre participation</div>';
    }
    else
    {
        echo "une erreur est survenue";
    }
}
else
{
    echo "une erreur est survenue";
}

?>
<a href="index.php?controller=recipe&action=list">retour a la liste des recettes</a>
</div>