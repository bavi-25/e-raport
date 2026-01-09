<!-- Info Boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-graduation-cap"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Student</span>
                <span class="info-box-number">{{ $stats['totalStudents'] }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1">
                <i class="fas fa-chalkboard-teacher"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Teacher</span>
                <span class="info-box-number">{{ $stats['totalTeachers'] }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-book-open"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Class Room</span>
                <span class="info-box-number">{{ $stats['totalClasses'] }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Student Attendance</span>
                <span class="info-box-number">1,180</span>
            </div>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="row mt-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Student Attendance (Example)</h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="attendanceStacked"
                        style="min-height:300px;height:300px;max-height:300px;width:100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Students by Grade (Example)</h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="studentsByGrade"
                        style="min-height:300px;height:300px;max-height:300px;width:100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
  var attLabels  = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
  var attPresent = [180, 175, 190, 185, 195, 180, 178];
  var attExcused = [10, 12, 8, 15, 9, 11, 10];
  var attAbsent  = [5, 8, 6, 5, 6, 4, 3];

  var gradeLabels = ['Grade X', 'Grade XI', 'Grade XII'];
  var gradeCounts = [420, 380, 400];

  // Attendance Chart
  var ctxAtt = document.getElementById('attendanceStacked').getContext('2d');
  new Chart(ctxAtt, {
    type: 'bar',
    data: {
      labels: attLabels,
      datasets: [
        { label: 'Present', backgroundColor: '#17a2b8', data: attPresent },
        { label: 'Excused', backgroundColor: '#ffc107', data: attExcused },
        { label: 'Absent', backgroundColor: '#dc3545', data: attAbsent }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        xAxes: [{ stacked: true, gridLines: { display: false } }],
        yAxes: [{ stacked: true, ticks: { beginAtZero: true, precision: 0 } }]
      },
      legend: { display: true }
    }
  });

  // Students by Grade Chart
  var ctxGrade = document.getElementById('studentsByGrade').getContext('2d');
  new Chart(ctxGrade, {
    type: 'horizontalBar',
    data: {
      labels: gradeLabels,
      datasets: [{
        label: 'Students',
        backgroundColor: '#28a745',
        data: gradeCounts
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        xAxes: [{ ticks: { beginAtZero: true, precision: 0 } }],
        yAxes: [{ gridLines: { display: false } }]
      },
      legend: { display: false }
    }
  });
</script>
@endpush