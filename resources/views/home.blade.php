@extends('layouts.admin')

@section('title', 'Inicio')

@section('content')

<div class="row">
    <!-- Tarjeta de bienvenida -->
    <div class="col-6 mb-4">
        <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title mb-1">Bienvenido, {{ Auth::user()->name }}!</h5>
                    <p class="mb-0">Estas viendo tu panel de administración.</p>
                </div>
                <div class="ms-3">
                    <img src="{{ asset('assets/img/illustrations/man-with-laptop.png') }}" alt="Bienvenida" style="height: auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta Play Store -->
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Descargas de Play Store</h6>
                <h3 class="fw-bold mb-3">158</h3>
                <canvas id="playStoreChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Tarjeta App Store -->
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Descargas de App Store</h6>
                <h3 class="fw-bold mb-3">103</h3>
                <canvas id="appStoreChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- NUEVA FILA CON DOS GRÁFICAS -->
<div class="row mb-4">
    <!-- Gráfica Doughnut -->
    <div class="col-md-6 mb-4">
        <div class="card p-3">
            <h5 class="mb-3">Visitas de tu público</h5>
            <canvas id="visitsDoughnut"  style="max-width: 270px; max-height: 270px; margin: 0 auto;"></canvas>
            <div class="mt-3">
                <ul class="list-unstyled">
                    <li><span class="badge bg-primary me-2">●</span> Facebook</li>
                    <li><span class="badge bg-success me-2">●</span> Página web</li>
                    <li><span class="badge bg-info me-2">●</span> Instagram</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Gráfica de Línea -->
    <div class="col-md-6 mb-4">
        <div class="card p-3">
            <h5 class="mb-3">Tendencia de visitas</h5>
            <div class="d-flex mb-3">
                <button class="btn btn-sm btn-outline-primary me-2" onclick="updateLineChart('mes')">Mes</button>
                <button class="btn btn-sm btn-outline-primary me-2" onclick="updateLineChart('semana')">Semana</button>
                <button class="btn btn-sm btn-outline-primary" onclick="updateLineChart('anio')">Año</button>
            </div>
            <canvas id="visitsLine"></canvas>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    /* ============================
       Gráficas de Play Store y App Store
    ============================= */
    const ctxPlay = document.getElementById('playStoreChart').getContext('2d');
    const playStoreChart = new Chart(ctxPlay, {
        type: 'line',
        data: {
            labels: ['Mayo','Junio','Julio','Agosto', 'Septiembre'],
            datasets: [{
                data: [23, 53, 51, 15,16],
                borderColor: 'rgba(0, 200, 83, 1)',
                backgroundColor: 'rgba(0, 200, 83, 0.1)',
                fill: true,
                tension: 0.3,
                pointRadius: 3,
                pointBackgroundColor: 'rgba(0, 200, 83, 1)'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { x: { display: false }, y: { display: false } }
        }
    });

    const ctxApp = document.getElementById('appStoreChart').getContext('2d');
    const appStoreChart = new Chart(ctxApp, {
        type: 'line',
        data: {
            labels: ['Junio','Julio','Agosto','Septiembre'],
            datasets: [{
                data: [18, 25, 49, 11],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                fill: true,
                tension: 0.3,
                pointRadius: 3,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { x: { display: false }, y: { display: false } }
        }
    });

    /* ============================
       NUEVAS GRÁFICAS
    ============================= */

    // Doughnut Chart (Visitas por plataforma)
    const doughnutCtx = document.getElementById('visitsDoughnut').getContext('2d');
    const visitsDoughnut = new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Facebook', 'Página Web', 'Instagram'],
            datasets: [{
                label: 'Visitas',
                data: [19, 187, 0],
                backgroundColor: ['#696cff', '#71dd37', '#03c3ec'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Line Chart (Tendencia de visitas)
    const lineCtx = document.getElementById('visitsLine').getContext('2d');

    const lineData = {
        mes: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            data: [5000, 7000, 6500, 12000, 8000, 9000, 7000]
        },
        semana: {
            labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
            data: [800, 950, 780, 1200, 1500, 1700, 1400]
        },
        anio: {
            labels: ['2021', '2022', '2023', '2024', '2025'],
            data: [50000, 65000, 75000, 90000, 105000]
        }
    };

    let visitsLine = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: lineData.mes.labels,
            datasets: [{
                label: 'Visitas',
                data: lineData.mes.data,
                borderColor: '#696cff',
                backgroundColor: 'rgba(105, 108, 255, 0.2)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#696cff'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Función para cambiar la vista (Mes/Semana/Año)
    window.updateLineChart = function(type) {
        visitsLine.data.labels = lineData[type].labels;
        visitsLine.data.datasets[0].data = lineData[type].data;
        visitsLine.update();
    };
</script>
@endsection
