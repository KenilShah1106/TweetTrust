<?php

namespace App\Http\Controllers;

use App\DTO\Answers\AnswerDTO;
use App\DTO\Questions\QuestionDTO;
use App\Models\Answer;
use App\Models\Question;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    public function voteQuestion(Question $question, int $vote)
    {
        $authUser = auth()->user();
        try {
            if($authUser->hasVoteForQuestion($question->id)) {
                //i will update
                if(($vote === 1 && $authUser->hasQuestionUpvote($question->id))) {
                    // Has already liked and wants to unlike
                    $question->updateVote($vote, 1);
                } elseif(($vote === 1 && $authUser->hasQuestionDownvote($question->id))) {
                    // Had disliked and now wants to like
                    $question->updateVote($vote);
                } elseif(($vote === -1 && $authUser->hasQuestionDownvote($question->id))) {
                    // Has already disliked and wants to undislike
                    $question->updateVote($vote, -1);
                } elseif(($vote === -1 && $authUser->hasQuestionUpvote($question->id))) {
                    // Had liked and now wants to dislike
                    $question->updateVote($vote);
                }

            }else {
                // i will create a new vote
                $question->vote($vote);
            }
            return new JsonResponse([
                'success' => [
                    'question' => new QuestionDTO(
                        id: $question->id,
                        upvotes_count: $question->upvotes_count,
                        downvotes_count: $question->downvotes_count,
                        has_question_upvote: $authUser->hasQuestionUpvote($question->id),
                        has_question_downvote: $authUser->hasQuestionDownvote($question->id),
                    ),
                ]
            ]);
        } catch(Exception $e) {
            return new JsonResponse([
                'error' => "Some unexpected error " . $e,
            ]);
        }
    }

    public function voteAnswer(Question $question, Answer $answer, int $vote)
    {
        try {
            $authUser = auth()->user();
            if($authUser->hasVoteForAnswer($answer->id)) {
                //i will update
                if(($vote === 1 && $authUser->hasAnswerUpvote($answer->id))) {
                    // Has already liked and wants to unlike
                    $answer->updateVote($vote, 1);
                } elseif(($vote === 1 && $authUser->hasAnswerDownvote($answer->id))) {
                    // Had disliked and now wants to like
                    $answer->updateVote($vote);
                } elseif(($vote === -1 && $authUser->hasAnswerDownvote($answer->id))) {
                    // Has already disliked and wants to undislike
                    $answer->updateVote($vote, -1);
                } elseif(($vote === -1 && $authUser->hasAnswerUpvote($answer->id))) {
                    // Had liked and now wants to dislike
                    $answer->updateVote($vote);
                }

            }else {
                // i will create a new vote
                $answer->vote($vote);
            }
            return new JsonResponse([
                'success' => [
                    'answer' => new AnswerDTO(
                        id: $answer->id,
                        upvotes_count: $answer->upvotes_count,
                        downvotes_count: $answer->downvotes_count,
                        has_answer_upvote: $authUser->hasAnswerUpvote($answer->id),
                        has_answer_downvote: $authUser->hasAnswerDownvote($answer->id),
                    ),
                ]
            ]);
        } catch(Exception $e) {
            return new JsonResponse([
                'error' => "Some unexpected error " . $e,
            ]);
        }
    }
}
