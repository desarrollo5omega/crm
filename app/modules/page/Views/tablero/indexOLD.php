<style>
    .modal-lg {
        max-width: 80%;
    }
</style>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var Calendar = FullCalendar.Calendar;
  var Draggable = FullCalendar.Draggable;

  var containerEl = document.getElementById('external-events');
  var calendarEl = document.getElementById('calendar');
  var checkbox = document.getElementById('drop-remove');

  // Inicializar los eventos arrastrables
  new Draggable(containerEl, {
    itemSelector: '.fc-event',
    eventData: function(eventEl) {
      return {
        title: eventEl.getAttribute('data-title'),
        id: eventEl.getAttribute('data-id')
      };
    }
  });

  // Inicializar el calendario
  var calendar = new Calendar(calendarEl, {
    locale: 'es',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week: 'Semana',
        day: 'Día'
    },
    initialView: 'timeGridWeek',
    editable: true,
    droppable: true,
    weekends: false,
    slotMinTime: '08:00:00',
    slotMaxTime: '18:00:00',

    events: [
        {
            title: 'Almuerzo',
            startTime: '13:00:00',
            endTime: '14:00:00',
            daysOfWeek: [1, 2, 3, 4, 5],
            display: 'block',
            editable: false,
            classNames: ['no-modal-fc-evento']
        },
        <?php foreach ($this->tablero as $evento): ?>
        {
            title: '<?= $evento->cliente . " - " . $evento->nombre ?>',
            start: '<?= $evento->tablero_fecha ?>T<?= $evento->tablero_inicia ?>',
            end: <?= $evento->tablero_fin !== 'No especificada' ? "'{$evento->tablero_fecha}T{$evento->tablero_fin}'" : "null" ?>,
            allDay: <?= $evento->tablero_all === 'Si' ? 'true' : 'false' ?>,
            color: '<?= $evento->tablero_color ?>',
            textColor: '<?= $evento->tablero_fuente ?>',
            id: <?= $evento->tablero_id ?>,
            group: <?= $evento->tablero_proyecto ?>,
            cliente_id: <?= $evento->cliente_id ?>
        },
        <?php endforeach; ?>
    ],

    drop: function(info) {
      if (checkbox.checked) {
        info.draggedEl.parentNode.removeChild(info.draggedEl);
      }
    },

    eventReceive: function(info) {
        var event = info.event;
        var proyecto = info.draggedEl.dataset.id;
        var cliente = info.draggedEl.dataset.label;
        var start = event.start;
        var end = new Date(start);
        end.setHours(start.getHours() + 1); // Añadir 1 hora al inicio
        event.setExtendedProp("group", proyecto);
        event.setExtendedProp("cliente_id", cliente);
        event.setEnd(end);

        var data = {
            id: event.id,
            ing: <?= $_GET["ing"] ?>,
            fecha: start.toISOString().split('T')[0],
            dia: start.toLocaleString('es-ES', { weekday: 'long' }),
            horaInicio: start.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }),
            horaFin: end.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }),
            esTodoElDia: event.allDay ? "Si" : "No",
            group: proyecto,
            cliente_id: cliente
        };
        
        $.post("/page/tablero/insertTablero/", data, function(res) {
            console.log("Respuesta del servidor (insert):", res);
        });
    },

    // Manejador para cuando se mueve un evento
    eventDrop: function(info) {
        var event = info.event;
        var start = event.start;
        var end = event.end;
    
        var data = {
            id: event.id,
            fecha: start.toISOString().split('T')[0],
            dia: start.toLocaleString('es-ES', { weekday: 'long' }),
            horaInicio: start.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }),
            horaFin: end.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }),
            esTodoElDia: event.allDay ? "Si" : "No"
        };

        $.post("/page/tablero/updateTablero/", data, function(res) {
            console.log("Respuesta del servidor (update - drop):", res);
            console.log(data);
        });
    },

    // Manejador para cuando se redimensiona un evento
    eventResize: function(info) {
        var event = info.event;
        var start = event.start;
        var end = event.end;

        var data = {
            id: event.id,
            fecha: start.toISOString().split('T')[0],
            dia: start.toLocaleString('es-ES', { weekday: 'long' }),
            horaInicio: start.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }),
            horaFin: end.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }),
            esTodoElDia: event.allDay ? "Si" : "No"
        };

        $.post("/page/tablero/updateTablero/", data, function(res) {
            console.log("Respuesta del servidor (update - resize):", res);
        });
    },

    eventDidMount: function(info) {
        var eventTitleElement = info.el.querySelector('.fc-event-title-container');
        var eventMainElement = info.el.querySelector('.fc-event-main');

        // Asegúrate de que el contenedor tenga las clases de flex
        if (eventTitleElement) {
            eventTitleElement.classList.add('d-flex', 'justify-content-between', 'align-items-center');

            // Aplicar estilos de fondo de alert-succes
            info.el.style.backgroundColor = '#d4edda'; // Color de fondo
            info.el.style.borderColor = '#c3e6cb';      // Color del borde

            // Aplicar color de texto directamente al elemento main
            if (eventMainElement) {
                eventMainElement.style.color = '#155724'; // Color del texto
            }
            <?php if ($this->level != 5) { ?>
                // Asegúrate de que el botón de eliminación esté presente
                var existingDeleteButton = eventTitleElement.querySelector('.delete-button');
                if (!existingDeleteButton) {
                    var deleteButton = document.createElement('span');
                    deleteButton.classList.add('delete-button');
                    deleteButton.innerHTML = '<i class="fa fa-times" aria-hidden="true"></i>';
                    deleteButton.style.cursor = 'pointer';
                    deleteButton.style.marginLeft = '10px';
                    deleteButton.style.fontSize = '12px';

                    // Añadir el evento click al botón de eliminación
                    deleteButton.addEventListener('click', function(event) {
                        event.stopPropagation();
                        var eventId = info.event.id;
                        if (confirm("¿Deseas eliminar este evento?")) {
                            info.event.remove();
                            $.post("/page/tablero/deleteTablero/", { id: eventId }, function(res) {
                                console.log("Respuesta del servidor:", res);
                            });
                        }
                    });

                    // Añadir el botón de eliminar al contenedor del título
                    eventTitleElement.appendChild(deleteButton);
                }
            <?php } ?>

            // Actualizar el título si es necesario
            var titleElement = eventTitleElement.querySelector('.fc-event-title');
        }

        // Asignar data-event-id al elemento del evento
        info.el.setAttribute('data-event-id', info.event.id);
    },

    eventClick: function(info) {
        
        if (info.event.classNames.includes('no-modal-fc-evento')) {
            return; // No hace nada si es el evento de almuerzo
        }

        var eventTitle = info.event.title;
        var idProject = info.event.extendedProps.group;
        var ing = $("#colaborador").val();
        var cliente = info.event.extendedProps.cliente_id;
        

        window.location.href = window.location.pathname + '?ing='+ing+'&proyecto='+idProject+'&cliente='+cliente;
        
        /* document.getElementById('eventTitle').innerText = eventTitle;
        var modal = new bootstrap.Modal(document.getElementById('eventModal'));
        modal.show();
        
        const urlParams = new URLSearchParams(window.location.search);
        const ingValue = urlParams.get('ing');
        $.post("/page/tablero/verReq/", { proyecto: , ing : ingValue }, function(res) {
            
            // Limpiar las columnas de requerimientos para evitar datos duplicados
            document.getElementById('tipo1').innerHTML = '';
            document.getElementById('tipo2').innerHTML = '';
            document.getElementById('tipo3').innerHTML = '';
            document.getElementById('lista_docs').innerHTML = ''; // Limpiar la lista de documentos
            document.getElementById('progressTipo1').style.width = '0%';
            document.getElementById('progressTipo2').style.width = '0%';
            document.getElementById('progressTipo3').style.width = '0%';
            document.getElementById('progressTipo1').innerText = '0%';
            document.getElementById('progressTipo2').innerText = '0%';
            document.getElementById('progressTipo3').innerText = '0%';
            
            // Mostrar la descripción del proyecto
            document.getElementById('descripcion_evento').innerHTML = res.desc;
            document.getElementById('fecha_final').innerHTML = res.fecha_final;

            // Agrupar los requerimientos y construir el contenido HTML
            if (res.requerimientos) {

                // Variables para conteo de requerimientos por tipo y estado
                let totalTipo1 = 0, completedTipo1 = 0;
                let totalTipo2 = 0, completedTipo2 = 0;
                let totalTipo3 = 0, completedTipo3 = 0;
                
                res.requerimientos.forEach(function(requerimiento) {
                    var tipo = requerimiento.requerimientos_tipo;
                    var estado = requerimiento.requerimientos_estado;
                    
                    if (estado == 1 || estado == 2) {
                        var requerimientoHtml = `
                            <div id="requerimiento_${requerimiento.requerimientos_id}" class="d-flex my-2">
                                <div class="gris-fondo-ing flex-grow-1" style="cursor: pointer;">
                                    <div class="text-justify">${requerimiento.requerimientos_desc}</div>
                                    <div class="d-flex justify-content-between mt-3" style="font-size: 12px;">
                                        <span>
                                            ${requerimiento.user_names} (${requerimiento.user_user})
                                        </span>
                                        <span>
                                            ${estado == 1 ? 
                                                '<button type="button" class="btn btn-sm btn-danger btn-circle" disabled></button>' : 
                                                '<button type="button" class="btn btn-sm btn-success btn-circle mb-1" disabled></button>'}
                                            ${formatoDMYH(requerimiento.requerimientos_fecha_t)}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column ms-2">
                                    <button type="button" class="btn btn-primary btn-manage btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modal_edit_reque_${requerimiento.requerimientos_id}"
                                    onclick="document.getElementById('iframe_requerimiento_${requerimiento.requerimientos_id}').src='/page/view/requerimiento?proyecto=${idProject}&r=${requerimiento.requerimientos_id}&cliente=${res.cliente}&detalle=1';">
                                        <i class="fa fa-pencil-alt" aria-hidden="true" data-bs-toggle="tooltip" data-placement="top" title="Editar"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-manage btn-sm mb-1" onclick="confirmStop(${requerimiento.requerimientos_id})">
                                        <i class="fa fa-clock" aria-hidden="true" data-bs-toggle="tooltip" data-placement="top" title="Finalizado"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-manage btn-sm" onclick="confirmDelete(${requerimiento.requerimientos_id})">
                                        <i class="fa fa-trash" aria-hidden="true" data-bs-toggle="tooltip" data-placement="top" title="Eliminar"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                    } else {
                        var requerimientoHtml = '';
                    }

                    // Insertar el contenido en la columna correspondiente y contar el estado
                    if (tipo == "1") {
                        totalTipo1++;
                        if (estado == 3) completedTipo1++;
                        document.getElementById('tipo1').innerHTML += requerimientoHtml;
                    } else if (tipo == "2") {
                        totalTipo2++;
                        if (estado == 3) completedTipo2++;
                        document.getElementById('tipo2').innerHTML += requerimientoHtml;
                    } else if (tipo == "3") {
                        totalTipo3++;
                        if (estado == 3) completedTipo3++;
                        document.getElementById('tipo3').innerHTML += requerimientoHtml;
                    }
                });

                // Calcular porcentaje de progreso por cada tipo
                let progressTipo1 = (totalTipo1 > 0) ? (completedTipo1 / totalTipo1) * 100 : 0;
                let progressTipo2 = (totalTipo2 > 0) ? (completedTipo2 / totalTipo2) * 100 : 0;
                let progressTipo3 = (totalTipo3 > 0) ? (completedTipo3 / totalTipo3) * 100 : 0;

                // Actualizar barras de progreso en la modal
                document.getElementById('progressTipo1').style.width = progressTipo1 + '%';
                document.getElementById('progressTipo1').innerText = Math.round(progressTipo1) + '%';
                document.getElementById('progressTipo2').style.width = progressTipo2 + '%';
                document.getElementById('progressTipo2').innerText = Math.round(progressTipo2) + '%';
                document.getElementById('progressTipo3').style.width = progressTipo3 + '%';
                document.getElementById('progressTipo3').innerText = Math.round(progressTipo3) + '%';

                // Mostrar los documentos en lista_docs
                if (res.docs) {
                    res.docs.forEach(function(doc) {
                        // Define la ruta del archivo según tu lógica en el backend
                        var docUrl = `/images/${doc.documentos_nombre}`;

                        var docHtml = `
                            <li class="list-group-item d-flex justify-content-between align-items-center mb-2">
                                <span>${doc.documentos_nombre}</span>
                                <a href="${docUrl}" class="btn btn-primary btn-sm" target="_blank" rel="noopener noreferrer">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </li>
                        `;
                        document.getElementById('lista_docs').innerHTML += docHtml;
                    });
                }
            }

        });*/
    }

  });

  calendar.render();
});

