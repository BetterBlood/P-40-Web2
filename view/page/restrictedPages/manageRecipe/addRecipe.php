






<?php
    if (!array_key_exists("isConnected", $_SESSION) || !$_SESSION["isConnected"])
    {
        header("Location: index.php?controller=user&action=loginForm");
    }
    else if (!isset($recipe))
    {
        $recipe = array();
        $recipe["recName"] = "";
        $recipe["recPrepTime"] = "";
        $recipe["recDifficulty"] = "";
        $recipe["recDescription"] = "";
        $recipe["recIngredientList"] = "";
        $recipe["recPreparation"] = "";
    }

    if (isset($firstPart) && $firstPart)
    {
?>

<div class="text-white">
    <h2>Page d'ajout de recette : partie 1</h2>

    <form action="index.php?controller=recipe&action=addRecipe" method="post">
        <!-- je pense qu'on va faire pointer dirrectement vers la page de modification en métant un champs spécifique dans le form pour dire qu'on vient en création -->

        <input type="text" id="recipeCreation1" name="recipeCreation1" style="display: none;" value="true">

        <div class="form-row">
            <div class="col-md-4 mb-3 pt-n2 pb-n2">
                <label for="recName">Nom de la recette</label>
                <?php
                    echo '<input type="text" class="form-control" name="recName" id="recName" placeholder="Paté de cornichon en croute" value="' . $recipe["recName"] . '">';
                ?>
            </div>

            <div class="form-row col-md-4 mb-3 pt-n2 pb-n2">
                <div class="mx-auto">
                    <label for="recPrepTime">Temps de préparation</label>
                    <?php
                        echo '<input type="number" class="form-control" style="width:fit-content;" name="recPrepTime" id="recPrepTime" placeholder="[minutes]" min="10" value="' . $recipe["recPrepTime"] . '">';
                    ?>
                </div>

                <div class="mx-auto">
                    <label for="recDifficulty">Difficultée</label>
                    <?php
                        echo '<input type="number" class="form-control" style="width:fit-content;" name="recDifficulty" id="recDifficulty" placeholder="2" min="1" max="5" value="' . $recipe["recDifficulty"] . '">';
                    ?>
                </div>
            </div>
        </div>
        
        <label for="recDescription">Description</label>
        <?php
            echo '<textarea type="text" class="form-control" name="recDescription" id="recDescription" rows="4" cols="50" placeholder="Sublimé de cornichons fraichement ceuillit sur un lit de cornichons légérement remonté pour une finission des plus invraissemblable">' . $recipe["recDescription"] . '</textarea>';
        ?>
        
        <div class="d-flex">
            <div class="mx-auto mt-3 mb-3">
                <input class="btn btn-primary" type="submit" value="valider cette étape">
            </div>
        </div>
    
    </form>
</div>

<?php
    }
    else
    {
       
?>

<div class="text-white">
    <h2>Page d'ajout de recette : partie 2</h2>
    <form action="">
        
        <div class="form-row mt-2">
            <input type="text" id="numberOfIngredients" value="1" style="display: none;">
            
            <div class="col-md-5 mb-3 pt-n2 pb-n2 pl-2">
                
                <label>Liste d'ingrédients</label>
                <input class="btn btn-info mb-2 ml-5" type="button" value="ajouter un ingrédient" onclick="addIngredient();"> 
                
                <div id="ingredients">
                    <div class="form-row">
                        <?php
                            echo '<input type="number" class="form-control col-md-2 mb-3 ml-auto mr-1 pt-n2 pb-n2" name="nbrIngredient1" placeholder="2" min="1" value="1">';
                            echo '<input type="text" class="form-control col-md-9 mb-3 mr-auto pt-n2 pb-n2" name="ingredient1" placeholder="cornichon">';
                        ?>
                    </div>
                </div>

            </div>

            <input type="text" id="numberOfstep" value="1" style="display: none;">

            <div class="col-md-7 mb-3 pt-n2 pb-n2 pl-2">

                <label>Étape de préparation</label>
                <input class="btn btn-info mb-2 ml-5" type="button" value="ajouter une étape" onclick="addStep();"> 

                <div id="preparationStep">
                    <div class="form-row">
                        <?php
                            echo '<label class="mt-1" >1 -</label>';
                            echo '<input type="text" class="form-control col-md-9 mb-3 mr-auto pt-n2 pb-n2" name="step1" placeholder="couper les cornichons en fines lamelles">';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>  
    
</div>

<?php
    }
       
?>