<?php
  /// Import des class
  ////////DAO
  require_once 'Model/DAO/implementationKeychainDAO_Dummy.php';
  require_once 'Model/DAO/implementationUserDAO_Dummy.php';
  require_once 'Model/DAO/interfaceKeychainDAO.php';
  require_once 'Model/DAO/interfaceKeyDAO.php';
  require_once 'Model/DAO/interfaceUserDAO.php';
  //require_once 'Model/DAO/implementationKeyDAO_Dummy.php';
  ////////Service
  require_once 'Model/Service/implementationBorrowService_Dummy.php';
  require_once 'Model/Service/interfaceBorrowService.php';

  /// Stockage des instances
  $implementationBorrowService_Dummy = implementationBorrowService_Dummy::getInstance();

  /// affichage valeurs
  print_r($implementationBorrowService_Dummy.getBorrowings());

  /// fusion table
