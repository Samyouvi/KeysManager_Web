<?php
require_once 'Model/VO/KeychainVO.php';
require_once 'Model/DAO/interfaceKeychainDAO.php';



// Implémentation de l'interface
// Ceci va fonctionner
class implementationKeychainDAO_Dummy implements interfaceKeychainDAO
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
         $keychain->setEnssatPrimaryKey((int) $xmlKeychain->enssatPrimaryKey);
         // Parametres
         $keychain->setCreationDate((string) $xmlKeychain->creationDate);
         $keychain->setDestructionDate((string) $xmlKeychain->destructionDate);
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

   public function getKeychains()
   {
     return $this->_keychains;
   }

   public function getRandomKeychain()
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
}


?>
