		<script>
			window.onload=function() {
				filterField();
			}
			function filterField() {
				var value = document.getElementById("select_filter").value;
				var filter_field = document.getElementById("filter_field");
				if(value == "utilisateur" || value == "porte") {
					filter_field.type = 'text';
					filter_field.style.display = 'inline';
				} else if(value == "date" || value == "emprunt_avant" || value == "emprunt_apres") {
					filter_field.type = 'date';
					filter_field.style.display = 'inline';
				} else {
					filter_field.style.display = 'none';
				}
			}
		</script>
		<div id="container2">
			<div id="tab_page_left">
				Filtres actifs:<br/>
				<?php showFilters(); ?>
			</div>
			<div id="tab_page_right">
				<form class="horizontal_form" method="POST">
					<label for="select_filter">Filtre:&nbsp;</label>
					<select id="select_filter" name="add_filter" onchange="filterField();">
						<option value="utilisateur" selected>utilisateur</option>
						<option value="porte">porte</option>
						<option value="date">date</option>
						<option value="emprunt_avant">emprunt avant</option>
						<option value="emprunt_apres">emprunt après</option>
						<option value="emprunt_en_retard">emprunt en retard</option>
						<option value="emprunt_en_cours">emprunt en cours</option>
					</select>
					<input type="text" id="filter_field" name="filter_field"/>&nbsp;
					<input class="lien" type="submit" value="ajouter le filtre"/>
				</form>
				<?php showErrors(); ?>
				<table>
					<tbody>
						<tr>
							<th>Emprunteur</th>
							<th>Trousseau</th>
							<th>Clé(s)</th>
							<th>Porte(s)</th>
							<th>Date emprunt</th>
							<th>Actions</th>
						</tr>
						<?php showArray(); ?>
					</tbody>
				</table>
			</div>
		</div>
		<a id="back_to_home" href="?page=acceuil"></a>
