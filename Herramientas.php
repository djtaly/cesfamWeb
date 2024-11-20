<!--Crear roles-->
			<div id="crearRoles" class="seccion" style="display: none;">
					<h3>Crear Roles</h3>
					<form id="formCrearRoles">
						<input type="text" name="nombre_rol" placeholder="Nombre del Rol" required>
						<button type="submit" class="btn-guardar">Crear Rol</button>
					</form>

					<h3>Lista de Roles</h3>
					<table id="tablaRoles">
						<thead>
							<tr>
								<th>ID</th>
								<th>Nombre del Rol</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<!-- Aquí se cargarán los roles dinámicamente -->
						</tbody>
					</table>
			</div>

		
		<!-- Crear Permisos -->
		<div id="crearPermisos" class="seccion" style="display: none;">
			<h3>Crear Permisos</h3>
			<form id="formCrearRoles">
				<input type="text" name="nombre_permiso" placeholder="Nombre del Permiso" required>
				<button type="submit" class="btn-guardar">Crear Permiso</button>
			</form>

			<h3>Lista de Permisos</h3>
			<table id="tablaPermisos">
				<thead>
					<tr>
						<th>ID</th>
						<th>Nombre del Permiso</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<!-- Aquí se cargarán los permisos dinámicamente -->
				</tbody>
			</table>
		</div>

		
					<!-- Crear Tipos de Consultas -->
			<div id="tipoConsultas" class="seccion" style="display: none;">
				<h3>Crear Tipo de Consulta</h3>
				<form id="formTipoConsultas">
					<input type="text" name="nombre_consulta" placeholder="Nombre de la Consulta" required>
					<button type="submit" class="btn-guardar">Crear Consulta</button>
				</form>

				<h3>Tipos de Consultas Registradas</h3>
				<table id="tablaConsultas">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nombre</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<!-- Aquí se cargarán las consultas dinámicamente -->
					</tbody>
				</table>
			</div>


		<!--Crear prioridades-->
		<div id="prioridades" class="seccion" style="display: none;">
    <h3>Asignar Prioridades</h3>
    <form id="formPrioridades">
        <input type="text" name="nombre_prioridad" placeholder="Nombre de la Prioridad" required>
        <button type="submit" class="btn-guardar">Asignar Prioridad</button>
    </form>
</div>
		
		<!--Asignar Roles y Permisos-->
		<div id="asignarRolesPermisos" class="seccion" style="display: none;">
    <h3>Asignar Roles y Permisos</h3>
    <form id="formAsignarRolesPermisos">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <select name="rol" required>
            <option value="">Seleccionar Rol</option>
            <!-- Opciones dinámicas -->
        </select>
        <select name="permiso" required>
            <option value="">Seleccionar Permiso</option>
            <!-- Opciones dinámicas -->
        </select>
        <button type="submit" class="btn-guardar">Asignar</button>
    </form>
</div>
