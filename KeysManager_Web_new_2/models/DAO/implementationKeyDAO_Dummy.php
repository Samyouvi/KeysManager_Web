<?php
require_once 'models/DAO/implementationObjectDAO_Dummy.php';
require_once 'models/VO/KeyVO.php';
require_once 'models/DAO/interfaceKeyDAO.php';



// Implémentation de l'interface
// Ceci va fonctionner
class implementationKeyDAO_Dummy extends implementationObjectDAO_Dummy implements interfaceKeyDAO
{

  private $_keys = array();

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
     if (file_exists(dirname(__FILE__).'/../XML/keys.xml')) {
       $keys = simplexml_load_file(dirname(__FILE__).'/../XML/keys.xml');
       foreach($keys->children() as $xmlKey)
       {
         $key = new KeyVO;
         // PRIMARYKEY
         $key->setId((int) $xmlKey->idKey);
         // FOREIGNKEYS
         $key->setIdKeychain((int) $xmlKey->idKeychain);
         $key->setIdProvider((int) $xmlKey->idProvider);
         // Parametres
         $key->setType((string) $xmlKey->type);
         array_push($this->_keys, $key);
       }
     } else {
         echo '<pre>';
         throw new RuntimeException('Echec lors de l\'ouverture du fichier keys.xml.');
         echo '</pre>';
         exit();
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
       self::$_instance = new implementationKeyDAO_Dummy();
     }
     return self::$_instance;
   }

   public function getKeys() {
     return $this->_keys;
   }

   /*public function getkeyByEnssatPrimaryKey($enssatPrimaryKey)
   {
     $i = 0;
     while($i < count($this->_keys)) {
       if($this->_keys[$i]->getEnssatPrimaryKey()==$enssatPrimaryKey)
         return $this->_keys[$i];
       $i++;
     }*/
     /*foreach($this->_keys as $key)
     {
       if($key->getEnssatPrimaryKey()==$enssatPrimaryKey)
         return $key;
       else
         return null;
     }*/
   //}

   /*public function getInfosWithId($id_key) {
      $infos = array();
      $i = 0;
      while($i < count($this->_keys) && count($infos) == 0) {
        if($this->_keys[$i]->getId() == $id_key) {
          $infos['id'] = $this->_keys[$i]->getId();
          $infos['id_keychain'] = $this->_keys[$i]->getIdKeychain();
          $infos['id_provider'] = $this->_keys[$i]->getIdProvider();
          $infos['nbr_exemplaires'] = $this->_keys[$i]->getNbrExemplaires();
          $infos['type'] = $this->_keys[$i]->getType();
        }
        $i++;
      }
      return $infos;
   }

   public function getInfosWithIdKeychain($id_keychain) {
      $infos_list = array();
      foreach ($this->_keys as $infos) {
        if($infos->getIdKeychain() == $id_keychain) {
          $record = array();
          $record['id'] = $infos->getId();
          $record['id_keychain'] = $infos->getIdKeychain();
          $record['id_provider'] = $infos->getIdProvider();
          $record['nbr_exemplaires'] = $infos->getNbrExemplaires();
          $record['type'] = $infos->getType();
          array_push($infos_list, $record);
        }
      }
      return $infos_list;
   }*/

   /////////////////////
   public function getKeyById($id_key) {
     return parent::genericGetObjectById($this->_keys, $id_key);
   }

   public function setKey($key_object) {
     $this->_keys = parent::genericSetObject($this->_keys, $key_object);
     $this->saveKey();
   }

   public function delKey($id_key) {
     $this->_keys = parent::genericDelObject($this->_keys, $id_key);
     $this->saveKey();
   }

   public function toString() {
     return parent::genericToString($this->_keys);
   }

   private function saveKey() {
     parent::genericSaveObject($this->_keys, 'key');
   }

   public function getKeyIdsWithKeychainId($id_keychain) {
      $ids = array();
      foreach ($this->_keys as $infos) {
        if($infos->getIdKeychain() == $id_keychain) {
          $ids[] = $infos->getId();
        }
      }
      return $ids;
   }

   public function getKeyIdsWithProvider($id_provider) {
      $ids = array();
      foreach ($this->_keys as $infos) {
        if($infos->getIdProvider() == $id_provider) {
          $ids[] = $infos->getId();
        }
      }
      return $ids;
   }

   public function getKeyIdsWithType($type) {
      $ids = array();
      foreach ($this->_keys as $infos) {
        if($infos->getType() == $type) {
          $ids[] = $infos->getId();
        }
      }
      return $ids;
   }
}
?>
