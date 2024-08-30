<footer class="text-sm space-x-4 px-4 flex items-center border-t border-gray-100 flex-wrap justify-between py-4 ">
    <div class="flex space-x-4">
        <a href="{{ route('locale', 'en') }}">
            <x-flag-country-us class="w-6 h-6"/>
        </a>
        <a href="{{ route('locale', 'vn') }}">
            <x-flag-country-vn class="w-6 h-6"/>
        </a>
    </div>
    <div class="space-x-4">
        <a class="text-gray-500 hover:text-yellow-500" href="">About Us</a>
        <a class="text-gray-500 hover:text-yellow-500" href="">Help</a>
        <a class="text-gray-500 hover:text-yellow-500" href="">Login</a>
        <a class="text-gray-500 hover:text-yellow-500" href="">Explore</a>
    </div>
</footer>
