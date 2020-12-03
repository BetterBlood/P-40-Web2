<h2>Liste des Recettes</h2>
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
		$startIndex = 0;
		if (array_key_exists("start", $_GET))
		{
			$startIndex = $_GET["start"];
		}

		foreach ($recipes as $recipe) {
			echo '<tr>';
				echo '<td>' . htmlspecialchars($recipe['recName']) . '</td>';
				echo '<td>' . htmlspecialchars($recipe['recPrepTime']) . ' minutes</td>';
				echo '<td>' . htmlspecialchars($recipe['recDifficulty']) . '</td>';
				echo '<td>' . htmlspecialchars($recipe['recNote']) . '</td>';
				echo '<td>' . htmlspecialchars($recipe['idUser']) . ', ' .  '</td>';
				echo '<td><a href="index.php?controller=recipe&action=list&id=' . htmlspecialchars($recipe['idRecipe']) . '&start=' . $startIndex . '"><img src="resources/image/icone/iconLoupe.png" alt="loupe"></a></td>';
			echo '</tr>';

			if (array_key_exists("id", $_GET) && htmlspecialchars($_GET["id"]) == htmlspecialchars($recipe['idRecipe']))
			{
				$user = $database->getOneUserById($recipe["idUser"]);

				echo '<tr>';
					$imageLink = '"resources/image/Recipes/' . htmlspecialchars($recipe['recImage']) . '"';
					//echo '<td COLSPAN="5"><img class="d-block w-50" src=' . $imageLink . ' alt="image d\'illustration de la recette"></td>';
					echo '<td COLSPAN="4">';
						echo '<div class="card" style="width: 35rem;">';
							echo '<img src=' . $imageLink . ' class="card-img-top d-block w-100" alt="image de profile du créateur de la recette">';
							echo '<div class="card-body" style="color:black">';
								echo '<h5 class="card-title">Description :</h5>';
								echo '<p class="card-text">' . $recipe["recDescription"] . '</p>';
								echo '<a href="#" class="btn btn-primary">Voir la recette</a>';
							echo '</div>';
						echo '</div>';
					echo '</td>';
					//echo htmlspecialchars($recipe['recImage']);

					echo '<td>';
						echo '<div class="card" style="width: 18rem;">';
							echo '<div class="card-body" style="color:black">';
								echo '<h4 class="card-title">informations</h4>';

								echo '<p class="card-text"> note : ' . $recipe["recNote"] . '  '; // TODO : ptetre mettre un dessin pour la note
								echo '<a href="#" class="btn btn-success">Noter la recette</a>' . '</p>';

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


					$imageProfilLink = '"resources/image/Users/' . htmlspecialchars($user['useImage']) . '"';
					//echo '<img class="d-block w-50" src=' . $imageProfilLink . ' alt="image de profile du créateur de la recette">';
				
					echo '<td style="width:100px">';
						echo '<div class="card" style="width: 18rem;">';
							echo '<img src=' . $imageProfilLink . ' class="card-img-top" alt="image de profile du créateur de la recette">';
							echo '<div class="card-body" style="color:black">';
								echo '<h5 class="card-title">' . $user["usePseudo"] . '</h5>';
								echo '<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>';
								echo '<a href="#" class="btn btn-warning">Voir l\'auteur</a>';
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
	
	<div class="justify-content-right numPage" aria-label="Page navigation" id="numPage"> <!-- cette div contient la pagination des recettes-->
		<ul class="pagination justify-content-center">
			<li class="page-item">
			<a class="page-link" href="index.php?controller=recipe&action=list&start=0" aria-label="Previous">
				<span aria-hidden="true">&laquo;</span>
			</a>
			</li>
			<li><a class="page-link" <?php echo 'href="index.php?controller=recipe&action=list&start=' . $realStartIndex . '"';?>><span aria-hidden="true"><</span></a></li>

			<?php
				if (array_key_exists("recipesNumber", $_SESSION))
				{
					if ($recipesNumber <= $lengthRecipe) // s'il n'y a qu'une seule page a afficher
					{
						echo '<li class="page-item active"><a class="page-link" href="#">' . '1' . '</a></li>';
					}
					else if ($recipesNumber <= 2*$lengthRecipe)
					{
						if ($startIndex < $lengthRecipe)
						{
							echo '<li class="page-item active"><a class="page-link" href="#">' . '1' . '</a></li>';
							echo '<li class="page-item"><a class="page-link" href="index.php?controller=recipe&action=list&start=' . ($startIndex + $lengthRecipe) . '">' . '2' . '</a></li>';
						}
						else
						{
							echo '<li class="page-item"><a class="page-link" href="index.php?controller=recipe&action=list&start=0">' . '1' . '</a></li>';
							echo '<li class="page-item active"><a class="page-link" href="#">' . '2' . '</a></li>';
						}
					}
					else
					{
						if ($startIndex < $lengthRecipe) // première et deuxieme page
						{
							echo '<li class="page-item active"><a class="page-link" href="#">' . '1' . '</a></li>';
							echo '<li class="page-item"><a class="page-link" href="index.php?controller=recipe&action=list&start=' . ($startIndex + $lengthRecipe) . '">' . '2' . '</a></li>';
						}
						else if ($startIndex >= $recipesNumber - $lengthRecipe) // dernière et avant dernière page
						{
							echo '<li class="page-item"><a class="page-link" href="index.php?controller=recipe&action=list&start=' . ($startIndex - $lengthRecipe) . '">' . (int)(($realStartIndex/$lengthRecipe) + 1) . '</a></li>';
							echo '<li class="page-item active"><a class="page-link" href="#">' . (int)(($realStartIndex/$lengthRecipe) + 2) . '</a></li>';
						}
						else
						{
							echo '<li class="page-item"><a class="page-link" href="index.php?controller=recipe&action=list&start=' . $realStartIndex . '">' . ($realStartIndex/$lengthRecipe + 1) . '</a></li>';
							echo '<li class="page-item active"><a class="page-link" href="#">' . ($realStartIndex/$lengthRecipe + 2) . '</a></li>';
							echo '<li class="page-item"><a class="page-link" href="index.php?controller=recipe&action=list&start=' . ($startIndex + $lengthRecipe) . '">' . ($realStartIndex/$lengthRecipe + 3) . '</a></li>';
						}
					}
				}
				else
				{
					if ($realStartIndex <= $lengthRecipe)
					{
						echo '<li class="page-item active"><a class="page-link" href="#">' . '1' . '</a></li>';
						echo '<li class="page-item"><a class="page-link" href="index.php?controller=recipe&action=list&start=' . ($startIndex + $lengthRecipe) . '">' . '2' . '</a></li>';
					}
					else
					{
						echo '<li class="page-item"><a class="page-link" href="index.php?controller=recipe&action=list&start=' . $realStartIndex . '">' . ($realStartIndex/$lengthRecipe + 1) . '</a></li>';
						echo '<li class="page-item active"><a class="page-link" href="#">' . ($realStartIndex/$lengthRecipe + 2) . '</a></li>';
						echo '<li class="page-item"><a class="page-link" href="index.php?controller=recipe&action=list&start=' . ($startIndex + $lengthRecipe) . '">' . ($realStartIndex/$lengthRecipe + 3) . '</a></li>';
					}
				}
			?>


			<li><a class="page-link" <?php echo 'href="index.php?controller=recipe&action=list&start=' . ($startIndex + $lengthRecipe) . '"';?>><span aria-hidden="true">></span></a></li>
			<li class="page-item">
				<?php
				echo '<a class="page-link" href="index.php?controller=recipe&action=list&start=' . PHP_INT_MAX . '" aria-label="Next">'; // (int)(($recipesNumber / $lengthRecipe) + $lengthRecipe + 1) 
				?>
				<span aria-hidden="true">&raquo;</span>
			</a>
			</li>
		</ul>
	</div>
</div>
