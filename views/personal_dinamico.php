<?php
// views/personal_dinamico.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Registro de EPP - Dinámico</title>
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

        .form-container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="3" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
        }

        .titulo-formulario {
            font-size: 2.5rem;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .form-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .formulario-epp {
            padding: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .form-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            border-left: 5px solid #3498db;
        }

        .section-title {
            color: #2c3e50;
            font-size: 1.3rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .input-text, .input-date, .select, .input-area {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .input-text:focus, .input-date:focus, .select:focus, .input-area:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
            padding: 10px;
            background: white;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .checkbox-group:hover {
            border-color: #3498db;
            background: #f0f8ff;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #3498db;
        }

        .checkbox-group label {
            margin: 0;
            font-weight: 500;
            cursor: pointer;
        }

        .epp-item {
            background: white;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #e9ecef;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .epp-item:hover {
            border-color: #3498db;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.1);
        }

        .epp-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.1rem;
            text-transform: capitalize;
        }

        .epp-dates {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }

        .btn-enviar {
            grid-column: 1 / -1;
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            border: none;
            padding: 18px 40px;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-enviar:hover {
            background: linear-gradient(135deg, #229954, #27ae60);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(39, 174, 96, 0.3);
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

        @media (max-width: 768px) {
            .formulario-epp {
                grid-template-columns: 1fr;
                padding: 20px;
            }
            
            .epp-dates {
                grid-template-columns: 1fr;
            }
            
            .titulo-formulario {
                font-size: 2rem;
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
        <a href="../views/lista_personal.php" class="nav-link">
            <i class="fas fa-list"></i>
            Ver Personal
        </a>
    </div>

    <div class="form-container">
        <div class="form-header">
            <h2 class="titulo-formulario">
                <i class="fas fa-hard-hat"></i> 
                Formulario Registro de EPP
            </h2>
            <p class="form-subtitle">Sistema dinámico de gestión de equipos de protección personal</p>
        </div>

        <!-- Mensajes -->
        <?php if(isset($success_message)): ?>
            <div style="padding: 20px 40px;">
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if(isset($message)): ?>
            <div style="padding: 20px 40px;">
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            </div>
        <?php endif; ?>

        <form action="/worksafe/personal_epp/index.php" method="post" enctype="multipart/form-data" class="formulario-epp">
            
            <!-- Sección Datos Personales -->
            <div class="form-section" style="grid-column: 1 / -1;">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    Datos Personales
                </h3>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Nombre:</label>
                        <input type="text" name="name" required class="input-text" placeholder="Nombre completo">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-hashtag"></i> Edad:</label>
                        <input type="number" name="edad" required class="input-text" min="18" max="70">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-briefcase"></i> Ocupación:</label>
                        <input type="text" name="ocupacion" required class="input-text" placeholder="Cargo o puesto">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-building"></i> Área de trabajo:</label>
                        <input type="text" name="area_trabajo" required class="input-text" placeholder="Departamento o área">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-cake-candles"></i> Fecha de nacimiento:</label>
                        <input type="date" name="fecha_cumple" required class="input-date">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-calendar-check"></i> Fecha de ingreso:</label>
                        <input type="date" name="fecha_ingreso" required class="input-date">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-toggle-on"></i> Estado:</label>
                        <select name="estado" required class="select">
                            <option value="activo">Activo</option>
                            <option value="retirado">Retirado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Sede:</label>
                        <select name="sede" required class="select">
                            <option value="LIMA">LIMA</option>
                            <option value="CHICLAYO">CHICLAYO</option>
                            <option value="AREQUIPA">AREQUIPA</option>
                            <option value="TARAPOTO">TARAPOTO</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-image"></i> Foto:</label>
                        <input type="file" name="foto" required class="input-text" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-shield-alt"></i> Estado EPP:</label>
                        <select name="estado_epp" class="select">
                            <option value="">-- Seleccionar --</option>
                            <option value="Activo">Activo</option>
                            <option value="Devuelto">Devuelto</option>
                        </select>
                    </div>

                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label><i class="fas fa-comment-dots"></i> Observaciones:</label>
                        <textarea name="observaciones" class="input-area" rows="3" placeholder="Observaciones adicionales..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Sección EPPs Dinámicos -->
            <div class="form-section" style="grid-column: 1 / -1;">
                <h3 class="section-title">
                    <i class="fas fa-hard-hat"></i>
                    Equipos de Protección Personal
                </h3>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px;">
                    <?php if(!empty($epp_fields)): ?>
                        <?php foreach($epp_fields as $epp_key => $epp_info): ?>
                            <?php if(isset($epp_info['campo'])): ?>
                                <div class="epp-item">
                                    <div class="checkbox-group">
                                        <input type="checkbox" name="<?php echo $epp_info['campo']; ?>" id="<?php echo $epp_info['campo']; ?>">
                                        <label for="<?php echo $epp_info['campo']; ?>">
                                            <i class="fas fa-shield-alt"></i>
                                            <?php echo $epp_info['nombre']; ?> entregado
                                        </label>
                                    </div>
                                    
                                    <div class="epp-dates">
                                        <?php if(isset($epp_info['fecha_entrega'])): ?>
                                            <div class="form-group">
                                                <label><i class="fas fa-calendar-day"></i> Fecha entrega:</label>
                                                <input type="date" name="<?php echo $epp_info['fecha_entrega']; ?>" class="input-date">
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if(isset($epp_info['cambio'])): ?>
                                            <div class="form-group">
                                                <label><i class="fas fa-calendar-plus"></i> Fecha cambio:</label>
                                                <input type="date" name="<?php echo $epp_info['cambio']; ?>" class="input-date">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            No se encontraron EPPs configurados. <a href="../admin/dashboard.php">Ir al Dashboard</a> para agregar EPPs.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sección Firma -->
            <div class="form-section" style="grid-column: 1 / -1;">
                <h3 class="section-title">
                    <i class="fas fa-signature"></i>
                    Firma y Documentación
                </h3>
                
                <div class="form-group">
                    <label><i class="fas fa-signature"></i> Firma digital:</label>
                    <textarea name="firmar" class="input-area" rows="4" placeholder="Firma digital en base64 o texto de confirmación..."></textarea>
                </div>
            </div>

            <button type="submit" class="btn-enviar">
                <i class="fas fa-save"></i>
                Guardar Registro EPP
            </button>
        </form>
    </div>

    <script>
        // Script para mejorar la experiencia del usuario
        document.addEventListener('DOMContentLoaded', function() {
            // Validación en tiempo real
            const form = document.querySelector('.formulario-epp');
            const inputs = form.querySelectorAll('input[required], select[required]');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.style.borderColor = '#e74c3c';
                    } else {
                        this.style.borderColor = '#27ae60';
                    }
                });
            });
            
            // Confirmar antes de enviar
            form.addEventListener('submit', function(e) {
                const confirmacion = confirm('¿Está seguro de que desea guardar este registro de EPP?');
                if (!confirmacion) {
                    e.preventDefault();
                }
            });
            
            // Mostrar/ocultar fechas según checkbox
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const eppItem = this.closest('.epp-item');
                    const fechaInputs = eppItem.querySelectorAll('input[type="date"]');
                    
                    fechaInputs.forEach(dateInput => {
                        if (this.checked) {
                            dateInput.style.opacity = '1';
                            dateInput.removeAttribute('disabled');
                        } else {
                            dateInput.style.opacity = '0.5';
                            dateInput.setAttribute('disabled', 'disabled');
                            dateInput.value = '';
                        }
                    });
                });
            });
            
            // Inicializar estado de fechas
            checkboxes.forEach(checkbox => {
                checkbox.dispatchEvent(new Event('change'));
            });
        });
    </script>
</body>
</html>