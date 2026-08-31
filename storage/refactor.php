<?php
$files = ['resources/views/frontend/home.blade.php', 'resources/views/frontend/shop.blade.php', 'resources/views/frontend/product.blade.php'];
foreach ($files as $file) {
    $content = file_get_contents($file);
    // Replace top
    $content = preg_replace('/^<!DOCTYPE html>.*?(<body[^>]*>)\s*(@include\(\'frontend\.partials\.header\'\))/is', "@extends('layouts.frontend')\n@section('content')", $content);
    // Replace bottom
    $content = preg_replace('/(<!-- ===================== FOOTER .*?@include\(\'frontend\.partials\.footer\'\)).*/is', "@endsection", $content);
    file_put_contents($file, $content);
    echo "Refactored $file\n";
}
