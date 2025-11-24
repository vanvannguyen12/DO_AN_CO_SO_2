<?php 
require 'config.php';

// --- AUTHENTICATION ---
if (isset($_POST['login'])) {
    if ($_POST['password'] == 'admin123') {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $error = "Sai mật khẩu!";
    }
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}
if (!isset($_SESSION['admin_logged_in'])) {
    // Form Login Giữ nguyên
    ?>
    <!DOCTYPE html><html lang="vi"><head><title>Admin Login</title><script src="https://cdn.tailwindcss.com"></script></head>
    <body class="bg-gray-100 h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded shadow w-96">
            <h2 class="text-2xl font-bold mb-4">Admin Login</h2>
            <?php if (isset($error)): ?><div class="bg-red-100 text-red-800 p-2 rounded mb-4 text-sm"><?php echo $error; ?></div><?php endif; ?>
            <form method="POST"><input type="password" name="password" class="w-full border p-2 mb-4" placeholder="Mật khẩu"><button name="login" class="w-full bg-blue-600 text-white p-2 hover:bg-blue-700">Login</button></form>
        </div>
    </body></html>
    <?php exit;
}

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'bookings'; 
$error = '';
// Lấy thông báo thành công từ redirect sau khi cập nhật
$success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : ''; 

// --- XỬ LÝ SỬA MÓN ĂN (Fetch data for Edit Form) ---
$edit_item = null;
if (isset($_GET['edit_item'])) {
    $stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
    $stmt->execute([$_GET['edit_item']]);
    $edit_item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$edit_item) {
        $error = "Không tìm thấy món ăn cần sửa!";
    } else {
        // Chuyển tab sang menu để hiển thị form sửa
        $tab = 'menu'; 
    }
}

// --- XỬ LÝ CHUNG CHO TAB MENU (Add, Update, Delete) ---
if ($tab == 'menu') {
    
    // --- XỬ LÝ CẬP NHẬT MÓN ĂN SAU KHI SỬA (MỚI) ---
    if (isset($_POST['update_item'])) {
        $id = $_POST['id'];
        $tenmon = $_POST['name'];
        $gia = $_POST['price'];
        $danhmuc = $_POST['cat'];
        $mota = $_POST['desc'];
        $image_path = $_POST['current_img_url'] ?? ''; // Lấy ảnh cũ từ input hidden

        if (empty($tenmon) || empty($gia)) {
            $error = "Tên món và Giá không được để trống!";
        } else {
            // Xử lý tải lên ảnh mới (giống logic add_item)
            if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
                $upload_dir = 'img/'; 
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                $file_extension = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));
                
                if (in_array($file_extension, $allowed_extensions)) {
                    $file_name = time() . uniqid() . '.' . $file_extension; 
                    $target_file = $upload_dir . $file_name;
                    
                    if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_file)) {
                        $image_path = $target_file; // Cập nhật ảnh mới
                    } 
                }
            }
            
            $stmt = $conn->prepare("UPDATE menu SET tenmon = ?, gia = ?, danhmuc = ?, mota = ?, hinhanh = ? WHERE id = ?");
            if ($stmt->execute([$tenmon, $gia, $danhmuc, $mota, $image_path, $id])) {
                $success = "Cập nhật món ăn thành công!";
                header("Location: admin.php?tab=menu&success=" . urlencode($success));
                exit;
            } else {
                $error = "Lỗi khi cập nhật CSDL.";
            }
        }
    }

    // Thêm món (Giữ nguyên)
    if (isset($_POST['add_item'])) {
        
        $image_path = ''; 
        $upload_dir = 'img/'; 

        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            $file_extension = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));
            
            if (in_array($file_extension, $allowed_extensions)) {
                
                $file_name = time() . uniqid() . '.' . $file_extension; 
                $target_file = $upload_dir . $file_name;
                if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_file)) {
                    $image_path = $target_file;
                } 
            } 
        }

        // Thực hiện INSERT vào database (Cột hinhanh giờ sẽ lưu $image_path)
        $stmt = $conn->prepare("INSERT INTO menu (tenmon, mota, gia, hinhanh, danhmuc) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['desc'], $_POST['price'], $image_path, $_POST['cat']]); 
        
        header("Location: admin.php?tab=menu");
        exit;
    }
    
    // Xóa món (Giữ nguyên)
    if (isset($_GET['delete_item'])) {
        $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
        $stmt->execute([$_GET['delete_item']]);
        header("Location: admin.php?tab=menu");
    }
    
    // Lấy danh sách món (Giữ nguyên)
    $menu_items = $conn->query("SELECT * FROM menu ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
}

