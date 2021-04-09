<?php

/* @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Entities\Tour;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Tour::class, function (Faker $faker) {
    //$faker = Faker\Factory::create('zh_CN');
    if(!File::exists(public_path()."/img/tour")){
        File::makeDirectory(public_path()."/img/tour");
    }

    $countries = ['韓國', '泰國', '日本'];
    $country = $faker->randomElement($countries);
    $title = $faker->realText($faker->numberBetween(10,10));
    $title = str_replace(
                array('!', '"', '#', '$', '%', '&', '\'', '(', ')', '*',
                    '+', ', ', '-', '.', '/', ':', ';', '<', '=', '>',
                    '?', '@', '[', '\\', ']', '^', '_', '`', '{', '|',
                    '}', '~', '；', '﹔', '︰', '﹕', '：', '，', '﹐', '、',
                    '．', '﹒', '˙', '·', '。', '？', '！', '～', '‥', '‧',
                    '′', '〃', '〝', '〞', '‵', '‘', '’', '『', '』', '「',
                    '」', '“', '”', '…', '❞', '❝', '﹁', '﹂', '﹃', '﹄'),
                '',
                $title);

//    $image = $faker->image('public/img/tour',1024,576,'city',false);

    $sets = ['經典行程', '優惠行程', '超值行程', '在地人推薦行程', '深度體驗行程'];

    $data = [
        'status' => 'r',
        'photo' => 'img/site/ig.png',
        'introduction' => $faker->realText($faker->numberBetween(300,500)),
        'sub_title' => $faker->randomElement($sets),
        'price' => $faker->numberBetween(1000, 5000),
        'inventory' => $faker->numberBetween(100, 500),
        'country' => $country,
    ];

    if($country == '韓國')
    {
        $cities = [
            '首爾' => [37.5511736, 126.9860379],
            '釜山' => [35.8561719, 129.2247477],
            '濟州島' => [33.4862836, 126.4876365]
        ];
        $city = $faker->randomElement(array_keys($cities));

        return array_merge($data, [
            'title' => '['.$city.$faker->randomElement(['半','一','二']).'日遊]'.$title,
            'city' => $city,
            'latitude' => reset($cities[$city]), //緯度
            'longitude' => end($cities[$city]) //經度
        ]);
    }
    elseif ($country == '日本') {
        $cities = [
            '大阪' => [33.6814002, 135.3752099],
            '北海道' => [40.5604862,139.9847784],
            '九州' => [34.4196287,131.0625685]
        ];
        $city = $faker->randomElement(array_keys($cities));

        return array_merge($data, [
            'title' => '['.$city.$faker->randomElement(['半','一','二']).'日遊]'.$title,
            'city' => $city,
            'latitude' => reset($cities[$city]), //緯度
            'longitude' => end($cities[$city]) //經度
        ]);
    }
    else
    {
        $cities = [
            '曼谷' => [13.7500943,100.4891153],
            '清邁' => [18.7939072,98.8864363],
            '蘇美島' => [9.5080185,100.0531805]
        ];
        $city = $faker->randomElement(array_keys($cities));

        return array_merge($data, [
            'title' => '['.$city.$faker->randomElement(['半','一','二']).'日遊]'.$title,
            'city' => $city,
            'latitude' => reset($cities[$city]), //緯度
            'longitude' => end($cities[$city]) //經度
        ]);
    }

});


