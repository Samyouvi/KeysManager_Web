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
////////DAO
$implementationKeychainDAO_Dummy = implementationKeychainDAO_Dummy::getInstance();
//$implementationKeyDAO_Dummy = implementationKeyDAO_Dummy::getInstance();
$implementationUserDAO_Dummy = implementationUserDAO_Dummy::getInstance();
//$interfaceKeyDAO = interfaceKeyDAO::getInstance();
//$interfaceKeychainDAO = interfaceKeychainDAO::getInstance();
//$interfaceUserDAO = interfaceUserDAO::getInstance();
////////Service
$implementationBorrowService_Dummy = implementationBorrowService_Dummy::getInstance();
//$interfaceBorrowService = interfaceBorrowService::getInstance();

////////DAO
echo '<pre>';
echo '$implementationKeychainDAO_Dummy<br/>';
print_r($implementationKeychainDAO_Dummy->getKeychains()[0]->getId());
//echo '<br/>$implementationKeyDAO_Dummy<br/>';
//print_r($implementationKeyDAO_Dummy->getInstance());
echo '<br/>$implementationUserDAO_Dummy<br/>';
print_r($implementationUserDAO_Dummy->getInstance());
//echo '<br/>$interfaceKeychainDAO<br/>';
//print_r($interfaceKeychainDAO->getInstance());
//echo '<br/>$interfaceKeyDAO<br/>';
//print_r($interfaceKeyDAO->getInstance());
//echo '<br/>$interfaceUserDAO<br/>';
//print_r($interfaceUserDAO->getInstance());
////////Service
echo '<br/>$implementationBorrowService_Dummy<br/>';
print_r($implementationBorrowService_Dummy);
//echo '<br/>$interfaceBorrowService<br/>';
//print_r($interfaceBorrowService->getInstance());*/
echo '</pre>';
?>
