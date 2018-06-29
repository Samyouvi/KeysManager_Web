<?php
  $errors = '';
  $confirmations = '';
  $selected_onglet = 1;

	// Events capture
  if(isset($_GET['onglet'])) {
  	$tmp = (int)htmlspecialchars($_GET['onglet']);
  	if($tmp > 0 && $tmp < 8)
  		$selected_onglet = $tmp;
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
            if($status == $value)
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
      showConfirmations();
      echo '</fieldset>'."\n";
    } else {
      $errors = 'Le type de donnée demandé est inconnu.';
    }
  }

  //Formulaire Emprunt
  function getForm1() {
  global  $_userDAO,$_doorDAO;
  echo '
<form method="POST" action="fpdf/pretPdf.php" target="_blank">
  <div class="align_left">
  <select name="user_choice" required>
    <option value="" disabled selected>--Choisir un utilisateur--</option>';
    foreach($_userDAO->getUsers() as $user){
        echo'<option value="'.$user->getName().' '.$user->getSurname().'">'.$user->getUserName().'</option>';
    }
  echo'
  </select><br/>
  ';
    foreach($_doorDAO->getDoors() as $door){
        echo'
        <input type="checkbox" id="'.$door->getId().'" name="portes[]" value="'.$door->getName().'">
        <label for="'.$door->getId().'">'.$door->getName().'</label><br/>
        ';
    }
  echo'
  </div>
  <ul class="fist_legend">
    <li>Dates du prêt:</li>
    <li>début&nbsp;<input type="date" id="date_debut_pret" name="date_debut_pret" required/></li>
    <li>fin&nbsp;&nbsp;&nbsp;<input type="date" id="date_fin_pret" name="date_fin_pret" required/></li>
  </ul>
  <input name="submit_valider" type="submit" value="Valider">
</form>
';
    }

  //Formulaire Utilisateur
  function getForm2() {
    global $_userDAO, $object;
    if(!isset($_POST['submit_valider_onglet2'])){
      echo <<<CODE
      <form method="POST">
      <input type="text" name="username" placeholder="username"><br/>
      <input name="submit_valider_onglet2" type="submit" value="Valider">
      </form>
CODE;

    }else{
      if($_userDAO->getUserIdWithUsername($_POST['username']) == -1){
        echo <<<CODE
        <form method="POST">
        <input type="text" name="username" value="{$_POST['username']}" readonly><br/>
        <input type="text" name="name" placeholder="name"><br/>
        <input type="text" name="surname" placeholder="surname"><br/>
        <select name="status">
              <option value="Student">Student</option>
              <option value="Staff">Staff</option>
              <option value="Outsider">Outsider</option>
        </select><br/>
        <input type="tel" name="phone" placeholder="phone"><br/>
        <input type="email" name="email" placeholder="email"><br/>
        <input name="submit_valider_user" type="submit" value="Valider">
        </form>
CODE;
        }else{
          $id_object = $_userDAO->getUserIdWithUsername($_POST['username']);
          $object = $_userDAO->getUserById($id_object);
          showForm();
        }
    }
    if(isset($_POST['submit_valider_user'])){
      $users = $_userDAO->getUsers();
      $user = new UserVO();
      $user->setId(((double) $users[count($users)-1]->getId())+1);
      $user->setUrlidentifier(($users[count($users)-1]->getUrlidentifier())+1);
      $user->setUsername($_POST['username']);
      $user->setName($_POST['name']);
      $user->setSurname($_POST['surname']);
      $user->setStatus($_POST['status']);
      $user->setPhone($_POST['phone']);
      $user->setEmail($_POST['email']);
      $_userDAO->setUser($user);
      print("Ajout de effectué");
    }
  }

  //Formulaire Fournisseurs
  function getForm3() {
    global $_providerDAO, $object;
  if(!isset($_POST['submit_valider_onglet3'])){
    echo <<<CODE
    <form method="POST">
    <input type="text" name="username" placeholder="username"><br/>
    <input name="submit_valider_onglet3" type="submit" value="Valider">
    </form>
CODE;

  }else{
    if($_providerDAO->getProviderIdWithUsername($_POST['username']) == -1){
      echo <<<CODE
      <form method="POST">
      <input type="text" name="username" value="{$_POST['username']}" readonly><br/>
      <input type="text" name="name" placeholder="name"><br/>
      <input type="text" name="surname" placeholder="surname"><br/>
      <input type="tel" name="phone" placeholder="phone"><br/>
      <input type="text" name="office" placeholder="office"><br/>
      <input type="email" name="email" placeholder="email"><br/>
      <input name="submit_valider_provider" type="submit" value="Valider">
      </form>
CODE;
      }else{
        $id_object = $_providerDAO->getProviderIdWithUsername($_POST['username']);
        $object = $_providerDAO->getProviderById($id_object);
        showForm();
      }
  }
  if(isset($_POST['submit_valider_provider'])){
  $providers = $_providerDAO->getProviders();
  $provider = new ProviderVO();
  $provider->setId(($providers[count($providers)-1]->getId())+1);
  $provider->setUsername($_POST['username']);
  $provider->setName($_POST['name']);
  $provider->setSurname($_POST['surname']);
  $provider->setPhone($_POST['phone']);
  $provider->setOffice($_POST['office']);
  $provider->setEmail($_POST['email']);
  $_providerDAO->setProvider($provider);
  print("Ajout effectué");
    }
  }

  //Formulaire Clés
  function getForm4() {
    global $_keyDAO, $_ouvreDAO, $_doorDAO;

    if(isset($_POST['submit_search']) || isset($_POST['submit_new'])) {
      // Form for new key and edit key
      $key_id = -1;
      if(isset($_POST['keys_list']) && !isset($_POST['submit_new']))
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
        $key_id = $keys[count($keys)-1]->getId()+1;
      }

      /*$call_me='';
      if(isset($_POST['submit_search'])) {
        $call_me = '<input type="hidden" name="submit_search">';
      } elseif (isset($_POST['submit_new'])) {
        $call_me = 'submit_new';
      }*/
      $keys = $_keyDAO->getKeys();
      $string_select = '';
      foreach ($keys as $key) {
        if($key->getId() == $key_id) {
          $string_select .= '<option selected>'.$key->getId().'</option>'."\n";
        } else {
          $string_select .= '<option>'.$key->getId().'</option>'."\n";
        }
      }

      echo <<<CODE
<form class="align_horizontal" method="POST">
  <div class="left">
    <select name="keys_list" size=5>
    $string_select
    </select><br/>
    <input name="submit_search" type="submit" value="Charger"><br/>
    <input name="submit_new" type="submit" value="Nouvelle clé">
  </div>
  <fieldset>
    <legend>Key (id: $key_id)</legend>
      $string_doors
      <input name="hidden_id_key" type="hidden" value="$key_id" /><br/>
      <input name="submit_validate" type="submit" value="Valider">
  </fieldset>
</form>
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
      <form class="left" method="POST">
      <select name="keys_list" size=5>
      $string_select
      </select><br/>
      <input name="submit_search" type="submit" value="Charger"><br/>
      <input name="submit_new" type="submit" value="Nouvelle clé">
      </form>
CODE;
    }
  }

  //Formulaire Portes
  function getForm5() {
    global $_doorDAO, $object, $_roomDAO, $_lockDAO;
    if(!isset($_POST['submit_valider_onglet5'])){
      echo <<<CODE
      <form method="POST">
      <input type="text" name="name" placeholder="door name"><br/>
      <input name="submit_valider_onglet5" type="submit" value="Valider">
      </form>
CODE;
      }else{
        if($_doorDAO->getDoorIdWithName($_POST['name']) == -1){
          echo <<<CODE
          <form method="POST">
CODE;
        echo '<select name="room">';
        $rooms = $_roomDAO->getRooms();
        foreach($rooms as $room){
          echo '<option value="'.$room->getName().'">'.$room->getName().'</option>';
        }
        echo '</select></br>';
        echo '<select name="lock">';
        $locks = $_lockDAO->getLocks();
        foreach($locks as $lock){
          echo '<option value="'.$lock->getId().'">'.$lock->getId().'</option>';
        }
        echo '</select></br>';
echo <<<CODE
            <input type="text" name="name" value="{$_POST['name']}" readonly><br/>
            <input name="submit_valider_door" type="submit" value="Valider">
          </form>
CODE;
        }else{
          $id_object = $_doorDAO->getDoorIdWithName($_POST['name']);
          $object = $_doorDAO->getDoorById($id_object);
          showForm();
        }
      }
        if(isset($_POST['submit_valider_door'])){
        $id = htmlspecialchars($_POST['lock']);
        $doors = $_doorDAO->getDoors();
        $door = new DoorVO();
        $door->setId(($doors[count($doors)-1]->getId())+1);
        $door->setIdRoom($_roomDAO->getRoomIdWithName($_POST['room']));
        $door->setIdLock($_POST['lock']);
        $length = -1;
        foreach ($_lockDAO->getLocks() as $infos) {
          if($infos->getId() == $id) {
            $length = $infos->getLength();
          }
        }
        $door->setLengthLock($length);
        $door->setName($_POST['name']);
        $_doorDAO->setDoor($door);
        print("Ajout effectué");
      }
  }

  //Formulaire Serrures
  function getForm6() {
  global $object, $_roomDAO, $_lockDAO, $_providerDAO;
    if(!isset($_POST['submit_valider_onglet6'])){
      echo <<<CODE
      <form method="POST">
      <input type="text" name="id" placeholder="lock id"><br/>
      <input name="submit_valider_onglet6" type="submit" value="Valider">
      </form>
CODE;
      }else{
        if($_lockDAO->getLockById($_POST['id']) == null){
          echo <<<CODE
          <form method="POST">
          <input type="text" name="id" value="{$_POST['id']}" readonly><br/>
CODE;
        echo '<select name="provider">';
        $providers = $_providerDAO->getProviders();
        foreach($providers as $provider){
          echo '<option value="'.$provider->getUsername().'">'.$provider->getUsername().'</option>';
        }
        echo '</select></br>';
echo <<<CODE
            <input type="text" name="length" placeholder="length"><br/>
            <input name="submit_valider_lock" type="submit" value="Valider">
          </form>
CODE;
        }else{
          //$id_object = $_lockDAO->getLockById($_POST['id']);
          $object = $_lockDAO->getLockById($_POST['id']);
          showForm();
        }
      }
        if(isset($_POST['submit_valider_lock'])){
        $locks = $_lockDAO->getLocks();
        $lock = new LockVO();
        $lock->setId(($locks[count($locks)-1]->getId())+1);
        $lock->setIdProvider($_providerDAO->getProviderIdWithUsername($_POST['provider']));
        $lock->setLength($_POST['length']);
        $_lockDAO->setLock($lock);
        print("Ajout effectué");
      }
  }

  //Formulaire Rooms
  function getForm7() {
  global $object, $_roomDAO;
    if(!isset($_POST['submit_valider_onglet7'])){
      echo <<<CODE
      <form method="POST">
      <input type="text" name="name" placeholder="room name"><br/>
      <input name="submit_valider_onglet7" type="submit" value="Valider">
      </form>
CODE;
      }else{
        if($_roomDAO->getRoomIdWithName($_POST['name']) == -1){
          echo <<<CODE
          Voulez vous créer cette nouvelle salle ?
          <form method="POST">
            <input type="text" name="name" value="{$_POST['name']}" readonly><br/>
            <input name="submit_valider_room" type="submit" value="Valider">
          </form>
CODE;
        }else{
          $id_object = $_roomDAO->getRoomIdWithName($_POST['name']);
          $object = $_roomDAO->getRoomById($id_object);
          showForm();
        }
      }
        if(isset($_POST['submit_valider_room'])){
        $rooms = $_roomDAO->getRooms();
        $room = new RoomVO();
        $room->setId(($rooms[count($rooms)-1]->getId())+1);
        $room->setName($_POST['name']);
        $_roomDAO->setRoom($room);
        print("Ajout effectué");
      }
  }

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
