<?php
$page_title = 'Prestamos';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
$all_branches = find_all('branch');
$all_blocks = find_all('blocks');
$all_products = find_all('products');
$all_loans = find_all('loans');

page_require_level(3);
?>
<?php
if (isset($_POST['add_loan'])) {
    if (empty($errors)) {
        $sql = "INSERT INTO loans (init_date, end_date, finisihed, id_sucursal, id_lab, id_producto)";
        $sql .= " VALUES ('{$_POST["init_date"]} {$_POST["init_time"]}', '{$_POST["end_date"]} {$_POST["end_time"]}', 0, '{$_POST["sucursal"]}', '{$_POST["lab"]}', '{$_POST["producto"]}')";
        if ($db->query($sql)) {

            $sqlInventory = "UPDATE inventory SET taken_quantitiy = taken_quantitiy +1 ";
            $sqlInventory.= "WHERE id_product='{$_POST["producto"]}' ";
            $sqlInventory.= "AND lab_id = '{$_POST["lab"]}' ";
            if ($db->query($sqlInventory)) {
                $session->msg("s", "Prestamo agregado exitosamente.");
                redirect('loan.php', false);
            }else{
                $session->msg("d", "Error al separar inventario");
                redirect('loan.php', false);
            }
            
        } else {
            $session->msg("d", "Lo siento, registro falló");
            redirect('loan.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('loan.php', false);
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
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Nuevo prestamo</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="loan.php">
                    <div class="form-group">
                        <label>Sucursal</label>
                        <select class="form-control" name="sucursal" required>
                            <option value="">SELECCIONE</option>
                            <?php
                            foreach ($all_branches as $value) {
                                ?>
                                <option value="<?= $value[0] ?>"><?= $value[1] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Bloque</label>
                        <select class="form-control" name="bloque" id="bloque" required onchange="setBlock(this)">
                            <option value="">SELECCIONE</option>
                            <?php
                            foreach ($all_blocks as $value) {
                                ?>
                                <option value="<?= $value[0] ?>"><?= $value[1] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Laboratorio</label>
                        <select class="form-control" name="lab" id="lab" required onchange="getProductsByLab(this)">
                            <option value="">SELECCIONE</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Producto</label>
                        <select class="form-control" name="producto" id="producto" required>
                            <option value="">SELECCIONE</option>
                            <?php
                            /* foreach($all_products as $value){
                              ?>
                              <option value="<?=$value[0]?>"><?=$value[1]?></option>
                              <?php
                              } */
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha inicial</label>
                        <input type="date" name="init_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Hora inicial</label>
                        <input type="time" name="init_time" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Fecha final</label>
                        <input type="date" name="end_date"class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Hora final</label>
                        <input type="time" name="end_time" class="form-control">
                    </div>
                    <button type="submit" name="add_loan" class="btn btn-primary">Solicitar prestamo</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Listado de prestamos</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Fecha inicial</th>
                            <th>Fecha final</th>
                            <th>Estado</th>
                            <th class="text-center" style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_loans as $loan): ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td class="text-center"><?php echo $loan[1] ?></td>
                                <td class="text-center"><?php echo $loan[2] ?></td>
                                <td class="text-center"><?php echo!$loan[3] ? "EN PRESTAMO" : "FINALIZADO" ?></td>

                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_loans.php?id=<?php echo (int) $loan['id']; ?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a disabled href="delete_blocks.php?id=<?php echo (int) $loan['id']; ?>"  class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
                                            <span class="glyphicon glyphicon-trash"></span>
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
</div>

<?php include_once('layouts/footer.php'); ?>
