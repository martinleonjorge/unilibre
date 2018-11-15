<?php
$page_title = 'Editar prestamo';
require_once('includes/load.php');
// Checkin What level user has permission to view this page

$all_branches = find_all('branch');
$all_blocks = find_all('blocks');
$all_products = find_all('products');
$all_labs = find_all('labs');

page_require_level(1);
?>
<?php
//Display all catgories.
$loans = find_by_id('loans', (int) $_GET['id']);
$info_lab = find_by_id('labs', $loans["id_lab"]);
//  print_r($loans);die();
if (!$loans) {
    $session->msg("d", "Missing blocks id.");
    redirect('loan.php');
}
?>

<?php
if (isset($_POST['edit_loan'])) {
    if (empty($errors)) {
        $sql = "UPDATE loans ";
        $sql .= "SET init_date='{$_POST["init_date"]} {$_POST["init_time"]}' ";
        $sql .= ",end_date='{$_POST["end_date"]} {$_POST["end_time"]}' ";
        $sql .= ",id_sucursal='{$_POST["sucursal"]}' ";
        $sql .= ",id_block='{$_POST["block"]}' ";
        $sql .= ",id_producto='{$_POST["producto"]}' ";
        $sql .= " WHERE id='{$loans['id']}'";
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg("s", "Prestamo actualizado con éxito.");
            redirect('loan.php', false);
        } else {
            $session->msg("d", "Lo siento, actualización falló.");
            redirect('loan.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('loan.php', false);
    }
} elseif (isset($_POST['finish_loand'])) {
    $sql = "UPDATE loans ";
    $sql .= "SET finisihed = 1 ";
    $sql .= " WHERE id='{$loans['id']}' LIMIT 1";
    $result = $db->query($sql);
    if ($result && $db->affected_rows() === 1) {
        $sqlInventory = "UPDATE inventory SET taken_quantitiy = taken_quantitiy - 1 ";
            $sqlInventory.= "WHERE id_product IN (SELECT id_producto FROM loans WHERE id='{$loans['id']}') ";
            $sqlInventory.= "AND lab_id IN (SELECT id_lab FROM loans WHERE id='{$loans['id']}') ";
            if (!$db->query($sqlInventory)) {
                $session->msg("s", "Error al liberar inventario.");
                redirect('loan.php', false);
            }
        $session->msg("s", "Prestamo finalizado con éxito.");
        redirect('loan.php', false);
    } else {
        $session->msg("d", "Lo siento, finalizacion falló.");
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
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Editando prestamo #<?php echo $loans['id']; ?></span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_loans.php?id=<?php echo (int) $loans['id']; ?>">
                    <div class="form-group">
                        <label>Sucursal</label>
                        <select class="form-control" name="sucursal" required>
                            <option value="">SELECCIONE</option>
                            <?php
                            foreach ($all_branches as $value) {
                                ?>
                                <option value="<?= $value[0] ?>" <?= $value[0] == $loans["id_sucursal"] ? "selected" : "" ?>><?= $value[1] ?></option>
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
                            foreach ($all_blocks as $value) {//$info_lab
                                ?>
                                <option value="<?= $value[0] ?>" <?= $value[0] == $info_lab["id_block"] ? "selected" : "" ?>><?= $value[1] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Laboratorio</label>
                        <select class="form-control" name="lab" id="lab" required>
                            <option value="">SELECCIONE</option>
                            <?php
                                foreach ($all_labs as $value) {
                                    ?>
                                    <option value="<?= $value[0] ?>" <?= $value[0] == $loans["id_lab"] ? "selected" : "" ?>><?= $value[1] ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Producto</label>
                        <select class="form-control" name="producto" required>
                            <option value="">SELECCIONE</option>
                            <?php
                            foreach ($all_products as $value) {
                                ?>
                                <option value="<?= $value[0] ?>" <?= $value[0] == $loans["id_producto"] ? "selected" : "" ?>><?= $value[2] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha inicial</label>
                        <input type="date" name="init_date" class="form-control" value="<?= substr($loans["init_date"], 0, 10) ?>">
                    </div>
                    <div class="form-group">
                        <label>Hora inicial</label>
                        <input type="time" name="init_time" class="form-control" value="<?= substr($loans["init_date"], 11, 8) ?>">
                    </div>
                    <div class="form-group">
                        <label>Fecha final</label>
                        <input type="date" name="end_date"class="form-control" value="<?= substr($loans["end_date"], 0, 10) ?>">
                    </div>
                    <div class="form-group">
                        <label>Hora final</label>
                        <input type="time" name="init_time" class="form-control" value="<?= substr($loans["end_date"], 11, 8) ?>">
                    </div>
                    <button type="submit" name="edit_loan" class="btn btn-primary" <?=$loans["finisihed"]==1?"disabled":""?>>Actualizar prestamo</button>
                    <button name="finish_loand" class="btn btn-success" <?=$loans["finisihed"]==1?"disabled":""?>>Finalizar prestamo</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once('layouts/footer.php'); ?>
