<main class="main main-panel">
    <?php
    $meses = array_column($ventasPorMes, 'mes');
    $totales = array_column($ventasPorMes, 'total');

    $nombresProductos = array_column($productosMasVendidos, 'nom_prod');
    $totalesVendidos = array_map('intval', array_column($productosMasVendidos, 'total_vendidos'));

    $nombresCategorias = array_column($stockPorCategoria, 'categoria');
    $stocksTotales = array_column($stockPorCategoria, 'stock_total');
    ?>

    <div class="main-panel-col1">
        <div class="dashboard-cards">
            <div class="card">
                <span class="card-title">Total Clientes:</span>
                <span class="card-estadistica"><?= $totalClientes ?></span>
            </div>
            <div class="card">
                <span class="card-title">Total Productos:</span>
                <span class="card-estadistica"><?= $totalProductos ?></span>
            </div>
            <div class="card">
                <span class="card-title">Total Ventas:</span>
                <span class="card-estadistica"><?= $totalVentas ?></span>
            </div>
            <div class="card">
                <span class="card-title">Total Pedidos:</span>
                <span class="card-estadistica"><?= $totalPedidos ?></span>
            </div>
        </div>

        <div class="chart-content">
            <h2>Ventas de los últimos meses</h2>
            <canvas id="ventasChart" width="400" height="200"></canvas>
        </div>
    </div>

    <div class="main-panel-col2">
        <div class="chart-content">
            <h2>Top Productos Más Vendidos</h2>
            <canvas id="topProductosChart" height="300"></canvas>
        </div>

        <div class="chart-content">
            <h2>Stock por Categoría</h2>
            <canvas id="stockCategoriaChart" style="max-width: 400px; height: 0;"></canvas>
        </div>
    </div>
</main>

<script src=" https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ventasChart').getContext('2d');

    const ventasChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($meses) ?>,
            datasets: [{
                label: 'Total Ventas (S/)',
                data: <?= json_encode($totales, JSON_NUMERIC_CHECK) ?>,
                backgroundColor: 'rgb(127, 226, 233, 0.6)',
                borderRadius: 6
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctxTop = document.getElementById('topProductosChart').getContext('2d');

    new Chart(ctxTop, {
        type: 'bar',
        data: {
            labels: <?= json_encode($nombresProductos) ?>,
            datasets: [{
                label: 'Unidades Vendidas',
                data: <?= json_encode($totalesVendidos, JSON_NUMERIC_CHECK) ?>,
                backgroundColor: 'rgba(255, 120, 43, 0.6)',
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.raw} unidades`
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return Number.isInteger(value) ? value : null;
                        }
                    },
                    title: {
                        display: true,
                        text: 'Unidades Vendidas'
                    }
                }
            }
        }
    });

    const ctxStock = document.getElementById('stockCategoriaChart').getContext('2d');

    new Chart(ctxStock, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($nombresCategorias) ?>,
            datasets: [{
                label: 'Stock por Categoría',
                data: <?= json_encode($stocksTotales, JSON_NUMERIC_CHECK) ?>,
                backgroundColor: [
                    'rgba(245, 117, 32, 0.6)',
                    'rgba(45, 90, 204, 0.6)',
                    'rgba(45, 233, 233, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(153, 102, 255, 0.6)'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            return `${label}: ${value} unidades`;
                        }
                    }
                }
            }
        }
    });
</script>