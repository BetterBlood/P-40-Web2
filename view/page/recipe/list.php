<div class="d-flex">
	<div>
		<h2>Liste des Recettes</h2>
	</div>
	
	<div class="ml-auto mb-2">
		<?php
			if(isset($_SESSION['isConnected']) && $_SESSION["isConnected"])
			{
				?>
					<a class="btn btn-success" href="index.php?controller=recipe&action=addRecipe">ajouter une recette</a>
				<?php
			}
		?>
	</div>
</div>
<div class="row">
	<table class="table table-striped table-dark">
	<tr>
		<th>nom</th>
		<th>catégorie</th>
		<th>temps de préparation</th>
		<th>difficulté</th>
		<th>note</th>
		<th class="text-center">auteur</th>
		<th class="text-center">détail</th>
	</tr>
	<?php
	// pour le tableau : "table table-striped"
		// Affichage de chaque client
		
		//var_dump($_SESSION);
		$startIndex = 0;
		if (array_key_exists("start", $_GET))
		{
			$startIndex = $_GET["start"];
		}

		foreach ($recipes as $recipe) {
			$user = $database->getOneUserById($recipe["idUser"]);

			echo '<tr>';
				echo '<td><a class="text-white" href="index.php?controller=recipe&action=detail&id=' . htmlspecialchars($recipe['idRecipe']) . '">' . htmlspecialchars($recipe['recName']) . '</a></td>';
				echo '<td>' . htmlspecialchars($recipe['recCategory']) . '</td>';
				echo '<td>' . htmlspecialchars($recipe['recPrepTime']) . ' minutes</td>';
				echo '<td>' . htmlspecialchars($recipe['recDifficulty']) . '</td>';
				if (isset($recipe["recGrade"]))
				{
					echo '<td>' . htmlspecialchars($recipe['recGrade']) . '</td>';
				}
				else
				{
					echo '<td>pas encore notée</td>';
				}
				echo '<td class="text-center">' . $user["usePseudo"] . '</td>';

				if (array_key_exists("id", $_GET) && $_GET["id"] == $recipe["idRecipe"]) // affiche/masque les détail d'une recette
				{
					echo '<td><a href="index.php?controller=recipe&action=list&start=' . $startIndex . '"><div class="bg-iconLoupe-reverse"></div></a></td>';
				}
				else 
				{
					echo '<td><a href="index.php?controller=recipe&action=list&id=' . htmlspecialchars($recipe['idRecipe']) . '&start=' . $startIndex . '"><div class="bg-iconLoupe"></div></a></td>';
				}

			echo '</tr>';

			if (array_key_exists("id", $_GET) && htmlspecialchars($_GET["id"]) == htmlspecialchars($recipe['idRecipe'])) // les premiers détails de la recette sont divisé en 3 parties
			{
				echo '<tr>';

					// première partie : concerne la recette elle-même
					$imageLink = '"resources/image/Recipes/' . htmlspecialchars($recipe['recImage']) . '"';
					echo '<td COLSPAN="3">';
						echo '<div class="card" style="width: 35rem;">';
							echo '<img src=' . $imageLink . ' class="card-img-top d-block w-100" alt="image de profile du créateur de la recette">';
							echo '<div class="card-body" style="color:black">';
								echo '<h5 class="card-title">Description :</h5>';
								echo '<p class="card-text">' . $recipe["recDescription"] . '</p>';

								if (array_key_exists("isConnected", $_SESSION) && $_SESSION["isConnected"])
								{
									echo '<a href="index.php?controller=recipe&action=detail&id=' . htmlspecialchars($recipe['idRecipe']) . '" class="btn btn-primary">Voir la recette</a>';
								}
								else
								{
									echo '<a href="index.php?controller=user&action=loginForm" class="btn btn-primary">Voir la recette</a>';

								}

							echo '</div>';
						echo '</div>';
					echo '</td>';
					//echo htmlspecialchars($recipe['recImage']);

					// seconde partie : les information secondaire de la recette (avec la note la difficultée et le temps de préparation)
					echo '<td COLSPAN="2">';
						echo '<div class="card" style="width: 18rem;">';
							echo '<div class="card-body" style="color:black">';
								echo '<h4 class="card-title">informations</h4>';

								echo '<p class="card-text"> note : ' . $recipe["recGrade"] . '  ';
								if (array_key_exists("isConnected", $_SESSION) && $_SESSION["isConnected"])
								{
									echo '<a href="index.php?controller=recipe&action=detail&id=' . htmlspecialchars($recipe['idRecipe']) . '" class="btn btn-success">Noter la recette</a>' . '</p>';
								}
								else
								{
									echo '<a href="index.php?controller=user&action=loginForm" class="btn btn-success">Login ?</a>';

								}

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


					// troisième partie : contient les premières informations du l'utilisateur
					$imageProfilLink = '"resources/image/Users/' . htmlspecialchars($user['useImage']) . '"';
					//echo '<img class="d-block w-50" src=' . $imageProfilLink . ' alt="image de profile du créateur de la recette">';
				
					echo '<td style="width:100px">';
						echo '<div class="card" style="width: 18rem;">';
							echo '<img src=' . $imageProfilLink . ' class="card-img-top" alt="image de profile du créateur de la recette">';
							echo '<div class="card-body" style="color:black">';
								echo '<h5 class="card-title">' . $user["usePseudo"] . '</h5>';
								echo '<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>';
								if (array_key_exists("isConnected", $_SESSION) && $_SESSION["isConnected"])
								{
									echo '<a href="index.php?controller=user&action=profile&idUser=' . $user["idUser"] .  '" class="btn btn-warning">Voir l\'auteur</a>'; // TODO : lier a la page du créateur de la recette
								}
								else 
								{
									echo '<a href="index.php?controller=user&action=loginForm" class="btn btn-warning">Login ?</a>';
								}
								
							echo '</div>';
						echo '</div>';


						//echo $user["usePseudo"];
						//var_dump($user);
					echo '</td>';
					echo '<td></td>';
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

	<!-- cette div contient la pagination des recettes-->
	<div class="justify-content-right numPage" id="numPage"> 
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
