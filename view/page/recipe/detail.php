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

			<div>
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
					évaluer la recette
				</button>

				<!-- Modal -->
				<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Évaluation de la recette par <?php echo $user["usePseudo"];?></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<?php 
							
							if ($alreadyRate)
							{
								echo 'Votre note est de : ' . $userNote;
								echo '<select name="note" id="note"></select>';
								echo '<option value="' . $userNote . '">4</option>';
								echo '</select>';
							}
							
							
							?>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save changes</button>
						</div>
						</div>
					</div>
				</div>
			</div>

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

			<?php
			echo $user["usePseudo"];
			$imageLink = '"resources/image/Users/' . htmlspecialchars($user['useImage']) . '"';
			echo '<img class="d-block" src=' . $imageLink . ' alt="image du profil utilisateur">';

			?>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="text-white">
				<p>Commentaires d'évaluation : </p>

				<?php
				
					foreach($ratings as $rating)
					{
						echo '<div class="card text-white bg-secondary  mb-3" style="max-width: 18rem;">';
							echo '<div class="card-header">' . $rating["usePseudo"] . ', note :' . $rating["ratGrade"] . ' </div>';
							
							echo '<div class="card-body">';
								echo '<h5 class="card-title">' . $rating["ratComment"] . '</h5>';
							echo '</div>';

						echo '</div>';
					}
				
				
				?>
			</div>
			
		</div>
		<div class="text-white mb-5 pb-5">
		<a href="index.php?controller=recipe&action=list&id=<?php echo $recipe["idRecipe"]; //. '&start=';// ptetre retrouver le start index de l'image ?>">Retour à la liste des recettes</a>
	</div>
	</div>
	
</div>