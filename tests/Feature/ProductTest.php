<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreProductSuccess()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $imageName = 'product1.jpg';
        $image = UploadedFile::fake()->image($imageName);

        $response = $this->actingAs($admin)->post(route('product.store'), [
            'name' => 'Product 1',
            'description' => 'Description Product 1',
            'price' => 10000,
            'image' => $image,
            'category_id' => $category->id,
        ]);

        $product = Product::where('name', 'Product 1')->first();

        $this->assertDatabaseHas('products', [
            'name' => 'Product 1',
            'description' => 'Description Product 1',
            'price' => 10000,
            'category_id' => $category->id,
            'image' => $product->image, // Verify the actual stored image name
        ]);

        Storage::disk('public')->assertExists('images/product/' . $product->image);

        $response->assertRedirect(route('product.index'));
        $response->assertSessionHas('success', 'Product created successfully');
    }

    public function testStoreProductFailed()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('product.store'), [
            'name' => '',
            'description' => '',
            'price' => '',
            'image' => '',
            'category_id' => '',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'Product name is required',
            'description' => 'Product description is required',
            'price' => 'Product price is required',
            'image' => 'Product image is required',
            'category_id' => 'Product category is required',
        ]);
    }

    public function testStoreProductAsUser()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user = User::factory()->create();
        $category = Category::factory()->create();

        $imageName = 'product1.jpg';
        $image = UploadedFile::fake()->image($imageName);

        $response = $this->actingAs($user)->post(route('product.store'), [
            'name' => 'Product 1',
            'description' => 'Description Product 1',
            'price' => 10000,
            'image' => $image,
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('home.index'));
        $response->assertSessionHas('error', 'You are not authorized to access this page');
    }

    public function testEditProductSuccess()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $product = Product::factory()->create();

        $imageName = 'product1.jpg';
        $image = UploadedFile::fake()->image($imageName);

        $response = $this->actingAs($admin)->put(route('product.update', $product->id), [
            'name' => 'Product 1',
            'description' => 'Description Product 1',
            'price' => 10000,
            'image' => $image,
            'category_id' => $category->id,
        ]);

        $product = Product::where('name', 'Product 1')->first();

        $this->assertDatabaseHas('products', [
            'name' => 'Product 1',
            'description' => 'Description Product 1',
            'price' => 10000,
            'category_id' => $category->id,
            'image' => $product->image,
        ]);

        Storage::disk('public')->assertExists('images/product/' . $product->image);

        $response->assertRedirect(route('product.index'));
        $response->assertSessionHas('success', 'Product updated successfully');
    }

    public function testUpdateProductFailed()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $admin = User::factory()->admin()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($admin)->put(route('product.update', $product->id), [
            'name' => '',
            'description' => '',
            'price' => '',
            'image' => '',
            'category_id' => '',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'Product name is required',
            'description' => 'Product description is required',
            'price' => 'Product price is required',
            'category_id' => 'Product category is required',
        ]);
    }

    public function testProductUpdateAsUser()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->put(route('product.update', $product->id), [
            'name' => 'Product 1',
            'description' => 'Description Product 1',
            'price' => 10000,
            'category_id' => 1,
        ]);

        $response->assertRedirect(route('home.index'));
        $response->assertSessionHas('error', 'You are not authorized to access this page');
    }

    public function testDeleteProductSuccess()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($admin)->delete(route('product.delete', $product->id));

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);

        Storage::disk('public')->assertMissing('images/product/' . $product->image);

        $response->assertRedirect(route('product.index'));
        $response->assertSessionHas('success', 'Product deleted successfully');
    }

    public function testDeleteProductFailed()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $admin = User::factory()->admin()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($admin)->delete(route('product.delete', 1000));

        $response->assertNotFound();
    }

    public function testDeleteAsUser()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->delete(route('product.delete', $product->id));

        $response->assertRedirect(route('home.index'));
        $response->assertSessionHas('error', 'You are not authorized to access this page');
    }

    public function testSearchProduct()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $imageName = 'product1.jpg';
        $image = UploadedFile::fake()->image($imageName);

        $this->actingAs($admin)->post(route('product.store'), [
            'name' => 'Product 1',
            'description' => 'Description Product 1',
            'price' => 10000,
            'image' => $image,
            'category_id' => $category->id,
        ]);

        $response = $this->get(route('product.index', ['search' => 'Product 1']));

        $response->assertSee('Product 1');
        $response->assertSee('Description Product 1');
    }

    public function testSearchProductEmpty()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('product.index', ['search' => 'NonExistingProduct']));

        $response->assertSee('Product data is empty');
    }

    public function testFilterCategory()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $imageName = 'product1.jpg';
        $image = UploadedFile::fake()->image($imageName);

        $this->actingAs($admin)->post(route('product.store'), [
            'name' => 'Product 1',
            'description' => 'Description Product 1',
            'price' => 10000,
            'image' => $image,
            'category_id' => $category->id,
        ]);

        $response = $this->get(route('product.index', ['category' => $category->id]));

        $response->assertSee('Product 1');
        $response->assertSee('Description Product 1');
    }

    public function testFilterCategoryEmpty()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('product.index', ['category' => 1000]));

        $response->assertSee('Product data is empty');
    }

    public function testGetAllProductSuccess()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        foreach (range(1, 10) as $index) {
            $imageName = 'product' . $index . '.jpg';
            $image = UploadedFile::fake()->image($imageName);

            $this->actingAs($admin)->post(route('product.store'), [
                'name' => 'Product ' . $index,
                'description' => 'Description Product ' . $index,
                'price' => 10000 + $index,
                'image' => $image,
                'category_id' => $category->id,
            ]);
        }

        $response = $this->actingAs($admin)->get(route('product.index'));

        foreach (range(1, 10) as $index) {
            $response->assertSee('Product ' . $index);
            $response->assertSee('Description Product ' . $index);
        }
    }

    public function testGetAllProductEmpty()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('product.index'));

        $response->assertSee('Product data is empty');
    }
}
