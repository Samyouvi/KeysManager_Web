<?php
require_once 'models/DAO/implementationObjectDAO_Dummy.php';
require_once 'models/VO/ProviderVO.php';
require_once 'models/DAO/interfaceProviderDAO.php';



// Implémentation de l'interface
// Ceci va fonctionner
class implementationProviderDAO_Dummy extends implementationObjectDAO_Dummy implements interfaceProviderDAO
{

  private $_providers = array();

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
     if (file_exists(dirname(__FILE__).'/../XML/providers.xml')) {
       $providers = simplexml_load_file(dirname(__FILE__).'/../XML/providers.xml');
       foreach($providers->children() as $xmlProvider)
       {
         $provider = new ProviderVO;
         // PRIMARYKEY
         $provider->setId((int) $xmlProvider->idProvider);
         // Parametres
         $provider->setUsername((string) $xmlProvider->username);
         $provider->setName((string) $xmlProvider->name);
         $provider->setSurname((string) $xmlProvider->surname);
         $provider->setPhone((string) $xmlProvider->phone);
         $provider->setOffice((string) $xmlProvider->office);
         $provider->setEmail((string) $xmlProvider->email);
         array_push($this->_providers, $provider);
       }
     } else {
         echo '<pre>';
         throw new RuntimeException('Echec lors de l\'ouverture du fichier providers.xml.');
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
       self::$_instance = new implementationProviderDAO_Dummy();
     }
     return self::$_instance;
   }

   public function getProviders() {
     return $this->_providers;
   }

   ////////////////
   public function getProviderById($id_provider) {
     return parent::genericGetObjectById($this->_providers, $id_provider);
   }

   public function setProvider($provider_object) {
     $this->_providers = parent::genericSetObject($this->_providers, $provider_object);
     $this->saveProvider();
   }

   public function delProvider($id_provider) {
     $this->_providers = parent::genericDelObject($this->_providers, $id_provider);
     $this->saveProvider();
   }

   public function toString() {
     return parent::genericToString($this->_providers);
   }

   private function saveProvider() {
     parent::genericSaveObject($this->_providers, 'provider');
   }

   public function getProviderIdWithUsername($username) {
     $id = -1;
     foreach ($this->_providers as $infos) {
       if($infos->getUsername() == $username) {
         $id = $infos->getId();
       }
     }
     return $id;
   }

   public function getProviderIdsWithName($name) {
     $ids = array();
     foreach ($this->_providers as $infos) {
       if($infos->getName() == $name) {
         $ids[] = $infos->getId();
       }
     }
     return $ids;
   }

   public function getProviderIdsWithSurname($surname) {
     $ids = array();
     foreach ($this->_providers as $infos) {
       if($infos->getSurname() == $surname) {
         $ids[] = $infos->getId();
       }
     }
     return $ids;
   }

   public function getProviderIdWithPhone($phone) {
     $id = -1;
     foreach ($this->_providers as $infos) {
       if($infos->getPhone() == $phone) {
         $id = $infos->getId();
       }
     }
     return $id;
   }

   public function getProviderIdsWithOffice($office) {
     $ids = array();
     foreach ($this->_providers as $infos) {
       if($infos->getOffice() == $office) {
         $ids[] = $infos->getId();
       }
     }
     return $ids;
   }

   public function getProviderIdWithEmail($email) {
     $id = -1;
     foreach ($this->_providers as $infos) {
       if($infos->getEmail() == $email) {
         $id = $infos->getId();
       }
     }
     return $id;
   }
}
?>
