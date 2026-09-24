<?php
session_start(); // เริ่มเซสชั่น
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarHub - ขายรถมือสอง</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> 
    <link rel="stylesheet" href="all.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
        <a class="navbar-brand" href="/">
    <img src="images/logo1.png" alt="UsedCarHub Logo" height="60"> <!-- ปรับ height ให้ใหญ่ขึ้น -->
</a>


        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
                <li class="nav-item"><a class="nav-link" href="category.php">ข้อมูลรถยนต์</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">เกี่ยวกับเรา</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">ติดต่อเรา</a></li>
                <li class="nav-item"><a class="nav-link" href="help.php">ช่วยเหลือ</a></li>
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person"></i> <?php echo $_SESSION['username']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php">ข้อมูลผู้ใช้</a></li>
                            <li><a class="dropdown-item" href="logout.php">ออกจากระบบ</a></li>
                        </ul>
                    </li>
                    
                <?php else: ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="guestDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person"></i> บัญชีผู้ใช้
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="login.php">เข้าสู่ระบบ</a></li>
                            <li><a class="dropdown-item" href="register.php">สมัครสมาชิก</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<header class="hero text-center text-white d-flex align-items-center justify-content-center" style="
    height: 300px; 
    background-image: url('images/name.png'); /* เปลี่ยนเป็นไฟล์รูปที่คุณต้องการ */
    background-size: cover; 
    background-position: center;
    background-blend-mode: overlay; /* ช่วยให้ข้อความอ่านง่ายขึ้น */
    background-color: rgba(0, 0, 0, 0.4); /* ทำให้พื้นหลังมืดลงเล็กน้อย */
">
    <div>
        <h1>ขายรถมือสองง่ายๆ ทั่วไทย</h1>
        <p>ขายรถมือสอง ราคาดี มีคุณภาพ มั่นใจได้</p>
    </div>
</header>

    <!-- Popular Cars -->
    <div class="container mt-5">
        <h2 class="text-center">🚗 รถมือสองยอดนิยม</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="images/1.png" class="card-img-top" alt="Toyota Vios">
                    <div class="card-body">
                        <h5 class="card-title">Toyota Vios</h5>
                        <p class="card-text">ราคา 350,000 บาท</p>
                        <a href="category.php" class="btn btn-primary">รายละเอียด</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="images/3.png" class="card-img-top" alt="Honda Civic">
                    <div class="card-body">
                        <h5 class="card-title">Honda Civic</h5>
                        <p class="card-text">ราคา 450,000 บาท</p>
                        <a href="category.php" class="btn btn-primary">รายละเอียด</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="images/2.png" class="card-img-top" alt="Toyota Fortuner">
                    <div class="card-body">
                        <h5 class="card-title">Toyota Fortuner</h5>
                        <p class="card-text">ราคา 1,200,000 บาท</p>
                        <a href="category.php" class="btn btn-primary">รายละเอียด</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="container mt-5">
        <h2 class="text-center">คำถามที่พบบ่อย (FAQ)</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">คำถาม</th>
                    <th scope="col">คำตอบ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>ทำไมถึงควรซื้อรถมือสอง?</td>
                    <td>การซื้อรถมือสองช่วยให้คุณประหยัดค่าใช้จ่าย แต่ยังคงได้รับคุณภาพที่ดีจากรถที่ผ่านการใช้งานมาแล้ว พร้อมราคาที่เหมาะสม</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>จะตรวจสอบประวัติการใช้งานของรถได้อย่างไร?</td>
                    <td>คุณสามารถขอประวัติการใช้งานจากเจ้าของรถหรือจากผู้ขายผ่านข้อมูลจากระบบทะเบียนรถหรือเอกสารที่เกี่ยวข้อง</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>การซื้อรถมือสองมีการรับประกันหรือไม่?</td>
                    <td>การรับประกันขึ้นอยู่กับผู้ขาย บางรายอาจมีการรับประกันหลังการขายหรือบริการหลังการขายเพิ่มเติม</td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>ทำไมราคาในเว็บไซต์ถึงแตกต่างกัน?</td>
                    <td>ราคาของรถมือสองอาจแตกต่างกันตามยี่ห้อ รุ่น ปีที่ผลิต สภาพของรถ และปัจจัยต่างๆ เช่น การใช้งานและอุปกรณ์เสริมที่ติดตั้ง</td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td>วิธีการติดต่อกับผู้ขายคืออะไร?</td>
                    <td>คุณสามารถติดต่อผู้ขายผ่านช่องทางที่ระบุไว้ในรายละเอียดของรถ เช่น เบอร์โทรศัพท์ อีเมล หรือฟอร์มการติดต่อในเว็บไซต์</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="footer bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <!-- ข้อมูลบริษัท -->
                <div class="col-md-3">
                    <h5>CarHub</h5>
                    <p>เว็บไซต์ขายรถมือสองที่ให้คุณเลือกซื้อรถได้อย่างง่ายดายและสะดวกสบาย.</p>
                </div>

                <!-- ช่องทางการติดต่อ -->
                <div class="col-md-3">
                    <h5>ติดต่อเรา</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-telephone"></i> โทรศัพท์: 02-123-4567</li>
                        <li><i class="bi bi-envelope"></i> อีเมล: contact@carhub.com</li>
                        <li><i class="bi bi-geo-alt"></i> ที่อยู่: 123 ถนนสุขุมวิท, กรุงเทพฯ, 10110</li>
                    </ul>
                </div>

                <!-- โซเชียลมีเดีย -->
                <div class="col-md-3">
                    <h5>ติดตามเรา</h5>
                    <ul class="list-unstyled">
                        <li><a href="https://facebook.com" class="text-white"><i class="bi bi-facebook"></i> Facebook</a></li>
                        <li><a href="https://twitter.com" class="text-white"><i class="bi bi-twitter"></i> Twitter</a></li>
                        <li><a href="https://instagram.com" class="text-white"><i class="bi bi-instagram"></i> Instagram</a></li>
                    </ul>
                </div>

                <!-- ลิงก์เกี่ยวกับเว็บไซต์ -->
                <div class="col-md-3">
                    <h5>เกี่ยวกับเว็บไซต์</h5>
                    <ul class="list-unstyled">
                        <li><a href="about.php" class="text-white">เกี่ยวกับเรา</a></li>
                        <li><a href="terms.php" class="text-white">ข้อตกลงและเงื่อนไข</a></li>
                        <li><a href="privacy.php" class="text-white">นโยบายความเป็นส่วนตัว</a></li>
                    </ul>
                </div>
            </div>

            <!-- ข้อความลิขสิทธิ์ -->
            <div class="text-center mt-4">
                <p>&copy; 2025 CarHub | All Rights Reserved</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
