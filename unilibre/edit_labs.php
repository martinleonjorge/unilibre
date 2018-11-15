<?php
$page_title = 'Editar bloque';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(1);
?>
<?php
//Display all catgories.
$data_blocks = find_all('blocks');
$labs = find_by_id('labs', (int) $_GET['id']);
if (!$labs) {
    $session->msg("d", "Missing blocks id.");
    redirect('labs.php');
}
?>

<?php
if (isset($_POST['edit_blocks'])) {
    $req_field = array('blocks-name');
    validate_fields($req_field);
    $block_name = remove_junk($db->escape($_POST['blocks-name']));
    $block_lab = remove_junk($db->escape($_POST['bloque']));
    if (empty($errors)) {
        $sql = "UPDATE labs SET description='{$block_name}', id_block='{$block_lab}'";
        $sql .= " WHERE id='{$labs['id']}'";
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg("s", "Laboratorio actualizado con éxito.");
            redirect('labs.php', false);
        } else {
            $session->msg("d", "Lo siento, actualización falló.");
            redirect('labs.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('labs.php', false);
    }
}elseif (isset($_POST['exit'])) {
    redirect('labs.php', false);
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
                    <span>Editando laboratorio <?php echo remove_junk(ucfirst($labs['description'])); ?></span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_labs.php?id=<?php echo (int) $labs['id']; ?>">
                    <div class="form-group">
                        <label>Bloque</label>
                        <select class="form-control" name="bloque" id="bloque" required onchange="setBlock(this)">
                            <option value="">SELECCIONE</option>
                            <?php
                            foreach ($data_blocks as $value) {
                                ?>
                                <option value="<?= $value[0] ?>" <?=$value[0]==$labs['id_block']?"selected":""?>><?= $value[1] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <input type="text" class="form-control" name="blocks-name" value="<?php echo remove_junk(ucfirst($labs['description'])); ?>">
                    </div>
                    <button type="submit" name="edit_blocks" class="btn btn-primary">Actualizar laboratorio</button>
                    <button type="submit" class="btn btn-warning" name="exit">Atrás</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once('layouts/footer.php'); ?>
