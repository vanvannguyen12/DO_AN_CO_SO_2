<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhà Hàng Hương Việt - Luxury</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-stone-50 text-stone-800 min-h-screen flex flex-col">

<nav class="bg-white/95 backdrop-blur-sm sticky top-0 z-40 border-b border-stone-200 shadow-sm">
    <div class="container mx-auto px-4 h-16 flex items-center justify-between">
        <a href="index.php" class="flex items-center space-x-2 group">
            <i class="fas fa-hat-chef text-3xl text-amber-600 group-hover:rotate-12 transition"></i>
            <span class="text-xl font-bold tracking-tight text-stone-900">Nhà Hàng <span class="text-amber-600">Hương Việt</span></span>
        </a>

      <div class="hidden md:flex items-center space-x-8 font-medium text-sm text-stone-600">
    <a href="index.php" class="hover:text-amber-600 transition">Trang Chủ</a>
    <a href="menu.php" class="hover:text-amber-600 transition">Thực Đơn</a>
    <a href="contact.php" class="hover:text-amber-600 transition">Liên Hệ</a>
    
    <?php 
    $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    ?>
    <a href="cart.php" class="hover:text-amber-600 transition relative">
        <i class="fas fa-shopping-bag text-lg"></i>
        <?php if($cart_count > 0): ?>
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] w-4 h-4 flex items-center justify-center rounded-full"><?php echo $cart_count; ?></span>
        <?php endif; ?>
    </a>
   <a href="admin.php" class="hover:text-amber-600 transition" title="Đăng nhập Admin">
        <i class="fas fa-user-shield text-lg"></i>
    </a>
    <a href="booking.php" class="bg-amber-600 text-white px-4 py-2 rounded-full font-bold hover:bg-amber-700 transition">Đặt Bàn</a>
</div>
    </div>
</nav>