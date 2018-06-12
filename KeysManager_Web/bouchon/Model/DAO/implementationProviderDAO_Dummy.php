<?php
require_once 'Model/VO/ProviderVO.php';
require_once 'Model/DAO/interfaceProviderDAO.php';



// Implémentation de l'interface
// Ceci va fonctionner
class implementationProviderDAO_Dummy implements interfaceProviderDAO
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
         throw new RuntimeException('Echec lors de l\'ouverture du fichier providers.xml.');
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

   public function getProviders()
   {
     return $this->_providers;
   }
}


?>
