<?php 
require 'config.php';
require 'header.php';
?>

<div class="animate-fade-in">
    <div class="bg-stone-900 text-white py-16 text-center">
        <h1 class="text-4xl font-bold mb-2">Liên Hệ Với Chúng Tôi</h1>
        <p class="text-stone-300">Chúng tôi luôn sẵn sàng lắng nghe bạn!</p>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="grid lg:grid-cols-2 gap-12">
            <div>
                <h2 class="text-3xl font-bold text-amber-600 mb-6">Thông Tin Chi Tiết</h2>
                <ul class="space-y-6 text-lg text-stone-700">
                    <li class="flex items-center gap-4">
                        <i class="fas fa-map-marker-alt text-2xl text-amber-600"></i>
                        <div>
                            <span class="font-bold block">Địa Chỉ:</span>
                            470 Trần Đại Nghĩa, Ngũ Hành Sơn, Đà Nẵng
                        </div>
                    </li>
                    <li class="flex items-center gap-4">
                        <i class="fas fa-phone text-2xl text-amber-600"></i>
                        <div>
                            <span class="font-bold block">Điện Thoại:</span>
                            <a href="tel:0901234567" class="hover:text-amber-700">0909 1122 443</a>
                        </div>
                    </li>
                    <li class="flex items-center gap-4">
                        <i class="fas fa-envelope text-2xl text-amber-600"></i>
                        <div>
                            <span class="font-bold block">Email:</span>
                            <a href="mailto:contact@huongviet.com" class="hover:text-amber-700">contact@huongviet.com</a>
                        </div>
                    </li>
                    <li class="flex items-center gap-4">
                        <i class="fas fa-clock text-2xl text-amber-600"></i>
                        <div>
                            <span class="font-bold block">Giờ Mở Cửa:</span>
                            9:00 - 22:00 (Hàng ngày)
                        </div>
                    </li>
                </ul>
            </div>
            
            <div>
                <h2 class="text-3xl font-bold text-amber-600 mb-6">Vị Trí Của Chúng Tôi</h2>
                <div class="relative w-full h-96 border-4 border-stone-200 rounded-xl overflow-hidden shadow-xl">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3835.7295115689712!2d108.24969041071259!3d15.97549578462668!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31421088d956ac8d%3A0x1c7f56e40c8525c7!2zNDcwIFRy4bqnbiDEkOG6oWkgTmdoxKlhLCBOZ8WpIEjDoG5oIFPGoW4sIMSQw6AgTuG6tW5nIDU1MDAwMCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1763711048953!5m2!1svi!2s" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                </div>
        </div>
    </div>
</div>

<?php 
require 'footer.php.php'; // Đảm bảo đúng tên file footer
?>