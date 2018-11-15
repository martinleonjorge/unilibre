<?php
$page_title = 'Lista de bloques';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
$all_labs = find_all('labs');
$data_blocks = find_all('blocks');
?>
<?php
if (isset($_POST['add_block'])) {
    $req_field = array('block-name');
    validate_fields($req_field);
    $block_name = remove_junk($db->escape($_POST['block-name']));
    $block_id = remove_junk($db->escape($_POST['bloque']));
    if (empty($errors)) {
        $sql = "INSERT INTO labs (id_block, description)";
        $sql .= " VALUES ('{$block_id}', '{$block_name}')";
        if ($db->query($sql)) {
            $session->msg("s", "Bloque agregado exitosamente.");
            redirect('labs.php', false);
        } else {
            $session->msg("d", "Lo siento, registro falló");
            redirect('labs.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('labs.php', false);
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
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Agregar laboratorio</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="labs.php">
                    <div class="form-group">
                        <label>Bloque</label>
                        <select class="form-control" name="bloque" id="bloque" required onchange="setBlock(this)">
                            <option value="">SELECCIONE</option>
                            <?php
                            foreach ($data_blocks as $value) {
                                ?>
                                <option value="<?= $value[0] ?>"><?= $value[1] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="block-name" placeholder="Nombre del laboratorio" required>
                    </div>
                    <button type="submit" name="add_block" class="btn btn-primary">Agregar laboratorio</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Lista de laboratorios</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Laboratorios</th>
                            <th class="text-center" style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_labs as $block): ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td><?php echo remove_junk(ucfirst($block['description'])); ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_labs.php?id=<?php echo (int) $block['id']; ?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a href="delete_labs.php?id=<?php echo (int) $block['id']; ?>"  class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
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
