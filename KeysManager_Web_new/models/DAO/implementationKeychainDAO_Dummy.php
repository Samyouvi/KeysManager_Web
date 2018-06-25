<?php
require_once 'models/DAO/implementationObjectDAO_Dummy.php';
require_once 'models/VO/KeychainVO.php';
require_once 'models/DAO/interfaceKeychainDAO.php';



// Implémentation de l'interface
// Ceci va fonctionner
class implementationKeychainDAO_Dummy extends implementationObjectDAO_Dummy implements interfaceKeychainDAO
{

  private $_keychains = array();

  /**
   * @var Singleton
   * @access private
   * @static
   */
   private static $_instance = null;


   /**
    * Constructeur de la classe
    *
    * @param void
    * @return void
    */
   private function __construct() {
     if (file_exists(dirname(__FILE__).'/../XML/keychains.xml')) {
       $keychains = simplexml_load_file(dirname(__FILE__).'/../XML/keychains.xml');
       foreach($keychains->children() as $xmlKeychain)
       {
         $keychain = new KeychainVO;
         // PRIMARYKEY
         $keychain->setId((int) $xmlKeychain->idKeychain);
         // FOREIGNKEYS
         $keychain->setEnssatPrimaryKey((string) $xmlKeychain->enssatPrimaryKey);
         // Parametres
         $keychain->setCreationDate((string) $xmlKeychain->creationDate);
         $keychain->setDestructionDate((string) $xmlKeychain->destructionDate);
         $keychain->setStatus((string) $xmlKeychain->status);
         array_push($this->_keychains, $keychain);
       }
     } else {
         throw new RuntimeException('Echec lors de l\'ouverture du fichier keychains.xml.');
     }
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
       self::$_instance = new implementationKeychainDAO_Dummy();
     }
     return self::$_instance;
   }

   public function getKeychains() {
     return $this->_keychains;
   }

   /*public function getRandomKeychain()
   {
     return $this->_keychains[array_rand($this->_keychains, 1)];
   }

   public function getIdWithUserId($id_user) {
     $id_keychain = -1;
     $i = 0;
     while($i < count($this->_keychains) && $id_keychain == -1) {
       if($this->_keychains[$i]->getEnssatPrimaryKey() == $id_user) {
         $id_keychain = $this->_keychains[$i]->getId();
       }
       $i++;
     }
     return $id_keychain;
   }

  public function setLost($id_keychain) {
    $retour = false;
    $i = 0;
    while($i < count($this->_keychains) && $retour == false) {
      if($this->_keychains[$i]->getId() == $id_keychain) {
        $retour = true;
        $this->_keychains[$i]->setStatus("Perdu");
      }
      $i++;
    }
    return $retour;
  }

  public function setRefound($id_keychain) {
    $retour = false;
    $i = 0;
    while($i < count($this->_keychains) && $retour == false) {
      if($this->_keychains[$i]->getId() == $id_keychain) {
        $retour = true;
        $this->_keychains[$i]->setStatus("Emprunté");
      }
      $i++;
    }
    return $retour;
  }

  public function setRendered($id_keychain) {
    $retour = false;
    $i = 0;
    while($i < count($this->_keychains) && $retour == false) {
      if($this->_keychains[$i]->getId() == $id_keychain) {
        $retour = true;
        $this->_keychains[$i]->setStatus("Archivé");
      }
      $i++;
    }
    return $retour;
  }

  public function getStatus($id_keychain) {
    $status = 'Inconnu';
    $i = 0;
    while($i < count($this->_keychains) && $status == 'Inconnu') {
      if($this->_keychains[$i]->getId() == $id_keychain) {
        $status = $this->_keychains[$i]->getStatus();
      }
      $i++;
    }
    return $status;
  }*/


  ///////////////
  public function getKeychainById($id_keychain) {
    return parent::genericGetObjectById($this->_keychains, $id_keychain);
  }

  public function setKeychain($keychain_object) {
    $this->_keychains = parent::genericSetObject($this->_keychains, $keychain_object);
  }

  public function delKeychain($id_keychain) {
    return parent::genericDelObject($this->_keychains, $id_keychain);
  }

  public function getKeychainIdsWithEnssatPrimaryKey($enssat_primary_key) {
    $ids = array();
    foreach ($this->_keychains as $infos) {
      if($infos->getEnssatPrimaryKey() == $enssat_primary_key) {
        $ids[] = $infos->getId();
      }
    }
    return $ids;
  }

  public function getKeychainIdsWithCreationDate($creation_date) {
    $ids = array();
    foreach ($this->_keychains as $infos) {
      if($infos->getCreationDate() == $creation_date) {
        $ids[] = $infos->getId();
      }
    }
    return $ids;
  }

  public function getKeychainIdsWithDestructionDate($destruction_date) {
    $ids = array();
    foreach ($this->_keychains as $infos) {
      if($infos->getDestructionDate() == $destruction_date) {
        $ids[] = $infos->getId();
      }
    }
    return $ids;
  }

  public function getKeychainIdsWithStatus($status) {
    $ids = array();
    foreach ($this->_keychains as $infos) {
      if($infos->getStatus() == $status) {
        $ids[] = $infos->getId();
      }
    }
    return $ids;
  }

  public function toString() {
    return parent::genericToString($this->_keychains);
  }
}
?>
