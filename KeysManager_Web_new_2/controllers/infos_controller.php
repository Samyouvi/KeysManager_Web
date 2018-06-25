<?php
  $type_collection = array('door', 'keychain', 'key', 'lock', 'masterkey', 'ouvre', 'provider', 'room', 'user');
  $errors = '';
  $object;
  $confirmation = '';

	// Events capture
  if(isset($_POST['btn_edit']) && isset($_GET['object']) && isset($_GET['id'])) {
    $table = htmlspecialchars($_GET['object']);
    $id = htmlspecialchars($_GET['id']);
    if(in_array($table, $type_collection)) {
      if((!in_array('creationDate', $_POST) || !in_array('destructionDate', $_POST)) || (in_array('creationDate', $_POST) && in_array('destructionDate', $_POST) && strcasecmp(htmlspecialchars($_POST['creationDate']), htmlspecialchars($_POST['destructionDate'])) <= 0)) {
        eval('$new_object = new '.ucfirst($table).'VO();');
        $one_empty = false;
        eval('$new_object->setId("'.$id.'");');
        foreach ($_POST as $field => $value) {
          $field = htmlspecialchars($field);
          $value = htmlspecialchars($value);
          if($field != 'btn_edit' && $field != 'object' && $field != 'creationDate' && $field != 'enssatPrimaryKey' && $field != 'id_'.strtolower(str_replace('VO', '', get_class($new_object)))) {
            if($value == '') {
              $one_empty = true;
            }
            $field = str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));
            //echo '$new_object->set'.$field.'("'.$value.'");'."\n";
            eval('$new_object->set'.$field.'("'.$value.'");');
          }
        }
        //echo '$_'.$table.'DAO->set'.ucfirst($table).'($new_object);'."\n\n";
        if(!$one_empty) {
          eval('$_'.$table.'DAO->set'.ucfirst($table).'($new_object);');
          $confirmation = 'La mise à jour à été prise en compte.';
        } else {

        }
      } else {
        $errors = 'La date de destruction ne peut-être inférieure à la date de création.';
      }
    } else {
      $errors = 'Le type de donnée demandé est inconnu.';
    }
  }

  if(isset($_GET['object']) && isset($_GET['id'])) {
    global $_doorDAO, $_keychainDAO, $_keyDAO, $_lockDAO, $_masterkeyDAO, $_ouvreDAO, $_providerDAO, $_roomDAO, $_userDAO;
    $table = htmlspecialchars($_GET['object']);
    $id_object = htmlspecialchars($_GET['id']);
    if(in_array($table, $type_collection)) {
      $id_object = (string) $id_object;
      //echo $id_object."<br/>\n";
      eval('$object = $_'.$table.'DAO->get'.ucfirst($table).'ById("'.$id_object.'");');
      //echo $object->getId();
    } else {
      $errors = 'Le type de donnée demandé est inconnu.';
    }
  }

  // Displays functions
  function showForm() {
    global $object;
    //echo $object->getId();
    if($object != null) {
      $object_name = str_replace('VO', '', get_class($object));
      echo '<fieldset>'."\n";
      echo '<legend>'.$object_name.' (id: '.$object->getId().')</legend>';
      echo '<form method="POST">'."\n";
      foreach(((array) $object) as $field => $value) {
        $field = trim($field, "* \t\n\r\0\x0B"); // remove characters (" *") added by the cast
        $locker = '';
        // Specialization
        if($field == 'creationDate' || $field == 'enssatPrimaryKey' || $field == 'id_'.strtolower(str_replace('VO', '', get_class($object)))) {
          $locker = 'disabled';
        }
        if($object_name == 'User' && $field == 'status') {
          echo '<label for="'.$field.'">'.$field.': </label><select id="'.$field.'" name="'.$field.'" '.$locker.'/>'."\n";
          foreach ($object->getStatusCollection() as $key => $status) {
            if($key == $value)
              echo '<option value="'.$key.'" selected>'.$status.'</option>'."\n";
            else
              echo '<option value="'.$key.'">'.$status.'</option>'."\n";
          }
          echo '</select><br/>'."\n";
        } else if($object_name == 'Keychain' && $field == 'status') {
          echo '<label for="'.$field.'">'.$field.': </label><select id="'.$field.'" name="'.$field.'" '.$locker.'/>'."\n";
          foreach ($object->getStatusCollection() as $status) {
            if($status == $value)
              echo '<option value="'.$status.'" selected>'.$status.'</option>'."\n";
            else
              echo '<option value="'.$status.'">'.$status.'</option>'."\n";
          }
          echo '</select><br/>'."\n";
        } else if(stripos($field, 'date')!==false) {
          $value = substr_replace($value, '-', 6, 0);
    			$value = substr_replace($value, '-', 4, 0);
          echo '<label for="'.$field.'">'.$field.': </label><input type="date" id="'.$field.'" name="'.$field.'" value="'.$value.'" '.$locker.'/><br/>'."\n";
        } else {
          echo '<label for="'.$field.'">'.$field.': </label><input type="text" id="'.$field.'" name="'.$field.'" value="'.$value.'" '.$locker.'/><br/>'."\n";
        }
      }
      echo '<input type="submit" name="btn_edit" value="Modifier"/>'."\n";
      echo '</form>'."\n";
      showErrors();
      showConfirmation();
      echo '</fieldset>'."\n";
    } else {
      $errors = 'Le type de donnée demandé est inconnu.';
    }
  }

  function showErrors() {
		global $errors;
		if(strlen($errors)>0) {
			echo '<div class="error">'.$errors.'</div>';
		}
	}

  function showConfirmation() {
    global $confirmation;
    echo $confirmation."\n";
  }
?>
