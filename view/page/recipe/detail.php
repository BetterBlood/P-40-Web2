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
				echo '<p>Description : ' . $recipe['recDescription'] . '</p>';
			?>
			<img src="" alt="">
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-white">
			<div>
				<div>
					<?php
					if (isset($recipe["recNote"]))
					{
						echo '<p>Note : ' . $recipe['recNote'];
						?>
							<div style="display: flex;">
								<div class="progress" style="width:160px;height:32px;">
									<div class="bg-warning" role="progressbar" style="width:<?php echo $recipe['recNote']*20; ?>%;">
										<img style="width:160px;height:32px;" src="resources/image/icone/evaluation.png" alt="icone d'évaluation transparent">
									</div>
								</div>
							</div>
						<?php
						echo '</p>';
					}
					else
					{
						?>
							<div style="display: flex;">
								<div class="progress" style="width:160px;height:32px;">
									<div class="bg-warning" role="progressbar" style="width: 50%;">
										<img style="width:160px;height:32px;" src="resources/image/icone/evaluation.png" alt="icone d'évaluation transparent">
									</div>
								</div>
							</div>
						<?php
						echo '<p>Note : Il n\'y a aucune note disponible pour le moment</p>'; 
					}
					?>
				</div>

				<!-- Button trigger modal -->
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
					évaluer la recette
				</button>

				<!-- Modal -->
				<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content bg-secondary">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Évaluation de la recette par <?php echo $_SESSION["username"];?></h5>
								
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<form action="trouver une page" method="POST">
								<div class="modal-body">
									<?php 
									echo 'votre évaluation : ';
									echo '<select name="note" id="note">';
									echo '<option value="-1">aucune</option>';

									for ($i = 1; $i <= 5; $i++)
									{
										echo '<option';
										echo ' value="' . $i . '" ';

										if ($alreadyRate && $userNote == $i)
										{
											echo 'selected';
										}

										echo '>'. $i . '</option>';
									}

									echo '</select>';
									
									?>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary">Save changes</button>
								</div>
							</form>
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
			echo $recipeCreator["usePseudo"];
			$imageLink = '"resources/image/Users/' . htmlspecialchars($recipeCreator['useImage']) . '"';
			echo '<img class="d-block" src=' . $imageLink . ' alt="image du profil utilisateur">';

			?>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-white">
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
		<div class="text-white mb-5 pb-5">
		<a href="index.php?controller=recipe&action=list&id=<?php echo $recipe["idRecipe"]; //. '&start=';// ptetre retrouver le start index de l'image ?>">Retour à la liste des recettes</a>
	</div>
	</div>
	
</div>