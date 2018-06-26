<?php
  $type_collection = array('door', 'keychain', 'key', 'lock', 'masterkey', 'ouvre', 'provider', 'room', 'user');
  $download_link = '';
  $errors = array();
  $errors['import'] = '';
  $errors['export'] = '';
  $confirmation = '';

  // Events capture
  function importData($html_field) {
    global $_doorDAO, $_keychainDAO, $_keyDAO, $_lockDAO, $_masterkeyDAO, $_ouvreDAO, $_providerDAO, $_roomDAO, $_userDAO;
    global $type_collection, $errors, $confirmation;
    if(isset($_FILES[$html_field]) && isset($_FILES[$html_field]['tmp_name'])) {
      $table = '';
      $fields = array();
      ## Read file and load data
      $handle = fopen($_FILES[$html_field]['tmp_name'], 'r');
      $i = 1;
      if($handle) {
        while(!feof($handle)) {
          $buffer = trim(fgets($handle));
          if($i == 1) {
            $table = strtolower($buffer);
            if(!in_array($table, $type_collection)) {
              $errors['import'] = 'Le contenu du fichier était non conforme.';
              break;
            }
          } else if($i == 2) {
            $fields = explode(',', $buffer);
          } else {
            //echo '$new_object = new '.ucfirst($table).'VO();'."\n";
            eval('$new_object = new '.ucfirst($table).'VO();');
            $full_empty = true;
            foreach (explode(',', $buffer) as $key => $value) {
              if($value != '') {
                $full_empty = false;
              }
              //echo '$new_object->set'.ucfirst($fields[$key]).'("'.$value.'");'."\n";
              if(('id'.ucfirst($table) == $fields[$key]) || ($table == 'user' && $fields[$key] == 'enssatPrimaryKey')) {
                eval('$new_object->setId("'.$value.'");');
              } else {
                eval('$new_object->set'.ucfirst($fields[$key]).'("'.$value.'");');
              }
            }
            //echo '$_'.$table.'DAO->set'.ucfirst($table).'($new_object);'."\n\n";
            if(!$full_empty) {
              //debug($new_object->getId());
              eval('$_'.$table.'DAO->set'.ucfirst($table).'($new_object);');
            }
          }
          $i++;
        }
        //eval('debug($_'.$table.'DAO);');
        fclose($handle);
        $confirmation = 'Importation effectuée.';
      }
    } else {
      $errors['import'] = 'Impossible de charger le fichier.';
    }
  }

  function removeDirectory($dirname) {
    if(is_dir($dirname))
      $dir_handle = opendir($dirname);
    if(!$dir_handle)
      return false;
    while($file = readdir($dir_handle)) {
      if ($file != "." && $file != "..") {
        if (!is_dir($dirname."/".$file))
          unlink($dirname."/".$file);
        else
          delete_directory($dirname.'/'.$file);
      }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
  }

  function exportData($data_type) {
    global $_doorDAO, $_keychainDAO, $_keyDAO, $_lockDAO, $_masterkeyDAO, $_ouvreDAO, $_providerDAO, $_roomDAO, $_userDAO;
    global $download_link, $type_collection, $errors;
    if(!in_array($data_type, $type_collection)) {
      if($data_type == 'all') {
        $random_index = date('Ymd').rand(0, 9);
        $tmp_work_folder = 'tmp/'.$random_index;
        mkdir($tmp_work_folder);
        $empry_folder = true;
        foreach ($type_collection as $type) {
          eval('$object = $_'.$type.'DAO;');
          if($object != null) {
            $filename = str_replace('implementation', '', strtolower(get_class($object)));
            $filename = str_replace('dao_dummy', '', $filename).'_export.csv';
            $fp = fopen($tmp_work_folder.'/'.$filename, 'w');
            fwrite($fp, $object->toString());
            fclose($fp);
            $empry_folder = false;
          } else {
            $errors['export'] .= 'Aucune donnée trouvée pour l\'objet "'.$type.'".'."\n";
          }
        }
        if(!$empry_folder) {
          if(class_exists('ZipArchive')){
            $zip = new ZipArchive();
            if($zip->open('tmp/'.$random_index.'_all_export.zip', ZipArchive::CREATE)===true) {
              if($directory = opendir('./'.$tmp_work_folder)) {
                while(($fichier = readdir($directory))!==false) {
                  if($fichier != '.' && $fichier != '..') {
                    $zip->addFile($tmp_work_folder.'/'.$fichier);
                  }
                }
                closedir($directory);
              }
              /*$files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($tmp_work_folder),
                RecursiveIteratorIterator::LEAVES_ONLY
              );
              foreach($files as $name => $file) {
                if(!$file->isDir()) {
                  $filePath = $file->getRealPath();
                  $relativePath = substr($filePath, strlen($tmp_work_folder)+1);
                  $zip->addFile($filePath, $relativePath);
                }
              }*/
              //$zip->addFile($tmp_work_folder.'/*');
              $zip->close();
              $download_link = '<a href="?page=download&file='.$random_index.'_all_export.zip" target="_blank">Télécharger le CSV</a>';
            } else {
              $errors['export'] = 'Impossible de créer l\'archive.';
            }
          } else {
            $errors['export'] = 'La classe "ZipArchive" est inexistante, veullez installer le paquet "php<version_php>-zip".';
          }
        } else {
          $errors['export'] = 'Aucune donnée chargée.';
        }
        removeDirectory($tmp_work_folder);
      } else {
        $errors['export'] = 'La catégorie demandée était inconnue.';
      }
    } else {
      eval('$object = $_'.$data_type.'DAO;');
      if($object != null) {
        $filename = str_replace('implementation', '', strtolower(get_class($object)));
        $filename = str_replace('dao_dummy', '', $filename).'_export.csv';
        $fp = fopen('tmp/'.$filename, 'w');
        fwrite($fp, $object->toString());
        fclose($fp);
        $download_link = '<a href="?page=download&file='.$filename.'" target="_blank">Télécharger le CSV</a>';
      } else {
        $errors['export'] = 'Aucune donnée trouvée pour l\'objet "'.$data_type.'".';
      }
    }
  }

  if(isset($_POST['importer'])) {
    importData('file_source');
  }
  if(isset($_POST['selected_data'])) {
    $data_type = htmlspecialchars($_POST['selected_data']);
    exportData($data_type);
  }

  // Displays functions
  function showDataType() {
    global $type_collection;
    echo '<option value="all">Tous</option>'."\n";
    foreach ($type_collection as $type) {
      echo '<option value="'.$type.'">'.ucfirst($type).'</option>'."\n";
    }
  }

  function showErrors($index) {
		global $errors;
    if(isset($errors[$index])) {
      $error_msg = $errors[$index];
  		if(strlen($error_msg)>0) {
  			echo '<div class="error">'.$error_msg.'</div>'."\n";
  		}
    }
	}

  function showDownloadLink() {
    global $download_link;
    echo $download_link."\n";
  }

  function showConfirmation() {
    global $confirmation;
    echo $confirmation."\n";
  }
?>
