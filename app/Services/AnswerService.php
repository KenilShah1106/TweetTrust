<?php

namespace App\Services;

use App\DTO\Answers\AnswerDTO;
use App\Models\Answer;
use Exception;

class AnswerService
{
    public function store(AnswerDTO $answerDTO)
    {
        $answer = Answer::storeAnswer($answerDTO);
        return new AnswerDTO(...$answer->toArray());
    }

    public function update(AnswerDTO $answerDTO, Answer $answer)
    {
        try {
            $answer->updateAnswer($answerDTO);
        } catch(Exception $e) {
            throw $e;
        }
    }

}
