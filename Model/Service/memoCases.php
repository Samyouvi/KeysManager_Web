<?php
class memoCases
{
  /***
   * @var Singleton
   * @access private
   * @static
   */
   private static $_instance = null;

   private $_doorDAO;
   private $_keychainDAO;
   private $_keyDAO;
   private $_lockDAO;
   private $_masterkeyDAO;
   private $_ouvreDAO;
   private $_providerDAO;
   private $_roomDAO;
   private $_userDAO;


   /**
   * Constructeur de la classe
   *
   * @param void
   * @return void
   */
   private function __construct()
   {
     $this->_doorDAO = implementationDoorDAO_Dummy::getInstance();
     $this->_keychainDAO = implementationKeychainDAO_Dummy::getInstance();
     $this->_keyDAO = implementationKeyDAO_Dummy::getInstance();
     $this->_lockDAO = implementationLockDAO_Dummy::getInstance();
     $this->_masterkeyDAO = implementationMasterkeyDAO_Dummy::getInstance();
     $this->_ouvreDAO = implementationOuvreDAO_Dummy::getInstance();
     $this->_providerDAO = implementationProviderDAO_Dummy::getInstance();
     $this->_roomDAO = implementationRoomDAO_Dummy::getInstance();
     $this->_userDAO = implementationUserDAO_Dummy::getInstance();
   }

   /**
    * Méthode qui crée l'unique instance de la classe
    * si elle n'existe pas encore puis la retourne.
    *
    * @param void
    * @return Singleton
    */
   public static function getInstance() {
     if(is_null(self::$_instance)) {
       self::$_instance = new memoCases();
     }
     return self::$_instance;
   }

  // Cas 1
  public function getKeysWithRoomName($room_name) {
    echo '// Cas 1 //<br/>';
    $id_room = $this->_roomDAO->getIdWithName($room_name);
    if($id_room != -1) {
      echo '$id_room='.$id_room.'<br/>';
      $id_lock = $this->_doorDAO->getIdLockWithIdRoom($id_room);
      if($id_lock != -1) {
        echo '$id_lock='.$id_lock.'<br/>';
        $id_keys = $this->_ouvreDAO->getIdsWithIdLock($id_lock);
        foreach ($id_keys as $key) {
          $key_infos = $this->_keyDAO->getInfosWithId($key->getIdKey());
          echo '<pre>';
          print_r($key_infos);
          echo '</pre>';
        }
      } else {
        echo 'Aucune <strong>$id_room</strong> trouvée pour <strong>'+$room_name+'</strong>.';
      }
    } else {
      echo 'Aucune <strong>$id_lock</strong> trouvée pour <strong>'+$id_room+'</strong>.';
    }
  }

  // Cas 3
  public function getKeychains() {
    echo '// Cas 3 //<br/>';
    $id_keychains = $this->_keychainDAO->getKeychains();
    foreach ($id_keychains as $keychain) {
      echo 'id='.$keychain->getId().'<br/>';
      echo 'date_création='.$keychain->getCreationDate().'<br/>';
      echo 'date_expiration='.$keychain->getDestructionDate().'<br/>';
      echo 'utilisateur='.$this->_userDAO->getUserByEnssatPrimaryKey($keychain->getEnssatPrimaryKey())->getUsername().'<br/><br/>';
    }
  }

  // Cas 4
  public function importCSV($table_name, $file_path) {
    echo '// Cas 4 //<br/>';
    $header = array();
    $first = true;
    if(($handle = fopen($file_path, "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        if($first) {
          $first = false;
          foreach ($data as $value) {
            array_push($header, $value);
          }
        } else {
          foreach ($data as $key => $value) {
            echo $header[$key].'='.$value."<br />\n";
          }
        }
      }
      fclose($handle);
    }
    echo '<br/>';
  }

  // Cas 5
  //users username/name&surname/email/phone
  public function getKeysWithRoomUsername($userRef) {
    echo '// Cas 5 //<br/>';
    $id_user = $this->_userDAO->getIdWithRef($userRef);
    if($id_user != -1) {
      echo '$id_user='.$id_user.'<br/>';
      $id_keychain = $this->_keychainDAO->getIdWithUserId($id_user);
      if($id_keychain != -1) {
        echo '$id_keychain='.$id_keychain.'<br/>';
        $id_keys = $this->_keyDAO->getInfosWithIdKeychain($id_keychain);
        foreach ($id_keys as $key_infos) {
          echo '<pre>';
          print_r($key_infos);
          echo '</pre>';
        }
      } else {
        echo 'Aucune <strong>$id_keychain</strong> trouvée pour <strong>'.$id_keychain.'</strong>.';
      }
    } else {
      echo 'Aucune <strong>$id_user</strong> trouvée pour <strong>'.$id_user.'</strong>.';
    }
    echo '<br/><br/>';
  }
}