// 2. Xử lý BOOKING (Giữ nguyên)
if ($tab == 'bookings') {
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $status = $_GET['action'] == 'confirm' ? 'confirmed' : 'cancelled';
        $stmt = $conn->prepare("UPDATE datban SET trangthai = ? WHERE id = ?"); // Sửa 'status' thành 'trangthai' cho đúng cột DB
        $stmt->execute([$status, $_GET['id']]);
        header("Location: admin.php?tab=bookings");
    }
    $reservations = $conn->query("SELECT * FROM datban ORDER BY tgtao DESC")->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Trang Quản Trị - Sen Vàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">
    
    <div class="w-64 bg-emerald-900 text-white flex flex-col">
        <div class="p-6 font-bold text-2xl text-amber-400 border-b border-emerald-800">
            <i class="fas fa-user-shield"></i> Admin Panel
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="?tab=bookings" class="block p-3 rounded hover:bg-emerald-800 <?php echo $tab=='bookings'?'bg-emerald-700':''; ?>">
                <i class="fas fa-calendar-check w-6"></i> Đặt Bàn
            </a>
            <a href="?tab=menu" class="block p-3 rounded hover:bg-emerald-800 <?php echo $tab=='menu'?'bg-emerald-700':''; ?>">
                <i class="fas fa-utensils w-6"></i> Quản Lý Menu
            </a>
            <a href="index.php" target="_blank" class="block p-3 rounded hover:bg-emerald-800 text-gray-300">
                <i class="fas fa-external-link-alt w-6"></i> Xem Website
            </a>
        </nav>
        <div class="p-4 border-t border-emerald-800">
            <a href="?logout=true" class="block text-center bg-red-600 py-2 rounded hover:bg-red-700">Đăng Xuất</a>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-8">
        
        <?php if($tab == 'bookings'): ?>
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Danh Sách Đặt Bàn</h2>
            <div class="bg-white rounded shadow overflow-hidden">
                <table class="w-full text-left border-collapse">
                  
 <thead class="bg-gray-200">
<tr>
<th class="p-3">Khách hàng</th>
<th class="p-3">Ngày/Giờ</th>
<th class="p-3">Khách</th>
<th class="p-3">Món Đặt Trước</th> 
                            <th class="p-3">Ghi chú</th>
 <th class="p-3">Trạng thái</th>
                            <th class="p-3">Hành động</th>
 </tr>
</thead>
                    <tbody>
                        <?php foreach($reservations as $res): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">
                                <div class="font-bold"><?php echo $res['ten']; ?></div>
                                <div class="text-sm text-gray-500"><?php echo $res['sdt']; ?></div>
                            </td>
                            <td class="p-3"><?php echo $res['ngay'] . ' - ' . $res['gio']; ?></td>
 <td class="p-3"><?php echo $res['soluong']; ?></td>

<td class="p-3 text-sm text-gray-700 max-w-xs">
<?php 
                                    // Hiển thị chi tiết món ăn hoặc 'Không đặt món' nếu trống
                                    echo htmlspecialchars($res['order_details'] ?? 'Không đặt món'); 
                                ?>
</td>
                            
 <td class="p-3 italic text-gray-500 text-sm"><?php echo $res['ghichu']; ?></td>
                          
<td class="p-3">
    <?php 
    // Nếu trangthai là NULL, coi như là 'pending' (Chờ xử lý)
    $status_key = $res['trangthai'] ?: 'pending'; 
    $status_text = 'Chờ xử lý';
    $color = 'text-yellow-600 bg-yellow-100'; 
    
    if ($status_key == 'confirmed') {
        $status_text = 'Đã xác nhận';
        $color = 'text-green-600 bg-green-100';
    } elseif ($status_key == 'cancelled') {
        $status_text = 'Đã hủy';
        $color = 'text-red-600 bg-red-100';
    }
    
    ?>
    <span class="px-2 py-1 rounded text-xs font-bold uppercase <?php echo $color; ?>"><?php echo $status_text; ?></span>
