<?php
  $page = '';
  if(isset($_GET['page'])) {
    $page = htmlspecialchars($_GET['page']);
  }

  if($page != 'download') {
    echo "<!DOCTYPE html>\n<html>\n";
    include('views/head.html');
    echo "<body>\n";
  }

  switch($page) {
    case 'keys_list':
      include('controllers/keys_list_controller.php');
      include('views/keys_list_view.php');
      break;
    /*case 'access_history':
      include('controllers/access_history_controller.php');
      include('views/access_history_view.php');
      break;*/
    case 'ressources_manager':
      include('controllers/ressources_manager_controller.php');
      include('views/ressources_manager_view.php');
      break;
    case 'import_export':
      include('controllers/import_export_controller.php');
      include('views/import_export_view.php');
      break;
    case 'infos':
      include('controllers/infos_controller.php');
      include('views/infos_view.php');
      break;
    case 'download':
      include('controllers/download_controller.php');
      include('views/download_view.php');
      break;
    default:
      $page = 'main_page';
      unset($_SESSION['cache']);
      include('views/main_page_view.html');
    break;
  }

  if($page != 'download') {
    echo "  </body>\n</html>";
  }

  if(!isset($_SESSION['back']))
    $_SESSION['back'] = '';
  if($page != 'infos')
    $_SESSION['back'] = $page;

  function debug($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
  }
?>
