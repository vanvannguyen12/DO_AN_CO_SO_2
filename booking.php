<?php 
require 'config.php';
require 'header.php';


$msg = "";
$booking_info = null;
// booking.php (Code mới)
$total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['qty'];
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];
    $note = $_POST['note'];
    $order_details = "Không đặt món trước.";
    // THÊM CỘT STATUS VÀ ĐẶT LÀ 'confirmed'
    $status = 'confirmed'; 

$order_details = "Không đặt món trước."; // Giá trị mặc định
    
    if (!empty($_SESSION['cart'])) {
        $details = [];
        $total_items = 0;
        foreach ($_SESSION['cart'] as $item) {
            $details[] = $item['name'] . " x" . $item['qty'];
            $total_items += $item['qty'];
        }
        $order_details = implode(", ", $details);
        $note = "Đã đặt trước: " . $order_details . ($note ? "\n--- Ghi chú thêm: " . $note : "");
        
        unset($_SESSION['cart']); 
    }

    $stmt = $conn->prepare("INSERT INTO datban (ten, sdt, email, ngay, gio, soluong, ghichu, trangthai, order_details) VALUES (?, ?,?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt->execute([$name, $phone,$email, $date, $time, $guests, $note, $status, $order_details])) {
        // ... (Giữ nguyên logic session và redirect để hiển thị thông báo thành công cho khách hàng)
        $_SESSION['last_booking'] = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'date' => $date,
            'time' => $time,
            'guests' => $guests,
            'note' => $note,
            'order_details' => $order_details
        ];
        header("Location: booking.php?success=1");
        exit;
    }
}

// Kiểm tra và lấy thông tin đặt bàn nếu có, sau đó xóa khỏi session
if (isset($_SESSION['last_booking']) && isset($_GET['success'])) {
    $booking_info = $_SESSION['last_booking'];
    // Xóa khỏi session sau khi lấy để lần truy cập sau hiển thị form
    unset($_SESSION['last_booking']);
}
?>

