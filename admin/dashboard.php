<?php
// admin/dashboard.php
session_start();
require_once '../library/conections.php';

// Verificar si es admin (puedes agregar tu lógica de autenticación aquí)

// Función para obtener todas las columnas EPP existentes
function getEppColumns() {
    try {
        $conn = dataPrueba();
        $sql = "SHOW COLUMNS FROM personal_epp WHERE Field LIKE '%_entrega_%' OR Field LIKE '%cambio_%' OR Field LIKE '%zapato_seguridad%' OR Field LIKE '%casco_seguridad%' OR Field LIKE '%orejeras_casco%'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return [];
    }
}

// Función para agregar nuevo EPP
function agregarNuevoEpp($nombre_epp) {
    try {
        $conn = dataPrueba();
        
        // Crear el nombre de la columna base
        $palabras = explode(' ', trim($nombre_epp));
        $iniciales = '';
        
        // Obtener iniciales de las primeras dos palabras
        for($i = 0; $i < min(2, count($palabras)); $i++) {
            $iniciales .= strtolower(substr($palabras[$i], 0, 1));
        }
        
        // Si hay más palabras, agregar más iniciales
        if(count($palabras) > 2) {
            for($i = 2; $i < count($palabras); $i++) {
                $iniciales .= strtolower(substr($palabras[$i], 0, 1));
            }
        }
        
        $nombre_columna = str_replace(' ', '_', strtolower($nombre_epp));
        $fecha_entrega = 'fecha_entrega_' . $iniciales;
        $cambio = 'cambio_' . $iniciales;
        
        // Verificar si las columnas ya existen
        $check_sql = "SHOW COLUMNS FROM personal_epp WHERE Field IN ('$nombre_columna', '$fecha_entrega', '$cambio')";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->execute();
        $existing = $check_stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($existing) > 0) {
            return "Error: Ya existe un EPP con ese nombre o iniciales similares";
        }
        
        // Agregar las columnas
        $sql1 = "ALTER TABLE personal_epp ADD COLUMN `$nombre_columna` TINYINT(1) DEFAULT 0";
        $sql2 = "ALTER TABLE personal_epp ADD COLUMN `$fecha_entrega` DATE NULL";
        $sql3 = "ALTER TABLE personal_epp ADD COLUMN `$cambio` DATE NULL";
        
        $conn->exec($sql1);
        $conn->exec($sql2);
        $conn->exec($sql3);
        
        return "EPP agregado exitosamente";
        
    } catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

// Procesar formulario
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_epp'])) {
    $nombre_epp = trim($_POST['nombre_epp']);
    if(!empty($nombre_epp)) {
        $mensaje = agregarNuevoEpp($nombre_epp);
    } else {
        $mensaje = "Error: Debe ingresar un nombre para el EPP";
    }
}

