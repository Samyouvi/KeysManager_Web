<?php
  $errors = '';

  // Events capture
  if(isset($_GET['file'])) {
    $dir = 'tmp';
    $filename = htmlspecialchars($_GET['file']);
    $filepath = $dir.'/'.$filename;
    if(file_exists($filepath)) {
      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Cache-Control: public");
      header("Content-type: application/octet-stream");
      header("Content-Description: File Transfer");
      header("Content-Transfer-Encoding: binary");
      header('Content-Length: '.filesize($filepath));
      header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
      ob_end_flush();
      @readfile($filepath);
      unlink($filepath);
    } else {
      $errors = 'Fichier introuvable.';
    }
  } else {
    $errors = 'Fichier introuvable.';
  }

  // Displays functions
  function showErrors() {
  	global $errors;
  	if(strlen($errors)>0) {
  		echo '<div class="error">'.$errors.'</div>'."\n";
  	}
  }
?>
