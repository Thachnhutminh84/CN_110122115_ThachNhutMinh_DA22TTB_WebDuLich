<?php
/**
 * Trang Liên Hệ - Bootstrap Version
 */
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
$isAdmin = $isLoggedIn && isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'manager']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ - Du Lịch Trà Vinh</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/bootstrap-custom.css">
</head>
<body class="bg-gradient-light-purple">

    <!-- Header -->
    <header class="header-main shadow-sm sticky-top">
        <div class="container py-2">
            <div class="d-flex align-items-center justify-content-between">
                <a href="index.php" class="d-flex align-items-center text-decoration-none">
                    <i class="fas fa-home fs-4 text-primary me-2"></i>
                    <span class="fw-bold text-primary">Du Lịch Trà Vinh</span>
                </a>

                <nav class="d-none d-md-flex gap-2">
                    <a href="dia-diem-du-lich-dynamic.php" class="btn btn-outline-primary btn-sm">Địa Điểm</a>
                    <a href="am-thuc.php" class="btn btn-outline-primary btn-sm">Ẩm Thực</a>
                    <a href="lien-he.php" class="btn btn-primary btn-sm">Liên Hệ</a>
                </nav>

                <div class="d-flex gap-2">
                    <?php if ($isLoggedIn): ?>
                        <a href="logout.php" class="btn btn-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="d-none d-sm-inline ms-1">Đăng Xuất</span>
                        </a>
                    <?php else: ?>
                        <a href="dang-nhap.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-sign-in-alt"></i>
                            <span class="d-none d-sm-inline ms-1">Đăng Nhập</span>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($isAdmin): ?>
                        <a href="quan-ly-users.php" class="btn btn-purple btn-sm">
                            <i class="fas fa-users-cog"></i>
                            <span class="d-none d-sm-inline ms-1">Quản Lý</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="py-5 bg-gradient-purple text-white">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Liên Hệ Với Chúng Tôi</h1>
            <p class="fs-5 opacity-75">Hãy để chúng tôi hỗ trợ bạn trong hành trình khám phá Trà Vinh</p>
        </div>
    </section>

    <!-- Contact Content -->
    <main class="container py-5">
        <div class="row g-4">
            <!-- Contact Form -->
            <div class="col-lg-6">
                <div class="card shadow-lg h-100">
                    <div class="card-body p-4">
                        <h2 class="fw-bold mb-4">Gửi Tin Nhắn</h2>
                        
                        <div id="alertMessage" class="alert d-none"></div>
                        
                        <form id="contactForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Họ và tên *</label>
                                    <input type="text" name="full_name" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email *</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3 mt-3">
                                <label class="form-label fw-semibold">Số điện thoại</label>
                                <input type="tel" name="phone" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Chủ đề *</label>
                                <select name="subject" class="form-select" required>
                                    <option>Tư vấn du lịch</option>
                                    <option>Đặt tour</option>
                                    <option>Thông tin địa điểm</option>
                                    <option>Khác</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tin nhắn *</label>
                                <textarea name="message" class="form-control" rows="5" required placeholder="Nhập tin nhắn của bạn..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-gradient-purple w-100 py-3">
                                <i class="fas fa-paper-plane me-2"></i>Gửi Tin Nhắn
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-6">
                <div class="card shadow-lg mb-4">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4">Thông Tin Liên Hệ</h3>
                        
                        <div class="d-flex mb-4">
                            <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                <i class="fas fa-map-marker-alt text-primary fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold">Địa chỉ</h5>
                                <p class="text-muted mb-0">Trường Đại học Trà Vinh<br>126 Nguyễn Thiện Thành, Khóm 4, Phường 5<br>TP. Trà Vinh, Tỉnh Trà Vinh</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="bg-info bg-opacity-10 rounded p-3 me-3">
                                <i class="fas fa-phone text-info fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold">Điện thoại</h5>
                                <p class="text-muted mb-0">Hotline: 0294.3855.246<br>Fax: 0294.3855.269</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="bg-success bg-opacity-10 rounded p-3 me-3">
                                <i class="fas fa-envelope text-success fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold">Email</h5>
                                <p class="text-muted mb-0">info@tvu.edu.vn<br>dulich@travinh.gov.vn</p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="bg-warning bg-opacity-10 rounded p-3 me-3">
                                <i class="fas fa-clock text-warning fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-semibold">Giờ làm việc</h5>
                                <p class="text-muted mb-0">Thứ 2 - Thứ 6: 7:30 - 17:00<br>Thứ 7: 7:30 - 11:30</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4">Kết Nối Với Chúng Tôi</h3>
                        <div class="d-flex gap-3">
                            <a href="https://www.facebook.com/travinh.tourism" target="_blank" class="social-icon social-icon-facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.instagram.com/travinh.tourism" target="_blank" class="social-icon social-icon-instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://www.youtube.com/@travinhtourism" target="_blank" class="social-icon social-icon-youtube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="card shadow-lg mt-5">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-4"><i class="fas fa-map-marked-alt me-2 text-primary"></i>Bản Đồ</h3>
                <div class="ratio ratio-21x9">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.0!2d106.3!3d9.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwNTQnMDAuMCJOIDEwNsKwMTgnMDAuMCJF!5e0!3m2!1svi!2s!4v1234567890" 
                            style="border:0; border-radius: 0.5rem;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const alertDiv = document.getElementById('alertMessage');
            
            fetch('api/contact.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                alertDiv.classList.remove('d-none', 'alert-success', 'alert-danger');
                if (data.success) {
                    alertDiv.classList.add('alert-success');
                    alertDiv.innerHTML = '<i class="fas fa-check-circle me-2"></i>Gửi tin nhắn thành công! Chúng tôi sẽ liên hệ lại sớm.';
                    this.reset();
                } else {
                    alertDiv.classList.add('alert-danger');
                    alertDiv.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>' + (data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(err => {
                alertDiv.classList.remove('d-none');
                alertDiv.classList.add('alert-danger');
                alertDiv.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>Lỗi kết nối: ' + err.message;
            });
        });
    </script>
</body>
</html>
