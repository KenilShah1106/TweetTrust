<?php

namespace App\Services;

use App\DTO\Answers\AnswerDTO;
use App\DTO\Questions\QuestionDTO;
use App\Models\Answer;
use App\Models\Question;
use Exception;

class QuestionService
{
    public function index()
    {
        $questions = Question::with('author', 'answers', 'tags')->get()->sortByDesc('created_at');
        $questionDTOs = [];

        foreach($questions as $question) {
            $tagDTOs = [];
            foreach ($question->tags as $tag) {
                $tag->questions = null;
                $tagDTOs[] = $tag->toDTO();
            }
            $question->tags = $tagDTOs;
            $question->answers = null;
            $questionDTO = $question->toDTO();
            $questionDTO->bestAnswer = new AnswerDTO(
                id: $questionDTO->best_answer_id,
                author: $question->bestAnswer->author->toDTO()
            );
            $questionDTOs[] = $questionDTO;
        }

        return $questionDTOs;
    }

    public function show(int $id)
    {
        $question = Question::with('author', 'answers', 'tags')->findOrFail($id);
        $tagDTOs = [];
        foreach($question->tags as $tag) {
            $tag->questions = null;
            $tagDTOs[] = $tag->toDTO();
        }
        $answerDTOs = [];
        foreach($question->answers->sortByDesc('created_at') as $answer) {
            $answerDTOs[] = $answer->toDTO();
        }
        $question->tags = $tagDTOs;
        $question->answers = $answerDTOs;
        $questionDTO = $question->toDTO();
        return $questionDTO;
    }

    public function store(QuestionDTO $questionDTO)
    {
        try {
            return Question::storeQuestion($questionDTO);
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function update(QuestionDTO $questionDTO, Question $question)
    {
        try {
            $question->updateQuestion($questionDTO);
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function markAsBestAnswer(Question $question, Answer $answer)
    {
        try {
            $question->markAsBestAnswer($answer->id);
        } catch(Exception $e) {
            throw $e;
        }
    }

}
