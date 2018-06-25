<?php
require_once 'models/DAO/implementationObjectDAO_Dummy.php';
require_once 'models/VO/DoorVO.php';
require_once 'models/DAO/interfaceDoorDAO.php';



// Implémentation de l'interface
// Ceci va fonctionner
class implementationDoorDAO_Dummy extends implementationObjectDAO_Dummy implements interfaceDoorDAO
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
         $door->setLengthLock((string) $xmlDoor->lengthLock);
         $door->setName((string) $xmlDoor->name);
         array_push($this->_doors, $door);
       }
     } else {
       echo '<pre>';
       throw new RuntimeException('Echec lors de l\'ouverture du fichier doors.xml.');
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
       self::$_instance = new implementationDoorDAO_Dummy();
     }
     return self::$_instance;
   }

   public function getDoors() {
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

   /*public function getIdLockWithIdRoom($id_room) {
     $id_lock = -1;
     $i = 0;
     while($i < count($this->_doors) && $id_lock == -1) {
       if($this->_doors[$i]->getIdRoom() == $id_room) {
         $id_lock = $this->_doors[$i]->getIdLock();
       }
       $i++;
     }
     return $id_lock;
   }*/

   ///////////////////////
   public function getDoorById($id_door) {
     return parent::genericGetObjectById($this->_doors, $id_door);
   }

   public function setDoor($door_object) {
     $this->_doors = parent::genericSetObject($this->_doors, $door_object);
     $this->saveDoor();
   }

   public function delDoor($id_door) {
     $this->_doors = parent::genericDelObject($this->_doors, $id_door);
     $this->saveDoor();
   }

   public function toString() {
     return parent::genericToString($this->_doors);
   }

   private function saveDoor() {
     parent::genericSaveObject($this->_doors, 'door');
   }

   public function getDoorIdsWithSerrureId($id_serrure) {
     $ids = array();
     foreach ($this->_doors as $infos) {
       if($infos->getIdSerrure() == $id_serrure) {
         $ids[] = $infos->getId();
       }
     }
     return $ids;
   }

   public function getDoorIdsWithRoomId($id_room) {
     $ids = array();
     foreach ($this->_doors as $infos) {
       if($infos->getIdRoom() == $id_room) {
         $ids[] = $infos->getId();
       }
     }
     return $ids;
   }

   public function getDoorIdWithLockId($id_lock) {
     $id = -1;
     foreach ($this->_doors as $infos) {
       if($infos->getIdLock() == $id_lock) {
         $ids = $infos->getId();
       }
     }
     return $id;
   }

   public function getDoorIdsWithName($name) {
     $ids = array();
     foreach ($this->_doors as $infos) {
       if($infos->getName() == $name) {
         $ids[] = $infos->getId();
       }
     }
     return $ids;
   }

   public function getDoorIdsWithLengthLock($length_lock) {
     $ids = array();
     foreach ($this->_doors as $infos) {
       if($infos->getLengthLock() == $length_lock) {
         $ids[] = $infos->getId();
       }
     }
     return $ids;
   }
}
?>
