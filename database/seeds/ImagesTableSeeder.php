<?php

use Illuminate\Database\Seeder;
use App\Image;
use Faker\Factory as Faker;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $imageLinks = array(
            "https://vuejsbook.com/img/vuejs/img1",
            "https://vuejsbook.com/img/vuejs/img2",
            "https://vuejsbook.com/img/vuejs/img3",
            "https://vuejsbook.com/img/vuejs/img4",
            "https://vuejsbook.com/img/vuejs/img5",
            "https://vuejsbook.com/img/vuejs/img6",
            "https://vuejsbook.com/img/vuejs/img7",
            "https://vuejsbook.com/img/vuejs/img8",
        );

        foreach($imageLinks as $imageLink)
        {

            Image::create([
                'title' => $faker->text(80),
                'description' => $content = $faker->paragraph(18),
                'thumbnail' => $imageLink.".jpg",
                'imageLink' => $imageLink."-l.jpg",
                'user_id' => $faker->numberBetween($min = 1, $max = 5),
            ]);
        }
    }
}
