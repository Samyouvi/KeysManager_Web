<?php
  require_once 'models/DAO/implementationDoorDAO_Dummy.php';
  require_once 'models/DAO/implementationKeychainDAO_Dummy.php';
  require_once 'models/DAO/implementationKeyDAO_Dummy.php';
  require_once 'models/DAO/implementationLockDAO_Dummy.php';
  require_once 'models/DAO/implementationMasterkeyDAO_Dummy.php';
  require_once 'models/DAO/implementationOuvreDAO_Dummy.php';
  require_once 'models/DAO/implementationProviderDAO_Dummy.php';
  require_once 'models/DAO/implementationRoomDAO_Dummy.php';
  require_once 'models/DAO/implementationUserDAO_Dummy.php';

  require_once 'models/DAO/interfaceDoorDAO.php';
  require_once 'models/DAO/interfaceKeychainDAO.php';
  require_once 'models/DAO/interfaceKeyDAO.php';
  require_once 'models/DAO/interfaceLockDAO.php';
  require_once 'models/DAO/interfaceMasterkeyDAO.php';
  require_once 'models/DAO/interfaceOuvreDAO.php';
  require_once 'models/DAO/interfaceProviderDAO.php';
  require_once 'models/DAO/interfaceRoomDAO.php';
  require_once 'models/DAO/interfaceUserDAO.php';

  $_doorDAO = implementationDoorDAO_Dummy::getInstance();
  $_keychainDAO = implementationKeychainDAO_Dummy::getInstance();
  $_keyDAO = implementationKeyDAO_Dummy::getInstance();
  $_lockDAO = implementationLockDAO_Dummy::getInstance();
  $_masterkeyDAO = implementationMasterkeyDAO_Dummy::getInstance();
  $_ouvreDAO = implementationOuvreDAO_Dummy::getInstance();
  $_providerDAO = implementationProviderDAO_Dummy::getInstance();
  $_roomDAO = implementationRoomDAO_Dummy::getInstance();
  $_userDAO = implementationUserDAO_Dummy::getInstance();
?>
