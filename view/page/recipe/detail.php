<div class="container">

	<h2>
		<?php
			// redirection si la recette n'existe pas
			if (isset($recipe))
			{
				echo $recipe['recName'] . ', dans la catégorie : ' . $recipe["recCategory"];
			}
			else 
			{
				header("Location: index.php?controller=recipe&action=list");
			}
			
		?>
	</h2>

	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-white">
			<div class="pl-5" style="display:flex;">
				Difficulté de préparation : 
				<div class="progress ml-3 mb-3" style="width:160px;height:32px;background-color: grey;">
					<div role="progressbar" style="width:<?php echo $recipe['recDifficulty']*20; ?>%;background-color: white;"> <!-- obligé de passer en style pour la width car il faudrait faire une infinité de classe sinon -->
						<div class="bg-difficulty"></div> <!-- src="resources/image/icone/difficulty.png" style="width:160px;height:32px;" alt="icone d'évaluation transparent"-->
					</div>
				</div>
				

			</div>
			<?php
				$imageLink = '"resources/image/Recipes/' . htmlspecialchars($recipe['recImage']) . '"'; // HTMLSPECIALCHARS
				echo '<img class="d-block w-100" src=' . $imageLink . ' alt="image d\'illustration de la recette">';
				echo '<p>Description : ' . $recipe['recDescription'] . '</p>';
			?>
			
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-white">
			<div>
				<div>
					<?php
					if (isset($recipe["recGrade"]))
					{
						echo '<p>Note : ' . $recipe['recGrade'];
						?>
							<div data-toggle="modal" data-target="#ratingModal" style="display:flex; width:323px; height:32px; cursor:pointer;">
								<div class="progress" style="width:160px;height:32px;">
									<div class="bg-warning" role="progressbar" style="width:<?php echo $recipe['recGrade']*20; ?>%;">
										<div class="bg-evaluation"></div>
										<!--<img style="width:160px;height:32px;" src="resources/image/icone/evaluation.png" alt="icone d'évaluation transparent">-->
									</div>
								</div>
								<!-- Button trigger modal -->
								<button type="button" class="btn btn-success ml-3" data-toggle="modal" data-target="#ratingModal">
									évaluer la recette
								</button>
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
										<div class="bg-evaluation"></div>
										<!--<img style="width:160px;height:32px;" src="resources/image/icone/evaluation.png" alt="icone d'évaluation transparent">-->
									</div>
								</div>
								<button type="button" class="btn btn-success ml-3" data-toggle="modal" data-target="#ratingModal">
									évaluer la recette
								</button>
							</div>
						<?php
						echo '<p>Note : Il n\'y a aucune note disponible pour le moment</p>'; 
					}
					?>
				</div>

				<!-- Modal -->
				<div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content bg-secondary">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Évaluation de la recette par <?php echo $_SESSION["username"];?></h5>
								
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<form action="index.php?controller=recipe&action=rate&id=<?php echo $recipe["idRecipe"];?>" method="POST">
								<div class="modal-body">
									<?php 
									echo '<label for="ratGrade">votre évaluation : </label>';
									echo '<select name="ratGrade" id="ratGrade">';
									echo '<option value="-1">aucune</option>';

									for ($i = 1; $i <= 5; $i++)
									{
										echo '<option';
										echo ' value="' . $i . '" ';

										if ($alreadyRate && $userGrade == $i)
										{
											echo 'selected';
										}

										echo '>'. $i . '</option>';
									}

									echo '</select>';
									
									?>

									<br>
									<label for="ratComment">votre commentaire : </label>
									<?php 

										echo '<textarea name="ratComment" id="ratComment" cols="40" rows="3">';
											
										if ($alreadyRate)
										{
											echo $userComment;
										}
										else
										{
											echo 'noComment';
										}
										echo '</textarea>';

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

	<div class="bg-secondary badge-pill mt-5 mb-3 mx-auto " style="height:8px;width:50%;"></div>
	<div class="bg-secondary badge-pill mt-3 mb-3 mx-auto " style="height:8px;width:40%;"></div>
	<div class="bg-secondary badge-pill mt-3 mb-3 mx-auto " style="height:8px;width:25%;"></div>
	<div class="bg-secondary badge-pill mt-3 mb-5 mx-auto " style="height:8px;width:10%;"></div>
	
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-white">
			<p>Créateur de la recette :</p>

			<?php
			$imageProfilLink = '"resources/image/Users/' . htmlspecialchars($recipeCreator['useImage']) . '"';
			echo '<div class="card" style="width: 18rem;">';
				echo '<img src=' . $imageProfilLink . ' class="card-img-top" alt="image de profile du créateur de la recette">';
				echo '<div class="card-body" style="color:black">';
					echo '<h5 class="card-title">' . $recipeCreator["usePseudo"] . '</h5>';
					echo '<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>';
					if (array_key_exists("isConnected", $_SESSION) && $_SESSION["isConnected"])
					{
						echo '<a href="index.php?controller=user&action=profile&idUser=' . $recipeCreator["idUser"] . '" class="btn btn-warning">Voir l\'auteur</a>';
					}
					else 
					{
						echo '<a href="index.php?controller=user&action=loginForm" class="btn btn-warning">Login ?</a>';
					}
					
				echo '</div>';
			echo '</div>';

			?>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-white">
			<p>Commentaires d'évaluation : </p>
			
			<div class="d-inline-block px-5" style="max-height:500px;overflow: auto;">
				
				<?php
					$j = 0;

					foreach($ratings as $rating)
					{
						echo '<div class="card text-white mb-3"';
						echo ' style="max-width: 25rem;background-color:';
						if ($j%2 != 1) // altérnance de couleur
						{
							echo '#1A5C45;';
						}
						else
						{
							echo '#2C9C74';
						}
						echo '">';

						echo '<div class="card-header"><strong>' . $rating["usePseudo"] . '</strong> à donné la note de <strong>' . $rating["ratGrade"] . '</strong> à cette recette</div>';
						
						echo '<div class="card-body">';
							echo '<h5 class="card-title">' . $rating["ratComment"] . '</h5>';
						echo '</div>';

						echo '<a class="btn mx-auto mb-2" style="width:15rem;background-color:#EBA555" href="index.php?controller=user&action=profile&idUser=' . $rating["idUser"] . '">vers le portail de l\'utilisateur</a>'; // je voulais mettre un bouton mais ça donne pas bien....

						echo '</div>';
						$j++;
					}
				
				
				?>
			
			</div>
		</div>
		<div class="text-white mb-5 pb-5">
			<a href="index.php?controller=recipe&action=list&id=<?php echo $recipe["idRecipe"]; //. '&start=';// ptetre retrouver le start index de l'image ?>">Retour à la liste des recettes</a>
		</div>
	</div>
	
</div>