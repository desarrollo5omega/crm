<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    #myPieChart {
        height: 425px !important;
        width: 425px !important;
        margin: auto
    }
    .modal-lg {
        max-width: 80%;
        margin: auto;
    }
    .file-input {
        width: 100%;
    }
    .modal-md-2 {
        max-width: 60%;
    }
    body {
        background: #eee;
    }
    .manage-btn {
        height: 37px !important;
    }

    <?php if ($_GET["sop"]) { ?>
        #main-content-proyectos {
            margin-left: 0px !important;
        }
    <?php } ?>
</style>

<?php if ($this->level == 5) { $none = "d-none"; } ?>

<div class="container-fluid">

    <!-- Sidebar (aparece oculto inicialmente) -->
    <?php if (!$_GET["sop"]) { ?>
    <div id="sidebar-proyectos" class="active">

        <div id="sidebar-proyectos-title" class="d-flex justify-content-between align-items-center mb-3">
            <span id="sidebar-proyectos-title">Listado de proyectos por Cliente</span>
            <button class="btn me-3 sidebar-proyectos-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div id="sidebar-proyectos-content" style="height: 82vh; display: flex; flex-direction: column;">
            <!-- Buscador con ícono -->
            <div class="search-box-proyectos position-relative mb-3">
                <label class="form-label">Filtrar proyectos por Cliente</label>
                <div class="input-group">
                    <select class="form-select" id="info_cliente" onchange="buscar_proyectos(); viewWhite();">
                        <option value="">Todos los clientes</option>
                        <?php foreach ($this->list_cliente_id as $key => $value) : ?>
                            <option value="<?= $key; ?>" <?php if ($_GET["cliente"] == $key) { echo "selected"; } ?>><?= $value; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <input type="hidden" id="proyectoId" value="<?= $_GET["proyecto"] ?>">

            <!-- Resultados de búsqueda reales con scroll independiente -->
            <div class="search-results-proyectos" style="overflow-y: auto; height: 40%;">
                <!-- Aquí se inyectarán los resultados reales a través de AJAX -->
            </div>
            
            <!-- Línea divisoria -->
            <hr class="my-3" style="border-top: 2px solid #ccc;">
            

            <!-- Resultados ficticios con scroll independiente -->
            <div class="search-results-ficticios" style="overflow-y: auto; height: 40%;">
                <div id="sidebar-proyectos-title" class="d-flex justify-content-between align-items-center" style="position: sticky; top: 0;width: 100%">
                    <span>Sin fecha de finalización (<?= count($this->lista_proyecto_sff) ?>)</span>
                </div>
                <?php foreach ($this->lista_proyecto_sff as $value){ ?>
                    <a href="/page/view/?cliente=<?= $value->cliente_id ?>&proyecto=<?= $value->id ?>"><span class="circle-red"></span> <?= $value->nombre ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- Main Content -->
    <div id="main-content-proyectos" class="active">
        <div class="row d-none justify-content-center align-items-center" id="logo-omega" style="height: 84vh !important;">
            <div class="col-auto">
                <img src="/skins/page/images/solo_o.png" class="img-fluid" style="width: 80px;">
            </div>
        </div>
        <div class="row mb-5" id="div-contenido-general">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 my-3 d-flex flex-wrap justify-content-between align-items-center">
                        <div class="d-flex align-items-center mb-3">
                            <h4 class="title-label"><i class="fas fa-info-circle"></i> Información del Proyecto</h4>
                        </div>
                        <?php 
                            foreach ($this->list_tablero_id as $key => $val) { 
                                if ($key == $_GET["proyecto"]) { 
                        ?>
                            <div class="alert alert-info mb-3" role="alert" style="margin: 0px; padding-top: 5px; padding-bottom: 5px;">
                                <strong>Info:</strong> Proyecto asignado en el plan de trabajo.
                            </div>
                        <?php } } ?>

                        <div class="d-flex flex-wrap align-items-center"> <!-- Ajuste aquí para centrar verticalmente -->

                            <span data-bs-toggle="tooltip" data-placement="top" title="Terminar proyecto" class="mb-1 <?= $none; ?>">
                                <a class="custom-btn-home" href="/page/view/terminar?id=<?= $this->info->id ?>&cliente=<?= $_GET["cliente"] ?>&proyecto=<?= $_GET["proyecto"] ?>" id="terminar_proyecto">
                                    <span class="add-button-home-2 lf-part-2">TERMINAR PROYECTO</span>
                                    <span class="rg-part"><i class="fas fa-clock"></i></span>
                                </a>
                            </span>

                            <span data-bs-toggle="tooltip" data-placement="top" title="Edición general" class="ms-3 <?= $none; ?>">
                                <a class="custom-btn-home" data-bs-toggle="modal" data-bs-target="#modal_editar">
                                    <span class="add-button-home-2 lf-part">EDICIÓN GENERAL</span>
                                    <span class="rg-part"><i class="fas fa-pencil-alt"></i></span>
                                </a>
                            </span>

                        </div>
                    </div>

                    <div class="col-lg-8 col-12">
                        <div class="row">                            
                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="caja_azul">
                                            <div class="d-flex justify-content-between align-items-center h-100">
                                                <div class="titulo_dashboard">
                                                    <i class="fa-solid fa-diagram-project"></i>
                                                    <span>Proyecto: </span><?= $this->info->nombre ?> - 
                                                    <span> Cliente: </span><?= $this->list_cliente_id[$this->info->cliente_id] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-12">
                                                <label class="form-label title-label">Tipo: </label>
                                                <span><?= $this->list_tipo[$this->info->tipo] ?></span>
                                            </div>
                                            <div class="col-lg-4 col-12">
                                                <label class="form-label title-label">Fecha de aprobación: </label>
                                                <span><?= formatoDMYH(date("Y-m-d", strtotime($this->info->fecha_aprobado))) ?></span>
                                            </div>
                                            <div class="col-lg-4 col-12">
                                                <label class="form-label title-label">Fecha de finalización: </label>
                                                <span><?php if ( $this->info->fecha_final) { echo formatoDMYH(date("Y-m-d", strtotime(str_replace("T", " ", $this->info->fecha_final)))); } ?></span>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label title-label">Descripción del Proyecto:</label><br>
                                                <span><?= $this->info->descripcion ?></span>
                                            </div>
                                        </div>
                                        <hr>                                        
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <label class="form-label title-label">Equipo Asignado: </label>
                                            </div>
                                            <div class="col-12 d-flex flex-wrap align-items-center gap-2">
                                                <?php 
                                                // Colores de alertas Bootstrap
                                                $alertColors = ['alert-primary', 'alert-secondary', 'alert-success', 'alert-danger', 'alert-warning', 'alert-info', 'alert-dark'];

                                                // Mezclar colores aleatoriamente
                                                shuffle($alertColors);
                                                $colorIndex = 0;

                                                foreach ($this->ingenieros as $key => $value) {
                                                    // Asignar un color sin repetir, y reiniciar si se acaban los colores
                                                    $randomColor = $alertColors[$colorIndex];
                                                    $colorIndex = ($colorIndex + 1) % count($alertColors);
                                                ?>
                                                    <div class="alert <?= $randomColor ?> border-radius-1 d-inline-flex align-items-center p-2 w-auto">
                                                        <i class="fas fa-user me-1"></i> 
                                                        <span class="text-uppercase"><?= $this->lista_ingenieros_user[$value->proyectosing_user]->user_names; ?></span>
                                                        <?php if (!$this->dnone) { ?>
                                                            <!--<button class="btn btn-sm btn-danger ms-2"><i class="fas fa-times"></i></button>-->
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal fade text-start" id="modal_seccion" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content ">
                                    <div class="modal-body">
                                        <form method="POST" action="/page/view/seccion/" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="caja_azul">
                                                        <div class="d-flex justify-content-between align-items-center h-100">
                                                            <b class="titulo_dashboard"><i class="fa-solid fa-puzzle-piece"></i> Crear nueva sección</b>
                                                            <div class="me-2">
                                                                <button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row px-3">
                                                <div class="col-lg-12 mt-3 mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <span class="detail-modal">Por favor ingrese los datos de la sección</span>
                                                        <button id="add-row-seccion" class="btn btn-primary btn-sm" type="button">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="content-table m-0">
                                                        <div class="col-lg-12 mb-3">
                                                            <div class="input-group">
                                                                <input type="text" name="seccion[]" class="form-control modal-input mb-3" placeholder="Nombre de la sección">
                                                            </div>
                                                            <div id="seccion-body"></div>
                                                        </div>

                                                        <input type="hidden" name="cliente" value="<?= $_GET["cliente"] ?>">
                                                        <input type="hidden" name="proyecto" value="<?= $_GET["proyecto"] ?>">
                                                        
                                                        <div class="col-lg-12 text-center mt-3">
                                                            <div class="btn-modal-footer d-grid gap-2">
                                                                <button class="btn w-100" type="submit">Guardar</button>
                                                                <a class="w-100" data-bs-dismiss="modal">Cancelar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="row">
                                            <div class="col-lg-12"><hr></div>
                                        </div>
                                        <div class="row">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <b class="titulo_dashboard"><i class="fa-solid fa-bars-staggered"></i> Secciones</b>
                                            </div>
                                            <?php foreach ($this->list_secciones as $value) { ?>
                                                <div class="col-lg-12">
                                                    <div class="card mb-1 card-secciones" id="seccion_<?= $value->secciones_id ?>">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span><?= $value->secciones_nombre ?></span>
                                                                <div class="d-flex">
                                                                    <button type="button" class="btn btn-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modal_secciones_<?= $value->secciones_id ?>">
                                                                        <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminar_seccion(<?= $value->secciones_id ?>)">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php foreach ($this->list_secciones as $value) { ?>
                            <div class="modal fade text-start" id="modal_secciones_<?= $value->secciones_id ?>" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content ">
                                        <div class="modal-body">
                                            <form method="POST" action="/page/view/update_seccion/" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="caja_azul">
                                                            <div class="d-flex justify-content-between align-items-center h-100">
                                                                <b class="titulo_dashboard"><i class="fa-solid fa-puzzle-piece"></i> Editar sección</b>
                                                                <div class="me-2">
                                                                    <button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row px-3">
                                                    <div class="col-lg-12 mt-3 mb-3">
                                                        <div class="d-flex justify-content-between">
                                                            <span class="detail-modal">Por favor ingrese los datos de la sección</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="content-table m-0">
                                                            <div class="col-lg-12 mb-3">
                                                                <div class="input-group">
                                                                    <input type="text" name="update_secciones_nombre" value="<?= $value->secciones_nombre ?>" class="form-control modal-input mb-3" placeholder="Nombre de la sección">
                                                                </div>
                                                            </div>

                                                            <input type="hidden" name="update_secciones_id" value="<?= $value->secciones_id ?>">
                                                            <input type="hidden" name="cliente" value="<?= $_GET["cliente"] ?>">
                                                            <input type="hidden" name="proyecto" value="<?= $_GET["proyecto"] ?>">
                                                            
                                                            <div class="col-lg-12 text-center mt-3">
                                                                <div class="btn-modal-footer d-grid gap-2">
                                                                    <button class="btn w-100" type="submit">Guardar</button>
                                                                    <a class="w-100" data-bs-dismiss="modal">Cancelar</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        
                        <div class="modal fade text-start" id="modal_reque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content ">
                                    <div class="modal-body">
                                        <form method="POST" action="/page/view/updateReque/" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="caja_azul">
                                                        <div class="d-flex justify-content-between align-items-center h-100">
                                                            <b class="titulo_dashboard"><i class="fa-solid fa-bell"></i> Agregar Requerimientos</b>
                                                            <div class="me-2">
                                                                <button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row px-3">
                                                <div class="container-fluid mt-3 mb-3">
                                                    <span class="detail-modal d-block mb-2">Por favor ingrese los datos del requerimiento</span>
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 mb-2">
                                                            <span class="detail-modal">Proyecto: <?= $this->info->nombre ?></span>
                                                        </div>
                                                        <div class="col-12 col-md-12 mb-2">
                                                            <span class="detail-modal text-md-end">Fecha del requerimiento: <?= date("d-m-Y H:i:s") ?></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="content-table m-0">
                                                        <input name="requerimientos_fecha" type="hidden" value="<?= date("d-m-Y H:i:s") ?>" class="form-control">
                                                        <div id="form-container">
                                                            <div class="row mb-2">
                                                                <div class="col-12 d-flex justify-content-between align-items-center">
                                                                    <button id="add-row" class="btn btn-primary btn-sm" type="button">
                                                                        <i class="fas fa-plus"></i> Agregar
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div id="table-body">
                                                                <div class="row mb-3 align-items-end item-row">
                                                                    <div class="col-md-12">
                                                                        <div class="input-group mb-3">
                                                                            <select class="form-select" name="requerimientos_seccion[]">
                                                                                <option value="">Seleccione sección</option>
                                                                                <?php foreach ($this->list_secciones AS $key => $value ){?>
                                                                                    <option value="<?= $value->secciones_id ?>"> <?= $value->secciones_nombre ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="input-group mb-3">
                                                                            <input name="requerimientos_fecha_t[]" type="datetime-local" class="form-control">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="input-group mb-3">
                                                                            <select class="form-select" name="requerimientos_tipo[]">
                                                                                <option value="">Seleccione tipo</option>
                                                                                <?php foreach ($this->list_tipo as $key => $value) { ?>
                                                                                    <option value="<?= $key; ?>"><?= $value; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="input-group mb-3">
                                                                            <select class="form-select" name="requerimientos_ing[]">
                                                                                <option value="">Seleccione colaborador</option>
                                                                                <?php foreach ($this->ingenieros as $key => $value) { ?>
                                                                                    <option value="<?= $value->proyectosing_user; ?>">
                                                                                        <?= $this->lista_ingenieros_user[$value->proyectosing_user]->user_names . " ( " . $this->lista_ingenieros_user[$value->proyectosing_user]->user_user . " ) "; ?>
                                                                                    </option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12 mb-3">
                                                                        <textarea name="requerimientos_desc[]" class="form-control tinyeditor" rows="3" oninput="toUpperPreservingCaret(this);"></textarea>
                                                                    </div>

                                                                    <div class="col-md-12 text-end">
                                                                        <div class="input-group mb-3">
                                                                            <button class="btn btn-danger btn-sm btn-delete" type="button"><i class="fas fa-minus"></i> Quitar</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-lg-12 text-center mt-3">
                                                    <div class="btn-modal-footer d-grid gap-2">
                                                        <button class="btn w-100" type="submit">Guardar</button>
                                                        <a class="w-100" data-bs-dismiss="modal">Cancelar</a>
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="id" value="<?= $this->info->id ?>">
                                                <input type="hidden" name="csrf" value="<?= $this->csrf ?>">
                                                <input type="hidden" name="csrf_section" value="<?= $this->csrf_section ?>">
                                                <input type="hidden" name="cliente" value="<?= $_GET["cliente"] ?>">

                                                <?php
                                                    $habilitarCampo = (isset($_GET["sop"]));
                                                ?>
                                                <input type="hidden" name="r" value="<?php echo $habilitarCampo ? 'detail' : ''; ?>" <?php echo $habilitarCampo ? '' : 'disabled'; ?>>
                                                <input type="hidden" name="proyecto" value="<?= $_GET["proyecto"] ?>">

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade text-start" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content ">
                                    <form method="POST" action="/page/view/updateGeneral/" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-12">
                                                    <div class="caja_azul">
                                                        <div class="d-flex justify-content-between align-items-center h-100">
                                                            <b class="titulo_dashboard"><i class="fa-solid fa-diagram-project icon-dash"></i> Editar Proyecto</b>
                                                            <div class="me-2">
                                                                <button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row px-3">
                                                <div class="col-lg-12 mt-3 mb-3">
                                                    <span class="detail-modal">Proyecto: <?= $this->info->nombre ?></span>
                                                </div>
                                                <div class="col-lg-3 col-12 mb-3">
                                                    <label for="fecha_final"  class="form-label title-label">Fecha Finalización del Proyecto: </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
                                                        <input type="datetime-local" name="fecha_final" id="fecha_final" class="form-control" <?php if ($this->info->fecha_final) { ?> value="<?= date('Y-m-d\TH:i', strtotime($this->info->fecha_final)) ?>" <?php } ?>>
                                                    </div>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="descripcion" class="form-label title-label" >Descripción del Proyecto: </label>
                                                    <textarea name="descripcion" id="descripcion" class="form-control tinyeditor" rows="3"><?= $this->info->descripcion ?></textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="caja_azul">
                                                        <div class="d-flex justify-content-between align-items-center h-100">
                                                            <b class="titulo_dashboard"><i class="fa-solid fa-diagram-project icon-dash"></i> Agregar adjuntos</b>
                                                            <div class="me-2">
                                                                <button id="add-row-adjuntos" class="btn btn-primary btn-sm" type="button">
                                                                    <i class="fas fa-plus"></i> <span class="span-responsive">Agregar campo para adjunto</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row px-3">
                                                <div class="col-lg-12 mt-3 mb-3">
                                                    <span class="detail-modal">Adjuntar documentos asociados al proyecto</span>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row" id="row-body-adjuntos">
                                                    <?php foreach ($this->docs as $docu) { ?>
                                                        <div class="col-lg-4 col-12 mb-1 new-adjunto">
                                                            <div class="card">
                                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                                    <b> <?= htmlspecialchars($docu->documentos_nombre) ?> </b>
                                                                    <button type="button" class="btn btn-danger btn-sm btn-delete-adjuntos"><i class="fas fa-trash"></i></button>
                                                                </div>
                                                                <div class="card-body">
                                                                    <?php
                                                                        $extension = pathinfo($docu->documentos_nombre, PATHINFO_EXTENSION);
                                                                        $rutaArchivo = "/images/" . $docu->documentos_nombre;
                                                                    ?>
                                                                        
                                                                    <?php if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) { ?>
                                                                        <img src="<?= $rutaArchivo ?>" class="img-fluid" style="height: 200px; object-fit: cover;">
                                                                    <?php } elseif (in_array(strtolower($extension), ['pdf'])) { ?>
                                                                        <iframe src="<?= $rutaArchivo ?>" width="100%" height="200px" frameborder="0"></iframe>
                                                                    <?php } else { ?>
                                                                        <a href="/page/view/download?id=<?= $docu->documentos_id ?>&debug=1" class="btn btn-primary">
                                                                            <i class="fa fa-download"></i>
                                                                        </a>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" value="<?= $docu->documentos_nombre ?>" name="adjuntos_name[]">
                                                        </div>
                                                    <?php } ?>
                                                        <div class="col-lg-4 col-12 mb-1 new-adjunto">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="input-group">
                                                                        <input type="file" name="adjuntos[]" class="form-control file-document" data-buttonName="btn-primary" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*">
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer">
                                                                    <button type="button" class="btn btn-danger btn-sm btn-delete-adjuntos"><i class="fas fa-minus"></i> Quitar campo</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3 ">
                                                <div class="col-lg-12">
                                                    <div class="caja_azul">
                                                        <div class="d-flex justify-content-between align-items-center h-100">
                                                            <b class="titulo_dashboard"><i class="fa-solid fa-diagram-project icon-dash"></i> Asignar ingeniero al proyecto</b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row px-3">
                                                <div class="col-lg-12 mt-3 mb-3">
                                                    <span class="detail-modal">Seleccione el o los ingenieros encargados del proyecto</span>
                                                </div>
                                                <div class="col-12">
                                                    <div id="proyectosing_user">
                                                        <?php 

                                                        $selected_users = array();
                                                        foreach ($this->ingenieros as $engineer) {
                                                            $selected_users[] = $engineer->proyectosing_user;
                                                        }
                                                        
                                                        foreach ($this->lista_ingenieros as $key => $value) { 
                                                        ?>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="proyectosing_user[]" value="<?php echo $key; ?>" id="ingeniero_<?php echo $key; ?>"
                                                                    <?php echo in_array($key, $selected_users) ? 'checked' : ''; ?>>
                                                                <label class="form-check-label text-uppercase" for="ingeniero_<?php echo $key; ?>">
                                                                    <?= $value; // Asegúrate que $value contenga el nombre del ingeniero ?>
                                                                </label>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" name="id" value="<?= $this->info->id ?>">
                                            <input type="hidden" name="csrf" value="<?= $this->csrf ?>">
                                            <input type="hidden" name="csrf_section" value="<?= $this->csrf_section ?>">
                                            <input type="hidden" name="cliente" value="<?= $_GET["cliente"] ?>">
                                            <input type="hidden" name="proyecto" value="<?= $_GET["proyecto"] ?>">

                                            <div class="col-lg-12 text-center mt-3">
                                                <div class="btn-modal-footer d-grid gap-2">
                                                    <button class="btn w-100" type="submit">Guardar</button>
                                                    <a class="w-100" data-bs-dismiss="modal">Cancelar</a>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="caja_azul">
                                    <div class="d-flex justify-content-between align-items-center h-100">
                                        <div class="titulo_dashboard">
                                            <i class="fa-solid fa-paperclip"></i> Lista de Adjuntos
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <ul class="list-group">
                                    <?php foreach ($this->docs as $index => $docu) { ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center mb-2">
                                            <span><?= htmlspecialchars($docu->documentos_nombre) ?></span>

                                            <?php $extension = pathinfo($docu->documentos_nombre, PATHINFO_EXTENSION); ?>

                                            <?php if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif','pdf'])) { ?>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalVerDocumento<?= $index ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            <?php } else { ?>
                                                <a href="/page/view/download?id=<?= $docu->documentos_id ?>" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            <?php } ?>

                                        </li>

                                        <!-- Modal para ver el documento -->
                                        <div class="modal fade" id="modalVerDocumento<?= $index ?>" tabindex="-1" aria-labelledby="modalLabel<?= $index ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel<?= $index ?>"><?= htmlspecialchars($docu->documentos_nombre) ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                        $extension = pathinfo($docu->documentos_nombre, PATHINFO_EXTENSION);
                                                        $rutaArchivo = "/images/" . $docu->documentos_nombre;

                                                        if (strtolower($extension) === 'pdf') {
                                                        ?>
                                                            <iframe src="<?= $rutaArchivo ?>" width="100%" height="500px" frameborder="0"></iframe>
                                                        <?php } elseif (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) { ?>
                                                            <img src="<?= $rutaArchivo ?>" class="img-fluid" style="width: 100%; height: auto;">
                                                        <?php } else { ?>
                                                            <p>Formato de archivo no compatible para previsualización.</p>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                


                <div class="row mb-3">
                    <div class="col-12 mt-2 d-flex flex-wrap justify-content-between align-items-center">
                        <h4 class="title-label"><i class="fas fa-tasks"></i> Lista de Requerimientos</h4>
                        <div class="d-flex flex-wrap align-items-center">
                            <span data-bs-toggle="tooltip" data-placement="top" title="Recuperar Columnas" class=" me-3 mb-1"  id="botonRecuperar" style="display:none;">
                                <a class="custom-btn-home" onclick="restaurarTarjetas()">
                                    <span class="add-button-home lf-part">RECUPERAR COLUMNAS</span>
                                    <span class="rg-part"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span>
                                </a>
                            </span>
                            <span data-bs-toggle="tooltip" data-placement="top" title="Agregar secciones" class="me-3 mb-1">
                                <a class="custom-btn-home" data-bs-toggle="modal" data-bs-target="#modal_seccion">
                                    <span class="add-button-home-2 lf-part-4">AGREGAR SECCIONES</span>
                                    <span class="rg-part"><i class="fas fa-plus"></i></span>
                                </a>
                            </span>
                            <span data-bs-toggle="tooltip" data-placement="top" title="Agregar requerimientos" class="">
                                <a class="custom-btn-home" data-bs-toggle="modal" data-bs-target="#modal_reque">
                                    <span class="add-button-home-2 lf-part-3">AGREGAR REQUERIMIENTOS</span>
                                    <span class="rg-part"><i class="fas fa-plus"></i></span>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row" id="cardContainer">
                    <?php
                        // Calcular porcentajes para Diseño
                        $total_requerimientos = count(array_filter($this->requerimientos, function($req) {
                            return $req->requerimientos_tipo == 3;
                        }));
                        $completados = count(array_filter($this->requerimientos, function($req) {
                            return $req->requerimientos_tipo == 3 && $req->requerimientos_estado == 3;
                        }));
                        $porcentaje = $total_requerimientos > 0 ? ($completados / $total_requerimientos) * 100 : 0;

                        // Calcular porcentajes para Desarrollo
                        $total_desarrollo = count(array_filter($this->requerimientos, function($req) {
                            return $req->requerimientos_tipo == 1;
                        }));
                        $completados_desarrollo = count(array_filter($this->requerimientos, function($req) {
                            return $req->requerimientos_tipo == 1 && $req->requerimientos_estado == 3;
                        }));
                        $porcentaje_desarrollo = $total_desarrollo > 0 ? ($completados_desarrollo / $total_desarrollo) * 100 : 0;

                        // Calcular porcentajes para Soporte
                        $total_soporte = count(array_filter($this->requerimientos, function($req) {
                            return $req->requerimientos_tipo == 2;
                        }));
                        $completados_soporte = count(array_filter($this->requerimientos, function($req) {
                            return $req->requerimientos_tipo == 2 && $req->requerimientos_estado == 3;
                        }));
                        $porcentaje_soporte = $total_soporte > 0 ? ($completados_soporte / $total_soporte) * 100 : 0;
                    ?>


                    

                    <div class="col-lg-4 col-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="caja_azul">
                                    <div class="titulo_dashboard d-flex justify-content-between align-items-center" style="height: 100%;">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-solid fa-code"></i>&nbsp;Desarrollo
                                        </div>

                                        <!-- Barra de progreso con porcentaje -->
                                        <div class="progress flex-grow-1 mx-2" style="max-width: 200px">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $porcentaje_desarrollo ?>%;" aria-valuenow="<?= $porcentaje_desarrollo ?>" aria-valuemin="0" aria-valuemax="100">
                                                <span style="font-size: 10px; color: white;"><?= round($porcentaje_desarrollo) ?>%</span>
                                            </div>
                                        </div>

                                        <div class="me-2">
                                            <button type="button" class="close btn-cerrar-modal" aria-label="Close" onclick="cerrarCard(this)"><i class="fa-solid fa-xmark"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">                            
                            <div class="card-body">
                                <?php 
                                    $array_seccion = array();
                                    foreach ($this->requerimientos as $req) { 
                                        if ($req->requerimientos_tipo == 1 && $req->requerimientos_estado != 3) { // Tipo Desarrollo
                                            if (!in_array($req->requerimientos_seccion, $array_seccion)) {
                                                $array_seccion[$req->requerimientos_seccion] = $this->list_secciones[$req->requerimientos_seccion]->secciones_nombre;
                                            }
                                        }
                                    }
                                ?>

                                <?php foreach ($array_seccion as $key => $value) { ?>
                                    <?php if ($value) { ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="caja_azul title-seccion">
                                                    <div class="d-flex justify-content-between align-items-center h-100">
                                                        <b class="titulo_dashboard"><i class="fa-solid fa-puzzle-piece"></i> <?= $value ?></b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row">
                                        <?php foreach ($this->requerimientos as $req) { 
                                            if ($req->requerimientos_tipo == 1 && $req->requerimientos_estado != 3) { // Tipo Desarrollo
                                                if ($req->requerimientos_seccion == $key) {
                                        ?>

                                            <div id="requerimiento_<?= $req->requerimientos_id ?>" class="d-flex my-2">
                                                <div class="gris-fondo-ing flex-grow-1" data-bs-toggle="modal" data-bs-target="#modal_view_reque_<?= $req->requerimientos_id ?>" style="cursor: pointer;">
                                                    <div class="text-justify color-requerimiento"><?= $req->requerimientos_desc ?></div>
                                                    <div class="d-flex justify-content-between mt-3" style="font-size: 12px;">
                                                        <span>
                                                            <?= $this->lista_ingenieros_user[$req->requerimientos_ing]->user_names . " ( " . $this->lista_ingenieros_user[$req->requerimientos_ing]->user_user . " ) "; ?>
                                                        </span>
                                                        <span>
                                                            <?php if ($req->requerimientos_estado == 1) { ?>
                                                                <button type="button" class="btn btn-sm btn-danger btn-circle" disabled></button>
                                                            <?php } elseif ($req->requerimientos_estado == 2) { ?>
                                                                <button type="button" class="btn btn-sm btn-warning btn-circle mb-1" disabled></button>
                                                            <?php } elseif ($req->requerimientos_estado == 3) { ?>
                                                                <button type="button" class="btn btn-sm btn-success btn-circle mb-1" disabled></button>
                                                            <?php } ?>
                                                            <?= formatoDMYH(str_replace("T", " ", $req->requerimientos_fecha_t)) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column ms-2">
                                                    <button type="button" class="btn btn-primary btn-manage btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modal_edit_reque_<?= $req->requerimientos_id ?>" onclick="event.stopPropagation();">
                                                        <i class="fa fa-pencil-alt" aria-hidden="true" data-bs-toggle="tooltip" data-placement="top" title="Editar"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-success btn-manage btn-sm mb-1" onclick="confirmStop(<?= $req->requerimientos_id ?>)">
                                                        <i class="fa fa-clock" aria-hidden="true" data-bs-toggle="tooltip" data-placement="top" title="Finalizado"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-manage btn-sm" onclick="confirmDelete(<?= $req->requerimientos_id ?>)">
                                                        <i class="fa fa-trash" aria-hidden="true" data-bs-toggle="tooltip" data-placement="top" title="Eliminar"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php } } } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="caja_azul">
                                    <div class="titulo_dashboard d-flex justify-content-between align-items-center" style="height: 100%;">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-solid fa-headset"></i>&nbsp;Soporte
                                        </div>

                                        <!-- Barra de progreso con porcentaje para Soporte -->
                                        <div class="progress flex-grow-1 mx-2" style="max-width: 200px">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $porcentaje_soporte ?>%;" aria-valuenow="<?= $porcentaje_soporte ?>" aria-valuemin="0" aria-valuemax="100">
                                                <span style="font-size: 10px; color: white;"><?= round($porcentaje_soporte) ?>%</span>
                                            </div>
                                        </div>

                                        <div class="me-2">
                                            <button type="button" class="close btn-cerrar-modal" aria-label="Close" onclick="cerrarCard(this)"><i class="fa-solid fa-xmark"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">                            
                            <div class="card-body">

                                <?php 
                                    $array_seccion = array();
                                    foreach ($this->requerimientos as $req) { 
                                        if ($req->requerimientos_tipo == 2 && $req->requerimientos_estado != 3) { // Tipo Desarrollo
                                            if (!in_array($req->requerimientos_seccion, $array_seccion)) {
                                                $array_seccion[$req->requerimientos_seccion] = $this->list_secciones[$req->requerimientos_seccion]->secciones_nombre;
                                            }
                                        }
                                    }
                                ?>

                                <?php foreach ($array_seccion as $key => $value) { ?>
                                    <?php if ($value) { ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="caja_azul title-seccion">
                                                    <div class="d-flex justify-content-between align-items-center h-100">
                                                        <b class="titulo_dashboard"><i class="fa-solid fa-puzzle-piece"></i> <?= $value ?></b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row">

                                        <?php foreach ($this->requerimientos as $req) { 
                                            if ($req->requerimientos_tipo == 2 && $req->requerimientos_estado != 3) { // Tipo Soporte
                                                if ($req->requerimientos_seccion == $key) {
                                        ?>
                                            <div id="requerimiento_<?= $req->requerimientos_id ?>" class="d-flex my-2">
                                                <div class="gris-fondo-ing flex-grow-1" data-bs-toggle="modal" data-bs-target="#modal_view_reque_<?= $req->requerimientos_id ?>" style="cursor: pointer;">
                                                    <div class="text-justify color-requerimiento"><?= $req->requerimientos_desc ?></div>
                                                    <div class="d-flex justify-content-between mt-3" style="font-size: 12px;">
                                                        <span>
                                                            <?= $this->lista_ingenieros_user[$req->requerimientos_ing]->user_names . " ( " . $this->lista_ingenieros_user[$req->requerimientos_ing]->user_user . " ) "; ?>
                                                        </span>
                                                        <span>
                                                            <?php if ($req->requerimientos_estado == 1) { ?>
                                                                <button type="button" class="btn btn-sm btn-danger btn-circle" disabled></button>
                                                            <?php } elseif ($req->requerimientos_estado == 2) { ?>
                                                                <button type="button" class="btn btn-sm btn-warning btn-circle mb-1" disabled></button>
                                                            <?php } elseif ($req->requerimientos_estado == 3) { ?>
                                                                <button type="button" class="btn btn-sm btn-success btn-circle mb-1" disabled></button>
                                                            <?php } ?>
                                                            <?= formatoDMYH(str_replace("T", " ", $req->requerimientos_fecha_t)) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column ms-2">
                                                    <button type="button" class="btn btn-primary btn-manage btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modal_edit_reque_<?= $req->requerimientos_id ?>" onclick="event.stopPropagation();">
                                                        <i class="fa fa-pencil-alt" aria-hidden="true" data-bs-toggle="tooltip" data-placement="top" title="Editar"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-success btn-manage btn-sm mb-1" onclick="confirmStop(<?= $req->requerimientos_id ?>)">
                                                        <i class="fa fa-clock" aria-hidden="true" data-bs-toggle="tooltip" data-placement="top" title="Finalizado"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-manage btn-sm" onclick="confirmDelete(<?= $req->requerimientos_id ?>)">
                                                        <i class="fa fa-trash" aria-hidden="true" data-bs-toggle="tooltip" data-placement="top" title="Eliminar"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php } } } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div> 

                    <div class="col-lg-4 col-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="caja_azul">
                                    <div class="titulo_dashboard d-flex justify-content-between align-items-center" style="height: 100%;">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-solid fa-object-group"></i>&nbsp;Diseño
                                        </div>

                                        <!-- Barra de progreso con porcentaje -->
                                        <div class="progress flex-grow-1 mx-2" style="max-width: 200px">
                                            <div class="progress-bar bg-success d-flex align-items-center justify-content-center" 
                                                role="progressbar" 
                                                style="width: <?= $porcentaje ?>%;" 
                                                aria-valuenow="<?= $porcentaje ?>" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                                <span style="font-size: 10px; color: white;"><?= round($porcentaje) ?>%</span>
                                            </div>
                                        </div>

                                        <div class="me-2">
                                            <button type="button" class="close btn-cerrar-modal" aria-label="Close" onclick="cerrarCard(this)"><i class="fa-solid fa-xmark"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">                            
                            <div class="card-body">

                                <?php 
                                    $array_seccion = array();
                                    foreach ($this->requerimientos as $req) { 
                                        if ($req->requerimientos_tipo == 3 && $req->requerimientos_estado != 3) { // Tipo Diseño
                                            if (!in_array($req->requerimientos_seccion, $array_seccion)) {
                                                $array_seccion[$req->requerimientos_seccion] = $this->list_secciones[$req->requerimientos_seccion]->secciones_nombre;
                                            }
                                        }
                                    }
                                ?>

                                <?php foreach ($array_seccion as $key => $value) { ?>
                                    <?php if ($value) { ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="caja_azul title-seccion">
                                                    <div class="d-flex justify-content-between align-items-center h-100">
                                                        <b class="titulo_dashboard"><i class="fa-solid fa-puzzle-piece"></i> <?= $value ?></b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row">
                                
                                        <?php 
                                        foreach ($this->requerimientos as $req) { 
                                            if ($req->requerimientos_tipo == 3 && $req->requerimientos_estado != 3) { // Tipo Diseño
                                                if ($req->requerimientos_seccion == $key) {
                                        ?>
                                            <div id="requerimiento_<?= $req->requerimientos_id ?>" class="d-flex my-2">
                                                <div class="gris-fondo-ing flex-grow-1" data-bs-toggle="modal" data-bs-target="#modal_view_reque_<?= $req->requerimientos_id ?>" style="cursor: pointer;">
                                                    <div class="text-justify color-requerimiento"><?= $req->requerimientos_desc ?></div>
                                                    <div class="d-flex justify-content-between mt-3" style="font-size: 12px;">
                                                        <span>
                                                            <?= $this->lista_ingenieros_user[$req->requerimientos_ing]->user_names . " ( " . $this->lista_ingenieros_user[$req->requerimientos_ing]->user_user . " ) "; ?>
                                                        </span>
                                                        <span>
                                                            <?php if ($req->requerimientos_estado == 1) { ?>
                                                                <button type="button" class="btn btn-sm btn-danger btn-circle" disabled></button>
                                                            <?php } elseif ($req->requerimientos_estado == 2) { ?>
                                                                <button type="button" class="btn btn-sm btn-warning btn-circle mb-1" disabled></button>
                                                            <?php } elseif ($req->requerimientos_estado == 3) { ?>
                                                                <button type="button" class="btn btn-sm btn-success btn-circle mb-1" disabled></button>
                                                            <?php } ?>
                                                            <?= formatoDMYH(str_replace("T", " ", $req->requerimientos_fecha_t)) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column ms-2">
                                                    <button type="button" class="btn btn-primary btn-manage btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modal_edit_reque_<?= $req->requerimientos_id ?>" onclick="event.stopPropagation();">
                                                        <i class="fa fa-pencil-alt" aria-hidden="true" data-bs-toggle="tooltip" data-placement="top" title="Editar"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-success btn-manage btn-sm mb-1" onclick="confirmStop(<?= $req->requerimientos_id ?>)">
                                                        <i class="fa fa-clock" aria-hidden="true" data-bs-toggle="tooltip" data-placement="top" title="Finalizado"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-manage btn-sm" onclick="confirmDelete(<?= $req->requerimientos_id ?>)">
                                                        <i class="fa fa-trash" aria-hidden="true" data-bs-toggle="tooltip" data-placement="top" title="Eliminar"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php } } } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <hr>

                <div class="row mb-3">
                    <div class="col-lg-12 mb-3">
                        <div class="caja_azul">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <b class="titulo_dashboard"><i class="fa-solid fa-bell"></i> Requerimientos realizados</b>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="title-label">Diseño</span>
                            </div>
                            
                            <div class="card-body">

                                <?php 
                                    $array_seccion = array();
                                    foreach ($this->requerimientos as $req) { 
                                        if ($req->requerimientos_tipo == 3 && $req->requerimientos_estado == 3) { // Tipo Diseño
                                            if (!in_array($req->requerimientos_seccion, $array_seccion)) {
                                                $array_seccion[$req->requerimientos_seccion] = $this->list_secciones[$req->requerimientos_seccion]->secciones_nombre;
                                            }
                                        }
                                    }
                                ?>

                                <?php foreach ($array_seccion as $key => $value) { ?>
                                    <?php if ($value) { ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="caja_azul title-seccion">
                                                    <div class="d-flex justify-content-between align-items-center h-100">
                                                        <b class="titulo_dashboard"><i class="fa-solid fa-puzzle-piece"></i> <?= $value ?></b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row">
                                
                                        <?php 
                                        foreach ($this->requerimientos as $req) { 
                                            if ($req->requerimientos_tipo == 3 && $req->requerimientos_estado == 3) { // Tipo Diseño
                                                if ($req->requerimientos_seccion == $key) {
                                        ?>
                                            <div id="requerimiento_<?= $req->requerimientos_id ?>" class="d-flex my-2">
                                                <div class="gris-fondo-ing flex-grow-1" data-bs-toggle="modal" data-bs-target="#modal_view_reque_<?= $req->requerimientos_id ?>" style="cursor: pointer;">
                                                    <div class="text-justify color-requerimiento"><?= $req->requerimientos_desc ?></div>
                                                    <div class="d-flex justify-content-between mt-3" style="font-size: 12px;">
                                                        <span>
                                                            <?= $this->lista_ingenieros_user[$req->requerimientos_ing]->user_names . " ( " . $this->lista_ingenieros_user[$req->requerimientos_ing]->user_user . " ) "; ?>
                                                        </span>
                                                        <span>
                                                            <?= formatoDMYH(str_replace("T", " ", $req->requerimientos_fecha_t)) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } } } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="title-label">Desarrollo</span>
                            </div>
                            
                            <div class="card-body">
                                <?php 
                                    $array_seccion = array();
                                    foreach ($this->requerimientos as $req) { 
                                        if ($req->requerimientos_tipo == 1 && $req->requerimientos_estado == 3) { // Tipo Desarrollo
                                            if (!in_array($req->requerimientos_seccion, $array_seccion)) {
                                                $array_seccion[$req->requerimientos_seccion] = $this->list_secciones[$req->requerimientos_seccion]->secciones_nombre;
                                            }
                                        }
                                    }
                                ?>

                                <?php foreach ($array_seccion as $key => $value) { ?>
                                    <?php if ($value) { ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="caja_azul title-seccion">
                                                    <div class="d-flex justify-content-between align-items-center h-100">
                                                        <b class="titulo_dashboard"><i class="fa-solid fa-puzzle-piece"></i> <?= $value ?></b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row">
                                        <?php foreach ($this->requerimientos as $req) { 
                                            if ($req->requerimientos_tipo == 1 && $req->requerimientos_estado == 3) { // Tipo Desarrollo
                                                if ($req->requerimientos_seccion == $key) {
                                        ?>

                                            <div id="requerimiento_<?= $req->requerimientos_id ?>" class="d-flex my-2">
                                                <div class="gris-fondo-ing flex-grow-1" data-bs-toggle="modal" data-bs-target="#modal_view_reque_<?= $req->requerimientos_id ?>" style="cursor: pointer;">
                                                    <div class="text-justify color-requerimiento"><?= $req->requerimientos_desc ?></div>
                                                    <div class="d-flex justify-content-between mt-3" style="font-size: 12px;">
                                                        <span>
                                                            <?= $this->lista_ingenieros_user[$req->requerimientos_ing]->user_names . " ( " . $this->lista_ingenieros_user[$req->requerimientos_ing]->user_user . " ) "; ?>
                                                        </span>
                                                        <span>
                                                            <?= formatoDMYH(str_replace("T", " ", $req->requerimientos_fecha_t)) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } } } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="title-label">Soporte</span>
                            </div>
                            
                            <div class="card-body">

                                <?php 
                                    $array_seccion = array();
                                    foreach ($this->requerimientos as $req) { 
                                        if ($req->requerimientos_tipo == 2 && $req->requerimientos_estado == 3) { // Tipo Desarrollo
                                            if (!in_array($req->requerimientos_seccion, $array_seccion)) {
                                                $array_seccion[$req->requerimientos_seccion] = $this->list_secciones[$req->requerimientos_seccion]->secciones_nombre;
                                            }
                                        }
                                    }
                                ?>

                                <?php foreach ($array_seccion as $key => $value) { ?>
                                    <?php if ($value) { ?>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="caja_azul title-seccion">
                                                    <div class="d-flex justify-content-between align-items-center h-100">
                                                        <b class="titulo_dashboard"><i class="fa-solid fa-puzzle-piece"></i> <?= $value ?></b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row">

                                        <?php foreach ($this->requerimientos as $req) { 
                                            if ($req->requerimientos_tipo == 2 && $req->requerimientos_estado == 3) { // Tipo Soporte
                                                if ($req->requerimientos_seccion == $key) {
                                        ?>
                                            <div id="requerimiento_<?= $req->requerimientos_id ?>" class="d-flex my-2">
                                                <div class="gris-fondo-ing flex-grow-1" data-bs-toggle="modal" data-bs-target="#modal_view_reque_<?= $req->requerimientos_id ?>" style="cursor: pointer;">
                                                    <div class="text-justify color-requerimiento"><?= $req->requerimientos_desc ?></div>
                                                    <div class="d-flex justify-content-between mt-3" style="font-size: 12px;">
                                                        <span>
                                                            <?= $this->lista_ingenieros_user[$req->requerimientos_ing]->user_names . " ( " . $this->lista_ingenieros_user[$req->requerimientos_ing]->user_user . " ) "; ?>
                                                        </span>
                                                        <span>
                                                            <?= formatoDMYH(str_replace("T", " ", $req->requerimientos_fecha_t)) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } } } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Final de contenido --->



                <?php foreach ($this->requerimientos as $req) { ?>
                    <div class="modal fade text-start" id="modal_edit_reque_<?= $req->requerimientos_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-md" role="document">
                            <div class="modal-content">
                                <form method="POST" action="/page/view/editarReque/" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="caja_azul">
                                                    <div class="d-flex justify-content-between align-items-center h-100">
                                                        <b class="titulo_dashboard"><i class="fa-solid fa-bell"></i> Editar requerimiento</b>
                                                        <div class="me-2">
                                                            <button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row px-3">
                                            <div class="container-fluid mt-3 mb-3">
                                                <span class="detail-modal d-block mb-2">Por favor ingrese los datos del requerimiento</span>
                                                <div class="row">
                                                    <div class="col-12 col-md-12 mb-2">
                                                        <span class="detail-modal">Proyecto: <?= $this->info->nombre ?></span>
                                                    </div>
                                                    <div class="col-12 col-md-12 mb-2">
                                                        <span class="detail-modal text-md-end">Fecha del requerimiento: <?= $req->requerimientos_fecha ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="content-table m-0">
                                                    <div id="table-body">
                                                        <div class="row mb-3 align-items-end item-row">
                                                            <div class="col-md-12">
                                                                <div class="input-group mb-3">
                                                                    <select class="form-select" name="requerimientos_seccion">
                                                                        <?php foreach ($this->list_secciones AS $key => $value ){?>
                                                                            <option value="<?php echo $key; ?>" <?php if ($req->requerimientos_seccion == $key){ echo "selected"; } ?>> <?= $value->secciones_nombre; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="input-group mb-3">
                                                                    <input name="requerimientos_fecha_t" type="datetime-local" value="<?= date('Y-m-d\TH:i', strtotime($req->requerimientos_fecha_t)) ?>" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="input-group mb-3">
                                                                    <select class="form-select" name="requerimientos_tipo">
                                                                        <option value="">Seleccione tipo</option>
                                                                        <?php foreach ($this->list_tipo AS $key => $value ){?>
                                                                            <option value="<?php echo $key; ?>" <?php if ($req->requerimientos_tipo == $key){ echo "selected"; } ?>> <?= $value; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="input-group mb-3">
                                                                    <select class="form-select" name="requerimientos_ing">
                                                                        <option value="">Seleccione colaborador</option>
                                                                        <?php foreach ($this->ingenieros AS $key => $value ){?>
                                                                            <option value="<?php echo $value->proyectosing_user; ?>" <?php if ($req->requerimientos_ing == $value->proyectosing_user){ echo "selected"; } ?>><?= $this->lista_ingenieros_user[$value->proyectosing_user]->user_names . " ( " .$this->lista_ingenieros_user[$value->proyectosing_user]->user_user . " ) "; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="input-group mb-3">
                                                                    <select class="form-select" name="requerimientos_estado">
                                                                        <option value="">Seleccione estado</option>
                                                                        <?php foreach ($this->list_estado_req AS $key => $value ){?>
                                                                            <option value="<?php echo $key; ?>" <?php if ($req->requerimientos_estado == $key){ echo "selected"; } ?>><?= $value; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 mb-3">
                                                                <textarea name="requerimientos_desc" id="requerimientos_desc" class="form-control tinyeditor" rows="3" oninput="this.value = this.value.toUpperCase();"><?= $req->requerimientos_desc ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                
                                            <input type="hidden" value="<?= $req->requerimientos_id ?>" name="requerimientos_id">
                                            <input type="hidden" name="csrf" value="<?= $this->csrf ?>">
                                            <input type="hidden" name="csrf_section" value="<?= $this->csrf_section ?>">
                                            <input type="hidden" name="cliente" value="<?= $_GET["cliente"] ?>">
                                            <input type="hidden" name="proyecto" value="<?= $_GET["proyecto"] ?>">

                                            <div class="col-lg-12 text-center mt-3">
                                                <div class="btn-modal-footer d-grid gap-2">
                                                    <button class="btn w-100" type="submit">Guardar</button>
                                                    <a class="w-100" data-bs-dismiss="modal">Cancelar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade text-start" id="modal_view_reque_<?= $req->requerimientos_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-md" role="document">
                            <div class="modal-content ">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="caja_azul">
                                                <div class="d-flex justify-content-between align-items-center h-100">
                                                    <b class="titulo_dashboard"><i class="fa-solid fa-bell"></i> Ver Requerimiento</b>
                                                    <div class="me-2">
                                                        <button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row px-3">
                                        <div class="col-lg-12 mt-3 mb-3">
                                            <span class="detail-modal">Fecha Asignacion: <?= formatoDMYH($req->requerimientos_fecha) ?></span><br>
                                            <span class="detail-modal">Fecha Vencimiento: <?= formatoDMYH(str_replace("T"," ",$req->requerimientos_fecha_t)) ?></span>
                                        </div>
                                        
                                        <div class="col-lg-12">
                                            <?php if ($req->requerimientos_seccion) { ?>
                                                <span class="mb-1"><?= $this->list_secciones[$req->requerimientos_seccion]->secciones_nombre; ?>: </span><br>
                                            <?php } ?>
                                            <span><?= $req->requerimientos_desc ?></span>
                                        </div>
                                        
                                        <hr class="mt-3">
                                        <div class="col-lg-12">
                                            <span>Ingeniero Encargado: </span>
                                            <?php 
                                                foreach ($this->ingenieros AS $key => $value ){
                                                    if ($req->requerimientos_ing == $value->proyectosing_user){
                                                        echo $this->lista_ingenieros_user[$value->proyectosing_user]->user_names . " ( " .$this->lista_ingenieros_user[$value->proyectosing_user]->user_user . " ) ";
                                                    } 
                                                }
                                            ?>
                                        </div>
                                        <div class="col-lg-12 text-center mt-3">
                                            <div class="btn-modal-footer d-grid gap-2">
                                                <a class="w-100" data-bs-dismiss="modal">Cancelar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    buscar_proyectos();
    function buscar_proyectos() {

        $('#logo-omega').addClass("d-none");
        
        var cliente = $("#info_cliente").val();
        var proyectoId = $("#proyectoId").val();

        console.log(cliente);
        $.post("/page/view/buscarProyectos/", {
            "cliente": cliente
        }, function(res) {
            console.log(res);
            // Limpiar los resultados previos
            $('.search-results-proyectos').empty();
            
            // Si hay resultados, los mostramos
            if (res.length > 0) {
                $.each(res, function(index, proyecto) {
                    var activeClass = proyecto.valor == proyectoId ? 'active' : '';
                    $('.search-results-proyectos').append('<a href="/page/view/?cliente='+cliente+'&proyecto='+proyecto.valor+'" class="' + activeClass + '">' + proyecto.texto + '</a>');
                });
            } else {
                // Si no hay resultados, mostramos un mensaje
                $('.search-results-proyectos').append('<p>No se encontraron proyectos.</p>');
            }
        });
    }

    function viewWhite() {
        $('#div-contenido-general').empty();  // Limpia el contenido del div antes de buscar proyectos
        $('#logo-omega').removeClass("d-none");
    }

    let removedCards = [];

    function cerrarCard(button) {
        const cardCol = button.closest('.col-4, .col-6, .col-12');
        if (cardCol) {
            removedCards.push(cardCol.outerHTML);  // Guarda el HTML de la tarjeta eliminada
            cardCol.remove();
            redistribuirTarjetas();
            mostrarBotonRecuperar();
        }
    }

    function redistribuirTarjetas() {

    }

    function mostrarBotonRecuperar() {
        const botonRecuperar = document.getElementById('botonRecuperar');
        if (removedCards.length > 0) {
            botonRecuperar.style.display = 'block'; // Mostrar el botón
        } else {
            botonRecuperar.style.display = 'none'; // Ocultar si no hay tarjetas eliminadas
        }
    }

    // Función para recuperar las tarjetas eliminadas
    function restaurarTarjetas() {
        const container = document.getElementById('cardContainer');
        removedCards.forEach(cardHTML => {
            container.insertAdjacentHTML('beforeend', cardHTML);
        });
        removedCards = [];  // Limpia el array después de restaurar
        redistribuirTarjetas();
        mostrarBotonRecuperar();
    }

    document.addEventListener('DOMContentLoaded', redistribuirTarjetas);




    $(document).ready(function() {
        // Agregar nueva columna con campo de archivo
        $('#add-row-adjuntos').on('click', function() {
            var newCol = `
                <div class="col-lg-4 col-12 mb-1 new-adjunto">
                    <div class="card">
                        <div class="card-body">
                            <div class="input-group">
                                <input type="file" name="adjuntos[]" class="form-control file-document" data-buttonName="btn-primary" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf,image/*">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-danger btn-sm btn-delete-adjuntos"><i class="fas fa-minus"></i> Quitar campo</button>
                        </div>
                    </div>
                </div>
            `;
            $('#row-body-adjuntos').append(newCol);

            // Re-aplicar el plugin fileinput a los nuevos inputs agregados dinámicamente
            $('.file-document').fileinput({
                maxFileSize: 10240,
                previewFileType: "image",
                browseLabel: "Examinar",
                browseClass: "btn btn-bck-gris",
                allowedFileExtensions: ["pdf","jpg", "jpeg", "gif", "png"],
                showUpload: false,
                showRemove: false,
                browseIcon: "<i class=\"fas fa-folder-open\"></i> ",
                language: "es",
                dropZoneEnabled: false
            });
        });

        // Función para eliminar una columna
        $('#row-body-adjuntos').on('click', '.btn-delete-adjuntos', function() {
            $(this).closest('.new-adjunto').remove();
        });
    });

    $(document).ready(function () {
        $('#add-row').on('click', function () {
            const newRow = `
                <div class="row mb-3 align-items-end item-row">
                    <div class="col-lg-12"><hr></div>
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <select class="form-select" name="requerimientos_seccion[]">
                                <option value="">Seleccione sección</option>
                                <?php foreach ($this->list_secciones AS $key => $value ){?>
                                    <option value="<?= $value->secciones_id ?>"> <?= $value->secciones_nombre ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <input name="requerimientos_fecha_t[]" type="datetime-local" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <select class="form-select" name="requerimientos_tipo[]">
                                <option value="">Seleccione tipo</option>
                                <?php foreach ($this->list_tipo as $key => $value) { ?>
                                    <option value="<?= $key; ?>"><?= $value; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <select class="form-select" name="requerimientos_ing[]">
                                <option value="">Seleccione colaborador</option>
                                <?php foreach ($this->ingenieros as $key => $value) { ?>
                                    <option value="<?= $value->proyectosing_user; ?>">
                                        <?= $this->lista_ingenieros_user[$value->proyectosing_user]->user_names . " ( " . $this->lista_ingenieros_user[$value->proyectosing_user]->user_user . " ) "; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <textarea name="requerimientos_desc[]" class="form-control tinyeditor" rows="3" oninput="this.value = this.value.toUpperCase();"></textarea>
                    </div>
                    <div class="col-md-12 text-end">
                        <div class="input-group mb-3">
                            <button class="btn btn-danger btn-sm btn-delete" type="button"><i class="fas fa-minus"></i> Quitar</button>
                        </div>
                    </div>
                </div>
            `;
            $('#table-body').append(newRow);
            obtenerSeccion(); // si usas alguna función para llenar los selects
        });

        // Eliminar una fila
        $('#table-body').on('click', '.btn-delete', function () {
            $(this).closest('.item-row').remove();
        });
    });

    $(document).ready(function() {
        $('#add-row-seccion').on('click', function() {
            var newRow = `
                <div class="input-group">
                    <input type="text" name="seccion[]" class="form-control modal-input mb-3 me-2" placeholder="Nombre de la sección">
                    <button class="btn btn-danger btn-manage btn-delete-seccion manage-btn"><i class="fas fa-minus"></i></button>
                </div>
            `;
            $('#seccion-body').append(newRow);
        });

        // Función para eliminar una fila
        $('#seccion-body').on('click', '.btn-delete-seccion', function() {
            $(this).closest('div').remove();
        });
    });

    $(document).ready(function() {
        $('#terminar_proyecto').on('click', function(e) {
            e.preventDefault(); // Previene la redirección automática

            // Muestra el cuadro de confirmación
            var confirmar = confirm("¿Estás seguro de que deseas terminar el proyecto?");
            
            // Si el usuario confirma, redirige al enlace
            if (confirmar) {
                window.location.href = $(this).attr('href');
            }
        });
    });

</script>

<script>
    function confirmDelete(requerimientos_id) {
        if (confirm("¿Estás seguro de que deseas eliminar esta solicitud?")) {
            // Enviar la solicitud AJAX si el usuario confirma
            $.post("/page/view/deleteRequerimiento", { id: requerimientos_id }, function(response) {
                $("#requerimiento_" + requerimientos_id).remove();
            });
        }
    }

    function confirmStop(requerimientos_id) {
        if (confirm("¿Estás seguro de que desea terminar el requermiento?")) {
            // Enviar la solicitud AJAX si el usuario confirma
            $.post("/page/view/stopRequerimiento", { id: requerimientos_id }, function(response) {
                $("#requerimiento_" + requerimientos_id).remove();
            });
        }
    }

    function eliminar_seccion(seccion_id) {
        if (confirm("¿ Estás seguro de que deseas eliminar esta sección ?")) {
            // Enviar la solicitud AJAX si el usuario confirma
            $.post("/page/view/deleteSeccion", { id: seccion_id }, function(response) {
                $("#seccion_" + seccion_id).remove();
            });
        }
    }

    function toUpperPreservingCaret(el) {
        const start = el.selectionStart;
        const end = el.selectionEnd;
        const upper = el.value.toUpperCase();

        if (el.value !== upper) {
            el.value = upper;
            el.setSelectionRange(start, end);
        }
    }
</script>