<?php

?>

<form id="formActualizarUsuario">
    <input type="hidden" name="id_usuario" value="<?php echo $usuarioData['id_usuario']; ?>">
    <div class="modal-header">
        <h5 class="modal-title">Actualizar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <!-- DNI (readonly) -->
        <div class="form-group">
            <label for="dni">DNI</label>
            <input type="text" class="form-control" name="dni" value="<?php echo $usuarioData['dni']; ?>" readonly>
        </div>
        <!-- Nombres -->
        <div class="form-group">
            <label for="nombres">Nombres</label>
            <input type="text" class="form-control" name="nombres" value="<?php echo $usuarioData['nombres']; ?>" required>
        </div>
        <!-- Apellidos -->
        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" class="form-control" name="apellidos" value="<?php echo $usuarioData['apellidos']; ?>" required>
        </div>
        <!-- Dirección -->
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" name="direccion" value="<?php echo $usuarioData['direccion']; ?>" required>
        </div>
        <!-- Celular -->
        <div class="form-group">
            <label for="celular">Celular</label>
            <input type="text" class="form-control" name="celular" value="<?php echo $usuarioData['celular']; ?>" required>
        </div>
        <!-- Correo -->
        <div class="form-group">
            <label for="correo">Correo</label>
            <input type="email" class="form-control" name="correo" value="<?php echo $usuarioData['correo']; ?>" required>
        </div>
        <!-- Usuario -->
        <div class="form-group">
            <label for="usuario">Nombre de Usuario</label>
            <input type="text" class="form-control" name="usuario" value="<?php echo $usuarioData['usuario']; ?>" required>
        </div>
        <!-- Cargo -->
        <div class="form-group">
            <label for="fk_idrol">Cargo</label>
            <select name="fk_idrol" class="form-control" required>
                <?php while($rol = $roles->fetch_assoc()) { ?>
                    <option value="<?php echo $rol['id_rol']; ?>" <?php if($rol['id_rol'] == $usuarioData['fk_idrol']) echo 'selected'; ?>>
                        <?php echo $rol['cargo']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <!-- Contraseña (opcional) -->
        <div class="form-group">
            <label for="password">Nueva Contraseña (dejar en blanco si no desea cambiarla)</label>
            <input type="password" class="form-control" name="password">
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</form>
