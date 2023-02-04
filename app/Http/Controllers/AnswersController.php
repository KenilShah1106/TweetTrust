<?php

namespace App\Http\Controllers;

use App\DTO\Answers\AnswerDTO;
use App\DTO\Users\UserDTO;
use App\Http\Requests\Answers\CreateAnswerRequest;
use App\Http\Requests\Answers\UpdateAnswerRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Services\AnswerService;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AnswersController extends Controller
{
    public function __construct(private AnswerService $answerService){}

    public function store(CreateAnswerRequest $request, Question $question)
    {
        try {
            $answerDTO = $this->answerService->store(new AnswerDTO(
                body: $request->body,
                user_id: auth()->id(),
                question_id: $question->id,
                upvotes_count: 0,
                downvotes_count: 0,
            ));
            // i have to manually set these values
            $user = User::findOrFail(auth()->id());
            $answerDTO->author = new UserDTO(...$user->toArray());
            $answerDTO->author->avatar = $user->avatar;
            $answerDTO->created_date = (new Carbon($answerDTO->created_at))->diffForHumans();
            $answerDTO->updated_date = (new Carbon($answerDTO->updated_at))->diffForHumans();
            return new JsonResponse([
                'success' => $answerDTO,
            ]);
        } catch(ValidationException $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ]);
        } catch(AuthenticationException $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ]);
        } catch(Exception $e) {
            return new JsonResponse([
                'error' => "Your request was not processed due to a server error" . $e,
            ]);
        }
    }

    public function update(UpdateAnswerRequest $request, Question $question, Answer $answer)
    {
        try {
            $this->answerService->update(new AnswerDTO(
                body: $request->body,
            ), $answer);
            session()->flash('success', 'Answer updated successfully');
            return redirect(route('frontend.questions.show', $question->id));
        }catch(Exception $e) {
            session()->flash('error', 'Please change some value to update');
            return redirect()->back();
        }

    }
    public function destroy(Question $question, Answer $answer)
    {
        try {
            $answer->delete();
            return new JsonResponse([
                'success' => [
                    'message' => 'Answer Deleted Successfully!',
                ]
            ]);
        } catch(Exception $e) {
            return new JsonResponse([
                'error' => 'Some unexpected error ' . $e
            ]);
        }

    }
}
