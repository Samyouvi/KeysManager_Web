<?php
require_once 'Model/DAO/implementationDoorDAO_Dummy.php';
require_once 'Model/DAO/implementationKeychainDAO_Dummy.php';
require_once 'Model/DAO/implementationKeyDAO_Dummy.php';
require_once 'Model/DAO/implementationLockDAO_Dummy.php';
require_once 'Model/DAO/implementationMasterkeyDAO_Dummy.php';
require_once 'Model/DAO/implementationOuvreDAO_Dummy.php';
require_once 'Model/DAO/implementationProviderDAO_Dummy.php';
require_once 'Model/DAO/implementationRoomDAO_Dummy.php';
require_once 'Model/DAO/implementationUserDAO_Dummy.php';

require_once 'Model/DAO/interfaceDoorDAO.php';
require_once 'Model/DAO/interfaceKeychainDAO.php';
require_once 'Model/DAO/interfaceKeyDAO.php';
require_once 'Model/DAO/interfaceLockDAO.php';
require_once 'Model/DAO/interfaceMasterkeyDAO.php';
require_once 'Model/DAO/interfaceOuvreDAO.php';
require_once 'Model/DAO/interfaceProviderDAO.php';
require_once 'Model/DAO/interfaceRoomDAO.php';
require_once 'Model/DAO/interfaceUserDAO.php';

require_once 'Model/Service/memoCases.php';

$testService = memoCases::getInstance();

// Cas 1
$testService->getKeysWithRoomName('102H');

// Cas 2
// à éclaircir

// Cas 3
$testService->getKeychains();

// Cas 4
$testService->importCSV("test", "Model/XML/test.xml");

// Cas 5
$testService->getKeysWithRoomUsername('jDalton');

// Cas 9
$testService->LostKeychain(2);
?>
