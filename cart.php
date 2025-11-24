<?php
require 'config.php';
require 'header.php';

// Xử lý xóa
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php"); exit;
}

// Checkout
$msg = "";
if (isset($_POST['checkout']) && !empty($_SESSION['cart'])) {
    $total = 0; $details = [];
    foreach($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['qty'];
        $details[] = $item['name'] . " x" . $item['qty'];
    }
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_phone, total_price, order_details) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$_POST['name'], $_POST['phone'], $total, implode(", ", $details)])) {
        unset($_SESSION['cart']);
        $msg = "<div class='bg-green-100 text-green-800 p-4 rounded mb-4'>✅ Đặt hàng thành công!</div>";
    }
}
?>

<div class="container mx-auto px-4 py-12 min-h-[60vh]">
    <h1 class="text-3xl font-bold text-stone-800 mb-8">Giỏ Hàng Của Bạn</h1>
    <?php echo $msg; ?>

    <?php if (empty($_SESSION['cart'])): ?>
        <div class="text-center py-16 bg-stone-50 rounded-2xl border border-stone-100">
            <i class="fas fa-shopping-basket text-6xl text-stone-200 mb-4"></i>
            <p class="text-stone-500 mb-6">Giỏ hàng đang trống.</p>
            <a href="menu.php" class="bg-amber-600 text-white px-6 py-3 rounded-full font-bold hover:bg-amber-700 transition">Quay lại thực đơn</a>
        </div>
    <?php else: ?>
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-2/3 bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-stone-50 text-stone-600 font-bold text-sm uppercase">
                        <tr><th class="p-4">Món ăn</th><th class="p-4">Giá</th><th class="p-4 text-center">SL</th><th class="p-4 text-right">Tổng</th><th class="p-4"></th></tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        <?php $total = 0; foreach($_SESSION['cart'] as $id => $item): $sub = $item['price']*$item['qty']; $total += $sub; ?>
                        <tr>
                            <td class="p-4 font-bold text-stone-800"><?php echo $item['name']; ?></td>
                            <td class="p-4 text-stone-500"><?php echo number_format($item['price']); ?></td>
                            <td class="p-4 text-center"><span class="px-3 py-1 bg-stone-100 rounded-full text-sm font-bold"><?php echo $item['qty']; ?></span></td>
                            <td class="p-4 text-right font-bold text-amber-600"><?php echo number_format($sub); ?></td>
                            <td class="p-4 text-right"><a href="?remove=<?php echo $id; ?>" class="text-stone-300 hover:text-red-500"><i class="fas fa-trash"></i></a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
        </div>
    <?php endif; ?>
</div>
<?php require 'footer.php.php'; ?>