<?php
//require_once 'models/DAO/interfaceObjectDAO.php';

abstract class implementationObjectDAO_Dummy //implements interfaceObjectDAO
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

  protected function genericSetObject($list, $object) { // Le passage par ref ne semble pas fonctionner
    if(count($list) > 0) {
      $type = get_class($list[0]);
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
      if($value->getId() == $id_object)
        unset($list[$key]);
        return $list;
    }
    return $list;
  }

  protected function genericGetObjectById($list, $id_object) {
    //debug($id_object);
    //echo 'manitou -> '.$id_object."<br>\n";
    foreach ($list as $value) {
      if($value->getId() == $id_object)
        return $value;
    }
    return null;
  }
}
?>
