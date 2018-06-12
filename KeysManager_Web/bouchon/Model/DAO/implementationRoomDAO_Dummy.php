<?php
require_once 'Model/VO/RoomVO.php';
require_once 'Model/DAO/interfaceRoomDAO.php';



// Implémentation de l'interface
// Ceci va fonctionner
class implementationRoomDAO_Dummy implements interfaceRoomDAO
{

  private $_rooms = array();

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
     if (file_exists(dirname(__FILE__).'/../XML/rooms.xml')) {
       $rooms = simplexml_load_file(dirname(__FILE__).'/../XML/rooms.xml');
       foreach($rooms->children() as $xmlRoom)
       {
         $room = new RoomVO;
         // PRIMARYKEY
         $room->setId((int) $xmlRoom->idRoom);
         // Parametres
         $room->setName((string) $xmlRoom->name);
         array_push($this->_rooms, $room);
       }
     } else {
         throw new RuntimeException('Echec lors de l\'ouverture du fichier rooms.xml.');
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
       self::$_instance = new implementationRoomDAO_Dummy();
     }

     return self::$_instance;
   }

   public function getRooms()
   {
     return $this->_rooms;
   }

   public function getIdWithName($room_name) {
     $id_room = -1;
     $i = 0;
     while($i < count($this->_rooms) && $id_room == -1) {
       if($this->_rooms[$i]->getName() == $room_name) {
         $id_room = $this->_rooms[$i]->getId();
       }
       $i++;
     }
     return $id_room;
   }
}


?>
