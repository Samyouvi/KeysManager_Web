<?php
require_once 'models/DAO/implementationObjectDAO_Dummy.php';
require_once 'models/VO/UserVO.php';
require_once 'models/DAO/interfaceUserDAO.php';



// Implémentation de l'interface
// Ceci va fonctionner
class implementationUserDAO_Dummy extends implementationObjectDAO_Dummy implements interfaceUserDAO
{

  private $_users = array();

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
     if (file_exists(dirname(__FILE__).'/../XML/users.xml')) {
       $users = simplexml_load_file(dirname(__FILE__).'/../XML/users.xml');
       foreach($users->children() as $xmlUser)
       {
         $user = new UserVO;
         // PRIMARYKEY
         $user->setId((string) $xmlUser->enssatPrimaryKey);
         // Parametres
         $user->setUrlidentifier((string) $xmlUser->urlidentifier);
         $user->setUsername((string) $xmlUser->username);
         $user->setName((string) $xmlUser->name);
         $user->setSurname((string) $xmlUser->surname);
         $user->setPhone((string) $xmlUser->phone);
         $user->setStatus((string) $xmlUser->status);
         $user->setEmail((string) $xmlUser->email);
         array_push($this->_users, $user);
       }
     } else {
       echo '<pre>';
       throw new RuntimeException('Echec lors de l\'ouverture du fichier users.xml.');
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
       self::$_instance = new implementationUserDAO_Dummy();
     }
     return self::$_instance;
   }

   public function getUsers() {
     return $this->_users;
   }

   /*public function getUserByEnssatPrimaryKey($enssatPrimaryKey)
   {
     $i = 0;
     while($i < count($this->_users)) {
       if($this->_users[$i]->getEnssatPrimaryKey() == $enssatPrimaryKey)
         return $this->_users[$i];
       $i++;
     }
     return null;*/
     /*foreach($this->_users as $user)
     {
       if($user->getEnssatPrimaryKey()==$enssatPrimaryKey)
         return $user;
       else
         return null;
     }*/
   //}

   /*public function getIdWithRef($userRef) {
     $id_user = -1;
     $i = 0;
     while($i < count($this->_users) && $id_user == -1) {
       $username = $this->_users[$i]->getUsername();
       $name = $this->_users[$i]->getName();
       $surname = $this->_users[$i]->getSurname();
       $email = $this->_users[$i]->getEmail();
       if(
            ($surname.' '.$name == $userRef) || ($name.' '.$surname == $userRef) ||
            ($username == $userRef) ||
            ($email == $userRef) ||
            ($phone == $userRef)
       ) {
         $id_user = $this->_users[$i]->getEnssatPrimaryKey();
       }
       $i++;
     }
     return $id_user;
   }*/

   //////////
   public function getUserById($id_user) {
     //echo 'getUserById='.$id_user.'<br/>'."\n";
     return parent::genericGetObjectById($this->_users, $id_user);
   }

   public function setUser($user_object) {
     $this->_users = parent::genericSetObject($this->_users, $user_object);
     $this->saveUser();
   }

   public function delUser($id_user) {
     $this->_users = parent::genericDelObject($this->_users, $id_user);
     $this->saveUser();
   }

   public function toString() {
     return parent::genericToString($this->_users);
   }

   public function saveUser() {
     parent::genericSaveObject($this->_users, 'user');
   }

   public function getUserIdsWithUrlidentifier($urlidentifier) {
     $ids = array();
     foreach ($this->_providers as $infos) {
       if($infos->getUrlidentifier() == $urlidentifier) {
         $ids[] = $infos->getId();
       }
     }
     return $ids;
   }

   public function getUserIdsWithUsername($username) {
     $ids = array();
     foreach ($this->_providers as $infos) {
       if($infos->getUsername() == $username) {
         $ids[] = $infos->getId();
       }
     }
     return $ids;
   }

   public function getUserIdsWithName($name) {
     $ids = array();
     foreach ($this->_providers as $infos) {
       if($infos->getName() == $name) {
         $ids[] = $infos->getId();
       }
     }
     return $ids;
   }

   public function getUserIdsWithSurname($surname) {
     $ids = array();
     foreach ($this->_providers as $infos) {
       if($infos->getSurname() == $surname) {
         $ids[] = $infos->getId();
       }
     }
     return $ids;
   }

   public function getUserIdsWithPhone($phone) {
     $ids = array();
     foreach ($this->_providers as $infos) {
       if($infos->getPhone() == $phone) {
         $ids[] = $infos->getId();
       }
     }
     return $ids;
   }

   public function getUserIdsWithKeyId($status) {
     $ids = array();
     foreach ($this->_providers as $infos) {
       if($infos->getStatus() == $status) {
         $ids[] = $infos->getId();
       }
     }
     return $ids;
   }

   public function getUserIdsWithEmail($email) {
     $ids = array();
     foreach ($this->_providers as $infos) {
       if($infos->getEmail() == $email) {
         $ids[] = $infos->getId();
       }
     }
     return $ids;
   }
}
?>
