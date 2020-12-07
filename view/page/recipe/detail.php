<div class="container">

	<h2 >
		<?php
			echo $recipe['recName'];
		?>
	</h2>
	<!-- Three columns of text below the carousel -->
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-white">
		<?php
			echo '<p>Description : ' . $recipe['recDescription'] . '</p>';
			echo '<p>Note : ' . $recipe['recNote'] . '</p>';

		?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<a href="index.php?controller=recipe&action=list&id=<?php echo $recipe["idRecipe"]; //. '&start=';// ptetre retrouver le start index de l'image ?>">Retour à la liste des recettes</a>
		</div>
	</div>
</div>