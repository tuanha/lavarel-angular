<?php

use App\Joke;
use Illuminate\Database\Seeder;

class Jokes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(1,30) as $index)
        {
            Joke::create([
                'body' => $faker->paragraph($nbSentences = 3),
                'user_id' =>$faker->numberBetween($min = 1, $max = 5)
            ]);
        }
    }
}
