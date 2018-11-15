<?php
  $page_title = 'Agregar producto';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_blocks = find_all('blocks');
  $all_products = find_all('products');
?>
<?php
 if(isset($_POST['add_inventory'])){
   $req_fields = array('producto', 'lab','quantity');
   validate_fields($req_fields);
   if(empty($errors)){
     $inv_prd  = remove_junk($db->escape($_POST['producto']));
     $inv_lab  = remove_junk($db->escape($_POST['lab']));
     $inv_qty   = (int) remove_junk($db->escape($_POST['quantity']));
     
     $date    = make_date();
     $query  = "INSERT INTO inventory (";
     $query .=" id_product, lab_id, stock_quantity, taken_quantitiy ";
     $query .=") VALUES (";
     $query .="'{$inv_prd}', '{$inv_lab}', {$inv_qty}, 0";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE stock_quantity = stock_quantity+$inv_qty";
     if($db->query($query)){
       $session->msg('s',"Inventario ingresado exitosamente. ");
       redirect('new_inventory.php', false);
     } else {
       $session->msg('d',' Lo siento, registro falló.');
       redirect('new_inventory.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('inventory.php',false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<script src="scripts.js"></script>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Registro de inventario</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
             <form method="post" action="new_inventory.php" class="clearfix">
              <div class="form-group">
                <select class="form-control" name="bloque" id="bloque" required onchange="setBlock(this)">
                    <option value="">SELECCIONE BLOQUE</option>
                    <?php
                    foreach($all_blocks as $value){
                        ?>
                    <option value="<?=$value[0]?>"><?=$value[1]?></option>
                    <?php
                    }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <select class="form-control" name="lab" id="lab" required>
                    <option value="">SELECCIONE LABORATORIO</option>
                </select>
              </div>
              <div class="form-group">
                <select class="form-control" name="producto" id="producto" required>
                    <option value="">SELECCIONE PRODUCTO</option>
                    <?php
                    foreach($all_products as $value){
                        ?>
                    <option value="<?=$value[0]?>"><?=$value[2]?></option>
                    <?php
                    }
                    ?>
                </select>
              </div>
              <div class="form-group">
                  <input class="form-control" type="number" min="0" name="quantity" placeholder="Cantidad">
              </div>
              <button type="submit" name="add_inventory" class="btn btn-danger">Agregar producto</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
