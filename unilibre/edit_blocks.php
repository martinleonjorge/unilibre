<?php
  $page_title = 'Editar bloque';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  //Display all catgories.
  $blocks = find_by_id('blocks',(int)$_GET['id']);
  if(!$blocks){
    $session->msg("d","Missing blocks id.");
    redirect('blocks.php');
  }
?>

<?php
if(isset($_POST['edit_blocks'])){
  $req_field = array('blocks-name');
  validate_fields($req_field);
  $block_name = remove_junk($db->escape($_POST['blocks-name']));
  if(empty($errors)){
        $sql = "UPDATE blocks SET name='{$block_name}'";
       $sql .= " WHERE id='{$blocks['id']}'";
     $result = $db->query($sql);
     if($result && $db->affected_rows() === 1) {
       $session->msg("s", "Bloque actualizado con éxito.");
       redirect('blocks.php',false);
     } else {
       $session->msg("d", "Lo siento, actualización falló.");
       redirect('blocks.php',false);
     }
  } else {
    $session->msg("d", $errors);
    redirect('blocks.php',false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
   <div class="col-md-5">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Editando <?php echo remove_junk(ucfirst($blocks['name']));?></span>
        </strong>
       </div>
       <div class="panel-body">
         <form method="post" action="edit_blocks.php?id=<?php echo (int)$blocks['id'];?>">
           <div class="form-group">
               <input type="text" class="form-control" name="blocks-name" value="<?php echo remove_junk(ucfirst($blocks['name']));?>">
           </div>
           <button type="submit" name="edit_blocks" class="btn btn-primary">Actualizar bloque</button>
       </form>
       </div>
     </div>
   </div>
</div>



<?php include_once('layouts/footer.php'); ?>
