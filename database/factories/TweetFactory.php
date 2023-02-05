<?php

namespace Database\Factories;

use App\Constants\TweetConstants;
use App\Models\Tweet;
use Illuminate\Database\Eloquent\Factories\Factory;

class TweetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tweet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->paragraphs(rand(5,10), true), // true for asText
            'likes_count' => rand(0,10),
            'replies_count' => rand(0,10),
            'report_spam_count' => rand(0,10),
            'status' => TweetConstants::VALID,
        ];
    }
}
