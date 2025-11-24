<?php 
require 'config.php';
require 'header.php';

// Xử lý thêm giỏ hàng (Giữ nguyên)
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $img = $_POST['img'];
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty']++;
    } else {
        $_SESSION['cart'][$id] = ['name' => $name, 'price' => $price, 'img' => $img, 'qty' => 1];
    }
    echo "<script>alert('Đã thêm món vào giỏ!'); window.location.href='menu.php';</script>";
}

// --- THAY ĐỔI: Thêm logic LỌC theo danh mục (category) ---
$search = $_GET['q'] ?? '';
$category = $_GET['cat'] ?? ''; // Lấy tham số 'cat' từ URL
$allowed_categories = ['Khai vị', 'Món chính', 'Tráng miệng', 'Thức uống']; // Các danh mục hợp lệ
$categories_display = ['Tất cả'] + $allowed_categories; // Để hiển thị trong dropdown

// Bắt đầu câu truy vấn SQL
$sql = "SELECT * FROM menu WHERE tenmon LIKE ?";
$params = ["%$search%"];

// Nếu có chọn danh mục VÀ danh mục đó hợp lệ
if ($category && in_array($category, $allowed_categories)) {
    $sql .= " AND danhmuc = ?"; // Thêm điều kiện lọc theo danh mục
    $params[] = $category;      // Thêm tham số danh mục vào mảng
}

$sql .= " ORDER BY danhmuc"; // Sắp xếp cuối cùng

$stmt = $conn->prepare($sql);
$stmt->execute($params); // Thực thi với mảng tham số đã chuẩn bị
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
// --- KẾT THÚC THAY ĐỔI LOGIC LỌC ---
?>

<div class="bg-stone-50 min-h-screen pb-20 animate-fade-in">
    <div class="bg-stone-900 text-white py-16 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <h1 class="text-4xl font-bold mb-4 relative z-10">Thực Đơn Thượng Hạng</h1>
        <p class="text-stone-400 relative z-10">Khám phá tinh hoa ẩm thực đa dạng</p>
        
        <div class="mt-8 max-w-2xl mx-auto px-4 relative z-10">
            <form class="flex space-x-4">
                
                <div class="relative w-1/3">
                    <select name="cat" 
                            onchange="this.form.submit()"
                            class="w-full py-3 pl-5 pr-12 rounded-full text-stone-900 focus:outline-none focus:ring-4 focus:ring-amber-500/50 shadow-lg appearance-none bg-white">
                        <option value="">Tất cả danh mục</option>
                        <?php foreach ($allowed_categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>"
                                    <?php echo $category == $cat ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-stone-600 pointer-events-none text-sm"></i>
                </div>
                
                <div class="relative flex-1">
                    <input type="text" name="q" value="<?php echo htmlspecialchars($search); ?>" placeholder="Tìm món ăn..." 
                           class="w-full py-3 pl-5 pr-12 rounded-full text-stone-900 focus:outline-none focus:ring-4 focus:ring-amber-500/50 shadow-lg">
                    <button class="absolute right-2 top-1.5 bg-amber-500 w-9 h-9 rounded-full text-white hover:bg-amber-600 transition flex items-center justify-center">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
            </form>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php if (empty($items)): ?>
                <div class="lg:col-span-4 text-center py-10 text-stone-500">
                    <i class="fas fa-exclamation-circle text-4xl mb-4"></i>
                    <p>Không tìm thấy món ăn nào phù hợp với điều kiện tìm kiếm/lọc.</p>
                </div>
            <?php else: ?>
                <?php foreach($items as $item): ?>
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden border border-stone-100 flex flex-col h-full">
                    <div class="h-56 overflow-hidden relative">
                        <img src="<?php echo $item['hinhanh']; ?>" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/300'">
                        <span class="absolute top-3 right-3 bg-black/70 backdrop-blur text-white text-[10px] font-bold px-2 py-1 rounded uppercase">
                            <?php echo $item['danhmuc']; ?>
                        </span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="font-bold text-lg text-stone-900 mb-1 line-clamp-1"><?php echo $item['tenmon']; ?></h3>
                        <p class="text-sm text-stone-500 mb-4 line-clamp-2 flex-1"><?php echo $item['mota']; ?></p>
                        
                        <div class="flex justify-between items-center pt-4 mt-auto border-t border-stone-100">
                            <span class="text-xl font-bold text-amber-600"><?php echo number_format($item['gia']); ?>đ</span>
                            
                            <form method="POST">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="name" value="<?php echo $item['tenmon']; ?>">
                                <input type="hidden" name="price" value="<?php echo $item['gia']; ?>">
                                <input type="hidden" name="img" value="<?php echo $item['hinhanh']; ?>">
                                <button type="submit" name="add_to_cart" class="w-8 h-8 rounded-full bg-stone-100 text-stone-600 hover:bg-amber-600 hover:text-white transition flex items-center justify-center">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require 'footer.php.php'; ?>