<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->delete();
        DB::table('products')->delete();
        DB::table('banners')->delete();

        // 1. Add Banner
        Banner::create([
            'title' => 'Elevate Your Aura, Purify Your Space',
            'subtitle' => '100% charcoal-free, pure cow dung based dhoop sticks and cones.',
            'image_path' => 'images/modern_banner_new.png',
            'link' => '/shop',
            'type' => 'hero',
            'is_active' => true
        ]);

        // 2. Add Categories based on product packaging ranges
        $catSticksPet = Category::create([
            'name' => 'Bambooless Dhoop Sticks (PET Box)',
            'slug' => 'bambooless-dhoop-sticks-in-pet-box',
            'description' => 'Regular Range: 3" sticks, 61 Sticks per box, 122g total weight. Natural & Herbal.',
            'image' => 'images/sacred_dhoop_sticks.png',
            'is_active' => true
        ]);

        $catConesPet = Category::create([
            'name' => 'Dhoop Cones (PET Box)',
            'slug' => 'dhoop-cones-in-pet-box',
            'description' => 'Regular Range: 1.5" cones, 63 Cones per box, 126g total weight. Natural & Herbal.',
            'image' => 'images/product.png',
            'is_active' => true
        ]);

        $catSticksCorr = Category::create([
            'name' => 'Bambooless Dhoop Sticks (Corrugated Box)',
            'slug' => 'bambooless-dhoop-sticks-in-corrugated-box',
            'description' => 'Luxury Range: 3" sticks, 48 Sticks per box, 96g total weight. In elegant Gift Packaging.',
            'image' => 'images/premium_dhoop_product.png',
            'is_active' => true
        ]);

        $catConesCorr = Category::create([
            'name' => 'Dhoop Cones (Corrugated Box)',
            'slug' => 'dhoop-cones-in-corrugated-box',
            'description' => 'Luxury Range: 1.5" cones, 45 Cones per box, 90g total weight. In elegant Gift Packaging.',
            'image' => 'images/premium_dhoop_product.png',
            'is_active' => true
        ]);

        // 3. Populate Products
        
        // --- RANGE 1: Bambooless Dhoop Sticks in PET Box (Regular Range, 9 variants, ₹119) ---
        $variantsSticksPet = ['Guggul', 'Loban', 'Sandal', 'Kasturi', 'Lavender', 'Jasmine', 'Rose', 'Hawan', 'Navgraha'];
        foreach ($variantsSticksPet as $index => $fragrance) {
            Product::create([
                'category_id' => $catSticksPet->id,
                'name' => 'VEDIC ' . strtoupper($fragrance) . ' Bambooless Dhoop Sticks (PET Box)',
                'slug' => Str::slug('VEDIC ' . $fragrance . ' Bambooless Dhoop Sticks PET Box'),
                'short_description' => '100% Natural, Herbal & Cow Dung Based Dhoop Sticks. Charcoal-Free, Bamboo-Free.',
                'description' => "Experience the calming essence of pure {$fragrance} fragrance blended with the purifying power of traditional cow dung. Formulated using ancient Ayurvedic principles with natural resins, herbs, and pure oils. Free from artificial colors, chemical binders, or toxic ingredients.\n\nSpecification:\n- Product Type: Bambooless Dhoop Sticks\n- Stick Size: 3\"\n- Quantity: 61 Sticks per box\n- Product Weight: 122g\n- Total Packed Weight: ~161g\n- Box Measurement: 5\" x 2\"",
                'price' => 119.00,
                'sale_price' => null,
                'sku' => 'VB-BDS-PB-' . strtoupper(substr($fragrance, 0, 3)),
                'quantity' => 150,
                'is_featured' => ($fragrance === 'Kasturi' || $fragrance === 'Sandal'),
                'is_bestseller' => ($fragrance === 'Loban' || $fragrance === 'Guggul'),
                'deal_of_week' => false,
                'is_active' => true,
                'images' => json_encode(['images/sacred_dhoop_sticks.png'])
            ]);
        }

        // --- RANGE 2: Dhoop Cones in PET Box (Regular Range, 5 variants, ₹119) ---
        $variantsConesPet = ['Sandal', 'Kasturi', 'Jasmine', 'Rose', 'Lavender'];
        foreach ($variantsConesPet as $index => $fragrance) {
            Product::create([
                'category_id' => $catConesPet->id,
                'name' => 'VEDIC ' . strtoupper($fragrance) . ' Dhoop Cones (PET Box)',
                'slug' => Str::slug('VEDIC ' . $fragrance . ' Dhoop Cones PET Box'),
                'short_description' => '100% Natural, Herbal & Cow Dung Based Dhoop Cones. Charcoal-Free, Bamboo-Free.',
                'description' => "Purify your surroundings with the divine aroma of {$fragrance} Dhoop Cones. Handcrafted using premium herbs, natural resins, and cow dung. Perfect for daily puja, meditation, and spiritual practices.\n\nSpecification:\n- Product Type: Dhoop Cones\n- Cone Size: 1.5\"\n- Quantity: 63 Cones per box\n- Product Weight: 126g\n- Total Packed Weight: ~164g\n- Box Measurement: 5\" x 2\"",
                'price' => 119.00,
                'sale_price' => null,
                'sku' => 'VB-DC-PB-' . strtoupper(substr($fragrance, 0, 3)),
                'quantity' => 120,
                'is_featured' => ($fragrance === 'Kasturi'),
                'is_bestseller' => ($fragrance === 'Sandal'),
                'deal_of_week' => false,
                'is_active' => true,
                'images' => json_encode(['images/product.png'])
            ]);
        }

        // --- RANGE 3: Bambooless Dhoop Sticks in Corrugated Box (Luxury Range, 4 variants, ₹199 / ₹249 MRP) ---
        $variantsSticksCorr = ['Jasmine', 'Kasturi', 'Sandal', 'Oudh'];
        foreach ($variantsSticksCorr as $index => $fragrance) {
            Product::create([
                'category_id' => $catSticksCorr->id,
                'name' => 'VEDIC ' . strtoupper($fragrance) . ' Bambooless Dhoop Sticks (Corrugated Box)',
                'slug' => Str::slug('VEDIC ' . $fragrance . ' Bambooless Dhoop Sticks Corrugated Box'),
                'short_description' => 'Luxury Gift Pack: Premium Natural, Herbal & Cow Dung Based Dhoop Sticks.',
                'description' => "Our premium Luxury Range of {$fragrance} Bambooless Dhoop Sticks is packed in an elegant, eco-friendly corrugated gift box. Perfect for gifting, meditation retreats, and creating an opulent, spiritually-uplifting ambiance in your space.\n\nSpecification:\n- Product Type: Bambooless Dhoop Sticks (Luxury Range)\n- Stick Size: 3\"\n- Quantity: 48 Sticks per box\n- Product Weight: 96g\n- Total Packed Weight: ~147g\n- Box Measurement: 5\" x 2\"\n\nSpecial Pricing Available On:\n- Amazon: Selling Price ₹199 (MRP ₹249)\n- Flipkart: Selling Price ₹189 (MRP ₹249)\n- Meesho: Selling Price ₹159 (MRP ₹249)",
                'price' => 249.00,
                'sale_price' => 199.00,
                'sku' => 'VB-BDS-CB-' . strtoupper(substr($fragrance, 0, 3)),
                'quantity' => 100,
                'is_featured' => ($fragrance === 'Oudh'),
                'is_bestseller' => ($fragrance === 'Jasmine'),
                'deal_of_week' => ($fragrance === 'Oudh'), // Set Oudh luxury as Deal of the Week
                'is_active' => true,
                'images' => json_encode(['images/premium_dhoop_product.png'])
            ]);
        }

        // --- RANGE 4: Dhoop Cones in Corrugated Box (Luxury Range, 4 variants, ₹199 / ₹249 MRP) ---
        $variantsConesCorr = ['Sandal', 'Jasmine', 'Kasturi', 'Oudh'];
        foreach ($variantsConesCorr as $index => $fragrance) {
            Product::create([
                'category_id' => $catConesCorr->id,
                'name' => 'VEDIC ' . strtoupper($fragrance) . ' Dhoop Cones (Corrugated Box)',
                'slug' => Str::slug('VEDIC ' . $fragrance . ' Dhoop Cones Corrugated Box'),
                'short_description' => 'Luxury Gift Pack: Premium Natural, Herbal & Cow Dung Based Dhoop Cones.',
                'description' => "Indulge in the therapeutic fragrance of premium {$fragrance} Dhoop Cones, housed in a beautifully crafted corrugated packaging box. Made with natural herbs, essential oils, and cow dung base to bring positive cosmic energy to your surroundings.\n\nSpecification:\n- Product Type: Dhoop Cones (Luxury Range)\n- Cone Size: 1.5\"\n- Quantity: 45 Cones per box\n- Product Weight: 90g\n- Total Packed Weight: ~141g\n- Box Measurement: 5\" x 2\"\n\nSpecial Pricing Available On:\n- Amazon: Selling Price ₹199 (MRP ₹249)\n- Flipkart: Selling Price ₹189 (MRP ₹249)\n- Meesho: Selling Price ₹159 (MRP ₹249)",
                'price' => 249.00,
                'sale_price' => 199.00,
                'sku' => 'VB-DC-CB-' . strtoupper(substr($fragrance, 0, 3)),
                'quantity' => 100,
                'is_featured' => ($fragrance === 'Sandal'),
                'is_bestseller' => ($fragrance === 'Kasturi'),
                'deal_of_week' => false,
                'is_active' => true,
                'images' => json_encode(['images/premium_dhoop_product.png'])
            ]);
        }
    }
}
