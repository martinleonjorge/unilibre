<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  $blocks = find_by_id('blocks',(int)$_GET['id']);
  if(!$blocks){
    $session->msg("d","ID del bloque falta.");
    redirect('blocks.php');
  }
?>
<?php
  $delete_id = delete_by_id('blocks',(int)$blocks['id']);
  if($delete_id){
      $session->msg("s","Bloque eliminada");
      redirect('blocks.php');
  } else {
      $session->msg("d","Eliminación falló");
      redirect('blocks.php');
  }
?>
