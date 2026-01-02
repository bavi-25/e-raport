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
                            <svg viewBox="0 0 490 490" xmlns="http://www.w3.org/2000/svg" style="
                                                            width: 20rem;
                                                            height: 20rem;
                                                            fill: rgba(255, 255, 255, 0.1);
                                                        ">
                                <g>
                                    <path d="M71.424,121.863h-3.19V68.474c0-2.771-1.642-5.279-4.183-6.386c-2.537-1.107-5.494-0.604-7.524,1.281L41.861,76.986
                                                        			c-2.818,2.618-2.981,7.026-0.363,9.846c2.617,2.819,7.025,2.982,9.844,0.364L54.3,84.45v37.413h-3.161
                                                        			c-3.848,0-6.967,3.119-6.967,6.967c0,3.847,3.119,6.966,6.967,6.966h20.285c3.848,0,6.967-3.119,6.967-6.966
                                                        			C78.391,124.982,75.271,121.863,71.424,121.863z" />
                                    <path d="M170.714,121.863h-3.162V68.474c0-2.771-1.642-5.277-4.18-6.385c-2.539-1.108-5.493-0.608-7.523,1.275l-14.689,13.617
                                                        			c-2.821,2.616-2.989,7.025-0.373,9.846c2.616,2.822,7.023,2.989,9.845,0.374l2.987-2.77v37.432h-3.162
                                                        			c-3.848,0-6.967,3.119-6.967,6.967c0,3.847,3.119,6.966,6.967,6.966h20.258c3.847,0,6.966-3.119,6.966-6.966
                                                        			C177.68,124.982,174.561,121.863,170.714,121.863z" />
                                    <path
                                        d="M125.605,92.411h-10.182V82.223c0-3.848-3.119-6.967-6.967-6.967s-6.967,3.119-6.967,6.967v10.188H91.307
                                                        			c-3.848,0-6.967,3.119-6.967,6.967c0,3.847,3.119,6.966,6.967,6.966h10.184v10.187c0,3.848,3.119,6.967,6.967,6.967
                                                        			s6.967-3.119,6.967-6.967v-10.187h10.182c3.848,0,6.967-3.119,6.967-6.966C132.572,95.53,129.453,92.411,125.605,92.411z" />
                                    <g>
                                        <g>
                                            <path
                                                d="M247.795,115.696h-39.296c-3.847,0-6.966-3.118-6.966-6.966c0-3.847,3.119-6.966,6.966-6.966h39.296
                                                        					c3.848,0,6.967,3.119,6.967,6.966C254.762,112.578,251.643,115.696,247.795,115.696z" />
                                        </g>
                                        <g>
                                            <path
                                                d="M247.795,135.712h-39.296c-3.847,0-6.966-3.119-6.966-6.967c0-3.848,3.119-6.967,6.966-6.967h39.296
                                                        					c3.848,0,6.967,3.119,6.967,6.967C254.762,132.593,251.643,135.712,247.795,135.712z" />
                                        </g>
                                    </g>
                                    <g>
                                        <path d="M315.544,135.712h-36.341c-2.699,0-5.154-1.56-6.305-4.002c-1.148-2.442-0.782-5.329,0.939-7.408
                                                        				c14.612-17.65,26.886-36.09,27.213-41.446c0.331-5.425-3.94-7.591-7.436-7.415c-4.1,0.207-7.443,3.33-7.443,7.423
                                                        				c0,3.847-3.119,6.965-6.967,6.965c-3.848,0-6.967-3.118-6.967-6.965c0-11.776,9.59-21.357,21.377-21.357
                                                        				c12.183,0,21.369,9.18,21.369,21.357c0,9.061-11.587,26.146-21.333,38.914h21.895c3.849,0,6.967,3.119,6.967,6.967
                                                        				C322.511,132.593,319.392,135.712,315.544,135.712z" />
                                    </g>
                                </g>
                                <g>
                                    <path
                                        d="M483.033,18.302H6.967C3.119,18.302,0,21.42,0,25.268V291.8c0,3.848,3.119,6.967,6.967,6.967h191.561
                                                        			c10.312,12.452,22.877,21.244,37.539,26.193c13.507,4.559,28.775,5.717,44.589,3.433v136.339c0,3.847,3.119,6.966,6.967,6.966
                                                        			h167.972c3.848,0,6.967-3.119,6.967-6.966V322.056c0-8.16-1.402-15.995-3.963-23.29h24.436c3.848,0,6.967-3.119,6.967-6.967
                                                        			V25.268C490,21.42,486.881,18.302,483.033,18.302z M448.627,457.765h-23.629v-97.202c0-3.848-3.119-6.967-6.967-6.967
                                                        			c-3.848,0-6.967,3.119-6.967,6.967v97.202H294.589V320.048c0-2.11-0.956-4.106-2.6-5.429c-1.646-1.323-3.802-1.828-5.861-1.375
                                                        			c-21.586,4.74-61.445,6.307-85.885-36.462c-9.851-17.237-14-49.797-4.48-70.792c2.866-6.319,9.073-11.681,16.48-9.41
                                                        			c6.819,2.092,10.666,9.343,8.574,16.164c-4.131,13.465-2.859,27.783,3.578,40.313c12.785,24.884,52.54,37.867,101.621,13.888
                                                        			c9.596,5.366,20.64,8.438,32.393,8.438c12.791,0,24.746-3.632,34.901-9.908c30.618,0.693,55.317,25.799,55.317,56.583V457.765z
                                                        			 M305.744,208.785c0-29.037,23.625-52.661,52.664-52.661c29.041,0,52.666,23.624,52.666,52.661
                                                        			c0,29.038-23.625,52.663-52.666,52.663C329.369,261.448,305.744,237.823,305.744,208.785z M476.066,284.833h-24.158
                                                        			c-9.776-15.665-25.526-27.237-44.039-31.507c10.645-11.809,17.138-27.429,17.138-44.541c0-36.72-29.876-66.594-66.599-66.594
                                                        			c-36.721,0-66.598,29.874-66.598,66.594c0,19.217,8.192,36.549,21.256,48.716c-36.648,15.294-66.982,7.282-76.278-10.812
                                                        			c-4.769-9.282-5.71-19.887-2.65-29.861c4.344-14.165-3.645-29.225-17.81-33.569c-13.208-4.051-26.885,2.931-33.255,16.976
                                                        			c-11.647,25.687-6.436,63.321,5.072,83.46c0.222,0.388,0.454,0.756,0.679,1.139H13.934V32.235h462.133V284.833z" />
                                    <path d="M389.31,413.406l-20.775-88.341l17.784-26.664c2.135-3.201,1.271-7.527-1.931-9.662c-3.199-2.133-7.525-1.27-9.661,1.931
                                                        			l-14.34,21.5l-14.34-21.5c-2.135-3.201-6.459-4.064-9.662-1.931c-3.201,2.135-4.065,6.461-1.931,9.662l17.933,26.885
                                                        			l-19.72,88.194c-0.449,2.008,0.014,4.115,1.264,5.751l21.105,27.608c1.304,1.706,3.204,2.715,5.351,2.736
                                                        			c2.122,0,4.313-0.967,5.636-2.629l21.957-27.609C389.309,417.667,389.799,415.482,389.31,413.406z M360.388,431.28l-13.413-17.93
                                                        			l13.413-61.086l14.587,61.043L360.388,431.28z" />
                                </g>

                            </svg>
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
                    <div class="col-lg-12 fade-in">
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
        <script src="/assets/plugins/popper/popper.min.js"></script>
        <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
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