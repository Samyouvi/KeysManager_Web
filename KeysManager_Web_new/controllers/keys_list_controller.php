<?php
	if(!isset($_SESSION['cache']['keys_list'])){
		$_SESSION['cache']['keys_list'] = array();
	}
	if(!isset($_SESSION['cache']['keys_list']['active_filters'])){
		$_SESSION['cache']['keys_list']['active_filters'] = array();
	}
	$errors = '';

	// Events capture
	if(isset($_POST['add_filter'])) {
		$option = htmlspecialchars($_POST['add_filter']);
		if($option != 'emprunt_en_retard' && $option != 'emprunt_en_cours') {
			if(isset($_POST['filter_field'])) {
				$search = htmlspecialchars($_POST['filter_field']);
				if(strlen($search)>2) {
					if($option == 'date' || $option == 'emprunt_apres' || $option == 'emprunt_avant') {
						if(isset($_SESSION['cache']['keys_list']['active_filters']['emprunt_en_retard'])) {
							unset($_SESSION['cache']['keys_list']['active_filters']['emprunt_en_retard']);
						}
						if(isset($_SESSION['cache']['keys_list']['active_filters']['emprunt_en_cours'])) {
							unset($_SESSION['cache']['keys_list']['active_filters']['emprunt_en_cours']);
						}
						if(isset($_SESSION['cache']['keys_list']['active_filters']['date'])) {
							unset($_SESSION['cache']['keys_list']['active_filters']['date']);
						}
						if($option != 'emprunt_apres' && $option != 'emprunt_avant') {
							if(isset($_SESSION['cache']['keys_list']['active_filters']['emprunt_apres'])) {
								unset($_SESSION['cache']['keys_list']['active_filters']['emprunt_apres']);
							}
							if(isset($_SESSION['cache']['keys_list']['active_filters']['emprunt_avant'])) {
								unset($_SESSION['cache']['keys_list']['active_filters']['emprunt_avant']);
							}
						}
					}
					$_SESSION['cache']['keys_list']['active_filters'][$option] = $search;
				} else {
					$errors = 'La recherche doit comporter au moins 3 caractères.';
				}
			}
		} else {
			if(isset($_SESSION['cache']['keys_list']['active_filters']['emprunt_en_retard'])) {
				unset($_SESSION['cache']['keys_list']['active_filters']['emprunt_en_retard']);
			}
			if(isset($_SESSION['cache']['keys_list']['active_filters']['emprunt_en_cours'])) {
				unset($_SESSION['cache']['keys_list']['active_filters']['emprunt_en_cours']);
			}
			if(isset($_SESSION['cache']['keys_list']['active_filters']['date'])) {
				unset($_SESSION['cache']['keys_list']['active_filters']['date']);
			}
			if(isset($_SESSION['cache']['keys_list']['active_filters']['emprunt_apres'])) {
				unset($_SESSION['cache']['keys_list']['active_filters']['emprunt_apres']);
			}
			if(isset($_SESSION['cache']['keys_list']['active_filters']['emprunt_avant'])) {
				unset($_SESSION['cache']['keys_list']['active_filters']['emprunt_avant']);
			}
			$_SESSION['cache']['keys_list']['active_filters'][$option] = '';
		}
	}
	if(isset($_POST['del_filter'])) {
		$del_filter = htmlspecialchars($_POST['del_filter']);
		//echo '<script>alert('.$del_filter.');</script>';
		unset($_SESSION['cache']['keys_list']['active_filters'][$del_filter]);
	}
	if(isset($_POST['id']) && isset($_POST['revoquer'])) {
		global $_keychainDAO;
		$id_keychain = htmlspecialchars($_POST['id']);
		$_keychainDAO->delKeychain($id_keychain);
	}

	// Displays functions
	function showFilters() {
		echo "<ul>\n";
		foreach($_SESSION['cache']['keys_list']['active_filters'] as $key => $value) {
			$string_value = ($value != '') ? $key.': '.$value : $key;
			echo '<li><form method="POST"><button name="del_filter" class="lien" type="submit" value="'.$key.'">'.$string_value.'</button></form></li>'."\n";
		}
		echo "</ul>\n";
	}

	function showArray() {
		global $_keychainDAO, $_userDAO, $_keyDAO, $_ouvreDAO, $_doorDAO;
		$data = $_keychainDAO->getKeychains();
		foreach($data as $keychain) {
			$ignore = false;
			// Keychain infos
			$id_keychain = $keychain->getId();
			$creation_date = substr_replace($keychain->getCreationDate(), '-', 6, 0);
			$creation_date = substr_replace($creation_date, '-', 4, 0);
			$destruction_date = substr_replace($keychain->getDestructionDate(), '-', 6, 0);
			$destruction_date = substr_replace($destruction_date, '-', 4, 0);
			// User infos
			$user_id = $keychain->getEnssatPrimaryKey();
			$user_infos = $_userDAO->getUserById($user_id);
			$username = 'Inconnu';
			if($user_infos != null)
				$username = $user_infos->getName().' '.$user_infos->getSurname();
			// Doors infos + key ids
			$doors_infos = array();
			$keys_infos = array();
			$key_ids = $_keyDAO->getKeyIdsWithKeychainId($id_keychain);
			foreach($key_ids as $key_id) {
				$keys_infos[] = $_keyDAO->getKeyById($key_id);
				$lock_ids = $_ouvreDAO->getLockIdsWithKeyId($key_id);
				foreach($lock_ids as $lock_id) {
					$door_ids = $_doorDAO->getDoorIdsWithLockId($lock_id);
					foreach ($door_ids as $door_id) {
						$doors_infos[] = $_doorDAO->getDoorById($door_id);
					}
				}
			}
			// String concatenations
			//// Door ids
			$doors_string = '';
			foreach($doors_infos as $door) {
				$doors_string .= '<a href="?page=infos&object=door&id='.$door->getId().'">'.$door->getName().'</a>/';
			}
			if(strlen($doors_string)>0) {
				$doors_string = substr($doors_string, 0, -1);
			}
			//// Key ids
			$keys_string = '';
			foreach($keys_infos as $key) {
				$keys_string .= '<a title="type passe: '.$key->getType().'" href="?page=infos&object=key&id='.$key->getId().'">'.$key->getId().'</a>/';
			}
			if(strlen($keys_string)>0) {
				$keys_string = substr($keys_string, 0, -1);
			}
			// Filters
			if(isset($_SESSION['cache']['keys_list']['active_filters']['utilisateur'])) {
				$searched_username = $_SESSION['cache']['keys_list']['active_filters']['utilisateur'];
				if(!preg_match('/\b'.$searched_username.'\b/', $username)) {
					// remove
					$ignore = true;
				}
			}
			if(isset($_SESSION['cache']['keys_list']['active_filters']['porte'])) {
				$searched_door = $_SESSION['cache']['keys_list']['active_filters']['porte'];
				$exist = false;
				foreach ($doors_infos as $door) {
					if($door->getName() == $searched_door) {
						$exist = true;
						break;
					}
				}
				if(!$exist) {
					$ignore = true;
				}
			}
			if(isset($_SESSION['cache']['keys_list']['active_filters']['emprunt_en_cours'])) {
				$current_date = date('Y-m-d');
				if(strcasecmp($current_date, $destruction_date) > 0) {
					$ignore = true;
				}
			}
			if(isset($_SESSION['cache']['keys_list']['active_filters']['emprunt_en_retard'])) {
				$current_date = date('Y-m-d');
				if(strcasecmp($current_date, $destruction_date) <= 0) {
					$ignore = true;
				}
			}
			if(isset($_SESSION['cache']['keys_list']['active_filters']['date'])) {
				$date = $_SESSION['cache']['keys_list']['active_filters']['date'];
				if(strcasecmp($date, $creation_date) < 0 || strcasecmp($date, $destruction_date) > 0) {
					$ignore = true;
				}
			}
			if(isset($_SESSION['cache']['keys_list']['active_filters']['emprunt_apres'])) {
				$date = $_SESSION['cache']['keys_list']['active_filters']['emprunt_apres'];
				if(strcasecmp($date, $destruction_date) >= 0) {
					$ignore = true;
				}
			}
			if(isset($_SESSION['cache']['keys_list']['active_filters']['emprunt_avant'])) {
				$date = $_SESSION['cache']['keys_list']['active_filters']['emprunt_avant'];
				if(strcasecmp($date, $creation_date) <= 0) {
					$ignore = true;
				}
			}
			// Displays
			if(!$ignore) {
				echo '
					<tr>
						<td><a href="?page=infos&object=user&id='.$user_id.'">'.$username.'</a></td>
						<td><a href="?page=infos&object=keychain&id='.$id_keychain.'">'.$id_keychain.'</a></td>
						<td>'.$keys_string.'</td>
						<td>'.$doors_string.'</td>
						<td>'.$creation_date.' - <a href="?page=infos&object=keychain&id='.$id_keychain.'">'.$destruction_date.'</a></td>
						<td>
							<form method="POST">
								<input name="id" type="hidden" value="'.$id_keychain.'"/>
								<input class="lien" name="revoquer" type="submit" value="révoquer"/>
							</form>
						</td>
					</tr>
				';
			}
		}
	}

	function showErrors() {
		global $errors;
		if(strlen($errors)>0) {
			echo '<div class="error">'.$errors.'</div>'."\n";
		}
	}
?>
