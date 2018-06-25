<?php
  $errors = '';
  $confirmations = '';
  $selected_onglet = 1;

	// Events capture
  if(isset($_GET['onglet'])) {
  	$tmp = (int)htmlspecialchars($_GET['onglet']);
  	if($tmp > 0 && $tmp < 6)
  		$selected_onglet = $tmp;
  }

  // Displays functions
  function getForm1() {
  echo <<<CODE
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
CODE;
    }

  function getForm2() {}

  function getForm3() {}

  function getForm4() {
    global $_keyDAO, $_ouvreDAO, $_doorDAO;

    if(isset($_POST['submit_search']) || isset($_POST['submit_new'])) {
      // Form for new key and edit key
      $key_id = -1;
      if(isset($_POST['keys_list']))
        $key_id = htmlspecialchars($_POST['keys_list']);
      $ids_lock = $_ouvreDAO->getLockIdsWithKeyId($key_id);
      $associated_doors = array();
      if($key_id != -1) {
        //// Prepare display associated doors
        foreach ($ids_lock as $id_lock) {
          if($_doorDAO->getDoorIdWithLockId($id_lock) != -1) {
            $associated_doors[] = $_doorDAO->getDoorIdWithLockId($id_lock);
          }
        }
      }
      //// Display associated doors
      $string_doors = '<div class="checkbox_list">';
      $list_doors = $_doorDAO->getDoors();
      foreach ($list_doors as $door) {
        $id_door = $door->getId();
        $door_name = $door->getName();
        $existe = false;
        foreach ($associated_doors as $value) {
          if($value == $id_door) {
            $existe = true;
          }
        }
        if($existe) {
          $string_doors .= '<input type="checkbox" name="door_list[]" id="checkbox_'.$id_door.'" value="'.$id_door.'" checked/><label for="">'.$door_name.'</label><br/>';
        } else {
          $string_doors .= '<input type="checkbox" name="door_list[]" id="checkbox_'.$id_door.'" value="'.$id_door.'"/><label for="">'.$door_name.'</label><br/>';
        }
      }
      if(strlen($string_doors) > 5)
        $string_doors = substr($string_doors, 0, -5);
      $string_doors .= '</div>';
      //// Display doors could be added
      if($key_id == -1) {
        $keys = $_keyDAO->getKeys();
        $key_id = $keys[count($keys)-1]->getKeys()+1;
      }

      $call_me='';
      if(isset($_POST['submit_search'])) {
        $call_me = '<input type="hidden" name="submit_search">';
      } elseif (isset($_POST['submit_new'])) {
        $call_me = 'submit_new';
      }

      echo <<<CODE
<fieldset>
  <legend>Key (id: $key_id)</legend>
  <form method="POST">
    $string_doors
    <input name="hidden_id_key" type="hidden" value="$key_id" /><br/>
    <input name="submit_validate" type="submit" value="Valider">
  </form>
</fieldset>
CODE;
} else if(isset($_POST['submit_validate']) && isset($_POST['hidden_id_key']) && isset($_POST['door_list'])) {
      // Apply modifications
      $id_key = htmlspecialchars($_POST['hidden_id_key']);
      $door_list = $_POST['door_list'];
      foreach ($door_list as $lock_id) {
        $lock_id = htmlspecialchars($lock_id);
        $ouvre = new OuvreVO();
        $ouvre->setIdKey($id_key);
        $ouvre->setIdLock($lock_id);
        $_ouvreDAO->setOuvre($ouvre);
      }
      echo 'L\'objet à été ajouté.';
    } else {
      $keys = $_keyDAO->getKeys();
      $string_select = '';
      $first = true;
      foreach ($keys as $key) {
        if($first) {
          $first = false;
          $string_select .= '<option selected>'.$key->getId().'</option>'."\n";
        } else {
          $string_select .= '<option>'.$key->getId().'</option>'."\n";
        }
      }
      echo <<<CODE
      <form method="POST">
      <select name="keys_list" size=10>
      $string_select
      </select><br/>
      <input name="submit_search" type="submit" value="Charger">
      <input name="submit_new" type="submit" value="Nouvelle clé">
      </form>
CODE;
    }
  }

  function getForm5() {}

  function isActive($index) {
    global $selected_onglet;
    if($selected_onglet==$index) echo ' onglet_actif';
  }

  function showContent($index) {
    global $selected_onglet;
    if($selected_onglet==$index) echo ' contenu_onglet_actif';
  }

  function showErrors() {
		global $errors;
		if(strlen($errors)>0) {
			echo '<div class="error">'.$errors.'</div>'."\n";
		}
	}

  function showConfirmations() {
		global $confirmations;
		if(strlen($confirmations)>0) {
			echo '<div class="error">'.$confirmations.'</div>'."\n";
		}
	}
?>
