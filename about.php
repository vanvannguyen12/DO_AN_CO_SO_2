<?php 
require 'config.php';
require 'header.php';
?>

<div class="bg-stone-50 min-h-screen animate-fade-in">
    <div class="relative h-[600px] flex items-center justify-center text-center text-white overflow-hidden">
        <div class="absolute inset-0 w-full h-full bg-cover bg-fixed bg-center" style="background-image: url('https://images.unsplash.com/photo-1544148103-60c7f2122396?w=1600&q=80&auto=format&fit=crop'); background-attachment: fixed;"></div>
        <div class="absolute inset-0 bg-stone-900/70"></div>
        
        <div class="relative z-10 px-4 max-w-4xl pt-20">
            <span class="text-amber-400 font-serif tracking-widest uppercase text-lg mb-4 block animate-slide-up">Hương vị của sự tận tâm</span>
            <h1 class="text-6xl md:text-8xl font-extrabold mb-6 leading-tight font-serif italic text-shadow-lg animate-fade-in-slow">
                Câu Chuyện Đam Mê Ẩm Thực
            </h1>
            <p class="text-xl md:text-2xl mb-10 text-stone-200 font-light max-w-3xl mx-auto">
                Khám phá triết lý ẩm thực độc đáo của Hương Việt, nơi truyền thống giao thoa cùng sự sáng tạo hiện đại.
            </p>
            <a href="#mission" class="inline-block border-2 border-white text-white px-8 py-3 rounded-full font-bold hover:bg-white hover:text-stone-900 transition duration-300">
                Khám phá ngay <i class="fas fa-arrow-down ml-2"></i>
            </a>
        </div>
    </div>

    <section id="mission" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-5xl font-bold text-center mb-16 text-stone-900 font-serif border-b-4 border-amber-500/50 inline-block mx-auto pb-2">Triết Lý Cốt Lõi</h2>
            
            <div class="grid md:grid-cols-2 gap-12">
                
                <div class="p-10 bg-stone-50 rounded-2xl shadow-2xl border-l-8 border-amber-600 transform hover:scale-[1.02] transition duration-500">
                    <i class="fas fa-handshake text-5xl text-amber-600 mb-6"></i>
                    <h3 class="text-3xl font-bold mb-4 text-stone-800 font-serif">Sứ Mệnh</h3>
                    <p class="text-stone-600 leading-relaxed text-lg">
                        Gìn giữ và tôn vinh tinh hoa ẩm thực Việt Nam thông qua những trải nghiệm ẩm thực độc đáo và chất lượng vượt trội. Chúng tôi cam kết sử dụng nguyên liệu tươi sạch, nuôi dưỡng văn hóa ẩm thực bền vững.
                    </p>
                </div>
                
                <div class="p-10 bg-stone-50 rounded-2xl shadow-2xl border-l-8 border-emerald-600 transform hover:scale-[1.02] transition duration-500">
                    <i class="fas fa-bullseye text-5xl text-emerald-600 mb-6"></i>
                    <h3 class="text-3xl font-bold mb-4 text-stone-800 font-serif">Tầm Nhìn</h3>
                    <p class="text-stone-600 leading-relaxed text-lg">
                        Trở thành nhà hàng ẩm thực Việt hàng đầu khu vực, là biểu tượng của sự sang trọng, sáng tạo và sự phục vụ tận tâm. Nơi khách hàng cảm nhận được sự khác biệt trong từng khoảnh khắc.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-stone-900 text-white">
        <div class="container mx-auto px-4 grid md:grid-cols-2 gap-16 items-center">
            
            <div>
                <span class="text-amber-400 font-bold tracking-widest uppercase text-sm mb-3 block">Chất lượng là danh dự</span>
                <h2 class="text-4xl font-bold mb-6 text-white font-serif">Nghệ Thuật Ẩm Thực Tinh Tế</h2>
                <p class="text-stone-300 mb-6 leading-relaxed text-lg">
                    Mỗi món ăn tại Hương Việt là một tác phẩm nghệ thuật, được tạo nên bởi sự kết hợp hoàn hảo giữa công thức truyền thống và kỹ thuật chế biến hiện đại. Chúng tôi tuyển chọn nguyên liệu mỗi ngày từ các trang trại hữu cơ, đảm bảo sự tươi ngon và an toàn tuyệt đối.
                </p>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center text-stone-200 font-medium"><i class="fas fa-check-circle text-amber-500 mr-3 text-xl"></i> Nguyên liệu Organic và đạt chuẩn quốc tế</li>
                    <li class="flex items-center text-stone-200 font-medium"><i class="fas fa-check-circle text-amber-500 mr-3 text-xl"></i> Không gian được thiết kế bởi kiến trúc sư danh tiếng</li>
                    <li class="flex items-center text-stone-200 font-medium"><i class="fas fa-check-circle text-amber-500 mr-3 text-xl"></i> Đội ngũ phục vụ được đào tạo theo tiêu chuẩn 5 sao</li>
                </ul>
                <a href="menu.php" class="px-8 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-full font-bold transition shadow-lg inline-flex items-center">
                    Khám Phá Menu <i class="fas fa-utensils ml-3"></i>
                </a>
            </div>
            
            <div class="relative group">
                <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?w=800&q=80&auto=format&fit=crop" class="rounded-2xl shadow-2xl w-full object-cover h-[450px] transform group-hover:rotate-1 transition duration-700">
                <div class="absolute -inset-2 bg-amber-500 rounded-2xl opacity-10 transform translate-x-4 translate-y-4 group-hover:translate-x-2 group-hover:translate-y-2 transition duration-500 -z-0"></div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-stone-50">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-4 text-stone-800 font-serif">Gặp Gỡ Những Bậc Thầy Ẩm Thực</h2>
            <p class="text-stone-500 mb-12 max-w-2xl mx-auto">Đội ngũ đầu bếp của chúng tôi là linh hồn của nhà hàng, những người biến nguyên liệu thành trải nghiệm.</p>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-xl p-8 transform hover:shadow-3xl transition duration-500 border-b-4 border-red-500">
                    <img src="Nguyenthihuyentram.jpg" alt="Đầu bếp 1" class="w-32 h-32 rounded-full mx-auto object-cover mb-4 border-4 border-white shadow-md">
                    <h4 class="text-2xl font-bold text-stone-900 font-serif">Nguyễn Thị Huyên Trâm</h4>
                    <p class="text-amber-600 mb-3 font-semibold">Bếp Trưởng Điều Hành</p>
                    <p class="text-sm text-stone-600 italic">"Ẩm thực là sự kết nối giữa trái tim và văn hóa."</p>
                </div>
                <div class="bg-white rounded-xl shadow-xl p-8 transform hover:shadow-3xl transition duration-500 border-b-4 border-green-500">
                    <img src="Nguyenthicamvann.jpg" alt="Đầu bếp 2" class="w-32 h-32 rounded-full mx-auto object-cover mb-4 border-4 border-white shadow-md">
                    <h4 class="text-2xl font-bold text-stone-900 font-serif">Nguyễn Thị Cẩm Vân</h4>
                    <p class="text-amber-600 mb-3 font-semibold">Chuyên gia Bánh </p>
                    <p class="text-sm text-stone-600 italic">"Sáng tạo không ngừng để mang lại hương vị bất ngờ."</p>
                </div>
                <div class="bg-white rounded-xl shadow-xl p-8 transform hover:shadow-3xl transition duration-500 border-b-4 border-blue-500">
                    <img src="Nguyenthinhutram.jpg" alt="Đầu bếp 3" class="w-32 h-32 rounded-full mx-auto object-cover mb-4 border-4 border-white shadow-md">
                    <h4 class="text-2xl font-bold text-stone-900 font-serif">Nguyễn Thị Như Trâm</h4>
                    <p class="text-amber-600 mb-3 font-semibold">Trưởng casual</p>
                    <p class="text-sm text-stone-600 italic">"Tận tâm tận tình vì khách hàng."</p>
                </div>
            </div>
        </div>
    </section>

</div>

<?php require 'footer.php.php'; ?>