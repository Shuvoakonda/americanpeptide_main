<?php

// Path to products.json and images directory
$jsonPath = __DIR__ . '/public/json/products.json';
$imagesDir = __DIR__ . '/storage/app/public/products';

// Load products.json
$products = json_decode(file_get_contents($jsonPath), true);
if (!$products) {
    exit("Failed to load products.json\n");
}

// Get all image filenames
$imageFiles = array_diff(scandir($imagesDir), ['.', '..']);

// Helper: normalize string for matching
function normalize($str) {
    return strtolower(preg_replace('/[^a-z0-9]+/', '', $str));
}

// Build a lookup of normalized image names
$imageMap = [];
foreach ($imageFiles as $file) {
    $name = pathinfo($file, PATHINFO_FILENAME);
    $imageMap[normalize($name)] = $file;
}

function findImage($productName, $variantName = '', $strength = '') {
    global $imageMap;
    $candidates = [];
    if ($variantName && $strength) {
        $candidates[] = normalize($variantName . $strength);
        $candidates[] = normalize($productName . $strength);
    }
    if ($variantName) {
        $candidates[] = normalize($variantName);
    }
    if ($strength) {
        $candidates[] = normalize($productName . $strength);
    }
    $candidates[] = normalize($productName);
    foreach ($candidates as $key) {
        foreach ($imageMap as $imgKey => $file) {
            if (strpos($imgKey, $key) !== false) {
                return 'products/' . $file;
            }
        }
    }
    return null;
}

$batchSize = 10;
$total = count($products);
$updated = 0;

foreach ($products as $i => &$product) {
    $productImg = findImage($product['name']);
    if ($productImg) {
        $product['thumbnail'] = $productImg;
        $updated++;
    }
    if (!empty($product['variants']) && is_array($product['variants'])) {
        foreach ($product['variants'] as &$variant) {
            $strength = '';
            if (!empty($variant['attributes']) && is_array($variant['attributes'])) {
                foreach ($variant['attributes'] as $attr) {
                    if (isset($attr['name']) && strtolower($attr['name']) === 'strength') {
                        $strength = $attr['value'];
                        break;
                    }
                }
            }
            $variantImg = findImage($product['name'], $variant['name'] ?? '', $strength);
            if ($variantImg) {
                $variant['thumbnail'] = $variantImg;
                $updated++;
            }
        }
        unset($variant);
    }
    // Batch save
    if (($i + 1) % $batchSize === 0 || $i + 1 === $total) {
        file_put_contents($jsonPath, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        echo "Processed batch: " . ($i + 1) . "/$total\n";
    }
}
echo "Updated $updated thumbnails.\n"; 