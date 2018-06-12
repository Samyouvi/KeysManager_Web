<?php
  /// Import des class
  ////////DAO
  require_once 'Model/DAO/implementationKeyDAO_Dummy.php';

  /// Stockage des instances
  $implementationKeyDAO_Dummy = implementationKeyDAO_Dummy::getInstance();
  $list_keys = $implementationKeyDAO_Dummy->getkeys();
  echo '<pre>';
  print_r($list_keys);
  echo '</pre>';
  /*$list_keys[0]->id = 'key666';
  $list_keys = $implementationKeyDAO_Dummy->getkeys();*/
  echo '<pre>';
  print_r($list_keys);
  echo '</pre>';
?>


// usager id_key porte date_acces



// usager id_trousseau portes date_emprunt-date_fin_emprunt



// clés_trousseau




/// un usager peut-il avoir plusieurs trousseaux ?
