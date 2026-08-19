<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $categoriesData = [
            'mexican' => 'Mexican Products',
            'beverage' => 'Beverages',
            'candy' => 'Grocery / Candy',
            'snacks' => 'Snacks',
            'water' => 'Water',
            'chocolate' => 'Chocolates',
        ];

        $categoryIds = [];

        foreach ($categoriesData as $slug => $name) {
            $cat = Category::firstOrCreate(['slug' => $slug], [
                'name' => $name,
                'is_active' => true,
            ]);
            $categoryIds[$slug] = $cat->id;
        }

        // [slug, name, sale_price, price, category_slug, image]
        $productsToSeed = [
            // New Products
            ["clear-fruit", "Clear Fruit - Beverage", 19.99, 22.49, "water", "images/clear_fruit.jpg"],
            ["citrus-twist", "Citrus Twist - Beverage", 32.99, 35.99, "beverage", "images/citrus_twist.jpg"],
            ["core-water", "Core - Hydration - Beverage", 29.99, 32.99, "water", "images/core_water.jpg"],
            ["spring-water", "Ozarka - Beverage - Water", 17.49, 19.99, "water", "images/spring_water.jpg"],
            
            // Best Sellers
            ["mardinni", "Mardinni - Dubai Chocolate", 82.49, 94.99, "chocolate", "images/dubai_chocolate_box.jpg"],
            ["patislove", "Patislove - Dubai Chocolate", 143.25, 159.99, "chocolate", "images/dubai_chocolate_box.jpg"],
            ["crazy-choco", "Crazy Choco - Candy", 15.99, 18.99, "candy", "images/chocolate_bar.jpg"],
            ["crazy-choco-snack", "Crazy Choco Snack Pack", 21.99, 24.99, "candy", "images/chocolate_bar.jpg"],
            
            // Featured
            ["trail-mix", "Nature's Best - Trail Mix", 6.49, 7.99, "snacks", "images/trail_mix.jpg"],
            ["cracker-treats", "Golden Crunch - Cracker Treats", 11.29, 12.99, "snacks", "images/cracker_treats.jpg"],
            ["volt-sport", "Volt Sport - Electrolyte Drink", 24.99, 28.00, "beverage", "images/volt_sport_blue.jpg"],
            ["berry-chips", "Deep Harvest - Berry Trail Chips", 8.99, 10.49, "snacks", "images/berry_chips.jpg"],
            
            // Additional items
            ["clamato-12", "Clamato - Mexican Tomato Cocktail", 38.49, 42.99, "mexican", "images/clamato_juice.jpg"],
            ["sabroso-mango", "Sabroso - Mango Nectar", 9.99, 11.99, "mexican", "images/mango_nectar.jpg"],
            ["coca-cola-24", "COCA COLA - SODA", 32.49, 36.00, "beverage", "images/coca_cola_24pk.jpg"],
            
            // 15 extra items for infinite scroll testing (30 total)
            ["spring-water-lg", "Spring Water - Large Size", 24.49, 27.99, "water", "images/spring_water.jpg"],
            ["sparkly-seltzer", "Sparkly Seltzer - Lime", 12.99, 14.99, "beverage", "images/citrus_twist.jpg"],
            ["hazelnut-spread", "Premium Hazelnut Spread", 45.00, 49.99, "candy", "images/chocolate_bar.jpg"],
            ["natural-oats", "Natural Oats - Instant Cup", 8.49, 9.99, "snacks", "images/trail_mix.jpg"],
            ["dark-roast", "Dark Roast Coffee Beans", 89.99, 99.99, "beverage", "images/citrus_twist.jpg"],
            ["golden-honey", "Golden Honey Pure Jar", 59.99, 65.00, "candy", "images/chocolate_bar.jpg"],
            ["crispy-rice", "Crispy Rice Cakes", 14.29, 15.99, "snacks", "images/cracker_treats.jpg"],
            ["pretzel-sticks", "Gourmet Pretzel Sticks", 18.99, 21.00, "snacks", "images/trail_mix.jpg"],
            ["fruit-bars", "Organic Fruit Bars (6pk)", 34.49, 38.99, "snacks", "images/trail_mix.jpg"],
            ["potato-wedges", "Spicy Potato Wedges Pack", 22.99, 25.99, "snacks", "images/cracker_treats.jpg"],
            ["cheddar-crackers", "Cheddar Cheese Crackers", 11.99, 13.49, "snacks", "images/cracker_treats.jpg"],
            ["tropical-juice", "Tropical Juice Box (1L)", 28.49, 32.00, "beverage", "images/mango_nectar.jpg"],
            ["roasted-almonds", "Roasted Almonds - Salted", 42.49, 45.99, "snacks", "images/trail_mix.jpg"],
            ["fruit-muesli", "Fruit and Nut Muesli Pack", 64.99, 69.99, "snacks", "images/trail_mix.jpg"],
            ["vanilla-yogurt", "Vanilla Yogurt Multipack", 36.49, 39.99, "candy", "images/chocolate_bar.jpg"],
        ];

        foreach ($productsToSeed as $index => $p) {
            Product::updateOrCreate(
                ['slug' => $p[0]],
                [
                    'name' => $p[1],
                    'category_id' => $categoryIds[$p[4]],
                    'price' => $p[3],
                    'sale_price' => $p[2],
                    'description' => 'This is a premium product from our catalog.',
                    'images' => json_encode([$p[5], $p[5]]), // Using same image twice for thumbnails
                    'is_active' => true,
                    'deal_of_week' => ($index === 14),
                    'is_bestseller' => ($index >= 4 && $index <= 7),
                    'is_featured' => ($index >= 8 && $index <= 11)
                ]
            );
        }

        // Seed default banners if banners table is empty
        if (\App\Models\Banner::count() === 0) {
            \App\Models\Banner::create([
                'title' => 'Fresh Organic Groceries',
                'subtitle' => 'Farm Fresh Produce',
                'image_path' => 'images/hero_banner_new.png',
                'link' => '/shop',
                'type' => 'hero',
                'is_active' => true,
            ]);
            \App\Models\Banner::create([
                'title' => 'Premium Beverages',
                'subtitle' => 'Refreshing Taste',
                'image_path' => 'images/banner2_new.png',
                'link' => '/shop?cat=beverage',
                'type' => 'hero',
                'is_active' => true,
            ]);
            \App\Models\Banner::create([
                'title' => 'Gourmet Snacks',
                'subtitle' => 'Crunchy Delights',
                'image_path' => 'images/banner3_new.png',
                'link' => '/shop?cat=snacks',
                'type' => 'hero',
                'is_active' => true,
            ]);
        }
    }
}

