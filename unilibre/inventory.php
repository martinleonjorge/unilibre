<?php
$page_title = 'Lista de productos';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
$inventorys = join_inventory_table();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="pull-right">
                    <a href="new_inventory.php" class="btn btn-primary">Ingresar inventario</a>
                </div>
                <div class="pull-right">
                    <a href="inventory_excel.php" target="_blank" class="btn btn-success">Descargar Excel</a>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th> Laboratorio </th>
                            <th class="text-center" style="width: 10%;"> Categoría </th>
                            <th class="text-center" style="width: 10%;"> Referencia </th>
                            <th class="text-center" style="width: 10%;"> Producto </th>
                            <th class="text-center" style="width: 10%;"> Cantidad total </th>
                            <th class="text-center" style="width: 10%;"> Cantidad en prestamo </th>
                            <th class="text-center" style="width: 100px;"> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inventorys as $inventory): ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td class="text-center"> <?php echo remove_junk($inventory['lab_description']); ?></td>
                                <td class="text-center"> <?php echo remove_junk($inventory['category_name']); ?></td>
                                <td class="text-center"> <?php echo remove_junk($inventory['reference']); ?></td>
                                <td class="text-center"> <?php echo remove_junk($inventory['product_name']); ?></td>
                                <td class="text-center"> <?php echo remove_junk($inventory['stock_quantity']); ?></td>
                                <td class="text-center"> <?php echo remove_junk($inventory['taken_quantitiy']); ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="add_inventory.php?id=<?php echo (int) $inventory['inventory_id']; ?>" class="btn btn-danger btn-xs"  title="Adicionar" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
