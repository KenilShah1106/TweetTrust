<?php

namespace App\Http\Controllers\Frontend;

use App\DTO\Answers\AnswerDTO;
use App\DTO\Questions\QuestionDTO;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;

class FrontendAnswersController extends Controller
{
    public function edit(Question $question, Answer $answer)
    {
        $questionDTO = new QuestionDTO(...$question->toArray());
        $question = $questionDTO;
        $answerDTO = new AnswerDTO(...$answer->toArray());
        $answer = $answerDTO;
        return view('frontend.answers.edit', compact(['question','answer']));
    }
}
