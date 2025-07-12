<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slider;
use Carbon\Carbon;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Welcome to MyShop!',
                'description' => 'Discover the latest products and deals.',
                'image' => 'https://picsum.photos/1920/1080?random=20',
                'button_text' => 'Shop Now',
                'button_url' => '/products',
                'button_color' => '#007bff',
                'position' => 'top',
                'is_active' => true,
                'sort_order' => 1,
                'starts_at' => Carbon::now()->subDays(10),
                'ends_at' => Carbon::now()->addDays(20),
            ],
            [
                'title' => 'Summer Sale',
                'description' => 'Up to 50% off selected items. Limited time only!',
                'image' => 'https://picsum.photos/1920/1080?random=21',
                'button_text' => 'View Offers',
                'button_url' => '/products?on_sale=1',
                'button_color' => '#28a745',
                'position' => 'middle',
                'is_active' => true,
                'sort_order' => 2,
                'starts_at' => Carbon::now()->subDays(5),
                'ends_at' => Carbon::now()->addDays(10),
            ],
            [
                'title' => 'New Arrivals',
                'description' => 'Check out the latest additions to our store.',
                'image' => 'https://picsum.photos/1920/1080?random=22',
                'button_text' => 'Browse New',
                'button_url' => '/products?sort=newest',
                'button_color' => '#ffc107',
                'position' => 'bottom',
                'is_active' => true,
                'sort_order' => 3,
                'starts_at' => Carbon::now()->subDays(2),
                'ends_at' => Carbon::now()->addDays(30),
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
