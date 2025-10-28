<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>E-Raport - Sistem Informasi Rapor Digital</title>

        <!-- Bootstrap 4 -->
        <link rel="stylesheet" href="/assets/css/adminlte.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
            rel="stylesheet">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="/assets/css/custom/home.css">


    </head>

    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="fas fa-graduation-cap"></i> E-Raport
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="fas fa-bars" style="color: #667eea;"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="#beranda">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#fitur">Fitur</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#keunggulan">Keunggulan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#kontak">Kontak</a>
                        </li>
                        <li class="nav-item ml-3">
                            <a href="/login" class="btn btn-login">
                                <i class="fas fa-sign-in-alt"></i> Masuk
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero-section" id="beranda">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content">
                            <h1>Sistem Rapor Digital Terpadu</h1>
                            <p>Kelola rapor siswa dengan mudah, cepat, dan efisien. Digitalisasi sistem penilaian untuk
                                pendidikan yang lebih modern.</p>
                            <button class="btn btn-hero">
                                <i class="fas fa-rocket"></i> Mulai Sekarang
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-image text-center">
                            <i class="fas fa-laptop-code" style="font-size: 20rem; color: rgba(255,255,255,0.2);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section" id="fitur">
            <div class="container">
                <div class="section-title fade-in">
                    <h2>Fitur Unggulan</h2>
                    <p>Solusi lengkap untuk manajemen rapor digital sekolah Anda</p>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-4 fade-in">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h4>Input Nilai Mudah</h4>
                            <p>Input dan kelola nilai siswa dengan antarmuka yang intuitif dan user-friendly</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 fade-in">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-print"></i>
                            </div>
                            <h4>Cetak Rapor Otomatis</h4>
                            <p>Generate dan cetak rapor secara otomatis dengan format yang sesuai standar</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 fade-in">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h4>Analisis Statistik</h4>
                            <p>Dapatkan insight mendalam dengan grafik dan laporan statistik yang komprehensif</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 fade-in">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4>Multi User Role</h4>
                            <p>Sistem role untuk Admin, Guru, dan Wali Murid dengan akses yang terkelola</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 fade-in">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-cloud"></i>
                            </div>
                            <h4>Cloud Based</h4>
                            <p>Akses data dari mana saja dan kapan saja dengan sistem berbasis cloud</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 fade-in">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <h4>Keamanan Terjamin</h4>
                            <p>Data siswa terlindungi dengan enkripsi dan sistem keamanan berlapis</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <span class="stat-number counter" data-target="500">0</span>
                            <span class="stat-label">Sekolah Terdaftar</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <span class="stat-number counter" data-target="50000">0</span>
                            <span class="stat-label">Siswa Aktif</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <span class="stat-number counter" data-target="2500">0</span>
                            <span class="stat-label">Guru Pengguna</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <span class="stat-number counter" data-target="99">0</span>
                            <span class="stat-label">% Kepuasan</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="benefits-section" id="keunggulan">
            <div class="container">
                <div class="section-title fade-in">
                    <h2>Keunggulan E-Raport</h2>
                    <p>Mengapa memilih sistem kami untuk sekolah Anda?</p>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-6 fade-in">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <div class="benefit-content">
                                <h5>Efisiensi Waktu</h5>
                                <p>Hemat waktu hingga 70% dalam proses pembuatan dan distribusi rapor</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="benefit-content">
                                <h5>Akses Mobile</h5>
                                <p>Responsive design yang dapat diakses dari smartphone, tablet, dan desktop</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-sync"></i>
                            </div>
                            <div class="benefit-content">
                                <h5>Real-time Update</h5>
                                <p>Sinkronisasi data secara real-time untuk informasi yang selalu akurat</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="benefit-content">
                                <h5>Support 24/7</h5>
                                <p>Tim support yang siap membantu Anda kapan pun dibutuhkan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 fade-in">
                        <div class="benefits-image">
                            <i class="fas fa-chalkboard-teacher"
                                style="font-size: 25rem; color: rgba(102, 126, 234, 0.1);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2>Siap Modernisasi Sistem Rapor Sekolah Anda?</h2>
                        <p>Bergabunglah dengan ratusan sekolah yang telah mempercayai E-Raport</p>
                        <a href="/login" class="btn btn-cta">
                            <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer" id="kontak">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <h5><i class="fas fa-graduation-cap"></i> E-Raport</h5>
                        <p style="color: rgba(255,255,255,0.7);">
                            Sistem Informasi Rapor Digital yang memudahkan proses manajemen nilai dan rapor siswa secara
                            modern dan efisien.
                        </p>
                        <div class="social-links mt-3">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 mb-4">
                        <h5>Menu</h5>
                        <ul>
                            <li><a href="#beranda">Beranda</a></li>
                            <li><a href="#fitur">Fitur</a></li>
                            <li><a href="#keunggulan">Keunggulan</a></li>
                            <li><a href="/login">Login</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5>Layanan</h5>
                        <ul>
                            <li><a href="#">Manajemen Nilai</a></li>
                            <li><a href="#">Cetak Rapor</a></li>
                            <li><a href="#">Laporan Statistik</a></li>
                            <li><a href="#">Data Siswa</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5>Kontak</h5>
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: rgba(255,255,255,0.7); margin-bottom: 10px;">
                                <i class="fas fa-map-marker-alt"></i> Jl. Pendidikan No. 123
                            </li>
                            <li style="color: rgba(255,255,255,0.7); margin-bottom: 10px;">
                                <i class="fas fa-phone"></i> +62 812-3456-7890
                            </li>
                            <li style="color: rgba(255,255,255,0.7);">
                                <i class="fas fa-envelope"></i> info@eraport.com
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="copyright">
                    <p>&copy; 2025 Buana Aviora. All Rights Reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="/assets/plugins/jquery/jquery.min.js"></script>
        <script src="/assets/js/adminlte.js"></script>
        </script>

        <script>
            // Navbar scroll effect
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('.navbar').addClass('scrolled');
            } else {
                $('.navbar').removeClass('scrolled');
            }
        });

        // Smooth scroll
        $('a[href^="#"]').on('click', function(e) {
            e.preventDefault();
            var target = $(this.getAttribute('href'));
            if(target.length) {
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 70
                }, 1000);
            }
        });

        // Counter animation
        function animateCounter() {
            $('.counter').each(function() {
                const $this = $(this);
                const countTo = $this.attr('data-target');
                $({countNum: 0}).animate({
                    countNum: countTo
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.floor(this.countNum).toLocaleString());
                    },
                    complete: function() {
                        $this.text(this.countNum.toLocaleString());
                    }
                });
            });
        }

        // Scroll animations
        function checkScroll() {
            $('.fade-in').each(function() {
                const elementTop = $(this).offset().top;
                const windowBottom = $(window).scrollTop() + $(window).height();
                if (elementTop < windowBottom - 100) {
                    $(this).addClass('visible');
                }
            });
        }
        
        let counterTriggered = false;
        $(window).scroll(function () {
            checkScroll();

            // jalankan counter sekali saat section statistik terlihat
            if (!counterTriggered) {
                const statsTop = $('.stats-section').offset().top || 0;
                const windowBottom = $(this).scrollTop() + $(this).height();
                if (windowBottom > statsTop + 100) {
                    animateCounter();
                    counterTriggered = true;
                }
            }
        });

        $(window).on('load', function () {
            checkScroll();
            const statsTop = $('.stats-section').offset()?.top || Number.POSITIVE_INFINITY;
            const windowBottom = $(window).scrollTop() + $(window).height();
            if (!counterTriggered && windowBottom > statsTop + 100) {
                animateCounter();
                counterTriggered = true;
            }
        });

        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReduced) {
            $('.fade-in').addClass('visible');
            animateCounter = function () {
                $('.counter').each(function () {
                    const $this = $(this);
                    const countTo = $this.attr('data-target');
                    $this.text(Number(countTo).toLocaleString());
                });
            };
        }

        $('.btn-hero').on('click', function (e) {
            e.preventDefault();
            const target = $('#fitur');
            if (target.length) {
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 70
                }, prefersReduced ? 0 : 1000);
            }
        });
        </script>
    </body>

</html>