<?php
require_once 'Model/VO/DoorVO.php';
require_once 'Model/DAO/interfaceDoorDAO.php';



// Implémentation de l'interface
// Ceci va fonctionner
class implementationDoorDAO_Dummy implements interfaceDoorDAO
{

  private $_doors = array();

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
     if (file_exists(dirname(__FILE__).'/../XML/doors.xml')) {
       $doors = simplexml_load_file(dirname(__FILE__).'/../XML/doors.xml');
       foreach($doors->children() as $xmlDoor)
       {
         $door = new DoorVO;
         // PRIMARYKEY
         $door->setId((int) $xmlDoor->idDoor);
          // FOREIGNKEYS
         $door->setIdSerrure((int) $xmlDoor->idSerrure);
         $door->setIdRoom((int) $xmlDoor->idRoom);
         $door->setIdLock((int) $xmlDoor->idLock);
         // Parametres
         //$door->setName((string) $xmlDoor->name);
         $door->setLengthLock((string) $xmlDoor->lengthLock);
         array_push($this->_doors, $door);
       }
     } else {
         throw new RuntimeException('Echec lors de l\'ouverture du fichier doors.xml.');
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
       self::$_instance = new implementationDoorDAO_Dummy();
     }

     return self::$_instance;
   }

   public function getDoors()
   {
     return $this->_doors;
   }

   /*public function getIdLockWithName($name) {
     $id_lock = -1;
     $i = 0;
     while($i < count($this->_doors) && $id_lock == -1) {
       if($this->_doors[i]->getName() == $name) {
         $id_lock = $this->_doors[i]->getIdLock();
       }
       $i++;
     }
     return $id_lock;
   }*/

   public function getIdLockWithIdRoom($id_room) {
     $id_lock = -1;
     $i = 0;
     while($i < count($this->_doors) && $id_lock == -1) {
       if($this->_doors[$i]->getIdRoom() == $id_room) {
         $id_lock = $this->_doors[$i]->getIdLock();
       }
       $i++;
     }
     return $id_lock;
   }
}


?>
