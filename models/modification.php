<?php
session_start();
require_once './library/conections.php'; // Asegúrate de que esté corregido el nombre del archivo




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $edad = $_POST['edad'];
    $sede = $_POST['sede'];
    //$foto = $_FILES['foto'];
    $ocupacion = trim(filter_input(INPUT_POST, 'ocupacion', FILTER_SANITIZE_STRING));
    $area_trabajo = trim(filter_input(INPUT_POST, 'area_trabajo', FILTER_SANITIZE_STRING));
    $fecha_cumple = $_POST['fecha_cumple'];// Obtener la fecha de cumpleaños del formulario
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $estado = $_POST['estado'];
    $estado_epp = $_POST['estado_epp'];
    $observaciones= $_POST['observaciones'];
      $zapato_seguridad = isset($_POST['zapato_seguridad']) ? 1 : 0;
$fecha_entrega_zp = !empty($_POST['fecha_entrega_zp']) ? $_POST['fecha_entrega_zp'] : null;
$cambio_zp = !empty($_POST['cambio_zp']) ? $_POST['cambio_zp'] : null;
$casco_seguridad = isset($_POST['casco_seguridad']) ? 1 : 0;
$fecha_entrega_cs = !empty($_POST['fecha_entrega_cs']) ? $_POST['fecha_entrega_cs'] : null;
$cambio_cs = !empty($_POST['cambio_cs']) ? $_POST['cambio_cs'] : null;
$orejeras_casco = isset($_POST['orejeras_casco']) ? 1 : 0;
$fecha_entrega_oc = !empty($_POST['fecha_entrega_oc']) ? $_POST['fecha_entrega_oc'] : null;
$cambio_oc = !empty($_POST['cambio_oc']) ? $_POST['cambio_oc'] : null;
$firmar = !empty($_POST['firmar']) ? $_POST['firmar'] : null;
$foto_captura = !empty($_POST['foto_captura']) ? $_POST['foto_captura'] : null;

    


   
    // Obtén los demás valores de los campos de entrada

    $pdo = dataPrueba();
    $firmar = str_replace('data:image/jpeg;base64,', '', $firmar);
    
    //$uploadDirectory = "../uploads/";
    //$fotoNombre = uniqid() . '_' . basename($foto['name']);
    //$targetFilePath = $uploadDirectory . $fotoNombre;

    // Procesa la imagen de perfil
   

    // Consulta SQL para actualizar los datos
    $stmt = $pdo->prepare("UPDATE personal_epp SET name = :name, edad = :edad, sede = :sede, ocupacion = :ocupacion, area_trabajo = :area_trabajo,fecha_cumple = :fecha_cumple,fecha_ingreso = :fecha_ingreso, estado= :estado,estado_epp= :estado_epp,observaciones= :observaciones, zapato_seguridad = :zapato_seguridad, fecha_entrega_zp = :fecha_entrega_zp, cambio_zp = :cambio_zp, casco_seguridad = :casco_seguridad,
    fecha_entrega_cs = :fecha_entrega_cs,
    cambio_cs = :cambio_cs,
    orejeras_casco = :orejeras_casco,
    fecha_entrega_oc = :fecha_entrega_oc,
    cambio_oc = :cambio_oc,
     firmar = :firmar,foto_captura = :foto_captura ,fecha = NOW()   WHERE id = :id");

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':edad', $edad);
    $stmt->bindParam(':sede', $sede);
    $stmt->bindParam(':id', $id);
    //$stmt->bindParam(':foto', $targetFilePath);
    $stmt->bindParam(':ocupacion', $ocupacion);
    $stmt->bindParam(':area_trabajo', $area_trabajo);
    $stmt->bindParam(':fecha_cumple', $fecha_cumple);
    $stmt->bindParam(':fecha_ingreso', $fecha_ingreso);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':estado_epp', $estado_epp);
    $stmt->bindParam(':observaciones', $observaciones);
    $stmt->bindParam(':zapato_seguridad', $zapato_seguridad);
    $stmt->bindParam(':fecha_entrega_zp', $fecha_entrega_zp);
    $stmt->bindParam(':cambio_zp', $cambio_zp);
    $stmt->bindParam(':casco_seguridad', $casco_seguridad);
    $stmt->bindParam(':fecha_entrega_cs', $fecha_entrega_cs);
    $stmt->bindParam(':cambio_cs', $cambio_cs);
    $stmt->bindParam(':orejeras_casco', $orejeras_casco);
        $stmt->bindParam(':fecha_entrega_oc', $fecha_entrega_oc);
        $stmt->bindParam(':cambio_oc', $cambio_oc);
        $stmt->bindParam(':firmar', $firmar);
        $stmt->bindParam(':foto_captura', $foto_captura);




    // Vincula los demás valores de los campos de entrada

   
    
       if ($stmt->execute()) {
       //   echo "Los datos se han actualizado correctamente.";
         include '../views/busqueda.php';
           exit();
      } else {
           echo "Error al actualizar los datos.";
      }
   } 


 //if (move_uploaded_file($foto['tmp_name'], $targetFilePath)) {
        // La imagen se cargó correctamente, ahora actualizamos los datos en la base de datos
    
       //if ($stmt->execute()) {
          //  echo "Los datos se han actualizado correctamente.";
           // include '../views/busqueda.php';
        //  exit();
     //  } else {
        //   echo "Error al actualizar los datos.";
       // }
   // } else {
       //echo "Error al cargar la imagen.";
  // }
//} 




?>