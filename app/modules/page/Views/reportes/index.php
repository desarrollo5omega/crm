<?php

function abreviarN($num) {

    if ($num >= 1000000) {
        return round($num / 1000000, 1) . "M";
    } elseif ($num >= 1000) {
        return round($num / 1000, 1) . "K";
    } else {
        return $num;
    }

}

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid">
    <div class="row mb-5">

        <div class="col-lg-3">
            <div class="row">
                <div class="col-lg-12">	

                    <div class="mt-4 content-dashboard no-padding">
                                            
                        <div class="caja_azul">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <b class="titulo_dashboard"><i class="fa-regular fa-star"></i> Rating - Clientes que mas cotizan</b>
                            </div>
                        </div>

                        <form class="mt-2" method="post" action="/page/reportes/">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <input type="date" name="fecha_a" id="fecha_a" class="form-control mb-2"  value="<?= $this->fecha_a ?>">
                                </div>
                                <div class="col-lg-5">
                                    <input type="date" name="fecha_b" id="fecha_b" class="form-control mb-2"  value="<?= $this->fecha_b ?>">
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-primary mb-2">
                                        <i class="fa-solid fa-magnifying-glass-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <div class="content-table tabla-fija-scroll-with-foot">
                            <table width="100%" border="0" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Cotizaciones</th>
                                        <th width="150">Valor</th>
                                    </tr>	
                                </thead>
                                <tbody>					
                                    <?php foreach($this->mascotizan as $key => $valor){?>
                                        <?php $id =  $content->id; ?>
                                        <tr class="div_mascotizan" id="div_mascotizan<?php echo $key; ?>" <?php if($key>9){ echo 'style="display:none";'; } ?>>
                                            <td><?= $valor->cliente_nombre ?></td>
                                            <td><?= $valor->total_cotizaciones ?></td>
                                            <td>$ <?= number_format($valor->total_valor, 0 . ".") ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-foot py-2 div-thead">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="ms-3">
                                    <button type="button" class="btn btn-viewmore btn-sm" onclick="mas_cotizan()">VER MÁS</button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" value="9" id="cantidad_mascotizan">

                    </div>

                </div>

                <div class="col-lg-12">	

                    <div class="mt-4 content-dashboard no-padding">
                                            
                        <div class="caja_azul">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <b class="titulo_dashboard"><i class="fa-regular fa-star"></i> Rating - Clientes que mas compran</b>
                            </div>
                        </div>

                        <form class="mt-2" method="post" action="/page/reportes">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <input type="date" name="fecha_c" id="fecha_c" class="form-control mb-2" value="<?= $this->fecha_c ?>">
                                </div>
                                <div class="col-lg-5">
                                    <input type="date" name="fecha_d" id="fecha_d" class="form-control mb-2" value="<?= $this->fecha_d ?>">
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-primary mb-2"  >
                                        <i class="fa-solid fa-magnifying-glass-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <div class="content-table tabla-fija-scroll-with-foot">
                            <table width="100%" border="0" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Proyectos</th>
                                        <th width="150">Valor</th>
                                    </tr>	
                                </thead>
                                <tbody>					
                                    <?php foreach($this->mascompran as $key => $valor){?>
                                        <?php $id =  $content->id; ?>
                                        <tr class="div_mascompran" id="div_mascompran<?php echo $key; ?>" <?php if($key>9){ echo 'style="display:none";'; } ?>>
                                            <td><?= $valor->cliente_nombre ?></td>
                                            <td><?= $valor->total_cotizaciones ?></td>
                                            <td>$ <?= number_format($valor->total_valor, 0 . ".") ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-foot py-2 div-thead">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="ms-3">
                                    <button type="button" class="btn btn-viewmore btn-sm" onclick="mas_compran()">VER MÁS</button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" value="9" id="cantidad_mascompran">

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="mt-4 content-dashboard no-padding">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-12 col-12 mb-3 grid-margin stretch-card">
                        <div class="card border-0 border-radius-2 bg-success">
                            <div class="card-body">
                                <div class="d-flex flex-md-column flex-xl-row flex-wrap  align-items-center justify-content-between">
                                    <div class="icon-rounded-inverse-success icon-rounded-lg">
                                        <i class="fa-solid fa-business-time"></i>
                                    </div>
                                    <div class="text-white">
                                        <span class="fw-medium mt-md-2 mt-xl-0 text-md-center text-xl-left">Total clientes</span>
                                        <div class="d-flex flex-md-column flex-xl-row flex-wrap align-items-baseline align-items-md-center align-items-xl-baseline" style="font-size:13px">
                                            <h4 class="mb-0 mb-md-1 mb-lg-0 me-1">
                                                <?php if ($this->num_clientes["Total"]) { echo $this->num_clientes["Total"]; } else { echo "0"; } ?></h4>
                                            <small class="mb-0">Total</small>
                                        </div>
                                        <div class="d-flex flex-md-column flex-xl-row flex-wrap align-items-baseline align-items-md-center align-items-xl-baseline" style="font-size:13px">
                                            <span class="mb-0 mb-md-1 mb-lg-0 me-1"><?= $this->num_clientes[date("Y")] ?></span>
                                            <small class="mb-0">Este año</small>
                                        </div>
                                        <div class="d-flex flex-md-column flex-xl-row flex-wrap align-items-baseline align-items-md-center align-items-xl-baseline" style="font-size:13px">
                                            <span class="mb-0 mb-md-1 mb-lg-0 me-1">
                                                <?php if ($this->num_clientes[date("Y-m")]) { echo $this->num_clientes[date("Y-m")]; } else { echo "0"; } ?></span>
                                            <small class="mb-0">Este mes</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 col-12 mb-3 grid-margin stretch-card">
                        <div class="card border-0 border-radius-2 bg-info">
                            <div class="card-body">
                                <div class="d-flex flex-md-column flex-xl-row flex-wrap  align-items-center justify-content-between">
                                    <div class="icon-rounded-inverse-info icon-rounded-lg">
                                        <i class="fa-solid fa-barcode icon-dash"></i>
                                    </div>
                                    <div class="text-white">
                                        <span class="fw-medium mt-md-2 mt-xl-0 text-md-center text-xl-left">Total Cotizaciones</span>
                                        <div class="d-flex flex-md-column flex-xl-row flex-wrap align-items-baseline align-items-md-center align-items-xl-baseline">
                                            <h4 class="mb-0 mb-md-1 mb-lg-0 me-1"><?= $this->cotizaciones_num[date("Y")] ?></h4>
                                            <small class="mb-0">Este año</small>
                                        </div>
                                        <div class="d-flex flex-md-column flex-xl-row flex-wrap align-items-baseline align-items-md-center align-items-xl-baseline" style="font-size:13px">
                                            <span class="mb-0 mb-md-1 mb-lg-0 me-1">
                                                <?php if ($this->total_coti_aprobados_num[date("Y-m")]) { echo $this->total_coti_aprobados_num[date("Y-m")]; } else { echo "0"; } ?>
                                            </span>
                                            <small class="mb-0">Este mes</small>
                                        </div>
                                        <div class="d-flex flex-md-column flex-xl-row flex-wrap align-items-baseline align-items-md-center align-items-xl-baseline" style="font-size:13px">
                                            <span class="mb-0 mb-md-1 mb-lg-0 me-1">
                                                <?php if ($this->totales_coti_valor[date("2025-02")]) { echo "$ " . abreviarN($this->totales_coti_valor[date("2025-02")]); } else { echo "0"; } ?></span>
                                            <small class="mb-0"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 col-12 mb-3 grid-margin stretch-card">
                        <div class="card border-0 border-radius-2 bg-danger">
                            <div class="card-body">
                                <div class="d-flex flex-md-column flex-xl-row flex-wrap  align-items-center justify-content-between">
                                    <div class="icon-rounded-inverse-danger icon-rounded-lg">
                                        <i class="fa-solid fa-diagram-project icon-dash"></i>
                                    </div>
                                    <div class="text-white">
                                        <span class="fw-medium mt-md-2 mt-xl-0 text-md-center text-xl-left">Total proyectos</span>
                                        <div class="d-flex flex-md-column flex-xl-row flex-wrap align-items-baseline align-items-md-center align-items-xl-baseline">
                                            <h4 class="mb-0 mb-md-1 mb-lg-0 me-1"><?= $this->desarrollo_num[date("Y")] ?></h4>
                                            <small class="mb-0">Este año</small>
                                        </div>
                                        <div class="d-flex flex-md-column flex-xl-row flex-wrap align-items-baseline align-items-md-center align-items-xl-baseline" style="font-size:13px">
                                            <span class="mb-0 mb-md-1 mb-lg-0 me-1">
                                            <?php if ($this->total_des_aprobados[date("Y-m")]) { echo $this->total_des_aprobados[date("Y-m")]; } else { echo "0"; } ?></span>
                                            <small class="mb-0">Este mes</small>
                                        </div>
                                        <div class="d-flex flex-md-column flex-xl-row flex-wrap align-items-baseline align-items-md-center align-items-xl-baseline" style="font-size:13px">
                                            <span class="mb-0 mb-md-1 mb-lg-0 me-1">
                                                <?php if ($this->total_des_aprobados_valor[date("2025-02")]) { echo "$ " . abreviarN($this->total_des_aprobados_valor[date("2025-02")]); } else { echo "0"; } ?></span>
                                            <small class="mb-0"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 col-12 grid-margin stretch-card">
                        <div class="card border-0 border-radius-2 bg-warning">
                            <div class="card-body">
                                <div class="d-flex flex-md-column flex-xl-row flex-wrap  align-items-center justify-content-between">
                                    <div class="icon-rounded-inverse-warning icon-rounded-lg">
                                        <i class="fa-solid fa-users-viewfinder"></i>
                                    </div>
                                    <div class="text-white">
                                        <p class="fw-medium mt-md-2 mt-xl-0 text-md-center text-xl-left">Total usuarios</p>
                                        <div class="d-flex flex-md-column flex-xl-row flex-wrap align-items-baseline align-items-md-center align-items-xl-baseline">
                                            <h3 class="mb-0 mb-md-1 mb-lg-0 me-1"><?= $this->num_user ?></h3>
                                            <small class="mb-0">Activos</small>
                                        </div>
                                        <div class="d-flex flex-md-column flex-xl-row flex-wrap align-items-baseline align-items-md-center align-items-xl-baseline" style="font-size:13px">
                                            <span class="mb-0 mb-md-1 mb-lg-0 me-1">&nbsp;</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-4">
                        <div class="caja_azul">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <b class="titulo_dashboard"><i class="fa-regular fa-star"></i> Informe anual cantidad de cotizaciones en pesos </b>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" style="height: 322px !important;">
                                <canvas id="chartValores" ></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-4">
                        <div class="caja_azul">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <b class="titulo_dashboard"><i class="fa-regular fa-star"></i> Informe anual cantidad total de cotizaciones</b>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" style="height: 322px !important;">
                                <canvas id="chartCotizaciones" ></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-4">
                        <div class="caja_azul">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <b class="titulo_dashboard"><i class="fa-regular fa-star"></i> Informe anual cantidad de proyectos aprobados en pesos</b>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" style="height: 322px !important;">
                                <canvas id="chartCotizaciones3" ></canvas>
                            </div>
                        </div>
                    </div> 

                    <div class="col-lg-6 mt-4">
                        <div class="caja_azul">
                            <div class="d-flex justify-content-between align-items-center h-100">
                                <b class="titulo_dashboard"><i class="fa-regular fa-star"></i> Informe anual cantidad de proyectos aprobados</b>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" style="height: 322px !important;">
                                <canvas id="chartCotizaciones2" ></canvas>
                            </div>
                        </div>
                    </div>              

                

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script type="text/javascript">
                        var ctxValores = document.getElementById('chartValores').getContext('2d');

                        var colors = ['rgba(255,99,132,1)', 'rgba(54,162,235,1)', 'rgba(255,206,86,1)', 'rgba(75,192,192,1)'];

                        var datosPorAno = {};
                        <?php 
                        foreach ($this->totales_coti as $key => $valor) { 
                            list($ano, $mes) = explode("-", $key); 
                        ?>
                            if (!datosPorAno.hasOwnProperty('<?php echo $ano; ?>')) {
                                datosPorAno['<?php echo $ano; ?>'] = Array(12).fill(null); // Inicializa con 12 meses
                            }
                            datosPorAno['<?php echo $ano; ?>'][<?php echo (int)$mes - 1; ?>] = <?php echo $valor; ?>;
                        <?php } ?>

                        var datasets = [];
                        var indexColor = 0;
                        for (var ano in datosPorAno) {
                            datasets.push({
                                label: ano,
                                data: datosPorAno[ano],
                                borderColor: colors[indexColor % colors.length],
                                backgroundColor: 'rgba(0,0,0,0)',
                                tension: 0.3,
                                fill: false
                            });
                            indexColor++;
                        }

                        var chartValores = new Chart(ctxValores, {
                            type: 'line',
                            data: {
                                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: { display: true, text: 'Valor en Pesos' },
                                        ticks: {
                                            callback: function(value) {
                                                return '$' + value.toLocaleString('es-CO');
                                            }
                                        }
                                    }
                                },
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                return 'Valor: $' + tooltipItem.raw.toLocaleString('es-CO');
                                            }
                                        }
                                    }
                                }
                            }
                        });


                        var ctxCotizaciones = document.getElementById('chartCotizaciones').getContext('2d');

                        var colors = ['rgba(255,99,132,1)', 'rgba(54,162,235,1)', 'rgba(255,206,86,1)', 'rgba(75,192,192,1)'];

                        var datosPorAño = {};
                        <?php 
                        foreach ($this->total_coti_aprobados as $key => $cantidad) { 
                            list($año, $mes) = explode("-", $key); 
                        ?>
                            if (!datosPorAño.hasOwnProperty('<?php echo $año; ?>')) {
                                datosPorAño['<?php echo $año; ?>'] = Array(12).fill(0); // Inicializa con 12 meses en 0
                            }
                            datosPorAño['<?php echo $año; ?>'][<?php echo (int)$mes - 1; ?>] = <?php echo $cantidad; ?>;
                        <?php } ?>

                        var datasets = [];
                        var indexColor = 0;
                        for (var año in datosPorAño) {
                            datasets.push({
                                label: año,
                                data: datosPorAño[año],
                                borderColor: colors[indexColor % colors.length],
                                backgroundColor: 'rgba(0,0,0,0)',
                                tension: 0.3,
                                fill: false
                            });
                            indexColor++;
                        }

                        var chartCotizaciones = new Chart(ctxCotizaciones, {
                            type: 'line',
                            data: {
                                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: { display: true, text: 'Cantidad de Cotizaciones' },
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                },
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                return 'Cotizaciones: ' + tooltipItem.raw;
                                            }
                                        }
                                    }
                                }
                            }
                        });


                        var ctxCotizaciones2 = document.getElementById('chartCotizaciones2').getContext('2d');

                        var colors = ['rgba(255,99,132,1)', 'rgba(54,162,235,1)', 'rgba(255,206,86,1)', 'rgba(75,192,192,1)'];

                        var datosPorAño = {};
                        <?php 
                        foreach ($this->total_des_aprobados as $key => $cantidad) { 
                            list($año, $mes) = explode("-", $key); 
                        ?>
                            if (!datosPorAño.hasOwnProperty('<?php echo $año; ?>')) {
                                datosPorAño['<?php echo $año; ?>'] = Array(12).fill(0); // Inicializa con 12 meses en 0
                            }
                            datosPorAño['<?php echo $año; ?>'][<?php echo (int)$mes - 1; ?>] = <?php echo $cantidad; ?>;
                        <?php } ?>

                        var datasets = [];
                        var indexColor = 0;
                        for (var año in datosPorAño) {
                            datasets.push({
                                label: año,
                                data: datosPorAño[año],
                                borderColor: colors[indexColor % colors.length],
                                backgroundColor: 'rgba(0,0,0,0)',
                                tension: 0.3,
                                fill: false
                            });
                            indexColor++;
                        }

                        var chartCotizaciones2 = new Chart(ctxCotizaciones2, {
                            type: 'line',
                            data: {
                                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: { display: true, text: 'Cantidad de Poryectos' },
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                },
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                return 'Proyectos: ' + tooltipItem.raw;
                                            }
                                        }
                                    }
                                }
                            }
                        });


                        var ctxCotizaciones3 = document.getElementById('chartCotizaciones3').getContext('2d');

                        var colors = ['rgba(255,99,132,1)', 'rgba(54,162,235,1)', 'rgba(255,206,86,1)', 'rgba(75,192,192,1)'];

                        var datosPorAño = {};
                        <?php 
                        foreach ($this->total_des_aprobados_valor as $key => $valorPesos) { 
                            list($año, $mes) = explode("-", $key); 
                        ?>
                            if (!datosPorAño.hasOwnProperty('<?php echo $año; ?>')) {
                                datosPorAño['<?php echo $año; ?>'] = Array(12).fill(null); // Usa null para evitar líneas entre puntos faltantes
                            }
                            datosPorAño['<?php echo $año; ?>'][<?php echo (int)$mes - 1; ?>] = <?php echo $valorPesos; ?>;
                        <?php } ?>

                        var datasets = [];
                        var indexColor = 0;
                        for (var año in datosPorAño) {
                            datasets.push({
                                label: año,
                                data: datosPorAño[año],
                                borderColor: colors[indexColor % colors.length],
                                backgroundColor: 'rgba(0,0,0,0)',
                                tension: 0.3,
                                fill: false
                            });
                            indexColor++;
                        }

                        var chartCotizaciones3 = new Chart(ctxCotizaciones3, {
                            type: 'line',
                            data: {
                                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: { display: true, text: 'Valor en Pesos' },
                                        ticks: {
                                            callback: function(value) {
                                                return '$' + value.toLocaleString('es-CO');
                                            }
                                        }
                                    }
                                },
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                return 'Valor: $' + tooltipItem.raw.toLocaleString('es-CO');
                                            }
                                        }
                                    }
                                }
                            }
                        });




                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function mascotizan() {

        var fecha_a = $("#fecha_a").val();
        var fecha_b = $("#fecha_b").val();

        $.post("/page/reportes/mascotizan", {
            "fecha_a": fecha_a,
            "fecha_b": fecha_b,
        }, function(res) {
            console.log(res);
        });
    }

    function mascompran() {

        var fecha_a = $("#fecha_a").val();
        var fecha_b = $("#fecha_b").val();

        $.post("/page/reportes/mascompran", {
            "fecha_a": fecha_a,
            "fecha_b": fecha_b,
        }, function(res) {
            console.log(res);
        });
    }



    /* Ver mas */
    function mas_cotizan(){
		var cantidad = $("#cantidad_mascotizan").val();
		cantidad = Number(cantidad);
		var i = 0;
		var nueva = cantidad+9;
		for(i=cantidad;i<=nueva; i++){
			$("#div_mascotizan"+i).show();
		}
		$("#cantidad_mascotizan").val(nueva);
	}

    function mas_compran(){
		var cantidad = $("#cantidad_mascompran").val();
		cantidad = Number(cantidad);
		var i = 0;
		var nueva = cantidad+9;
		for(i=cantidad;i<=nueva; i++){
			$("#div_mascompran"+i).show();
		}
		$("#cantidad_mascompran").val(nueva);
	}
</script>