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
                <h3 class="fw-bold mb-3">142</h3>
                <canvas id="playStoreChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Tarjeta App Store -->
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted">Descargas de App Store</h6>
                <h3 class="fw-bold mb-3">92</h3>
                <canvas id="appStoreChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Play Store
    const ctxPlay = document.getElementById('playStoreChart').getContext('2d');
    const playStoreChart = new Chart(ctxPlay, {
        type: 'line',
        data: {
            labels: ['Mayo','Junio','Julio','Agosto'],
            datasets: [{
                data: [23, 53, 51, 15],
                borderColor: 'rgba(0, 200, 83, 1)',       // verde
                backgroundColor: 'rgba(0, 200, 83, 0.1)', // relleno transparente
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

    // App Store
    const ctxApp = document.getElementById('appStoreChart').getContext('2d');
    const appStoreChart = new Chart(ctxApp, {
        type: 'line',
        data: {
            labels: ['Junio','Julio','Agosto',],
            datasets: [{
                data: [18, 25, 49],
                borderColor: 'rgba(54, 162, 235, 1)',       // azul
                backgroundColor: 'rgba(54, 162, 235, 0.1)', // relleno transparente
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
</script>
@endsection
