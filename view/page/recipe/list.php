<div class="container">

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
				echo '<td>' . htmlspecialchars($recipe['recPrepTime']) . '</td>';
				echo '<td>' . htmlspecialchars($recipe['recDifficulty']) . '</td>';
				echo '<td>' . htmlspecialchars($recipe['recNote']) . '</td>';
				echo '<td>' . htmlspecialchars($recipe['idUser']) . '</td>';
				echo '<td><a href="index.php?controller=recipe&action=list&id=' . htmlspecialchars($recipe['idRecipe']) . '&start=' . $startIndex . '"><img src="resources/image/icone/iconLoupe.png" alt="loupe"></a></td>';
				echo '</tr>';

				if (array_key_exists("id", $_GET) && htmlspecialchars($_GET["id"]) == htmlspecialchars($recipe['idRecipe']))
				{
					$imageLink = '"resources/image/Recipes/' . htmlspecialchars($recipe['recImage']) . '"';
					echo '<td COLSPAN="6"><img src=' . $imageLink . ' alt="recipeImage"></td>';
					echo htmlspecialchars($recipe['recImage']);
				}
			}

			echo '<tr>';
			echo '<td></td>';
			echo '<td><a href="index.php?controller=recipe&action=list&start=' . ($startIndex - 5) . '">prev</a></td>';
			echo '<td>..</td>';
			echo '<td COLSPAN="3" ><a href="index.php?controller=recipe&action=list&start=' . ($startIndex + 5) . '">next</a></td>';
			echo '</tr>';
		?>
		</table>
	</div>
</div>