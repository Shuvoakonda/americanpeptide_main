<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting Product Seeder...');
        
            $jsonPath = public_path('json/products.json');
        if (!file_exists($jsonPath)) {
            $this->command->error("JSON file not found at: {$jsonPath}");
            return;
        }

        $jsonContent = file_get_contents($jsonPath);
        $products = json_decode($jsonContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Invalid JSON format: ' . json_last_error_msg());
            return;
        }
        
        $categories = Category::all();
    
        
        $createdCount = 0;
        $updatedCount = 0;
        $skippedCount = 0;

        foreach ($products as $index => $productData) {
            $this->command->line("Processing product " . ($index + 1) . "/" . count($products) . ": {$productData['name']}");
            try {
                // Assign a random brand and category for now (customize as needed)
 
                $category = $categories->random();

                // Create the main product
                $product = Product::updateOrCreate(
                    ['slug' => $productData['slug']],
                    [
                        'name' => $productData['name'],
                        'slug' => $productData['slug'],
                        'description' => $productData['description'] ?? null,
                   
                    'category_id' => $category->id,
                        'thumbnail' => $productData['thumbnail'] ?? null,
                        'status' => $productData['status'] ?? 'active',
                        'views' => $productData['views'] ?? 0,
                        'variants' => $productData['variants'] ?? null,
                        ]
                );

             
                $createdCount++;
            } catch (\Exception $e) {
                $this->command->warn("⚠️  Skipped product '{$productData['name']}': " . $e->getMessage());
                $skippedCount++;
            }
        }
        $this->command->info("✅ Products seeded successfully! Created/Updated: {$createdCount}, Skipped: {$skippedCount}");
    }
} 