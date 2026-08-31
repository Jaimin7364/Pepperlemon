<?php
$files = ['resources/views/frontend/home.blade.php', 'resources/views/frontend/shop.blade.php', 'resources/views/frontend/product.blade.php'];
foreach ($files as $file) {
    $content = file_get_contents($file);
    $content = str_replace("@include('frontend.partials.pwa_head')", "", $content);
    $content = str_replace("@include('frontend.partials.pwa_script')", "", $content);
    $content = str_replace("<!-- PWA Meta Tags -->", "", $content);
    $content = str_replace("<!-- PWA Installation Banners and Scripts -->", "", $content);
    
    // Check if there's a script at the bottom that needs wrapping
    if (preg_match('/(<script>.*?<\/script>)\s*@endsection/is', $content, $matches)) {
        $scripts = $matches[1];
        $content = str_replace($scripts, "", $content);
        $content = str_replace("@endsection", "@endsection\n\n@push('scripts')\n" . $scripts . "\n@endpush", $content);
    }
    
    file_put_contents($file, $content);
    echo "Cleaned up $file\n";
}
