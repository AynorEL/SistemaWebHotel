<form id="formCrearHabitacion" method="POST">
    <div class="modal-header">
        <h5 class="modal-title" id="modalCrearHabitacionLabel">Crear Habitación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="numero">Número de Habitación</label>
            <input type="number" class="form-control" name="numero" id="numero" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" name="descripcion" id="descripcion" required></textarea>
        </div>
        <div class="form-group">
            <label for="fk_tipo">Tipo de Habitación</label>
            <select class="form-control" name="fk_tipo" id="fk_tipo" required>
                <option value="">Seleccionar Tipo</option>
                <?php foreach ($tipos_habitacion as $tipo): ?>
                    <option value="<?= $tipo['id_tipo'] ?>"><?= $tipo['nom_tipo'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="fk_estado">Estado de Habitación</label>
            <select class="form-control" name="fk_estado" id="fk_estado" required>
                <option value="">Seleccionar Estado</option>
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
