<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>


<form id="searchForm" method="GET" action="./search/index.php">
    <label for="nombre">Buscar por nombre:</label>
    <input type="text" id="nombre" name="nombre">

    <label for="area_trabajo">Buscar por área de trabajo:</label>
    <input type="text" id="area_trabajo" name="area_trabajo">

    <input type="submit" value="Buscar">
</form><br><br>

<div id="personList" class="person-list">
    <?php
    // Array para mapear las siglas a los nombres completos
    $nombres_completos = array(
        'Cs' => 'Casco Seguridad',
        'Oc' => 'orejeras_casco',
        'Ov' => 'orejeras_vincha',
        'Gbd' => 'guantes_badana',
        'Zp' => 'zapato_seguridad',
        'Ga' => 'guantes_anticorte',
        'Gc' => 'guantes_cuero',
        'Gac' => 'guantes_acido_n',
        'Mp' => 'guantes_limpieza',
        'Gs' => 'guantes_soldar',
        'Cas' => 'casco_soldar',
        'Cms' => 'camisa_soldar',
        'Hs' => 'hombrera_soldar',
        'Ms' => 'mandil_soldar',
        'Bs' => 'botas_soldar',
        'Ls' => 'lentes_seguridad',
        'Pf' => 'protector_facial',
        'Fc' => 'faja_carga',
        'Lg' => 'lentes_google',
        'R3m' => 'respirador_3m',
        'Vo' => 'filtro_vapor_org',
        'Fp' => 'filtro_paticulas',
        'Ta' => 'traje_acido',
        'Chc' => 'chompa_camara',
        'Pc' => 'pantalon_camara',
        'Mc' => 'medias_camara',
        'Pm' => 'pasamontaña',
        'Cam' => 'guantes_camara',
        'Tc' => 'traje_camara',
        'Bb' => 'bota_blancas',
        'U' => 'uniforme_produccion',
        'Ua' => 'uniforme_almacen',
        'Ul' => 'uniforme_limpieza',
        'Zc' => 'zapato_camara',
        'Um' => 'Uniforme_matenimiento',
        'Bp' => 'botas_punta',
        'Tv' => 'traje_tyvek',
        // Agrega más si es necesario
    );

    // Verificar si se ha enviado el formulario y si hay resultados para mostrar
    if (!empty($personas)) {
        echo '<div class="marco">';
        echo '<h2>Resultados de la búsqueda</h2>';
        echo '<ul id="personListUl">';
        // Mostrar los resultados
        foreach ($personas as $persona) {
            $persona['firmar'] = 'data:image/jpeg;base64,' . $persona['firmar'];
            // Verificar si la persona tiene al menos un equipo de seguridad asignado
            $tiene_epp = false;
            foreach ($persona as $key => $value) {
                if ((strpos($key, 'fecha_entrega_') !== false || strpos($key, 'cambio_') !== false) && $value !== '0000-00-00' && $value !== '0') {
                    $tiene_epp = true;
                    break; // Salir del bucle una vez que se haya encontrado al menos un equipo de seguridad asignado
                }
            }
            // Mostrar la persona solo si tiene al menos un equipo de seguridad asignado
            if ($tiene_epp) {
                echo '<li>';
                echo '<div class="photo">';
                echo '<img src="' . $persona['foto'] . '" alt="' . $persona['name'] . '">';
                echo '</div>';
                // Mostrar solo una vez el nombre y la información general
                echo '<span>';
                echo 'Estado: <span class="' . ($persona['estado'] === 'activo' ? 'estado-activo' : 'estado-retirado') . '">' . $persona['estado'] . '</span><br>';
                echo 'Nombre: ' . $persona['name'] . '<br>';
                echo 'Edad: ' . $persona['edad'] . '<br>';
                echo 'Ocupación: ' . $persona['ocupacion'] . '<br>';
                echo 'Area: ' . $persona['area_trabajo'] . '<br>';
                echo 'Sede: ' . $persona['sede'] . '<br>';
                echo 'Fecha de ingreso: ' . $persona['fecha_ingreso'] . '<br>';
                echo 'Fecha de cumpleaños: ' . $persona['fecha_cumple'] . '<br>';
                echo '</span>';
                echo '<span>';
                echo '<h2> Equipos de Seguridad </h2>';
                echo '</span>';
                echo 'Estado de EPP: <span class="' . ($persona['estado_epp'] === 'devuelto' ? 'estado_epp_devuelto' : ($persona['estado_epp'] === 'activo' ? 'estado_epp_activos' : '')) . '">' . $persona['estado_epp'] . '</span><br>';

                echo 'Observaciones: ' . $persona['observaciones']. '<br>','<br>';

                // Mostrar los campos dinámicos de los checkboxes y las fechas
                $mostrado = []; // Array para almacenar los elementos mostrados

                // Mostrar los campos dinámicos de los checkboxes y las fechas
                foreach ($persona as $key => $value) {
                    // Verificar si el campo tiene una fecha de entrega o un cambio, y si es mayor o igual a 1 o diferente de "0000-00-00" o "0"
                    if ((strpos($key, 'fecha_entrega_') !== false || strpos($key, 'cambio_') !== false) && $value !== '0000-00-00' && $value !== '0' && !empty($value)) {
                        $epp_nombre = ucwords(str_replace('', ' ', str_replace(['fecha_entrega_', 'cambio_'], '', $key)));
                        // Si existe el nombre completo en el array, lo mostramos, de lo contrario, mostramos la sigla
                        if (array_key_exists($epp_nombre, $nombres_completos)) {
                            $epp_nombre_completo = $nombres_completos[$epp_nombre];
                            // Verificar si ya se ha mostrado este elemento
                            if (!in_array($epp_nombre_completo, $mostrado)) {
                                echo $epp_nombre_completo . ':<br>';
                                echo 'Fecha de Entrega: ' . $value . '<br>';
                                // Marcar como mostrado para evitar la repetición
                                $cambio_key = str_replace('fecha_entrega_', 'cambio_', $key);
                                echo 'Fecha de Cambio: ' . $persona[$cambio_key] . '<br>';
                                $mostrado[] = $epp_nombre_completo; // Agregar al array de elementos mostrados
                            }
                        }
                    }
                }
                echo '<br>';
                 echo '<h2>Firma</h2>';
                 echo '<br>';
                echo '<td><img clas="firma" src="' . htmlspecialchars($persona['firmar']) . '" alt="Firma" /></td>';
                echo '<br>';
                echo '<td><img src="data:image/png;base64,' . htmlspecialchars($persona['foto_captura']) . '" alt="Última Foto" width="300" height="225"></td>';
                echo '<h2>Foto evidencia</h2>';
                echo 'Fecha de firma: ' . htmlspecialchars($persona['fecha']) . '<br>';
                echo '</li>';
            }
        }
        echo '</ul>';
        echo '</div>';
        if ($_SESSION['clientData']['clientLevel'] == 3 || $_SESSION['clientData']['clientLevel'] == 4) {
            echo '<a href="../views/mpersonal.php?id=' . $persona['id'] . '" class="btn-modificar">Modificar Datos</a>';
        }
    } else {
        echo '<p>No se encontraron resultados para la búsqueda.</p>';
    }
    ?>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>