function formatoDMYH(fechaStr) {
    const fecha = new Date(fechaStr);
    const dia = String(fecha.getDate()).padStart(2, '0');
    const mes = String(fecha.getMonth() + 1).padStart(2, '0'); // Los meses son 0-indexados
    const año = fecha.getFullYear();
    const horas = String(fecha.getHours()).padStart(2, '0');
    const minutos = String(fecha.getMinutes()).padStart(2, '0');
    return `${dia}/${mes}/${año} ${horas}:${minutos}`;
}

// Función de confirmación y redirección
function confirmNavigation(id) {
    const confirmation = confirm("¿Estás seguro de que quieres continuar?");
    if (confirmation) {
        // Redirigir a la URL deseada
        window.location.href = `/ruta/deseada/${id}`;
    }
}

// Función para buscar proyectos y añadirlos a los eventos arrastrables
buscar_proyectos();
function buscar_proyectos() {
    var cliente = $("#info_cliente").val();
    var proyectoId = $("#proyectoId").val();

    $.post("/page/tablero/obtenerProyecto/", {
        "cliente": cliente,
        "ing" : <?= $_GET["ing"]; ?>
    }, function(res) {

        // Limpiar los resultados previos en el contenedor de eventos arrastrables
        $('.search-results-proyectos').empty();
        
        // Si hay resultados, los mostramos
        if (res) {

            $.each(res, function(index, proyecto) {
                // Crear un div para cada proyecto en el formato necesario
                var colorClass = proyecto.color ? proyecto.color : 'fc-event-default'; // Puedes asignar una clase de color personalizada

                $('.search-results-proyectos').append(`
                    <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event ${colorClass}' data-title="${proyecto.texto}" data-id="${proyecto.valor}" data-label="${proyecto.cliente_id}">
                        <div class='fc-event-main'>${proyecto.cliente} - ${proyecto.texto}</div>
                    </div>
                `);
            });

        } else {
            // Si no hay resultados, mostramos un mensaje
            $('.search-results-proyectos').append('<p>No se encontraron proyectos.</p>');
        }
    });
}


