<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    #myPieChart {
        height: 425px !important;
        width: 425px !important;
        margin: auto
    }
</style>

<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-6 mt-4">				
            <div class="caja_azul">
                <b class="titulo_dashboard">Cotizaciones realizadas en el mes</b>
            </div>
            <div class="col-lg-12 no-padding d-none">
                <table width="100%" border="1">
                    <tr>
                        <td><b>Mes</b></td>
                        <td align="center"><b>Cantidad</b></td>
                        <td align="center"><b>Valor</b></td>
                    </tr>
                    <?php 
                    $i = 0; // Inicializa el índice $i
                    foreach($this->meses as $key => $mes){ 
                        $i++;
                        $calificaciones[$i] = $mes;
                        $valores[$i] = (int)$this->total_coti_aprobados[$key]; // Cantidad de cotizaciones
                        $totales[$i] = number_format($this->totales_coti[$key]); // Valores en pesos
                    ?>
                    <tr>
                        <td><?php echo $mes; ?></td>
                        <td align="center"><?php echo (int)$this->total_coti_aprobados[$key]; ?></td>
                        <td align="center"><?php echo (int)$this->totales_coti[$key]; ?></td>
                    </tr>										
                    <?php } ?>
                </table>
            </div>

            <div class="row">
                <!-- Gráfica de cantidad de cotizaciones -->
                <div class="col-lg-6">
                    <canvas id="chartCotizaciones" style="height: 400px; max-width: 100%;"></canvas>
                </div>

                <!-- Gráfica de valor total en pesos -->
                <div class="col-lg-6">
                    <canvas id="chartValores" style="height: 400px; max-width: 100%;"></canvas>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script type="text/javascript">
                var ctxCotizaciones = document.getElementById('chartCotizaciones').getContext('2d');
                var ctxValores = document.getElementById('chartValores').getContext('2d');

                // Define los colores para cada barra
                var colors = ['rgba(255, 99, 132, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 205, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(201, 203, 207, 0.2)'];

                // Gráfica de cantidad de cotizaciones
                var dataCotizaciones = {
                    labels: [<?php for($x = 1; $x <= $i; $x++) { echo "'" . $calificaciones[$x] . "', "; } ?>],
                    datasets: [{
                        label: 'Cantidad de Cotizaciones',
                        data: [<?php for($x = 1; $x <= $i; $x++) { echo $valores[$x] . ', '; } ?>],
                        backgroundColor: colors.slice(0, <?php echo $i; ?>), // Asigna los colores a las barras
                        borderColor: '#000',
                        borderWidth: 1
                    }]
                };

                // Gráfica de valor total en pesos
                var dataValores = {
                    labels: [<?php for($x = 1; $x <= $i; $x++) { echo "'" . $calificaciones[$x] . "', "; } ?>],
                    datasets: [{
                        label: 'Valor Total en Pesos',
                        data: [<?php for($x = 1; $x <= $i; $x++) { echo str_replace(",", "", $totales[$x]) . ', '; } ?>],
                        backgroundColor: colors.slice(0, <?php echo $i; ?>),
                        borderColor: '#000',
                        borderWidth: 1
                    }]
                };

                // Opciones para las gráficas
                var options = {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Cantidad'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Mes'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                title: function(tooltipItems) {
                                    return 'Mes: ' + tooltipItems[0].label;
                                }
                            }
                        }
                    }
                };

                // Crear la gráfica de cantidad de cotizaciones
                var chartCotizaciones = new Chart(ctxCotizaciones, {
                    type: 'bar',
                    data: dataCotizaciones,
                    options: {
                        ...options,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    ...options.plugins.tooltip.callbacks,
                                    label: function(tooltipItem) {
                                        return 'Cotizaciones: ' + tooltipItem.raw;
                                    }
                                }
                            }
                        }
                    }
                });

                // Crear la gráfica de valor total en pesos
                var chartValores = new Chart(ctxValores, {
                    type: 'bar',
                    data: dataValores,
                    options: {
                        ...options,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Valor en Pesos'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    ...options.plugins.tooltip.callbacks,
                                    label: function(tooltipItem) {
                                        return 'Valor Total: $' + tooltipItem.raw;
                                    }
                                }
                            }
                        }
                    }
                });
            </script>



        </div>
        <div class="col-6 mt-4">				
            <div class="caja_azul">
                <b class="titulo_dashboard">Proyectos en Desarrollo</b>
            </div>
            <div class="col-lg-12 no-padding d-none">
                <table width="100%" border="1">
                    <tr>
                        <td><b>Mes</b></td>
                        <td align="center"><b>Cantidad</b></td>
                        <td align="center"><b>Valor</b></td>
                    </tr>
                    <?php 
                    $i = 0; // Inicializa el índice $i
                    foreach($this->meses as $key => $mes){ 
                        $i++;
                        $calificaciones[$i] = $mes;
                        $valores[$i] = (int)$this->total_desarrollo[$key];
                        $totales[$i] = (int)$this->totales[$key];
                    ?>
                    <tr>
                        <td><?php echo $mes; ?></td>
                        <td align="center"><?php echo (int)$this->total_desarrollo[$key]; ?></td>
                        <td align="center"><?php echo number_format($this->totales[$key]); ?></td>
                    </tr>										
                    <?php } ?>
                </table>
            </div>
            
            <div class="row">
                <div class="col-6">
                    <canvas id="myChart_aprobados" style="height: 400px; max-width: 100%;"></canvas>
                </div>
                <div class="col-6">
                    <canvas id="myChart_totales" style="height: 400px; max-width: 100%;"></canvas>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script type="text/javascript">
                // Gráfica de Aprobados
                var ctx_aprobados = document.getElementById('myChart_aprobados').getContext('2d');

                var colors = ['rgba(255, 99, 132, 0.2)','rgba(255, 159, 64, 0.2)','rgba(255, 205, 86, 0.2)','rgba(75, 192, 192, 0.2)','rgba(54, 162, 235, 0.2)','rgba(153, 102, 255, 0.2)','rgba(201, 203, 207, 0.2)'];

                var data_aprobados = {
                    labels: [<?php for($x = 1; $x <= $i; $x++) { echo "'" . $calificaciones[$x] . "', "; } ?>],
                    datasets: [{
                        label: 'Aprobados',
                        data: [<?php for($x = 1; $x <= $i; $x++) { echo $valores[$x] . ', '; } ?>],
                        backgroundColor: colors.slice(0, <?php echo $i; ?>),
                        borderColor: '#000',
                        borderWidth: 1
                    }]
                };

                var options_aprobados = {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Cantidad de Aprobados'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Mes'
                            }
                        }
                    }
                };

                var myChartAprobados = new Chart(ctx_aprobados, {
                    type: 'bar',
                    data: data_aprobados,
                    options: options_aprobados
                });

                // Gráfica de Totales en Valor (Pesos)
                var ctx_totales = document.getElementById('myChart_totales').getContext('2d');

                var data_totales = {
                    labels: [<?php for($x = 1; $x <= $i; $x++) { echo "'" . $calificaciones[$x] . "', "; } ?>],
                    datasets: [{
                        label: 'Totales (Pesos)',
                        data: [<?php for($x = 1; $x <= $i; $x++) { echo $totales[$x] . ', '; } ?>],
                        backgroundColor: colors.slice(0, <?php echo $i; ?>),
                        borderColor: '#000',
                        borderWidth: 1
                    }]
                };

                var options_totales = {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Valor en Pesos'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Mes'
                            }
                        }
                    }
                };

                var myChartTotales = new Chart(ctx_totales, {
                    type: 'bar',
                    data: data_totales,
                    options: options_totales
                });
            </script>



        </div>


        <div class="col-6 mt-4 mb-5">				
            <div class="caja_azul">
                <b class="titulo_dashboard">Total proyectos</b>
            </div>
            <div class="col-lg-12 no-padding">
                <table width="100%" border="1" class="d-none">
                    <tr>
                        <td><b>Estado</b></td>
                        <td align="center"><b>Cantidad</b></td>
                        <td align="center"><b>Valor Total</b></td>
                    </tr>
                    <?php 
                    $valorTotalProyectos = 0; // Valor total de proyectos
                    $etiquetas = [];
                    $cantidades = [];
                    $valoresTotales = []; // Array para los valores totales

                    foreach ($this->estado as $key => $count) { 
                        $valorTotal = number_format($this->estadoSuma[$key], 2); // Formatear el valor con dos decimales
                        $valorTotalProyectos += $this->estadoSuma[$key]; // Sumar el valor total

                        // Agregar etiquetas, cantidades y valores totales para la gráfica
                        $etiquetas[] = $this->listaestado[$key];
                        $cantidades[] = $count;
                        $valoresTotales[] = $valorTotal; // Agregar el valor total
                    ?>
                    <tr>
                        <td><?php echo $this->listaestado[$key]; ?></td>
                        <td align="center"><?php echo $count; ?></td>
                        <td align="center"><?php echo $valorTotal; ?></td>
                    </tr>										
                    <?php } ?>
                    <!-- Fila de total -->
                    <tr>
                        <td><b>Total</b></td>
                        <td align="center"><b><?php echo $this->totalProyectos; ?></b></td>
                        <td align="center"><b><?php echo number_format($valorTotalProyectos, 2); ?></b></td>
                    </tr>
                </table>
            </div>

            <canvas id="myPieChart" width="400" height="400"></canvas>
            <script>
                const ctx_2 = document.getElementById('myPieChart').getContext('2d');

                // Asegúrate de que los datos estén disponibles y sean válidos
                const etiquetas = <?php echo json_encode($etiquetas); ?>;
                const cantidades = <?php echo json_encode($cantidades); ?>;
                const valoresTotales = <?php echo json_encode($valoresTotales); ?>; // Valores totales

                const myPieChart = new Chart(ctx_2, {
                    type: 'pie', // Tipo de gráfico
                    data: {
                        labels: etiquetas, // Etiquetas del gráfico
                        datasets: [{
                            label: 'Cantidad por Estado',
                            data: cantidades, // Datos del gráfico
                            backgroundColor: [
                                'rgba(255, 206, 86, 0.2)', // amarillo
                                'rgba(75, 192, 192, 0.2)', // verde
                                'rgba(255, 99, 132, 0.2)', // rosa
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)', // lila
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',                                
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Distribución de Cantidad por Estado'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        const cantidad = tooltipItem.raw; // Obtiene la cantidad del tooltip
                                        const valorTotal = valoresTotales[tooltipItem.dataIndex]; // Obtiene el valor total correspondiente
                                        return `Cantidad: ${cantidad}\nValor Total: ${valorTotal}`;
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