// Obtener EPPs existentes
$epp_columns = getEppColumns();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - EPP Manager</title>
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

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="3" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
        }

        .dashboard-title {
            font-size: 2.5rem;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .dashboard-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .dashboard-content {
            padding: 40px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #3498db;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 1rem;
        }

        .form-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-input:focus {
            outline: none;
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .btn {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn:hover {
            background: linear-gradient(135deg, #2980b9, #1abc9c);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #229954, #27ae60);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .epp-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .epp-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #17a2b8;
            transition: all 0.3s ease;
        }

        .epp-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }

        .epp-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
            text-transform: capitalize;
        }

        .epp-details {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
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

        .navigation-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .dashboard-content {
                padding: 20px;
            }
            
            .dashboard-title {
                font-size: 2rem;
            }
            
            .epp-grid {
                grid-template-columns: 1fr;
            }
            
            .navigation-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">
                <i class="fas fa-shield-alt"></i>
                Dashboard EPP Manager
            </h1>
            <p class="dashboard-subtitle">Panel de Administración - Gestión de Equipos de Protección Personal</p>
        </div>

        <div class="dashboard-content">
            <!-- Botones de navegación -->
            <div class="navigation-buttons">
                <a href="../personal_epp/index.php" class="btn">
                    <i class="fas fa-plus-circle"></i>
                    Registrar Personal EPP
                </a>
                <a href="../views/lista_personal.php" class="btn btn-success">
                    <i class="fas fa-list"></i>
                    Ver Lista Personal
                </a>
            </div>

            <!-- Estadísticas -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-number"><?php echo count($epp_columns); ?></div>
                    <div class="stat-label">EPPs Registrados</div>
                </div>
            </div>

            <!-- Mensajes -->
            <?php if($mensaje): ?>
                <div class="alert <?php echo strpos($mensaje, 'Error') === 0 ? 'alert-error' : 'alert-success'; ?>">
                    <i class="fas <?php echo strpos($mensaje, 'Error') === 0 ? 'fa-exclamation-triangle' : 'fa-check-circle'; ?>"></i>
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <!-- Formulario para agregar nuevo EPP -->
            <div class="card">
                <h2 class="card-title">
                    <i class="fas fa-plus-circle"></i>
                    Agregar Nuevo EPP
                </h2>
                <form method="POST">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-hard-hat"></i>
                            Nombre del EPP:
                        </label>
                        <input type="text" name="nombre_epp" class="form-input" 
                               placeholder="Ej: Guantes Anticorte, Botas Dieléctricas, etc." 
                               required maxlength="30">
                        <small style="color: #6c757d; font-size: 0.9rem; margin-top: 5px; display: block;">
                            <i class="fas fa-info-circle"></i>
                            Se crearán automáticamente las columnas: nombre_epp, fecha_entrega_xx, cambio_xx
                        </small>
                    </div>
                    <button type="submit" name="agregar_epp" class="btn">
                        <i class="fas fa-save"></i>
                        Agregar EPP
                    </button>
                </form>
            </div>

            <!-- Lista de EPPs existentes -->
            <div class="card">
                <h2 class="card-title">
                    <i class="fas fa-list-ul"></i>
                    EPPs Existentes en el Sistema
                </h2>
                <?php if(empty($epp_columns)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        No se encontraron EPPs en el sistema
                    </div>
                <?php else: ?>
                    <div class="epp-grid">
                        <?php 
                        $processed = [];
                        foreach($epp_columns as $column): 
                            $field = $column['Field'];
                            
                            // Extraer nombre base del EPP
                            if(strpos($field, 'fecha_entrega_') === 0 || strpos($field, 'cambio_') === 0) {
                                continue;
                            }
                            
                            if(in_array($field, ['zapato_seguridad', 'casco_seguridad', 'orejeras_casco'])) {
                                $base_name = str_replace('_', ' ', $field);
                            } else {
                                $base_name = str_replace('_', ' ', $field);
                            }
                            
                            if(!in_array($base_name, $processed)):
                                $processed[] = $base_name;
                        ?>
                            <div class="epp-item">
                                <div class="epp-name">
                                    <i class="fas fa-shield-alt"></i>
                                    <?php echo ucwords($base_name); ?>
                                </div>
                                <div class="epp-details">
                                    <i class="fas fa-database"></i>
                                    Campo: <?php echo $field; ?>
                                </div>
                            </div>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Información del sistema -->
            <div class="card">
                <h2 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Información del Sistema
                </h2>
                <div style="color: #6c757d; line-height: 1.6;">
                    <p><strong>Cómo funciona:</strong></p>
                    <ul style="margin-left: 20px; margin-top: 10px;">
                        <li>Al agregar un nuevo EPP, se crean automáticamente 3 columnas en la base de datos</li>
                        <li>Los cambios se reflejan inmediatamente en el formulario de registro</li>
                        <li>Las iniciales se generan automáticamente de las primeras letras de cada palabra</li>
                        <li>Máximo 30 caracteres para el nombre del EPP</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>