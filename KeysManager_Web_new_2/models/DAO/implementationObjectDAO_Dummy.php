<?php

abstract class implementationObjectDAO_Dummy
{
  protected function genericToString($list) {
    $content = '';
    foreach($list as $item) {
      if($content == '') {
        $content = strtolower(str_replace('VO', '', get_class($item)))."\n";
        $fields = '';
        $values = '';
        foreach(((array) $item) as $key => $value) {
          $key = trim($key, "* \t\n\r\0\x0B"); // remove characters (" *") added by the cast
          $fields .= $key.',';
          $values .= $value.',';
        }
        $fields = substr($fields, 0, -1);
        $values = substr($values, 0, -1);
        $content .= $fields."\n".$values."\n";
      } else {
         foreach(((array) $item) as $value) {
           $content .= $value.',';
         }
         $content = substr($content, 0, -1)."\n";
      }
    }
    return $content;
  }

  protected function genericSetObject($list, $object) {
    if(count($list) > 0) {
      $i = 0;
      $type = '';
      while($i < count($list)) {
        if(isset($list[$i])){
          $type = get_class($list[$i]);
        }
        $i++;
      }
      if($object instanceof $type) {
        $i = -1;
        foreach ($list as $index => $item) {
          if($item->getId() == $object->getId()) {
            $i = $index;
            unset($list[$index]);
            break;
          }
        }
        if($i != -1) {
          $list[] = $object;
        } else {
          $list[$i] = $object;
        }
      }
    } else {
      $list[] = $object;
    }
    return $list;
  }

  protected function genericDelObject($list, $id_object) {
    foreach ($list as $key => $value) {
      if($value->getId() == $id_object) {
        unset($list[$key]);
        return $list;
      }
    }
    return $list;
  }

  protected function genericGetObjectById($list, $id_object) {
    foreach ($list as $value) {
      if($value->getId() == $id_object)
        return $value;
    }
    return null;
  }

  protected function genericSaveObject($list, $type) {
    // Determines the filepath
    $filepath = dirname(__FILE__).'/../XML/'.$type.'s.xml';
    if(count($list) > 0) {
      // Reset file
      if(file_exists($filepath)) {
        if($fp = fopen($filepath, "a")) {
        	fputs($fp, '');
        	fclose($fp);
        } else {
        	echo '<pre>';
          throw new RuntimeException('Echec lors de l\'ouverture du fichier '.$type.'s.xml.');
          echo '</pre>';
          exit();
        }
      }
      // Create xml structure
      $xml = new DOMDocument('1.0', 'utf-8');
      $xml->preserveWhiteSpace = false;
      $xml->formatOutput = true;
      // Create xml root node
      $family_node = $xml->createElement($type.'s');
      $xml->appendChild($family_node);
      foreach($list as $item) {
        // Create xml node for the item
        $object_node = $xml->createElement($type);
        $family_node->appendChild($object_node);
        foreach(((array) $item) as $key => $value) {
          $key = trim($key, "* \t\n\r\0\x0B"); // remove characters (" *") added by the cast
          $key = str_replace(' ', '', lcfirst(ucwords(str_replace('_', ' ', $key)))); // adapt the key format (my_key to myKey)
          $value_node = $xml->createElement($key, $value);
          $object_node->appendChild($value_node);
        }
      }
      // Save xml
      $xml->save($filepath);
    } else {
      // Create an empty xml file
      $xml = new DOMDocument('1.0', 'utf-8');
      $xml->preserveWhiteSpace = false;
      $xml->formatOutput = true;
      $family_node = $xml->createElement($type.'s');
      $xml->appendChild($family_node);
      // Save xml
      $xml->save($filepath);
    }
  }
}
?>
