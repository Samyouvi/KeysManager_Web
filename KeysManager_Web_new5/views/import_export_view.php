<div id="container3">
	<div id="centered_block">
		<fieldset>
		<legend>Import</legend>
			<form method="POST" enctype="multipart/form-data">
				<label for="file_source">Fichier source:&nbsp;</label>
				<input type="file" name="file_source" id="file_source" accept=".csv"><br/>
				<input name="importer" type="submit" value="importer"/>
			</form>
			<?php
				showErrors('import');
				showConfirmation();
			?>
		</fieldset><br/>
		<fieldset>
		<legend>Export</legend>
			<form method="POST">
				<label for="selected_data">Données à exporter:&nbsp;</label>
				<select id="selected_data" name="selected_data">
					<?php showDataType(); ?>
				</select>
				<input name="exporter" type="submit" value="exporter"/>
			</form>
			<?php
				showErrors('export');
				showDownloadLink();
			?>
		</fieldset>
	</div>
</div>
<a id="back_to_home" href="?page=acceuil"></a>
