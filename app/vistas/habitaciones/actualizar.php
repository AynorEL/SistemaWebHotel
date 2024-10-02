<?php
// Aquí asumimos que la información de la habitación ya fue cargada en $habitacion
?>

<form id="formActualizarHabitacion" method="POST">
    <div class="modal-header">
        <h5 class="modal-title" id="modalActualizarHabitacionLabel">Actualizar Habitación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="id_habitacion" value="<?= $habitacion['id_habitacion'] ?>">
        <div class="form-group">
            <label for="numero_habitacion">Número de la Habitación</label>
            <input type="number" class="form-control" name="numero" id="numero_habitacion" value="<?= $habitacion['numero_habitacion'] ?>" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" name="descripcion" id="descripcion" required><?= $habitacion['descripcion'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="fk_tipo">Tipo de Habitación</label>
            <select class="form-control" name="fk_tipo" id="fk_tipo" required>
                <?php foreach ($tipos_habitacion as $tipo): ?>
                    <option value="<?= $tipo['id_tipo'] ?>" <?= $tipo['id_tipo'] == $habitacion['fk_id_tipo'] ? 'selected' : '' ?>>
                        <?= $tipo['nom_tipo'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="fk_estado">Estado de la Habitación</label>
            <select class="form-control" name="fk_estado" id="fk_estado" required>
                <?php foreach ($estados_habitacion as $estado): ?>
                    <option value="<?= $estado['id_estado_habitacion'] ?>" <?= $estado['id_estado_habitacion'] == $habitacion['fk_id_estado_habitacion'] ? 'selected' : '' ?>>
                        <?= $estado['nombre_estado'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</form>

