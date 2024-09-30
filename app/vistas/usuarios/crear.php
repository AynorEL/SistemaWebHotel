<?php
// Asumiendo que $roles ya está disponible en el alcance
?>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="dni">DNI</label>
        <input type="text" class="form-control" id="dni" name="dni" required>
    </div>
    <div class="form-group col-md-6">
        <label for="nombres">Nombres</label>
        <input type="text" class="form-control" id="nombres" name="nombres" required>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="apellidos">Apellidos</label>
        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
    </div>
    <div class="form-group col-md-6">
        <label for="direccion">Dirección</label>
        <input type="text" class="form-control" id="direccion" name="direccion">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="celular">Celular</label>
        <input type="text" class="form-control" id="celular" name="celular">
    </div>
    <div class="form-group col-md-6">
        <label for="correo">Correo</label>
        <input type="email" class="form-control" id="correo" name="correo">
    </div>
</div>
<h5>Datos de Usuario</h5>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="usuario">Usuario</label>
        <input type="text" class="form-control" id="usuario" name="usuario" required>
    </div>
    <div class="form-group col-md-6">
        <label for="password">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
</div>
<div class="form-group">
    <label for="fk_idrol">Rol</label>
    <select class="form-control" id="fk_idrol" name="fk_idrol" required>
        <?php while($rol = $roles->fetch_assoc()) { ?>
            <option value="<?php echo $rol['id_rol']; ?>"><?php echo $rol['cargo']; ?></option>
        <?php } ?>
    </select>
</div>
