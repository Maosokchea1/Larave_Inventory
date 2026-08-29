<?php

if (!function_exists('translateUserName')) {
    function translateUserName($name) {
        $locale = app()->getLocale();
        
        // ប្រសិនបើបច្ចុប្បន្នជាភាសាខ្មែរ (km ឬ kh)
        if ($locale == 'km' || $locale == 'kh') {
            try {
                // ប្រើប្រាស់ Google Translate API endpoint បែប Public ដោយមិនបាច់ចុះឈ្មោះ Key
                $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=km&dt=t&q=" . urlencode($name);
                
                $response = @file_get_contents($url);
                if ($response) {
                    $data = json_decode($response, true);
                    // ទាញយកលទ្ធផលដែលបានបកប្រែរួច
                    if (isset($data[0][0][0])) {
                        return $data[0][0][0];
                    }
                }
            } catch (\Exception $e) {
                // បើមានបញ្ហា វានឹងបង្ហាញឈ្មោះដើមវិញស្វ័យប្រវត្តិ
                return $name;
            }
        }
        
        return $name;
    }
}