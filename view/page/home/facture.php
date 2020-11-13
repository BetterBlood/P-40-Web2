<div class="container">

	<h2>Liste des factures</h2>
	<div class="row">
		<table class=" table table-striped">
		<tr>
			<th>idInvoice</th>
			<th>invQuantity</th>
			<th>invPrice</th>
			<th>fkContact</th>
			<th></th>
		</tr>
		<?php
		    // Affichage de chaque client
			foreach ($invoices as $facture) {
				echo '<tr>';
				echo '<td>' . htmlspecialchars($facture['idInvoice']) . '</td>';
				echo '<td>' . htmlspecialchars($facture['invQuantity']) . '</td>';
				echo '<td>' . htmlspecialchars($facture['invPrice']) . '</td>';
				echo '<td>' . htmlspecialchars($facture['fkContact']) . '</td>';
				//echo '<td><a href="index.php?controller=customer&action=detail&id=' . htmlspecialchars($facture['idInvoice']) .'"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span></a></td>';
				echo '</tr>';
			}
		?>
		</table>
	</div>
</div>