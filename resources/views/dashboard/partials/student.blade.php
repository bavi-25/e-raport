<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>12</h3>

                <p>Enrollment</p>
            </div>
            <div class="icon">
                <i class="fas fa-book-open"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>85.5</h3>

                <p>Average Score</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>95<sup style="font-size: 20px">%</sup></h3>

                <p>Attendance Rate</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-orange">
            <div class="inner">
                <h3>5</h3>

                <p>Total Absences</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-times"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<div class="row mt-3">
    <!-- Score Trend -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Score Trend</h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="studentScoreChart"
                        style="min-height:300px;height:300px;max-height:300px;width:100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Overview -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Attendance Overview</h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="attendancePieChart"
                        style="min-height:300px;height:300px;max-height:300px;width:100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
<script>
    // ===== DUMMY DATA =====
  // Nilai rata-rata per mata pelajaran
  var subjects = ['Math', 'English', 'Science', 'History', 'Art', 'PE'];
  var scores = [80, 85, 90, 78, 88, 92];

  // Kehadiran
  var attendanceLabels = ['Present', 'Sick', 'Excused', 'Absent'];
  var attendanceData = [190, 5, 3, 2];
  var attendanceColors = ['#28a745', '#ffc107', '#17a2b8', '#dc3545'];

  // ===== SCORE TREND (Line Chart) =====
  var ctxScore = document.getElementById('studentScoreChart').getContext('2d');
  new Chart(ctxScore, {
    type: 'line',
    data: {
      labels: subjects,
      datasets: [{
        label: 'Average Score',
        data: scores,
        fill: false,
        borderColor: '#007bff',
        backgroundColor: '#007bff',
        tension: 0.3,
        pointRadius: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        yAxes: [{
          ticks: { beginAtZero: true, suggestedMax: 100 }
        }]
      },
      tooltips: {
        mode: 'index',
        intersect: false
      },
      legend: { display: false }
    }
  });

  // ===== ATTENDANCE OVERVIEW (Doughnut Chart) =====
  var ctxPie = document.getElementById('attendancePieChart').getContext('2d');
  new Chart(ctxPie, {
    type: 'doughnut',
    data: {
      labels: attendanceLabels,
      datasets: [{
        data: attendanceData,
        backgroundColor: attendanceColors
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        position: 'bottom'
      },
      cutoutPercentage: 70,
      tooltips: {
        callbacks: {
          label: function(tooltipItem, data) {
            var dataset = data.datasets[tooltipItem.datasetIndex];
            var total = dataset.data.reduce((a, b) => a + b, 0);
            var currentValue = dataset.data[tooltipItem.index];
            var percentage = ((currentValue / total) * 100).toFixed(1);
            return data.labels[tooltipItem.index] + ': ' + currentValue + ' (' + percentage + '%)';
          }
        }
      }
    }
  });
</script>
@endpush