<div class="container mx-auto px-4 py-12 grid md:grid-cols-2 gap-12 animate-fade-in min-h-[80vh] items-center">
    <div>
        <h2 class="text-4xl font-bold text-stone-800 mb-4">Đặt Bàn Trực Tuyến</h2>
        <p class="text-stone-600 mb-8 text-lg">Vui lòng điền thông tin bên dưới để chúng tôi chuẩn bị chu đáo nhất cho bữa ăn của bạn.</p>
        
        <div class="bg-amber-50 p-6 rounded-2xl mb-8 border border-amber-100 shadow-sm">
            <h3 class="font-bold text-amber-800 mb-3 flex items-center"><i class="fas fa-info-circle mr-2"></i> Lưu ý</h3>
            <ul class="text-sm text-amber-900 space-y-2 list-disc list-inside">
                <li>Vui lòng đặt trước ít nhất 2 giờ.</li>
                <li>Giữ bàn tối đa 15 phút sau giờ hẹn.</li>
                <li>Đoàn trên 20 người vui lòng liên hệ hotline.</li>
            </ul>
        </div>
        
        <img src="https://scontent.fdad1-2.fna.fbcdn.net/v/t39.30808-6/523099072_1365128168952271_2745612801021442221_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=833d8c&_nc_eui2=AeFhPJHQWtKPLy76bTJsL9LnN17TbSDZLt43XtNtINku3ql4VhO4eLNtETnTHKCvq2eHYDZPzOuxvuUBQwb0f_h6&_nc_ohc=mdaKUDcG34QQ7kNvwHbtnPS&_nc_oc=AdnKYx-dFxrCeg_kZhgizvr0JHz9rLCJTFYuuDVmBrSPun0avu_MQ73Dk9hvY0EBTc4&_nc_zt=23&_nc_ht=scontent.fdad1-2.fna&_nc_gid=slWAeQiIwgaY7UbvhSc6iw&oh=00_AfgDBv1DXimghnz4QD-janEgO3v9gIrOCxBf10qqNTX5UA&oe=6925FFEB" class="rounded-2xl shadow-xl w-full h-96 object-cover hidden md:block">
    </div>

    <div class="bg-white p-8 rounded-3xl shadow-xl border border-stone-100">
        <?php if($booking_info): ?>
            <div class='bg-green-100 text-green-800 p-4 rounded-lg mb-6 flex items-center'><i class='fas fa-check-circle mr-2'></i> Đặt bàn thành công! Thông tin của bạn:</div>
            
            <div class="space-y-4 p-4 border border-green-200 rounded-xl bg-white shadow-inner">
                <h3 class="text-xl font-bold text-stone-800 border-b pb-2 mb-2">Thông Tin Đặt Bàn</h3>
                <p class="flex justify-between"><strong>Tên khách hàng:</strong> <span class="text-stone-700"><?php echo htmlspecialchars($booking_info['name']); ?></span></p>
                <p class="flex justify-between"><strong>Số điện thoại:</strong> <span class="text-stone-700"><?php echo htmlspecialchars($booking_info['phone']); ?></span></p>
                <p class="flex justify-between"><strong>Email:</strong> <span class="text-stone-700"><?php echo htmlspecialchars($booking_info['email']); ?></span></p>
                <p class="flex justify-between"><strong>Thời gian:</strong> <span class="text-amber-600 font-bold"><?php echo htmlspecialchars(date('d/m/Y', strtotime($booking_info['date']))) . ' lúc ' . htmlspecialchars($booking_info['time']); ?></span></p>
                <p class="flex justify-between"><strong>Số lượng khách:</strong> <span class="text-stone-700"><?php echo htmlspecialchars($booking_info['guests']); ?> người</span></p>
                <?php if ($booking_info['order_details'] != 'Không đặt món trước.'): ?>
                <div class="pt-4 mt-4 border-t border-stone-200">
                    <strong>Món đã đặt trước:</strong> 
                    <p class="text-sm text-stone-700 italic mt-1"><?php echo nl2br(htmlspecialchars($booking_info['order_details'])); ?></p>
                </div>
                <?php endif; ?>
               
                <?php if (!empty($booking_info['note'])): ?>
                    <p><strong>Ghi chú:</strong> <span class="text-stone-700 italic"><?php echo nl2br(htmlspecialchars($booking_info['note'])); ?></span></p>
                <?php endif; ?>
                <a href="index.php" class="mt-4 block text-center bg-amber-600 text-white font-bold py-3 rounded-xl hover:bg-amber-700 transition">Quay về Trang Chủ</a>
            </div>

        <?php else: ?>
            <?php echo $msg; // Nếu có lỗi SQL, nó sẽ hiển thị ở đây ?>
            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-1">Họ và Tên</label>
                    <input type="text" name="name" required class="w-full p-3 bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 outline-none transition" placeholder="Nguyễn Văn A">
                </div>
                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-1">Số Điện Thoại</label>
                    <input type="text" name="phone" required class="w-full p-3 bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 outline-none transition" placeholder="090...">
                </div>
                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-1">Email</label>
                    <input type="email" name="email" required class="w-full p-3 bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 outline-none transition" placeholder="example@gmail.com">
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1">Ngày</label>
                        <input type="date" name="date" required class="w-full p-3 bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1">Giờ</label>
                        <input type="time" name="time" required class="w-full p-3 bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-stone-700 mb-1">Khách</label>
                        <input type="number" name="guests" value="2" min="1" class="w-full p-3 bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 outline-none transition font-bold text-center">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-stone-700 mb-1">Ghi chú (Tùy chọn)</label>
                    <textarea name="note" rows="3" class="w-full p-3 bg-stone-50 border border-stone-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 outline-none transition" placeholder="Yêu cầu ghế trẻ em, dị ứng..."></textarea>
                </div>

                <button type="submit" class="w-full bg-amber-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-amber-700 transition transform hover:-translate-y-1">
                    Xác Nhận Đặt Bàn
                </button>
                <div class="lg:w-1/3">
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-stone-100 sticky top-24 text-center">
                    <h3 class="font-bold text-xl text-stone-800 mb-4">Tổng Cộng:</h3>
                    <div class="flex justify-between text-3xl font-bold mb-6 pb-6 border-b border-stone-100">
                        <span></span>
                        <span class="text-amber-600"><?php echo number_format($total); ?> đ</span>
                    </div>
                    
                    <p class="text-sm text-stone-600 mb-4">Giỏ hàng này sẽ được đính kèm vào đơn đặt bàn của bạn.</p>
                    
                    <a href="booking.php" class="w-full bg-amber-600 text-white font-bold py-4 rounded-xl hover:bg-amber-700 transition shadow-lg inline-block">
                        Tiếp Tục Đặt Bàn
                    </a>
                </div>
            </div>
            </form>
        <?php endif; ?>
    </div>
</div>
<?php require 'footer.php.php'; ?>