</td>                     
                            <td class="p-3 space-x-2">
                                <?php if ($res['trangthai'] != 'confirmed'): ?>
                                    <a href="?tab=bookings&action=confirm&id=<?php echo $res['id']; ?>" class="text-green-600 hover:text-green-800" title="Xác nhận"><i class="fas fa-check"></i></a>
                                <?php endif; ?>
                                <?php if ($res['trangthai'] != 'cancelled'): ?>
                                    <a href="?tab=bookings&action=cancel&id=<?php echo $res['id']; ?>" class="text-red-600 hover:text-red-800" title="Hủy"><i class="fas fa-times"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php if($tab == 'menu'): ?>
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Quản Lý Thực Đơn</h2>
            
            <?php if($error): ?><div class="bg-red-100 text-red-800 p-3 rounded mb-4"><?php echo $error; ?></div><?php endif; ?>
            <?php if($success): ?><div class="bg-green-100 text-green-800 p-3 rounded mb-4"><?php echo $success; ?></div><?php endif; ?>
            
            <div class="bg-white p-6 rounded shadow mb-8">
                <h3 class="font-bold mb-4 text-lg border-b pb-2"><?php echo $edit_item ? 'Sửa Món Ăn (ID: ' . $edit_item['id'] . ')' : 'Thêm Món Mới'; ?></h3>
                
                <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    
                    <?php if ($edit_item): // Nếu đang ở chế độ sửa ?>
                        <input type="hidden" name="update_item" value="1">
                        <input type="hidden" name="id" value="<?php echo $edit_item['id']; ?>">
                        <input type="hidden" name="current_img_url" value="<?php echo htmlspecialchars($edit_item['hinhanh']); ?>">
                    <?php else: ?>
                        <input type="hidden" name="add_item" value="1">
                    <?php endif; ?>
                    
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold mb-1">Tên món</label>
                        <input type="text" name="name" required class="w-full border p-2 rounded" value="<?php echo $edit_item ? htmlspecialchars($edit_item['tenmon']) : ''; ?>">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold mb-1">Danh mục</label>
                        <input type="text" name="cat" placeholder="Khai vị/Món chính..." class="w-full border p-2 rounded" value="<?php echo $edit_item ? htmlspecialchars($edit_item['danhmuc']) : ''; ?>">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-xs font-bold mb-1">Giá</label>
                        <input type="number" name="price" required class="w-full border p-2 rounded" value="<?php echo $edit_item ? $edit_item['gia'] : ''; ?>">
                    </div>
                   <div class="md:col-span-1">
                        <label class="block text-xs font-bold mb-1">Tải Ảnh Lên (Mới)</label>
                        <input type="file" name="image_file" accept="image/*" class="w-full border p-1 rounded bg-stone-50">
                        <?php if ($edit_item && $edit_item['hinhanh']): ?>
                            <p class="text-xs text-gray-500 mt-1">Ảnh hiện tại:</p>
                            <img src="<?php echo htmlspecialchars($edit_item['hinhanh']); ?>" class="w-10 h-10 object-cover inline-block rounded">
                        <?php endif; ?>
                    </div>
                     <div class="md:col-span-4">
                        <label class="block text-xs font-bold mb-1">Mô tả</label>
                        <textarea name="desc" rows="2" class="w-full border p-2 rounded" placeholder="Mô tả chi tiết về món ăn..."><?php echo $edit_item ? htmlspecialchars($edit_item['mota']) : ''; ?></textarea>
                    </div>
                    
                    <button type="submit" name="<?php echo $edit_item ? 'update_item' : 'add_item'; ?>" class="bg-blue-600 text-white p-2 rounded font-bold h-10 hover:bg-blue-700 transition">
                        <?php echo $edit_item ? 'Cập Nhật' : 'Thêm Mới'; ?>
                    </button>
                    
                    <?php if ($edit_item): ?>
                        <a href="admin.php?tab=menu" class="text-gray-600 ml-4 hover:text-gray-800 self-center text-sm">Hủy bỏ sửa</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach($menu_items as $item): ?>
                <div class="bg-white rounded shadow flex gap-4 p-3 relative group">
                    <img src="<?php echo $item['hinhanh']; ?>" class="w-20 h-20 object-cover rounded">
                    <div>
                        <h4 class="font-bold"><?php echo $item['tenmon']; ?></h4>
                        <p class="text-sm text-gray-500"><?php echo $item['danhmuc']; ?></p>
                        <p class="text-amber-600 font-bold"><?php echo number_format($item['gia']); ?> đ</p>
                    </div>
                    
                    <a href="?tab=menu&edit_item=<?php echo $item['id']; ?>" class="absolute top-2 right-10 text-blue-400 hover:text-blue-600 opacity-0 group-hover:opacity-100 transition" title="Sửa món ăn">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="?tab=menu&delete_item=<?php echo $item['id']; ?>" onclick="return confirm('Xóa món này?')" class="absolute top-2 right-2 text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition" title="Xóa món ăn">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>