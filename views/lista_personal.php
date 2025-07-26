<?php
// views/lista_personal.php
require_once '../library/conections.php';
require_once '../models/personal_mode.php';

// Obtener todos los registros de personal
$personal_list = getAllPersonal();
$epp_fields = getEppFields();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Personal EPP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .navigation-links {
            padding: 20px 40px;
            background: #f8f9fa;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .nav-link {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, #495057, #343a40);
            transform: translateY(-2px);
        }

        .content {
            padding: 40px;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: scale(1.05);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        .filters {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-input {
            padding: 8px 12px;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .filter-input:focus {
            outline: none;
            border-color: #3498db;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: linear-gradient(135deg, #34495e, #2c3e50);
            color: white;
            padding: 15px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e9ecef;
            font-size: 0.85rem;
            vertical-align: top;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            text-align: center;
            min-width: 60px;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-info {
            background: #cce7f0;
            color: #055160;
        }

        .epp-status {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .epp-item-status {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
        }

        .photo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #3498db;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .actions {
            display: flex;
            gap: 5px;
        }

        .btn-action {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .btn-view {
            background: #17a2b8;
            color: white;
        }

        .btn-edit {
            background: #ffc107;
            color: #212529;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-1px);
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .content {
                padding: 20px;
            }
            
            .filters {
                flex-direction: column;
                align-items: stretch;
            }
            
            .table-container {
                overflow-x: auto;
            }
            
            .table {
                min-width: 1000px;
            }
        }
    </style>
</head>
<body>
    <!-- Navegación -->
    <div class="navigation-links">
        <a href="../admin/dashboard.php" class="nav-link">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard Admin
        </a>
        <a href="../personal_epp/index.php" class="nav-link">
            <i class="fas fa-plus-circle"></i>
            Registrar Personal
        </a>
    </div>

    <div class="container">
        <div class="header">
            <h1><i class="fas fa-users"></i> Lista de Personal EPP</h1>
            <p>Gestión y seguimiento de equipos de protección personal</p>
        </div>

        <div class="content">
            <!-- Estadísticas -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-number"><?php echo count($personal_list); ?></div>
                    <div class="stat-label">Total Personal</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #27ae60, #2ecc71);">
                    <div class="stat-number">
                        <?php echo count(array_filter($personal_list, function($p) { return $p['estado'] == 'activo'; })); ?>
                    </div>
                    <div class="stat-label">Personal Activo</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #e74c3c, #c0392b);">
                    <div class="stat-number">
                        <?php echo count(array_filter($personal_list, function($p) { return $p['estado'] == 'retirado'; })); ?>
                    </div>
                    <div class="stat-label">Personal Retirado</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #f39c12, #e67e22);">
                    <div class="stat-number"><?php echo count($epp_fields); ?></div>
                    <div class="stat-label">EPPs Configurados</div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="filters">
                <div class="filter-group">
                    <label><i class="fas fa-search"></i> Buscar:</label>
                    <input type="text" id="searchInput" class="filter-input" placeholder="Nombre, ocupación, área...">
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-filter"></i> Estado:</label>
                    <select id="estadoFilter" class="filter-input">
                        <option value="">Todos</option>
                        <option value="activo">Activo</option>
                        <option value="retirado">Retirado</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-map-marker-alt"></i> Sede:</label>
                    <select id="sedeFilter" class="filter-input">
                        <option value="">Todas</option>
                        <option value="LIMA">LIMA</option>
                        <option value="CHICLAYO">CHICLAYO</option>
                        <option value="AREQUIPA">AREQUIPA</option>
                        <option value="TARAPOTO">TARAPOTO</option>
                    </select>
                </div>
            </div>

            <!-- Tabla -->
            <div class="table-container">
                <?php if(empty($personal_list)): ?>
                    <div class="no-data">
                        <i class="fas fa-users fa-3x" style="color: #dee2e6; margin-bottom: 20px;"></i>
                        <h3>No hay personal registrado</h3>
                        <p>Comience registrando personal desde el formulario</p>
                        <a href="../personal_epp/index.php" class="nav-link" style="margin-top: 20px; display: inline-flex;">
                            <i class="fas fa-plus-circle"></i>
                            Registrar Personal
                        </a>
                    </div>
                <?php else: ?>
                    <table class="table" id="personalTable">
                        <thead>
                            <tr>
                                <th><i class="fas fa-image"></i> Foto</th>
                                <th><i class="fas fa-user"></i> Nombre</th>
                                <th><i class="fas fa-hashtag"></i> Edad</th>
                                <th><i class="fas fa-briefcase"></i> Ocupación</th>
                                <th><i class="fas fa-building"></i> Área</th>
                                <th><i class="fas fa-calendar"></i> F. Ingreso</th>
                                <th><i class="fas fa-toggle-on"></i> Estado</th>
                                <th><i class="fas fa-map-marker-alt"></i> Sede</th>
                                <th><i class="fas fa-hard-hat"></i> EPPs</th>
                                <th><i class="fas fa-cogs"></i> Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($personal_list as $persona): ?>
                                <tr>
                                    <td>
                                        <?php if($persona['foto']): ?>
                                            <img src="<?php echo htmlspecialchars($persona['foto']); ?>" 
                                                 alt="Foto" class="photo" 
                                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAiIGhlaWdodD0iNTAiIHZpZXdCb3g9IjAgMCA1MCA1MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjUiIGN5PSIyNSIgcj0iMjUiIGZpbGw9IiNERUUyRTYiLz4KPHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBzdHlsZT0idHJhbnNmb3JtOiB0cmFuc2xhdGUoMTNweCwgMTNweCkiPgo8cGF0aCBkPSJNMjAgMjFWMTlBNCA0IDAgMCAwIDE2IDE1SDhBNCA0IDAgMCAwIDQgMTlWMjEiIHN0cm9rZT0iIzZDNzU3RCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPGNpcmNsZSBjeD0iMTIiIGN5PSI3IiByPSI0IiBzdHJva2U9IiM2Qzc1N0QiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+Cjwvc3ZnPgo8L3N2Zz4K'">
                                        <?php else: ?>
                                            <div style="width: 50px; height: 50px; border-radius: 50%; background: #dee2e6; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-user" style="color: #6c757d;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?php echo htmlspecialchars($persona['name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($persona['edad']); ?></td>
                                    <td><?php echo htmlspecialchars($persona['ocupacion']); ?></td>
                                    <td><?php echo htmlspecialchars($persona['area_trabajo']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($persona['fecha_ingreso'])); ?></td>
                                    <td>
                                        <span class="badge <?php echo $persona['estado'] == 'activo' ? 'badge-success' : 'badge-danger'; ?>">
                                            <?php echo ucfirst($persona['estado']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info"><?php echo htmlspecialchars($persona['sede']); ?></span>
                                    </td>
                                    <td>
                                        <div class="epp-status">
                                            <?php 
                                            $epp_count = 0;
                                            $epp_activos = 0;
                                            foreach($epp_fields as $epp_key => $epp_info): 
                                                if(isset($epp_info['campo']) && isset($persona[$epp_info['campo']])):
                                                    $epp_count++;
                                                    if($persona[$epp_info['campo']] == 1):
                                                        $epp_activos++;
                                            ?>
                                                        <div class="epp-item-status">
                                                            <i class="fas fa-check-circle" style="color: #28a745;"></i>
                                                            <span><?php echo substr($epp_info['nombre'], 0, 15); ?></span>
                                                        </div>
                                            <?php 
                                                    endif;
                                                endif;
                                            endforeach; 
                                            
                                            if($epp_count == 0):
                                            ?>
                                                <span class="badge badge-warning">Sin EPP</span>
                                            <?php else: ?>
                                                <small style="color: #6c757d; margin-top: 5px;">
                                                    <?php echo $epp_activos; ?>/<?php echo $epp_count; ?> EPPs
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <button class="btn-action btn-view" onclick="verDetalle(<?php echo $persona['id']; ?>)" title="Ver detalle">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-action btn-edit" onclick="editarPersona(<?php echo $persona['id']; ?>)" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-action btn-delete" onclick="eliminarPersona(<?php echo $persona['id']; ?>)" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Funciones de filtrado
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const estadoFilter = document.getElementById('estadoFilter');
            const sedeFilter = document.getElementById('sedeFilter');
            const table = document.getElementById('personalTable');
            const rows = table ? table.getElementsByTagName('tbody')[0].getElementsByTagName('tr') : [];

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const estadoValue = estadoFilter.value.toLowerCase();
                const sedeValue = sedeFilter.value.toLowerCase();

                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];
                    const cells = row.getElementsByTagName('td');
                    
                    const nombre = cells[1].textContent.toLowerCase();
                    const ocupacion = cells[3].textContent.toLowerCase();
                    const area = cells[4].textContent.toLowerCase();
                    const estado = cells[6].textContent.toLowerCase();
                    const sede = cells[7].textContent.toLowerCase();

                    const matchesSearch = nombre.includes(searchTerm) || 
                                        ocupacion.includes(searchTerm) || 
                                        area.includes(searchTerm);
                    const matchesEstado = estadoValue === '' || estado.includes(estadoValue);
                    const matchesSede = sedeValue === '' || sede.includes(sedeValue);

                    if (matchesSearch && matchesEstado && matchesSede) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }

            if (searchInput) searchInput.addEventListener('input', filterTable);
            if (estadoFilter) estadoFilter.addEventListener('change', filterTable);
            if (sedeFilter) sedeFilter.addEventListener('change', filterTable);
        });

        // Funciones de acciones
        function verDetalle(id) {
            // Abrir modal o redireccionar a página de detalle
            window.open('../views/detalle_personal.php?id=' + id, '_blank', 'width=800,height=600');
        }

        function editarPersona(id) {
            // Redireccionar a formulario de edición
            window.location.href = '../personal_epp/editar.php?id=' + id;
        }

        function eliminarPersona(id) {
            if (confirm('¿Está seguro de que desea eliminar este registro? Esta acción no se puede deshacer.')) {
                // Enviar solicitud AJAX para eliminar
                fetch('../controllers/eliminar_personal.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({id: id})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Personal eliminado exitosamente');
                        location.reload();
                    } else {
                        alert('Error al eliminar: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el registro');
                });
            }
        }

        // Función para exportar a Excel
        function exportarExcel() {
            const table = document.getElementById('personalTable');
            if (!table) return;

            let csv = [];
            const rows = table.querySelectorAll('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const row = [];
                const cols = rows[i].querySelectorAll('td, th');
                
                for (let j = 0; j < cols.length - 1; j++) { // -1 para excluir columna de acciones
                    let cellText = cols[j].innerText.replace(/"/g, '""');
                    row.push('"' + cellText + '"');
                }
                csv.push(row.join(','));
            }

            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            
            if (link.download !== undefined) {
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', 'personal_epp_' + new Date().toISOString().slice(0,10) + '.csv');
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        // Función para imprimir
        function imprimirLista() {
            const printWindow = window.open('', '_blank');
            const tableHTML = document.querySelector('.table-container').innerHTML;
            
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Lista de Personal EPP</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; }
                            table { width: 100%; border-collapse: collapse; }
                            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                            th { background-color: #f2f2f2; }
                            .actions { display: none; }
                            .photo { width: 30px; height: 30px; }
                            @media print {
                                .actions { display: none !important; }
                            }
                        </style>
                    </head>
                    <body>
                        <h1>Lista de Personal EPP</h1>
                        <p>Fecha de impresión: ${new Date().toLocaleDateString()}</p>
                        ${tableHTML}
                    </body>
                </html>
            `);
            
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</body>
</html>