<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UserSeeder::class);

        User::factory(4)->create()->each(function(User $user) {
            Tag::factory(4)->create();
            $user->questions()
                ->saveMany(
                    Question::factory(rand(2,5))->make()
                )
                ->each(function(Question $question) {
                    $question->answers()->saveMany(
                        Answer::factory(rand(2,7))->make()
                    );

                    $question->tags()->attach(Tag::pluck('id')->random(rand(1,4)));
                });
        });
    }
}
