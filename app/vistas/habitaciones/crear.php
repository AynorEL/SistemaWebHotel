<form id="formCrearHabitacion" method="POST">
    <div class="modal-header">
        <h5 class="modal-title" id="modalCrearHabitacionLabel">Crear Habitación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <input type="number" class="form-control" name="numero" id="numero" placeholder="Número de Habitación" required>
        </div>
        <div class="form-group">
            <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Descripción" required></textarea>
        </div>
        <div class="form-group">
            <select class="form-control" name="fk_tipo" id="fk_tipo" required>
                <option value="" disabled selected>Seleccionar Tipo de Habitación</option>
                <?php foreach ($tipos_habitacion as $tipo): ?>
                    <option value="<?= $tipo['id_tipo'] ?>"><?= $tipo['nom_tipo'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="fk_estado" id="fk_estado" required>
                <option value="" disabled selected>Seleccionar Estado de Habitación</option>
                <?php foreach ($estados_habitacion as $estado): ?>
                    <option value="<?= $estado['id_estado_habitacion'] ?>"><?= $estado['nombre_estado'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</form>
