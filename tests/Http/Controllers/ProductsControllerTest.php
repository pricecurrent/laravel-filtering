<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;
use App\Models\Rating;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Modules\Sales\Infrastructure\PostCutoffChanges\SkipOrderPostCutoffService;

class ProductsControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_lists_all_products()
    {
        $product = Product::factory()->create();

        $response = $this->json('get', route('products.index'));

        $response->assertOk();
        $this->assertCount(1, $response->json('data'));
        $products = $response->json('data');
        $this->assertEquals($products[0]['id'], $product->id);
    }

    /**
     * @test
     */
    public function it_filters_products_by_name()
    {
        $productA = Product::factory()->create(['name' => 'test']);
        $productB = Product::factory()->create(['name' => 'carrot']);

        $response = $this->json('get', route('products.index'), [
            'search' => 'test',
        ]);

        $response->assertOk();
        $this->assertCount(1, $response->json('data'));
        $products = $response->json('data');
        $this->assertEquals($products[0]['id'], $productA->id);
    }

    /**
     * @test
     */
    public function it_doesnt_filtelr_by_search_term_if_one_not_passed()
    {
        $productA = Product::factory()->create(['name' => 'test']);
        $productB = Product::factory()->create(['name' => 'carrot']);
        $this->withoutExceptionHandling();
        $response = $this->json('get', route('products.index'), [
            'search' => null,
        ]);

        $response->assertOk();
        $this->assertCount(2, $response->json('data'));
    }

    /**
     * @test
     */
    public function it_filters_products_by_min_average_rating()
    {
        $productA = Product::factory()->create(['name' => 'test']);
        $productB = Product::factory()->create(['name' => 'carrot']);
        Rating::factory()->create(['product_id' => $productA->id, 'score' => 4]);
        Rating::factory()->create(['product_id' => $productA->id, 'score' => 5]);
        Rating::factory()->create(['product_id' => $productB->id, 'score' => 5]);
        Rating::factory()->create(['product_id' => $productB->id, 'score' => 1]);


        $this->withoutExceptionHandling();
        $response = $this->json('get', route('products.index'), [
            'min_rating' => 4,
        ]);

        $response->assertOk();
        $this->assertCount(1, $response->json('data'));
        $products = $response->json('data');
        $this->assertEquals($products[0]['id'], $productA->id);
    }

    /**
     * @test
     */
    public function it_doesnt_filter_by_average_rating_if_no_value_set()
    {
        $productA = Product::factory()->create(['name' => 'test']);
        $productB = Product::factory()->create(['name' => 'carrot']);
        Rating::factory()->create(['product_id' => $productA->id, 'score' => 4]);
        Rating::factory()->create(['product_id' => $productA->id, 'score' => 5]);
        Rating::factory()->create(['product_id' => $productB->id, 'score' => 5]);
        Rating::factory()->create(['product_id' => $productB->id, 'score' => 1]);


        $response = $this->json('get', route('products.index'), [
            'min_rating' => null,
        ]);

        $response->assertOk();
        $this->assertCount(2, $response->json('data'));
    }

    /**
     * @test
     */
    public function it_filters_products_by_price()
    {
        $productA = Product::factory()->create(['price' => 1200]);
        $productB = Product::factory()->create(['price' => 900]);
        $productC = Product::factory()->create(['price' => 1500]);


        $this->withoutExceptionHandling();
        $response = $this->json('get', route('products.index'), [
            'min_price' => 10,
            'max_price' => 15,
        ]);

        $response->assertOk();
        $this->assertCount(2, $response->json('data'));
        $products = $response->json('data');
        $this->assertEquals(array_shift($products)['id'], $productA->id);
        $this->assertEquals(array_shift($products)['id'], $productC->id);
    }
}