</script>

<style>
    .no-modal-fc-evento {
        color: #004085 !important;
        background-color: #cce5ff !important;
        border-color: #b8daff !important;
    }
</style>

<h1 class="titulo-principal"><i class="fas fa-cogs"></i> <?php echo $this->titlesection; ?></h1>
<div class="container-fluid">
    <div class="content-dashboard">
        <div class="row">
            <div class="col-lg-2 col-12 mb-3">
                <div class="caja_azul">
                    <div class="d-flex justify-content-between align-items-center h-100">
                        <b class="titulo_dashboard">
                            <i class="fa-solid fa-barcode icon-dash"></i>
                            <strong>Proyectos de <?= $this->lista_ingenieros_user[$_GET["ing"]]->user_names ?></strong>
                        </b>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body" id='external-events'>
                        <div id="sidebar-proyectos-content">
                            <!-- Buscador con ícono -->
                            <div class="search-box-proyectos position-relative">
                                <label class="form-label">Colaborador</label>
                                <div class="input-group mb-3">
                                    <select class="form-select" name="colaborador" id="colaborador" onchange="submitColaborador()">
                                        <option value="">Seleccione colaborador</option>
                                        <?php foreach ($this->lista_ingenieros as $key => $value) { ?>
                                            <?php if ($key == $_GET["ing"]) { $select = "selected"; } else { $select = ''; } ?>
                                            <option value="<?= $key ?>" <?= $select ?>><?= $value ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <label class="form-label">Filtrar Proyectos por Cliente</label>
                                <div class="input-group">
                                    <select class="form-select" id="info_cliente" onchange="buscar_proyectos();">
                                        <option value="">Todos los clientes</option>
                                        <?php foreach ($this->list_cliente_id as $key => $value) : ?>
                                            <option value="<?= $key; ?>" <?php if ($_GET["cliente"] == $key) { echo "selected"; } ?>><?= $value; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="proyectoId" value="<?= $_GET["proyecto"] ?>">

                            <!-- Resultados de búsqueda (falsos resultados) -->
                            <div class="search-results-proyectos">
                            </div>
                        </div>
                        <p class="d-none">
                            <input type='checkbox' id='drop-remove' />
                            <label for='drop-remove'>Eliminar después de soltar</label>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-12 mb-3">
                <div class="caja_azul">
                    <div class="d-flex justify-content-between align-items-center h-100">
                        <b class="titulo_dashboard">
                            <i class="fa-solid fa-barcode icon-dash"></i>
                            <strong>Plan de Trabajo <?= $this->lista_ingenieros_user[$_GET["ing"]]->user_names ?></strong>
                        </b>
                        <?php if ($this->level != 5) { ?>
                            <div class="gris_claro me-2">
                                <span data-bs-toggle="tooltip" data-placement="top" title="Agregar soporte" class="">
                                    <a class="custom-btn-home" data-bs-toggle="modal" data-bs-target="#modal_crear_proyecto">
                                        <span class="add-button-home-2 lf-part">AGREGAR SOPORTE</span>
                                        <span class="rg-part"><i class="fas fa-plus"></i></span>
                                    </a>
                                </span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body" id='calendar-container'>
                        <div id='calendar' lang="es"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-12 mb-5">
                <div class="caja_azul">
                    <div class="d-flex justify-content-between align-items-center h-100">
                        <!-- Icono y Texto -->
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-barcode icon-dash"></i>
                            <strong>Requerimientos <br> 
                                <span class="font-requerimiento-2">
                                    ( <?= $this->list_cliente_id[$this->info->cliente_id] ?> <?= $this->info->nombre ?> )
                                </span>
                            </strong>
                        </div>

                        <!-- Texto como botón para abrir el menú -->
                        <div class="dropdown me-2">
                            <span class="dropdown-toggle custom-text-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-gears"></i>
                            </span>
                            <?php if ($this->level != 5) { ?>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center cursor-pointer" data-bs-toggle="modal" data-bs-target="#modal_reque">
                                            Agregar requerimiento
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center cursor-pointer" data-bs-toggle="modal" data-bs-target="#modal_seccion">
                                            Agregar sección
                                        </a>
                                    </li>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
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


                            

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="caja_azul cursor-pointer" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            <div class="titulo_dashboard d-flex justify-content-between align-items-center" style="height: 100%;">
                                                <div class="d-flex align-items-center" style="width: 130px">
                                                    <i class="fa-solid fa-code"></i>&nbsp;Desarrollo
                                                </div>

                                                <!-- Barra de progreso con porcentaje -->
                                                <div class="progress flex-grow-1 mx-2" style="max-width: 230px">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $porcentaje_desarrollo ?>%;" aria-valuenow="<?= $porcentaje_desarrollo ?>" aria-valuemin="0" aria-valuemax="100">
                                                        <span style="font-size: 10px; color: white;"><?= round($porcentaje_desarrollo) ?>%</span>
                                                    </div>
                                                </div>

                                                
                                                <i class="fa-solid fa-chevron-down icono-collapse me-2"></i>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contenido que se colapsa -->
                                <div id="collapseOne" class="card collapse">                 
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
                                                            <div class="text-justify color-requerimiento font-requerimiento"><?= $req->requerimientos_desc ?></div>
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
                                                            <?php if ($this->level != 5) { ?>
                                                                <button type="button" class="btn btn-success btn-manage btn-sm mb-1" onclick="confirmStop(<?= $req->requerimientos_id ?>)">
                                                                    <i class="fa fa-clock" aria-hidden="true" data-bs-toggle="tooltip" data-placement="top" title="Finalizado"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-danger btn-manage btn-sm" onclick="confirmDelete(<?= $req->requerimientos_id ?>)">
                                                                    <i class="fa fa-trash" aria-hidden="true" data-bs-toggle="tooltip" data-placement="top" title="Eliminar"></i>
                                                                </button>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                <?php } } } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="caja_azul cursor-pointer" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <div class="titulo_dashboard d-flex justify-content-between align-items-center" style="height: 100%;">
                                                <div class="d-flex align-items-center" style="width: 130px">
                                                    <i class="fa-solid fa-headset"></i>&nbsp;Soporte
                                                </div>

                                                <!-- Barra de progreso con porcentaje para Soporte -->
                                                <div class="progress flex-grow-1 mx-2" style="max-width: 230px">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $porcentaje_soporte ?>%;" aria-valuenow="<?= $porcentaje_soporte ?>" aria-valuemin="0" aria-valuemax="100">
                                                        <span style="font-size: 10px; color: white;"><?= round($porcentaje_soporte) ?>%</span>
                                                    </div>
                                                </div>

                                                <i class="fa-solid fa-chevron-down icono-collapse me-2"></i>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card collapse" id="collapseTwo">                          
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
                                                            <div class="text-justify color-requerimiento font-requerimiento"><?= $req->requerimientos_desc ?></div>
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

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="caja_azul cursor-pointer" data-bs-toggle="collapse" data-bs-target="#collapseTre" aria-expanded="false" aria-controls="collapseTre">
                                            <div class="titulo_dashboard d-flex justify-content-between align-items-center" style="height: 100%;">
                                                <div class="d-flex align-items-center" style="width: 130px">
                                                    <i class="fa-solid fa-object-group"></i>&nbsp;Diseño
                                                </div>

                                                <!-- Barra de progreso con porcentaje -->
                                                <div class="progress flex-grow-1 mx-2" style="max-width: 230px">
                                                    <div class="progress-bar bg-success d-flex align-items-center justify-content-center" 
                                                        role="progressbar" 
                                                        style="width: <?= $porcentaje ?>%;" 
                                                        aria-valuenow="<?= $porcentaje ?>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                        <span style="font-size: 10px; color: white;"><?= round($porcentaje) ?>%</span>
                                                    </div>
                                                </div>

                                                <i class="fa-solid fa-chevron-down icono-collapse me-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card collapse" id="collapseTre">                            
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
                                                            <div class="text-justify color-requerimiento font-requerimiento"><?= $req->requerimientos_desc ?></div>
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
                    </div>
                </div>
            </div>

            <?php foreach ($this->requerimientos as $req) { ?>
                <div class="modal fade text-start" id="modal_edit_reque_<?= $req->requerimientos_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form method="POST" action="/page/tablero/editarReque/" enctype="multipart/form-data">
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
                                        <div class="col-lg-12 mt-3 mb-3">
                                            <span class="detail-modal">Por favor ingrese los datos del requerimiento</span><br>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="detail-modal">Proyecto: <?= $this->info->nombre ?></span>
                                                <span class="detail-modal">Fecha del requerimiento: <?= $req->requerimientos_fecha ?></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="content-table m-0">
                                                <table class="table table-striped table-hover table-administrator">
                                                    <thead style="background: #575757; color:white;">
                                                        <tr>
                                                            <td>Sección</td>
                                                            <td>Fecha Vencimiento</td>
                                                            <td>Tipo de Requerimiento</td>
                                                            <td>Ing Encargado del Requerimiento</td>
                                                            <td>Estado</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table-body">
                                                        <tr>
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-text input-icono" ><i class="far fa-list-alt"></i></span>
                                                                    <select class="form-select" name="requerimientos_seccion" required>
                                                                        <option value="">Seleccione</option>
                                                                        <?php foreach ($this->list_secciones AS $key => $value ){?>
                                                                            <option value="<?= $value->secciones_id ?>" <?php if ($req->requerimientos_seccion == $key) { echo "selected"; } ?>> <?= $value->secciones_nombre ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="help-block with-errors"></div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
                                                                    <input name="requerimientos_fecha_t" type="datetime-local" value="<?= date('Y-m-d\TH:i', strtotime($req->requerimientos_fecha_t)) ?>" class="form-control">
                                                                </div>
                                                                <div class="help-block with-errors"></div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-text input-icono" ><i class="far fa-list-alt"></i></span>
                                                                    <select class="form-select" name="requerimientos_tipo">
                                                                        <option value="">Seleccione</option>
                                                                        <?php foreach ($this->list_tipo AS $key => $value ){?>
                                                                            <option value="<?php echo $key; ?>" <?php if ($req->requerimientos_tipo == $key){ echo "selected"; } ?>> <?= $value; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="help-block with-errors"></div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-text input-icono" ><i class="far fa-list-alt"></i></span>
                                                                    <select class="form-select" name="requerimientos_ing">
                                                                        <option value="">Seleccione</option>
                                                                        <?php foreach ($this->ingenieros AS $key => $value ){?>
                                                                            <option value="<?php echo $value->proyectosing_user; ?>" <?php if ($req->requerimientos_ing == $value->proyectosing_user){ echo "selected"; } ?>><?= $this->lista_ingenieros_user[$value->proyectosing_user]->user_names . " ( " .$this->lista_ingenieros_user[$value->proyectosing_user]->user_user . " ) "; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="help-block with-errors"></div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-text input-icono" ><i class="far fa-list-alt"></i></span>
                                                                    <select class="form-select" name="requerimientos_estado">
                                                                        <option value="">Seleccione</option>
                                                                        <?php foreach ($this->list_estado_req AS $key => $value ){?>
                                                                            <option value="<?php echo $key; ?>" <?php if ($req->requerimientos_estado == $key){ echo "selected"; } ?>><?= $value; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="help-block with-errors"></div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">
                                                                <textarea name="requerimientos_desc" id="requerimientos_desc" class="form-control tinyeditor" rows="1" oninput="this.value = this.value.toUpperCase();"><?= $req->requerimientos_desc ?></textarea>
                                                                <div class="help-block with-errors"></div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                            
                                        <input type="hidden" value="<?= $req->requerimientos_id ?>" name="requerimientos_id">
                                        <input type="hidden" name="csrf" value="<?= $this->csrf ?>">
                                        <input type="hidden" name="csrf_section" value="<?= $this->csrf_section ?>">
                                        <input type="hidden" name="cliente" value="<?= $_GET["cliente"] ?>">
                                        <input type="hidden" name="proyecto" value="<?= $_GET["proyecto"] ?>">
                                        <input type="hidden" name="ing" value="<?= $_GET["ing"] ?>">

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


                
            <!-- Modals -->
            <div class="modal fade text-start" id="modal_seccion" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content ">
                        <div class="modal-body">
                            <form method="POST" action="/page/tablero/seccion/" enctype="multipart/form-data">
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
                                            <input type="hidden" name="ing" value="<?= $_GET["ing"] ?>">
                                            
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
            
            <div class="modal fade text-start" id="modal_reque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content ">
                        <div class="modal-body">
                            <form method="POST" action="/page/tablero/updateReque/" enctype="multipart/form-data">
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
                                    <div class="col-lg-12 mt-3 mb-3">
                                        <span class="detail-modal">Por favor ingrese los datos del requerimiento</span><br>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="detail-modal">Proyecto: <?= $this->info->nombre ?></span>
                                            <span class="detail-modal">Fecha del requerimiento: <?= date("d-m-Y H:i:s") ?></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="content-table m-0">
                                            <input name="requerimientos_fecha" type="hidden" value="<?= date("d-m-Y H:i:s") ?>" class="form-control">
                                            <table class="table table-striped table-hover table-administrator">
                                                <thead style="background: #575757; color:white;">
                                                    <tr>
                                                        <td>Sección</td>
                                                        <td>Fecha Vencimiento</td>
                                                        <td>Tipo de Requerimiento</td>
                                                        <td>Ing Encargado del Requerimiento</td>
                                                        <td style="width: 35%;">Descripción del requerimiento</td>
                                                        <td>
                                                            <button id="add-row" class="btn btn-primary btn-sm" type="button">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-body">
                                                    <tr>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-text input-icono" ><i class="far fa-list-alt"></i></span>
                                                                <select class="form-select" name="requerimientos_seccion[]">
                                                                    <option value="">Seleccione</option>
                                                                    <?php foreach ($this->list_secciones AS $key => $value ){?>
                                                                        <option value="<?= $value->secciones_id ?>"> <?= $value->secciones_nombre ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="help-block with-errors"></div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
                                                                <input name="requerimientos_fecha_t[]" type="datetime-local" value="" class="form-control">
                                                            </div>
                                                            <div class="help-block with-errors"></div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-text input-icono" ><i class="far fa-list-alt"></i></span>
                                                                <select class="form-select" name="requerimientos_tipo[]">
                                                                    <option value="">Seleccione</option>
                                                                    <?php foreach ($this->list_tipo AS $key => $value ){?>
                                                                        <option value="<?php echo $key; ?>"> <?= $value; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="help-block with-errors"></div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-text input-icono" ><i class="far fa-list-alt"></i></span>
                                                                <select class="form-select" name="requerimientos_ing[]">
                                                                    <option value="">Seleccione</option>
                                                                    <?php foreach ($this->ingenieros AS $key => $value ){?>
                                                                        <option value="<?php echo $value->proyectosing_user; ?>"><?= $this->lista_ingenieros_user[$value->proyectosing_user]->user_names . " ( " .$this->lista_ingenieros_user[$value->proyectosing_user]->user_user . " ) "; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="help-block with-errors"></div>
                                                        </td>
                                                        <td>
                                                            <textarea name="requerimientos_desc[]" id="requerimientos_desc" required class="form-control tinyeditor" rows="1" oninput="this.value = this.value.toUpperCase();"></textarea>
                                                            <div class="help-block with-errors"></div>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm btn-delete"><i class="fas fa-minus"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                                    <input type="hidden" name="proyecto" value="<?= $_GET["proyecto"] ?>">
                                    <input type="hidden" name="ing" value="<?= $_GET["ing"] ?>">

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade text-start" id="modal_crear_proyecto" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <form class="text-start" enctype="multipart/form-data" method="post" action="/page/soporte/insert">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="caja_azul">
                                            <div class="d-flex justify-content-between align-items-center h-100">
                                                <b class="titulo_dashboard"><i class="fa-solid fa-diagram-project icon-dash"></i> Crear nuevo proyecto en soporte</b>
                                                <div class="me-2">
                                                    <button type="button" class="close btn-cerrar-modal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row px-3">
                                    <div class="col-lg-12 mt-3 mb-3">
                                        <span class="detail-modal">Por favor ingrese los datos del proyecto</span>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="input-group">
                                            <select class="form-select modal-input" name="cliente_id" required <?php if($_GET['detalle'] == "1" && $_GET['hash'] == "") { echo "disabled"; } ?>>
                                                <option value="">Cliente</option>
                                                <?php foreach ($this->list_cliente_all AS $key => $value ){?>
                                                    <option <?php if($this->getObjectVariable($this->content,"cliente_id") == $key or $_GET['cliente'] == $key){ echo "selected"; $valor_cliente = $key; }?> value="<?php echo $key; ?>"> <?= $value; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <div class="input-group">
                                            <input type="text" value="" name="nombre" id="nombre" class="form-control modal-input" required minlength="3" pattern="[^\d]*" title="No se permiten numeros" placeholder="Nombre del Proyecto">
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>				
                                    <div class="col-lg-12 mb-3 d-none">
                                        <div class="input-group">
                                            <input type="text" value="0" name="valor" id="valor" class="form-control modal-input" onchange="puntitos(this)" onkeyup="puntitos(this)">
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="input-group">
                                            <select class="form-select modal-input" name="tipo" required>
                                                <option value="">Tipo de Proyecto</option>
                                                <?php foreach ($this->list_tipo AS $key => $value ){?>
                                                    <option <?php if($this->getObjectVariable($this->content,"tipo") == $key ){ echo "selected"; }?> value="<?php echo $key; ?>" /> <?= $value; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="input-group">
                                        <select class="form-select" name="proyectosing_user">
                                            <option value="">Seleccione ingeniero</option>
                                            <?php foreach ($this->lista_ingenieros as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>"><?= $value; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 mb-3 d-none">
                                        <div class="input-group">
                                            <input type="hidden" value="9" name="estado" id="estado" class="form-control modal-input">
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="col-lg-12 text-center mt-3">
                                        <div class="btn-modal-footer d-grid gap-2">
                                            <button class="btn w-100" type="submit">Guardar</button>
                                            <a class="w-100" data-bs-dismiss="modal">Cancelar</a>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="r" id="r" value="tablero">
                                    <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->csrf ?>">
                                    <input type="hidden" name="csrf_section" id="csrf_section" value="<?php echo $this->csrf_section ?>">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="caja_azul">
                    <div class="d-flex justify-content-between align-items-center h-100">
                        <div class="titulo_dashboard">
                            <i class="fa-solid fa-diagram-project"></i>
                            Detalles del Proyecto: <span id="eventTitle"></span>
                        </div>
                    </div>
                </div>
                <div class="row" id="eventDetails">
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="d-flex justify-content-between align-contents-center">
                                            <label class="form-label title-label">Descripción del Proyecto:</label>
                                            <label class="form-label title-label">Fecha Finalización: <span id="fecha_final"></span></label>
                                        </div>
                                        <span id="descripcion_evento"></span>
                                    </div>
                                    <div class="col-4">
                                        <div class="caja_azul">
                                            <div class="d-flex justify-content-between align-items-center h-100">
                                                <div class="titulo_dashboard">
                                                    <i class="fa-solid fa-paperclip"></i> Lista de Adjuntos
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body" id="lista_docs"></div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <!-- Columna Desarrollo -->
                    <div class="col-4">
                        <div class="caja_azul">
                            <div class="titulo_dashboard d-flex justify-content-between align-items-center" style="height: 100%;">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-code"></i>&nbsp;Desarrollo
                                </div>

                                <!-- Barra de progreso con porcentaje -->
                                <div class="progress flex-grow-1 mx-2" style="height: 15px;">
                                    <div id="progressTipo1" class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <span style="font-size: 10px; color: white;">0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" id="tipo1">
                                <!-- Requerimientos de tipo 1 irán aquí -->
                            </div>
                        </div>
                    </div>

                    <!-- Columna Soporte -->
                    <div class="col-4">
                        <div class="caja_azul">
                            <div class="titulo_dashboard d-flex justify-content-between align-items-center" style="height: 100%;">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-headset"></i>&nbsp;Soporte
                                </div>

                                <!-- Barra de progreso con porcentaje para Soporte -->
                                <div class="progress flex-grow-1 mx-2" style="height: 15px;">
                                    <div id="progressTipo2" class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <span style="font-size: 10px; color: white;">0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" id="tipo2">
                                <!-- Requerimientos de tipo 2 irán aquí -->
                            </div>
                        </div>
                    </div>

                    <!-- Columna Diseño -->
                    <div class="col-4">
                        <div class="caja_azul">
                            <div class="titulo_dashboard d-flex justify-content-between align-items-center" style="height: 100%;">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-object-group"></i>&nbsp;Diseño
                                </div>

                                <!-- Barra de progreso con porcentaje -->
                                <div class="progress flex-grow-1 mx-2" style="height: 15px;">
                                    <div id="progressTipo3" class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <span style="font-size: 10px; color: white;">0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" id="tipo3">
                                <!-- Requerimientos de tipo 3 irán aquí -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php foreach ($this->requerimientosAll as $req) { ?>
<div class="modal fade text-start" id="modal_edit_reque_<?= $req->requerimientos_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="iframe_requerimiento_<?= $req->requerimientos_id ?>" width="100%" height="380" frameborder="0" src="about:blank"></iframe>
            </div>                        
        </div>
    </div>
</div>
<?php } ?>





<script>

    function cerrarModal(id) {
        $("#"+id).modal('hide');
    }

    cambiar_datos()
    function cambiar_datos(element) {
        var cliente = $(element).val();
        // Encuentra el select de proyectos dentro de la misma fila
        var proyectosSelect = $(element).closest('.card').find('#proyectos');

        $.post("/page/tablero/buscarProyectos", {
            "cliente": cliente
        }, function(res) {
            arrayProyectos(res, proyectosSelect);
        });
    }

    function arrayProyectos(res, proyectosSelect) {
        proyectosSelect.empty().append('<option value="">Seleccione...</option>');

        for (let index = 0; index < res.length; index++) {
            if (typeof res !== 'undefined' && res[index]['texto'] !== '') {
                const option = $("<option>", {
                    value: res[index]['valor'],
                    text: res[index]['texto']
                });
                proyectosSelect.append(option);
            }
        }
    }

    $(document).ready(function() {
        // Agregar nueva columna con campo de archivo
        $('#add-card-req').on('click', function() {
            var newCol = `
            <div class="card mt-3 mb-3">
                <div class="card-header">
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-danger btn-sm btn-delete-req"><i class="fas fa-minus"></i> Quitar Sección</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 mb-3">
                            <label for="client_id"  class="form-label">Cliente</label>
                            <div class="input-group">
                                <span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
                                <select class="form-select" name="client_id[]" id="client_id" onchange='cambiar_datos(this);'>
                                    <option value="" selected>Seleccione</option>
                                    <?php foreach ($this->clientes as $key => $valor) { ?>
                                        <option value="<?= $key ?>"><?= $valor ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="requerimientos_proyecto"  class="form-label">Proyectos</label>
                            <div class="input-group">
                                <span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
                                <select class="form-select" name="requerimientos_proyecto[]" id="proyectos">
                                    <option value="" selected>Seleccione</option>
                                    <?php foreach ($this->proyectos as $key => $valor) { ?>
                                        <option value="<?= $key ?>"><?= $valor ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="requerimientos_tipo"  class="form-label title-label">Tipo de Requerimiento</label>
                            <div class="input-group">
                                <span class="input-group-text input-icono" ><i class="far fa-list-alt"></i></span>
                                <select class="form-select" name="requerimientos_tipo[]">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($this->list_tipo AS $key => $value ){?>
                                        <option value="<?php echo $key; ?>"> <?= $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="requerimientos_fecha"  class="form-label title-label">Fecha del Requerimiento</label>
                            <div class="input-group">
                                <span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
                                <input name="requerimientos_fecha[]" type="text" value="<?= date("d-m-Y H:i:s") ?>" class="form-control" readonly>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="requerimientos_fecha_t"  class="form-label title-label">Fecha Vencimiento</label>
                            <div class="input-group">
                                <span class="input-group-text input-icono" ><i class="fas fa-pencil-alt"></i></span>
                                <input type="datetime-local" name="requerimientos_fecha_t[]" id="requerimientos_fecha_t" class="form-control">
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-3 mb-3">
                            <label for="requerimientos_ing"  class="form-label title-label">Ing Encargado del Requerimiento</label>
                            <div class="input-group">
                                <span class="input-group-text input-icono" ><i class="far fa-list-alt"></i></span>
                                <select class="form-select" name="requerimientos_ing[]">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($this->lista_ingenieros AS $key => $value ){?>
                                        <option value="<?php echo $key; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="requerimientos_desc"  class="form-label title-label">Descripción del requerimiento</label>
                            <textarea name="requerimientos_desc[]" id="requerimientos_desc" class="form-control tinyeditor" rows="1" oninput="this.value = this.value.toUpperCase();"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            `;
            $('#more-req').append(newCol);
        });

        // Función para eliminar una columna
        $('#more-req').on('click', '.btn-delete-req', function() {
            $(this).closest('.card').remove();
        });
    });

    function submitColaborador() {
        var ing = $("#colaborador").val();
        if (ing) {
            window.location.href = window.location.pathname + '?ing=' + ing;
        }
    }

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

    document.addEventListener("DOMContentLoaded", function () {
        let collapses = document.querySelectorAll(".collapse");

        collapses.forEach(collapse => {
            let icon = collapse.previousElementSibling.querySelector(".icono-collapse");

            collapse.addEventListener("show.bs.collapse", function () {
                icon.classList.add("rotado");
            });

            collapse.addEventListener("hide.bs.collapse", function () {
                icon.classList.remove("rotado");
            });
        });

        // Activar el primer collapse al cargar la página
        if (collapses.length > 0) {
            let firstCollapse = new bootstrap.Collapse(collapses[0], { toggle: true });
        }
    });



</script>