<?php
require_once 'includes/header.php';
?>

<main class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Tez-tez so'raladigan savollar</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Qiziltepa Akademik Kutubxonasi haqida eng ko'p so'raladigan savollar va javoblar
            </p>
        </div>

        <!-- FAQ Categories -->
        <div class="mb-8">
            <div class="flex flex-wrap justify-center gap-4">
                <button onclick="showCategory('general')" class="faq-btn active bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                    Umumiy savollar
                </button>
                <button onclick="showCategory('membership')" class="faq-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">
                    A'zolik
                </button>
                <button onclick="showCategory('borrowing')" class="faq-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">
                    Kitob olish
                </button>
                <button onclick="showCategory('digital')" class="faq-btn bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition duration-300">
                    Raqamli xizmatlar
                </button>
            </div>
        </div>

        <!-- FAQ Content -->
        <div id="faq-content">
            <!-- General Questions -->
            <div id="general" class="faq-category">
                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow-md">
                        <button class="faq-question w-full text-left p-6 focus:outline-none" onclick="toggleAnswer(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Kutubxona qachon ochiq?</h3>
                                <i class="fas fa-chevron-down text-gray-500 transform transition-transform"></i>
                            </div>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6">
                            <p class="text-gray-700">
                                Kutubxona dushanba-jumadan 08:00 dan 18:00 gacha, shanbada 09:00 dan 15:00 gacha ishlaydi. 
                                Yakshanba kuni dam olish kuni. Bayram kunlari maxsus jadval bo'yicha ishlaymiz.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md">
                        <button class="faq-question w-full text-left p-6 focus:outline-none" onclick="toggleAnswer(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Kutubxona qayerda joylashgan?</h3>
                                <i class="fas fa-chevron-down text-gray-500 transform transition-transform"></i>
                            </div>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6">
                            <p class="text-gray-700">
                                Kutubxona Qiziltepa shahar markazida, Mustaqillik ko'chasi 123-uyda joylashgan. 
                                Shahar hokimiyati binosi yonida.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md">
                        <button class="faq-question w-full text-left p-6 focus:outline-none" onclick="toggleAnswer(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Kutubxonada nechta kitob bor?</h3>
                                <i class="fas fa-chevron-down text-gray-500 transform transition-transform"></i>
                            </div>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6">
                            <p class="text-gray-700">
                                Hozirgi vaqtda kutubxonamizda 50,000 dan ortiq kitob mavjud. Buning ichida 
                                badiy adabiyot, ilmiy kitoblar, o'quv qo'llanmalar va bolalar adabiyoti kiradi.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md">
                        <button class="faq-question w-full text-left p-6 focus:outline-none" onclick="toggleAnswer(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Wi-Fi bepulmi?</h3>
                                <i class="fas fa-chevron-down text-gray-500 transform transition-transform"></i>
                            </div>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6">
                            <p class="text-gray-700">
                                Ha, kutubxonamizda barcha foydalanuvchilar uchun bepul Wi-Fi mavjud. 
                                Ulanish uchun kutubxona xodimlaridan parol so'rang.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Membership Questions -->
            <div id="membership" class="faq-category hidden">
                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow-md">
                        <button class="faq-question w-full text-left p-6 focus:outline-none" onclick="toggleAnswer(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Qanday qilib a'zo bo'lish mumkin?</h3>
                                <i class="fas fa-chevron-down text-gray-500 transform transition-transform"></i>
                            </div>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6">
                            <p class="text-gray-700">
                                A'zo bo'lish uchun pasport bilan kutubxonaga kelib, ro'yxatdan o'tish formasini 
                                to'ldiring. Shuningdek, onlayn ro'yxatdan o'tish ham mumkin.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md">
                        <button class="faq-question w-full text-left p-6 focus:outline-none" onclick="toggleAnswer(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">A'zolik to'lovi bormi?</h3>
                                <i class="fas fa-chevron-down text-gray-500 transform transition-transform"></i>
                            </div>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6">
                            <p class="text-gray-700">
                                Yo'q, kutubxona a'zoligi mutlaqo bepul. Faqat kitoblarni kechiktirish 
                                yoki yo'qotish uchun jarima to'lanadi.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md">
                        <button class="faq-question w-full text-left p-6 focus:outline-none" onclick="toggleAnswer(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Chet elliklar a'zo bo'lishi mumkinmi?</h3>
                                <i class="fas fa-chevron-down text-gray-500 transform transition-transform"></i>
                            </div>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6">
                            <p class="text-gray-700">
                                Ha, chet el fuqarolari ham kutubxona a'zosi bo'lishi mumkin. 
                                Buning uchun pasport va O'zbekistonda yashash hujjati kerak.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Borrowing Questions -->
            <div id="borrowing" class="faq-category hidden">
                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow-md">
                        <button class="faq-question w-full text-left p-6 focus:outline-none" onclick="toggleAnswer(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Nechta kitob olish mumkin?</h3>
                                <i class="fas fa-chevron-down text-gray-500 transform transition-transform"></i>
                            </div>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6">
                            <p class="text-gray-700">
                                Har bir foydalanuvchi bir vaqtning o'zida maksimal 5 ta kitob olishi mumkin. 
                                Talabalar uchun bu raqam 3 ta kitobgacha cheklangan.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md">
                        <button class="faq-question w-full text-left p-6 focus:outline-none" onclick="toggleAnswer(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Kitoblarni qancha muddat saqlash mumkin?</h3>
                                <i class="fas fa-chevron-down text-gray-500 transform transition-transform"></i>
                            </div>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6">
                            <p class="text-gray-700">
                                Kitoblarni 30 kun muddat saqlash mumkin. Zarurat bo'lsa, 1 marta 
                                15 kunga uzaytirish imkoniyati mavjud.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md">
                        <button class="faq-question w-full text-left p-6 focus:outline-none" onclick="toggleAnswer(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Kitobni kechiktirish uchun jarima qancha?</h3>
                                <i class="fas fa-chevron-down text-gray-500 transform transition-transform"></i>
                            </div>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6">
                            <p class="text-gray-700">
                                Har bir kechiktirilgan kun uchun 1,000 so'm jarima to'lanadi. 
                                Kitobni yo'qotish uchun kitob qiymatining 3 baravari to'lanadi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Digital Services Questions -->
            <div id="digital" class="faq-category hidden">
                <div class="space-y-4">
                    <div class="bg-white rounded-lg shadow-md">
                        <button class="faq-question w-full text-left p-6 focus:outline-none" onclick="toggleAnswer(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Elektron kitoblar qanday olinadi?</h3>
                                <i class="fas fa-chevron-down text-gray-500 transform transition-transform"></i>
                            </div>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6">
                            <p class="text-gray-700">
                                Elektron kitoblarni veb-sayt orqali yuklab olish mumkin. Buning uchun 
                                kutubxona a'zosi bo'lish va tizimga kirish kerak.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md">
                        <button class="faq-question w-full text-left p-6 focus:outline-none" onclick="toggleAnswer(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Onlayn katalog qanday ishlaydi?</h3>
                                <i class="fas fa-chevron-down text-gray-500 transform transition-transform"></i>
                            </div>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6">
                            <p class="text-gray-700">
                                Onlayn katalog orqali kitoblarni qidirish, bron qilish va o'z hisobingizni 
                                boshqarish mumkin. Katalog 24/7 ishlaydi.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md">
                        <button class="faq-question w-full text-left p-6 focus:outline-none" onclick="toggleAnswer(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Mobil ilova bormi?</h3>
                                <i class="fas fa-chevron-down text-gray-500 transform transition-transform"></i>
                            </div>
                        </button>
                        <div class="faq-answer hidden px-6 pb-6">
                            <p class="text-gray-700">
                                Hozircha mobil ilova yo'q, lekin veb-sayt mobil qurilmalarga moslashtirilgan. 
                                Mobil ilova ustida ishlamoqdamiz.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact for More Questions -->
        <div class="mt-12 bg-blue-50 p-8 rounded-lg text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Boshqa savollar bormi?</h2>
            <p class="text-gray-600 mb-6">
                Agar sizning savolingiz ro'yxatda bo'lmasa, biz bilan bog'laning
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="contact.php" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-envelope mr-2"></i>Xabar yuborish
                </a>
                <a href="tel:+998791234567" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-300">
                    <i class="fas fa-phone mr-2"></i>Qo'ng'iroq qilish
                </a>
            </div>
        </div>
    </div>
</main>

<script>
function showCategory(categoryId) {
    // Hide all categories
    const categories = document.querySelectorAll('.faq-category');
    categories.forEach(category => category.classList.add('hidden'));
    
    // Show selected category
    document.getElementById(categoryId).classList.remove('hidden');
    
    // Update button styles
    const buttons = document.querySelectorAll('.faq-btn');
    buttons.forEach(btn => {
        btn.classList.remove('bg-blue-600', 'text-white');
        btn.classList.add('bg-gray-200', 'text-gray-700');
    });
    
    // Highlight active button
    event.target.classList.remove('bg-gray-200', 'text-gray-700');
    event.target.classList.add('bg-blue-600', 'text-white');
}

function toggleAnswer(button) {
    const answer = button.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (answer.classList.contains('hidden')) {
        answer.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        answer.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>

<?php require_once 'includes/footer.php'; ?>