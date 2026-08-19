<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutAndProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that guest users are redirected to login when trying to access checkout.
     */
    public function test_guest_user_cannot_access_checkout(): void
    {
        $response = $this->get('/checkout');

        $response->assertRedirect('/login');
    }

    /**
     * Test that authenticated users can access checkout when they have items in cart.
     */
    public function test_authenticated_user_can_access_checkout_with_cart_items(): void
    {
        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'Incense Sticks',
            'slug' => 'incense-sticks',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Sandalwood Dhoop',
            'slug' => 'sandalwood-dhoop',
            'price' => 150.00,
            'quantity' => 10,
        ]);

        // Place a mock item in the cart session
        $response = $this->actingAs($user)
            ->withSession([
                'cart' => [
                    $product->id => [
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => 1,
                        'image' => 'https://via.placeholder.com/150',
                        'slug' => $product->slug,
                    ]
                ]
            ])
            ->get('/checkout');

        $response->assertStatus(200);
        $response->assertSee('Sandalwood Dhoop');
    }

    /**
     * Test that the product detail page does not contain the COMPARE button.
     */
    public function test_product_page_does_not_contain_compare_button(): void
    {
        $category = Category::create([
            'name' => 'Incense Sticks',
            'slug' => 'incense-sticks',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Sandalwood Dhoop',
            'slug' => 'sandalwood-dhoop',
            'price' => 150.00,
            'quantity' => 10,
        ]);

        $response = $this->get('/product/' . $product->slug);

        $response->assertStatus(200);
        $response->assertDontSee('COMPARE');
        $response->assertSee('bi-heart');
    }

    /**
     * Test that admin users are redirected and blocked when trying to access checkout.
     */
    public function test_admin_user_cannot_access_checkout(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)
            ->get('/checkout');

        $response->assertRedirect('/cart');
        $response->assertSessionHas('error', 'Admins are not allowed to place orders.');

        $responsePost = $this->actingAs($admin)
            ->post('/checkout', [
                'shipping_name' => 'Admin User',
                'shipping_email' => 'admin@admin.com',
                'shipping_phone' => '1234567890',
                'shipping_address' => 'Admin HQ',
                'shipping_address2' => 'Apt B',
                'shipping_city' => 'Admin City',
                'shipping_state' => 'Admin State',
                'shipping_zip' => '12345',
                'payment_method' => 'cod',
            ]);

        $responsePost->assertRedirect('/cart');
        $responsePost->assertSessionHas('error', 'Admins are not allowed to place orders.');
    }

    /**
     * Test that user profile address details are updated after successful checkout.
     */
    public function test_user_address_details_are_updated_after_checkout(): void
    {
        $user = User::factory()->create([
            'phone' => null,
            'address' => null,
            'city' => null,
            'state' => null,
            'zip' => null,
        ]);

        $category = Category::create([
            'name' => 'Incense Sticks',
            'slug' => 'incense-sticks',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Sandalwood Dhoop',
            'slug' => 'sandalwood-dhoop',
            'price' => 150.00,
            'quantity' => 10,
        ]);

        $response = $this->actingAs($user)
            ->withSession([
                'cart' => [
                    $product->id => [
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => 1,
                        'image' => 'https://via.placeholder.com/150',
                        'slug' => $product->slug,
                    ]
                ]
            ])
            ->post('/checkout', [
                'shipping_name' => 'John Doe',
                'shipping_email' => 'john@example.com',
                'shipping_phone' => '9876543210',
                'shipping_address' => '123 Spiritual Lane',
                'shipping_address2' => 'Near Temple',
                'shipping_city' => 'Varanasi',
                'shipping_state' => 'Uttar Pradesh',
                'shipping_zip' => '221001',
                'payment_method' => 'cod',
            ]);

        $response->assertRedirect();
        
        // Assert address details were saved to user profile
        $user->refresh();
        $this->assertEquals('9876543210', $user->phone);
        $this->assertEquals('123 Spiritual Lane, Near Temple', $user->address);
        $this->assertEquals('Varanasi', $user->city);
        $this->assertEquals('Uttar Pradesh', $user->state);
        $this->assertEquals('221001', $user->zip);
    }
}
