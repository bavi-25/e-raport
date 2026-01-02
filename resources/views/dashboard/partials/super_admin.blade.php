<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-school"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tenant</span>
                <span class="info-box-number">{{ $stats['tenantCount'] }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Users</span>
                <span class="info-box-number">{{ $stats['userCount'] }}</span>
            </div>
        </div>
    </div>

    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-graduation-cap"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Students</span>
                <span class="info-box-number">{{ $stats['studentsCount'] }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-globe"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Active Tenants</span>
                <span class="info-box-number">{{ $stats['activeTenants'] }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tenant Growth</h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="tenantGrowthChart"
                        style="min-height:300px;height:300px;max-height:300px;width:100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
    const tenantGrowth = @json($widgets['super_admin']['tenant_growth']);

    const labels = tenantGrowth.map(t => t.name);
    const dataCounts = tenantGrowth.map(t => t.users_count);

    const ctx = document.getElementById('tenantGrowthChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Users',
                data: dataCounts,
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(79, 70, 229, 0.15)',
                borderColor: '#4f46e5',
                pointBackgroundColor: '#22c55e',
                pointBorderColor: '#ffffff',
                pointRadius: 5,
                pointHoverRadius: 7,
                borderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: (ctx) => ` ${ctx.parsed.y} users`
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tenant Name'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Users'
                    },
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endpush