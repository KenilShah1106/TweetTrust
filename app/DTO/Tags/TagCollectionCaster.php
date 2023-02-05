<?php

namespace App\DTO\Tags;

use App\DTO\Tweets\TweetCollectionCaster;
use App\DTO\Users\UserDTO;
use Carbon\Carbon;
use Spatie\DataTransferObject\Caster;

class TagCollectionCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        return new TagCollection(array_map(function(array $data){
            $tweetCaster = new TweetCollectionCaster();
            return new TagDTO(
                id: $data['id'],
                name: $data['name'],
                desc: $data['desc'],
                creator: new UserDTO(...$data['creator']),
                tweets: $data['tweets'],
                tweets_collection: $tweetCaster->cast($data['tweets']),
                created_at: $data['created_at'],
                created_date: (new Carbon($data['created_at']))->diffForHumans(),
                updated_at: $data['updated_at'],
                updated_date: (new Carbon($data['updated_at']))->diffForHumans(),
            );
        }, $value));
    }
}
