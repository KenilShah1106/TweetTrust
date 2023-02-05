<?php

namespace App\Services;

use App\DTO\Replies\RepliesDTO;
use App\Models\Replies;
use Exception;

class RepliesService
{
    public function store(RepliesDTO $answerDTO)
    {
        $answer = Replies::storeReplies($answerDTO);
        return new RepliesDTO(...$answer->toArray());
    }

    public function update(RepliesDTO $answerDTO, Replies $answer)
    {
        try {
            $answer->updateReplies($answerDTO);
        } catch(Exception $e) {
            throw $e;
        }
    }

}
