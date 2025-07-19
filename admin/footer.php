<!-- Footer -->
<footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <h3 class="text-lg font-semibold mb-4"><?php echo translate('about'); ?></h3>
                    <p class="text-gray-300 mb-4">
                        <?php echo translate('library_name'); ?> - zamonaviy kutubxona xizmatlari va elektron resurslar.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Tezkor havolalar</h3>
                    <ul class="space-y-2">
                        <li><a href="../catalog.php" class="text-gray-300 hover:text-white transition duration-300"><?php echo translate('catalog'); ?></a></li>
                        <li><a href="../services.php" class="text-gray-300 hover:text-white transition duration-300"><?php echo translate('services'); ?></a></li>
                        <li><a href="../news.php" class="text-gray-300 hover:text-white transition duration-300"><?php echo translate('news'); ?></a></li>
                        <li><a href="../events.php" class="text-gray-300 hover:text-white transition duration-300"><?php echo translate('events'); ?></a></li>
                        <li><a href="../faq.php" class="text-gray-300 hover:text-white transition duration-300">FAQ</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4"><?php echo translate('contact'); ?></h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-3 text-blue-400"></i>
                            <span class="text-gray-300">Navoiy shahar, O'zbekiston</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone mr-3 text-blue-400"></i>
                            <span class="text-gray-300">+998 90 123 45 67</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-blue-400"></i>
                            <span class="text-gray-300">info@library.uz</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-3 text-blue-400"></i>
                            <span class="text-gray-300">Dush-Juma: 08:00-18:00</span>
                        </div>
                    </div>
                </div>

                <!-- Opening Hours -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Ish vaqti</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-300">Dushanba:</span>
                            <span class="text-gray-300">08:00-18:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Seshanba:</span>
                            <span class="text-gray-300">08:00-18:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Chorshanba:</span>
                            <span class="text-gray-300">08:00-18:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Payshanba:</span>
                            <span class="text-gray-300">08:00-18:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Juma:</span>
                            <span class="text-gray-300">08:00-18:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Shanba:</span>
                            <span class="text-red-400">Yopiq</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-300">Yakshanba:</span>
                            <span class="text-red-400">Yopiq</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Newsletter -->
            <div class="mt-8 pt-8 border-t border-gray-700">
                <div class="max-w-md mx-auto">
                    <h3 class="text-lg font-semibold mb-4 text-center">Yangiliklar obunasi</h3>
                    <form class="flex">
                        <input type="email" placeholder="Email manzilingizni kiriting" class="flex-1 px-4 py-2 bg-gray-700 text-white rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-r-md hover:bg-blue-700 transition duration-300">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="bg-gray-900 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">
                        &copy; <?php echo date('Y'); ?> <?php echo translate('library_name'); ?>. Barcha huquqlar himoyalangan.
                    </p>
                    <div class="flex space-x-4 mt-2 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition duration-300">Maxfiylik siyosati</a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition duration-300">Foydalanish shartlari</a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition duration-300">Sayt xaritasi</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script src="../js/main.js"></script>
</body>
</html>