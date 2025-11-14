<?php
// Configuración de la página
$page_title = 'Título de la Página';
$menu = 'principal'; // 'principal', 'reserva', 'tabla'

// Incluir el layout
require_once 'inc/layout.php';
?>

<!-- Contenido específico de la página -->
<div class="max-w-4xl mx-auto">
    <div class="card">
        <div class="card-header">
            <h1 class="text-2xl font-semibold text-dark"><?php echo htmlspecialchars($page_title); ?></h1>
        </div>

        <div class="card-body">
            <!-- Contenido principal aquí -->
            <p class="text-neutral-600 mb-6">
                Este es un ejemplo de página usando el design system unificado.
            </p>

            <!-- Ejemplo de botones -->
            <div class="flex flex-wrap gap-4 mb-6">
                <a href="#" class="btn btn-primary">
                    <iconify-icon icon="mdi:plus"></iconify-icon>
                    Botón Primario
                </a>
                <a href="#" class="btn btn-secondary">
                    <iconify-icon icon="mdi:settings"></iconify-icon>
                    Botón Secundario
                </a>
                <a href="#" class="btn btn-success">
                    <iconify-icon icon="mdi:check"></iconify-icon>
                    Exportar Excel
                </a>
                <a href="#" class="btn btn-danger">
                    <iconify-icon icon="mdi:file-pdf"></iconify-icon>
                    Exportar PDF
                </a>
            </div>

            <!-- Ejemplo de formulario -->
            <form class="space-y-6">
                <div class="form-group">
                    <label for="example-input" class="form-label">Campo de Texto</label>
                    <input type="text" id="example-input" class="form-control" placeholder="Ingresa algo...">
                </div>

                <div class="form-group">
                    <label for="example-select" class="form-label">Selección</label>
                    <select id="example-select" class="form-select">
                        <option value="">Selecciona una opción</option>
                        <option value="1">Opción 1</option>
                        <option value="2">Opción 2</option>
                        <option value="3">Opción 3</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <iconify-icon icon="mdi:content-save"></iconify-icon>
                    Guardar
                </button>
            </form>

            <!-- Ejemplo de tabla -->
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-dark mb-4">Datos de Ejemplo</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Ejemplo 1</td>
                                <td><span class="badge badge-success">Activo</span></td>
                                <td>
                                    <a href="#" class="btn btn-secondary btn-sm">
                                        <iconify-icon icon="mdi:pencil"></iconify-icon>
                                        Editar
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Ejemplo 2</td>
                                <td><span class="badge badge-danger">Inactivo</span></td>
                                <td>
                                    <a href="#" class="btn btn-secondary btn-sm">
                                        <iconify-icon icon="mdi:pencil"></iconify-icon>
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Cerrar el layout
require_once 'inc/footer.php';
?>
