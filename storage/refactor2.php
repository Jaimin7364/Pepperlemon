<?php
$files = ['resources/views/frontend/home.blade.php', 'resources/views/frontend/shop.blade.php', 'resources/views/frontend/product.blade.php'];
foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Replace top HTML up to the first <main> or <header> or first real content
    $content = preg_replace('/^<!DOCTYPE html>.*?(<body[^>]*>)\s*@include\(\'frontend\.partials\.header\'\)\s*/is', "@extends('layouts.frontend')\n\n@section('content')\n", $content);
    
    // Remove footer and bottom nav
    $content = preg_replace('/@include\(\'frontend\.partials\.footer\'\)\s*/is', "", $content);
    $content = preg_replace('/@include\(\'frontend\.partials\.bottom_nav\'\)\s*/is', "", $content);
    
    // Extract everything after </main> or the last section
    // Actually, just replace </body></html> with @endsection
    // And if there are scripts, wrap them in @push('scripts')
    
    // Find where the scripts start (after the main content, usually after </main>)
    if (preg_match('/(<script>.*?<\/script>)\s*<\/body>\s*<\/html>/is', $content, $matches) || preg_match('/(<script src=.*?<\/script>\s*<script>.*?<\/script>)\s*<\/body>\s*<\/html>/is', $content, $matches)) {
        // Scripts found. We will remove them from the bottom and push them.
    }
    
    // A simpler approach:
    // Remove scripts that are already in the layout (bootstrap, script.js)
    $content = preg_replace('/<script src="https:\/\/cdn\.jsdelivr\.net\/npm\/bootstrap@5\.3\.3.*?<\/script>\s*/is', "", $content);
    $content = preg_replace('/<script>\s*window\.pl_csrf = .*?<\/script>\s*/is', "", $content);
    $content = preg_replace('/<script src="\{\{ asset\(\'js\/script\.js\?v=.*?<\/script>\s*/is', "", $content);
    
    // Now any remaining <script> tags should be wrapped in @push
    if (preg_match('/(<script>.*<\/script>)\s*<\/body>\s*<\/html>/is', $content, $matches)) {
        $scripts = $matches[1];
        $content = str_replace($matches[0], "\n@endsection\n\n@push('scripts')\n" . $scripts . "\n@endpush", $content);
    } else {
        $content = preg_replace('/<\/body>\s*<\/html>/is', "\n@endsection\n", $content);
    }
    
    file_put_contents($file, $content);
    echo "Refactored $file\n";
}
