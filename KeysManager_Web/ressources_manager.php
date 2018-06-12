<?php
	$selected_onglet = 1;
	if(isset($_GET['onglet'])) {
		$tmp = (int)htmlspecialchars($_GET['onglet']);
		if($tmp > 0 && $tmp < 6)
			$selected_onglet = $tmp;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>My Website</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div id="container3">
			<div id="centered_block">
				<div id="onglet_container">
					<div id="tabs">
						<div class="onglet<?php if($selected_onglet==1) echo ' onglet_actif';?>"><a href="?onglet=1">Emprunts</a></div>
						<div class="onglet<?php if($selected_onglet==2) echo ' onglet_actif';?>""><a href="?onglet=2">Utilisateurs</a></div>
						<div class="onglet<?php if($selected_onglet==3) echo ' onglet_actif';?>""><a href="?onglet=3">Trousseaux</a></div>
						<div class="onglet<?php if($selected_onglet==4) echo ' onglet_actif';?>""><a href="?onglet=4">Clés</a></div>
						<div class="onglet<?php if($selected_onglet==5) echo ' onglet_actif';?>""><a href="?onglet=5">Portes</a></div>
					</div>
					<div id="tabcontent">
						<div class="tabpanel<?php if($selected_onglet==1) echo ' contenu_onglet_actif';?>">
							<form method="POST">
								<div class="align_left">
									<input list="users" type="text" id="user_choice" placeholder="utilisateur">
									<datalist id="users">
										<option value="user1">
										<option value="user2">
										<option value="user3">
										<option value="user4">
									</datalist>
									<input name="submit_add_user" class="lien" type="submit" value="créer nouvel utilisateur"><br/>
								<input list="keyrings" type="text" id="keyring_choice" placeholder="trousseau">
								<datalist id="keyrings">
									<option value="keyring1">
									<option value="keyring2">
									<option value="keyring3">
									<option value="keyring4">
								</datalist>
								<input name="submit_add_keyring" class="lien" type="submit" value="créer nouveau trousseau"><br/>
								</div>
								<ul class="fist_legend">
									<li>Dates du prêt:</li>
									<li>début&nbsp;<input type="date" id="date_debut_pret" name="date_debut_pret"/></li>
									<li>fin&nbsp;&nbsp;&nbsp;<input type="date" id="date_fin_pret" name="date_fin_pret"/></li>
								</ul>
								<input name="submit_valider" type="submit" value="Valider">
							</form>
						</div>
						<div class="tabpanel<?php if($selected_onglet==2) echo ' contenu_onglet_actif';?>">
							<form method="POST">
								<?php
									if(isset($_POST['submit_valider_onglet2'])){
										echo <<<CODE
<input type="text" id="phone" placeholder="phone">
<select id="monselect">
	<option value="valeur1">Valeur 1</option> 
	<option value="valeur2" selected>Valeur 2</option>
	<option value="valeur3">Valeur 3</option>
</select>
<input type="text" id="firstname" placeholder="firstname">
<input type="text" id="firstname" placeholder="firstname">
<input type="text" id="firstname" placeholder="firstname">
CODE;
									}
								?>
								<input type="text" id="firstname" placeholder="firstname">
								<input type="text" id="name" placeholder="name"><br/>
								<input name="submit_valider_onglet2" type="submit" value="Valider">
							</form>
						</div>
						<div class="tabpanel<?php if($selected_onglet==3) echo ' contenu_onglet_actif';?>">
							<form method="POST">
								<div class="align_left">
									<input type="text" id="keyring" placeholder="keyring name"><br/>
									<input list="keys" type="text" id="key_choice" placeholder="key">
									<datalist id="keys">
										<option value="key1">
										<option value="key2">
										<option value="key3">
										<option value="key4">
									</datalist>
									<input name="submit_add_key" class="lien" type="submit" value="ajouter la clé">
								</div>
								<div id="added_keys_block"></div><br/>
								<input name="submit_valider" type="submit" value="Valider">
							</form>
						</div>
						<div class="tabpanel<?php if($selected_onglet==4) echo ' contenu_onglet_actif';?>">
							<form method="POST">
								<div class="align_left">
									<input type="text" id="key" placeholder="key name"><br/>
									<input list="doors" type="text" id="key_choice" placeholder="door">
									<datalist id="doors">
										<option value="door1">
										<option value="door2">
										<option value="door3">
										<option value="door4">
									</datalist>
									<input name="submit_add_door" class="lien" type="submit" value="ajouter une porte">
								</div>
								<div id="added_doors_block"></div><br/>
								<input name="submit_valider" type="submit" value="Valider">
							</form>
						</div>
						<div class="tabpanel<?php if($selected_onglet==5) echo ' contenu_onglet_actif';?>">
							<form method="POST">
								<input type="text" id="door" placeholder="door name"><br/>
								<input name="submit_valider" type="submit" value="Valider">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<a id="back_to_home" href="main_page.html"></a>
	</body>
</html>
