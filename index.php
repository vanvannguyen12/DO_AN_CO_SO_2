<?php 
require 'config.php';
require 'header.php';

// Lấy 3 món nổi bật
$stmt = $conn->prepare("SELECT * FROM menu LIMIT 3"); // Bạn có thể thêm WHERE is_featured=1
$stmt->execute();
$featured_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="animate-fade-in">
    <div class="relative h-[600px] flex items-center justify-center text-center text-white bg-black overflow-hidden">
        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1600&q=80" class="absolute inset-0 w-full h-full object-cover opacity-60 hover:scale-105 transition duration-[20s]">
        <div class="relative z-10 px-4 max-w-3xl">
            <span class="text-amber-400 font-bold tracking-widest uppercase text-sm mb-4 block">Chào mừng đến với Hương Việt</span>
            <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">Trải Nghiệm Ẩm Thực <br/> Đẳng Cấp</h1>
            <p class="text-lg md:text-xl mb-10 text-stone-200 font-light">Hương vị truyền thống, không gian hiện đại. Nơi cảm xúc thăng hoa.</p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <a href="booking.php" class="px-8 py-4 bg-amber-600 hover:bg-amber-700 text-white rounded-full font-bold transition shadow-lg transform hover:scale-105">
                    Đặt Bàn Ngay
                </a>
                <a href="menu.php" class="px-8 py-4 bg-white hover:bg-stone-100 text-stone-900 rounded-full font-bold transition shadow-lg">
                    Xem Thực Đơn
                </a>
            </div>
        </div>
    </div>
<section class="py-20 bg-white">
        <div class="container mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">
            <div class="relative">
                <div class="absolute -inset-4 bg-amber-100 rounded-2xl transform -rotate-2"></div>
                <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?w=800&q=80" class="relative rounded-2xl shadow-2xl w-full object-cover h-[400px]">
            </div>
            <div>
                <h2 class="text-4xl font-bold mb-6 text-stone-800 font-serif">Về Nhà Hàng Chúng Tôi</h2>
                <p class="text-stone-600 mb-6 leading-relaxed text-lg">
                    Tìm hiểu sâu hơn về triết lý ẩm thực, tầm nhìn và đội ngũ đầu bếp tài năng của Hương Việt. Nơi chúng tôi biến đam mê thành nghệ thuật phục vụ, với cam kết về chất lượng và sự phục vụ tận tâm.
                </p>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center text-stone-700 font-medium"><i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i> Câu chuyện về Tinh hoa Ẩm thực Việt</li>
                    <li class="flex items-center text-stone-700 font-medium"><i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i> Sứ mệnh chất lượng và sự phục vụ</li>
                    <li class="flex items-center text-stone-700 font-medium"><i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i> Gặp gỡ đội ngũ chuyên nghiệp</li>
                </ul>
                <a href="about.php" class="px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full font-bold transition shadow-lg transform hover:scale-105 inline-flex items-center">
                    Xem Chi Tiết Giới Thiệu <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 bg-stone-100">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-4 text-stone-800">Món Ăn Nổi Bật</h2>
            <p class="text-stone-500 mb-12 max-w-2xl mx-auto">Những lựa chọn tuyệt vời nhất được thực khách yêu thích.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach($featured_items as $item): ?>
                <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-2xl transition duration-300 group text-left">
                    <div class="h-64 overflow-hidden relative">
                       <img src="<?php echo $item['hinhanh']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider shadow-sm">
                            <?php echo $item['danhmuc']; ?>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-stone-900 group-hover:text-amber-600 transition"><?php echo $item['tenmon']; ?></h3>
                        </div>
                        <p class="text-stone-500 mb-6 line-clamp-2 text-sm"><?php echo $item['mota']; ?></p>
                        <div class="flex items-center justify-between pt-4 border-t border-stone-100">
                            <span class="text-2xl font-bold text-amber-600"><?php echo number_format($item['gia']); ?>đ</span>
                            <a href="menu.php" class="w-10 h-10 rounded-full bg-stone-100 text-stone-600 flex items-center justify-center hover:bg-amber-600 hover:text-white transition">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-12">
                <a href="menu.php" class="inline-flex items-center text-amber-700 font-bold hover:text-amber-900 tracking-wide uppercase text-sm">
                    Xem toàn bộ thực đơn <i class="fas fa-long-arrow-alt-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>
</div>

<?php require 'footer.php.php'; ?>