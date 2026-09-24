<?php
session_start();
require 'config.php'; // เชื่อมต่อฐานข้อมูลหรือไฟล์อื่น ๆ ที่จำเป็น

// กำหนดจำนวนผลลัพธ์ที่จะแสดงต่อหน้า
$results_per_page = 6; 

// หาค่าหน้าปัจจุบันจาก URL
if (isset($_GET['page'])) {
    $page_number = $_GET['page'];
} else {
    $page_number = 1;
}

// คำนวณค่า OFFSET สำหรับ SQL
$offset = ($page_number - 1) * $results_per_page;

// ดึงข้อมูลรถทั้งหมดจากฐานข้อมูล
$sql = "SELECT * FROM cars WHERE status = 'available' LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $results_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

// ค้นหารถจากคำค้นหาที่ผู้ใช้กรอก
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM cars WHERE (brand LIKE ? OR model LIKE ?) AND status = 'available' LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search . "%";
    $stmt->bind_param("ssii", $search_param, $search_param, $results_per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
}

// คำนวณจำนวนหน้าทั้งหมด
$total_sql = "SELECT COUNT(*) AS total FROM cars WHERE status = 'available'";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $results_per_page);

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UsedCarHub - ซื้อรถมือสองง่ายๆ ทั่วไทย</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> 
    <link rel="stylesheet" href="all.css">
    <style>
        .card {
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* เพิ่มเงาเพื่อให้กรอบดูมีมิติ */
            border-radius: 10px; /* มุมโค้งมน */
            margin-bottom: 30px; /* ให้ระยะห่างระหว่างการ์ด */
            overflow: hidden; /* ป้องกันเนื้อหาที่เกินออกจากขอบการ์ด */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* เพิ่มการเคลื่อนไหวเมื่อเลื่อนเมาส์ */
        }

        .card:hover {
            transform: translateY(-5px); /* เมื่อเลื่อนเมาส์การ์ดจะเลื่อนขึ้น */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* เพิ่มเงาเมื่อมีการ hover */
        }

        .card-body {
            padding: 20px; /* เพิ่มระยะห่างภายในการ์ด */
        }

        .card-title {
            font-size: 1.25rem; /* ขนาดตัวอักษรของชื่อรถ */
            font-weight: bold;
            margin-bottom: 15px; /* เพิ่มระยะห่างใต้ชื่อรถ */
        }

        .card-text {
            font-size: 1rem; /* ขนาดตัวอักษร */
            margin-bottom: 10px; /* ระยะห่างระหว่างบรรทัด */
        }

        .card-img-top {
            width: 100%;
            height: 200px; /* ลดความสูงของรูป */
            object-fit: cover; /* ทำให้รูปเต็มพื้นที่โดยไม่ผิดสัดส่วน */
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
.card-body {
    position: relative; /* ทำให้การ์ดมีตำแหน่งที่สัมพันธ์กับเนื้อหาภายใน */
    padding: 20px;
}

.card-body .btn {
    position: absolute;
    bottom: 10px;
    right: 10px;
}
        /* ปรับให้การ์ดในแต่ละคอลัมน์เท่ากัน */
        .row .col-md-4 {
            display: flex;
            justify-content: center;
        }

        .search-box {
            max-width: 600px;
            margin: auto;
            border-radius: 50px;
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
        <a class="navbar-brand" href="/">
    <img src="images/logo1.png" alt="UsedCarHub Logo" height="60"> <!-- ปรับ height ให้ใหญ่ขึ้น -->
</a>


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
                    <li class="nav-item"><a class="nav-link" href="booking_history.php">ข้อมูลการจอง</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> 
                            <?php echo isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true 
                                ? htmlspecialchars($_SESSION['username']) 
                                : "บัญชีผู้ใช้"; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                                <li><a class="dropdown-item" href="profile.php">ข้อมูลผู้ใช้</a></li>
                                <li><a class="dropdown-item" href="logout.php">ออกจากระบบ</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="login.php">เข้าสู่ระบบ</a></li>
                                <li><a class="dropdown-item" href="register.php">สมัครสมาชิก</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
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

    <!-- Search Box -->
    <div class="container mt-4">
        <div class="search-box p-4">
            <form action="search.php" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="🔍 ค้นหารถที่คุณต้องการ...">
                    <button type="submit" class="btn btn-primary">ค้นหา</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Car Listing -->
    <div class="container mt-5">
        <h2 class="text-center">🚗 รถมือสองที่พร้อมขาย</h2>
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while($car = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="get_image.php?car_id=<?php echo $car['id']; ?>" class="card-img-top" alt="<?php echo $car['brand']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $car['brand'] . ' ' . $car['model']; ?></h5>
                                <p class="card-text">ปี: <?php echo $car['year']; ?></p>
                                <p class="card-text">หมายเลขทะเบียน: <?php echo $car['license_plate']; ?></p>
                                <p class="card-text">ราคาขาย: ฿<?php echo number_format($car['price_per'], 2); ?></p>
                                <p class="card-text">สถานะ: <?php echo ucfirst($car['status']); ?></p>
                                <a href="details.php?id=<?php echo $car['id']; ?>" class="btn btn-primary">ดูรายละเอียด</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">ขออภัย, ไม่มีรถที่พร้อมขายในขณะนี้</p>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <nav>
                <ul class="pagination">
                    <?php if ($page_number > 1): ?>
                        <li class="page-item"><a class="page-link" href="category.php?page=<?php echo $page_number - 1; ?>">ก่อนหน้า</a></li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page_number) ? 'active' : ''; ?>">
                            <a class="page-link" href="category.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page_number < $total_pages): ?>
                        <li class="page-item"><a class="page-link" href="category.php?page=<?php echo $page_number + 1; ?>">ถัดไป</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 mt-5 bg-dark text-white">
        <p>&copy; 2025 UsedCarHub | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
