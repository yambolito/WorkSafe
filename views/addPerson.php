
<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/header.php"; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<body>
    <h2 class="titulo-formulario"><i class="fas fa-hard-hat"></i> Formulario Registro de EPP</h2>

    <form action="/worksafe/personal_epp/index.php" method="post" class="formulario-epp">
        
        <label><i class="fas fa-user"></i> Nombre:
            <input type="text" name="name" required class="input-text">
        </label>

        <label><i class="fas fa-hashtag"></i> Edad:
            <input type="number" name="edad" required class="input-text">
        </label>

        <label><i class="fas fa-briefcase"></i> Ocupación:
            <input type="text" name="ocupacion" required class="input-text">
        </label>

        <label><i class="fas fa-building"></i> Área de trabajo:
            <input type="text" name="area_trabajo" required class="input-text">
        </label>

        <label><i class="fas fa-cake-candles"></i> Fecha de nacimiento:
            <input type="date" name="fecha_cumple" required class="input-date">
        </label>

        <label><i class="fas fa-calendar-check"></i> Fecha de ingreso:
            <input type="date" name="fecha_ingreso" required class="input-date">
        </label>

        <label><i class="fas fa-toggle-on"></i> Estado:
            <select name="estado" required class="select">
                <option value="activo">Activo</option>
                <option value="retirado">Retirado</option>
            </select>
        </label>

        <label><i class="fas fa-map-marker-alt"></i> Sede:
            <select name="sede" required class="select">
                <option value="LIMA">LIMA</option>
                <option value="CHICLAYO">CHICLAYO</option>
                <option value="AREQUIPA">AREQUIPA</option>
                <option value="TARAPOTO">TARAPOTO</option>
            </select>
        </label>

        <label><i class="fas fa-image"></i> Foto (URL):
            <input type="file" name="foto" required class="input-text">
        </label>

        <label><i class="fas fa-shield-alt"></i> Estado EPP:
            <select name="estado_epp" class="select">
                <option value="">-- Seleccionar --</option>
                <option value="Activo">Activo</option>
                <option value="Devuelto">Devuelto</option>
            </select>
        </label>

        <label><i class="fas fa-comment-dots"></i> Observaciones:
            <input type="text" name="observaciones" class="input-text">
        </label>

        <label><input type="checkbox" name="casco_seguridad"> <i class="fas fa-hard-hat"></i> Casco de seguridad entregado</label>
        <label><i class="fas fa-calendar-day"></i> Fecha entrega casco:
            <input type="date" name="fecha_entrega_cs" class="input-date">
        </label>
        <label><i class="fas fa-calendar-plus"></i> Cambio de casco:
            <input type="date" name="cambio_cs" class="input-date">
        </label>

        <label><input type="checkbox" name="orejeras_casco"> <i class="fas fa-headphones-alt"></i> Orejeras entregadas</label>
        <label><i class="fas fa-calendar-day"></i> Fecha entrega orejeras:
            <input type="date" name="fecha_entrega_oc" class="input-date">
        </label>
        <label><i class="fas fa-calendar-plus"></i> Cambio orejeras:
            <input type="date" name="cambio_oc" class="input-date">
        </label>

        <label><i class="fas fa-signature"></i> Firma digital:
            <textarea name="firmar" class="input-area"></textarea>
        </label>

        <label><i class="fas fa-camera"></i> Foto captura:
            <canvas name="foto_captura" class="input-area"></canvas>
        </label>

        <button type="submit" class="btn-enviar"><i class="fas fa-save"></i> Guardar</button>
    </form>
</body>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/worksafe/common/footer.php"; ?>
</html>
