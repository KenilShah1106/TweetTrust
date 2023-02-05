<?php

namespace Database\Factories;

use App\Models\Replies;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepliesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Replies::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->paragraphs(rand(3,7), true),
            'user_id' => User::pluck('id')->random(),
            'tweet_id' => Tweet::pluck('id')->random(),
            'likes_count' => rand(0,5),
            'report_spam_count' => rand(0,5),
        ];
    }
}
