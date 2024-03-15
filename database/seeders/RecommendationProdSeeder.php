<?php

namespace Database\Seeders;

use App\Models\Recommendation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class RecommendationProdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id'           => 1,
                'prod_name'    => 'white t-shirt',
                'prod_type'    => 'clothes',
                'price'        => 590,
            ],
            [
                'id'           => 2,
                'prod_name'    => 'blue jeans',
                'prod_type'    => 'pants',
                'price'        => 1180,
            ],
            [
                'id'           => 3,
                'prod_name'    => 'black hat',
                'prod_type'    => 'hat',
                'price'        => 390,
            ],
        ];

        foreach ($data as $value) {
            \DB::table('recommendation')->insert($value);
        }
    }
}
