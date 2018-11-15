<?php
  $page_title = 'Editar producto';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$product = find_by_id('products',(int)$_GET['id']);
$all_categories = find_all('categories');
if(!$product){
  $session->msg("d","Missing product id.");
  redirect('product.php');
}
?>
<?php
 if(isset($_POST['product'])){
//    $req_fields = array('product-title','product-categorie','product-stock_total','product-stock_loan', 'product-stock_available' );
    $req_fields = array('product-title','product-categorie');
    validate_fields($req_fields);

   if(empty($errors)){
       $p_name  = remove_junk($db->escape($_POST['product-title']));
       $p_cat   = (int)$_POST['product-categorie'];
       $p_ref   = $_POST['product-ref'];
//       $p_stk   = remove_junk($db->escape($_POST['product-stock_total']));
//       $p_stk_loan   = remove_junk($db->escape($_POST['product-stock_loan']));
//       $p_stk_ava  = remove_junk($db->escape($_POST['product-stock_available']));

       $query   = "UPDATE products SET";
       $query  .=" name ='{$p_name}', reference ='{$p_ref}',";
//       $query  .=" stock_loan ='{$p_stk_loan}', stock_available ='{$p_stk_ava}', categorie_id ='{$p_cat}'";
       $query  .=" categorie_id ='{$p_cat}'";
       $query  .=" WHERE id ='{$product['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Producto ha sido actualizado. ");
                 redirect('product.php', false);
               } else {
                 $session->msg('d',' Lo siento, actualización falló.');
                 redirect('edit_product.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_product.php?id='.$product['id'], false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Editar producto</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-ref" placeholder="Referencia" value="<?php echo remove_junk($product['reference']);?>">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" placeholder="Descripcion" value="<?php echo remove_junk($product['name']);?>">
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="product-categorie">
                    <option value="">Selecciona una categoría</option>
                   <?php  foreach ($all_categories as $cat): ?>
                     <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['categorie_id'] === $cat['id']): echo "selected"; endif; ?> >
                       <?php echo remove_junk($cat['name']); ?></option>
                   <?php endforeach; ?>
                 </select>
                  </div>
                </div>
              </div>

<!--              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Stock Total</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="number" class="form-control" name="product-stock_total" value="<?php echo remove_junk($product['stock_total']); ?>">
                   </div>
                  </div>
                 </div>
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Stock en Prestamo</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="number" class="form-control" name="product-stock_loan" value="<?php echo remove_junk($product['stock_loan']);?>">
                   </div>
                  </div>
                 </div>
                  <div class="col-md-4">
                   <div class="form-group">
                     <label for="qty">Stock Disponible</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-shopping-cart"></i>
                       </span>
                       <input type="number" class="form-control" name="product-stock_available" value="<?php echo remove_junk($product['stock_available']);?>">
                    </div>
                   </div>
                  </div>
               </div>
              </div>-->
              <button type="submit" name="product" class="btn btn-danger">Actualizar</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
