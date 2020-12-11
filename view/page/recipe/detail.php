<div class="container">

	<h2>
		<?php
			// redirection si la recette n'existe pas
			if (isset($recipe))
			{
				echo $recipe['recName'];
			}
			else 
			{
				header("Location: index.php?controller=recipe&action=list");
			}
		?>
	</h2>

	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-white">
			<?php
				$imageLink = '"resources/image/Recipes/' . htmlspecialchars($recipe['recImage']) . '"';
				echo '<img class="d-block w-100" src=' . $imageLink . ' alt="image d\'illustration de la recette">';
			?>
			<img src="" alt="">
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-white">
			
			<?php
			echo '<p>Description : ' . $recipe['recDescription'] . '</p>';

			echo '<div>';
			if (isset($recipe["recNote"]))
			{
				echo '<p>Note : ' . $recipe['recNote'] . '</p>';
			}
			else
			{
				echo '<p>Note : Il n\'y a aucune note disponible pour le moment</p>'; 
			}
			?>

			<button class="btn btn-success">évaluer la recette</button></div>

			<?php
			

			echo '<p>Préparation :</p>';
			$preparationSteps = preg_split('/(,)/u', $recipe["recPreparation"]);
			foreach ($preparationSteps as $prep)
			{
				echo '♦ ' . $prep . '<br>';
			}
			
			echo '<br>';

			echo '<p>Ingrédients :</p>';
			$ingredients = preg_split('/(,)/u', $recipe["recIngredientList"]);
			foreach ($ingredients as $ingredient)
			{
				echo '- ' . $ingredient . '<br>';
			}

			?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-white">
			<p>Profil :</p>







		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="text-white">
				<p>Commentaires d'évaluation : </p>
			</div>
			
			<a href="index.php?controller=recipe&action=list&id=<?php echo $recipe["idRecipe"]; //. '&start=';// ptetre retrouver le start index de l'image ?>">Retour à la liste des recettes</a>
		</div>
	</div>
</div>