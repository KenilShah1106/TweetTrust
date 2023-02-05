<?php

namespace App\Http\Controllers;

use App\Constants\TweetConstants;
use App\DTO\Replies\RepliesDTO;
use App\DTO\Tweets\TweetDTO;
use App\DTO\Users\UserDTO;
use App\Http\Requests\Replies\CreateRepliesRequest;
use App\Http\Requests\Replies\UpdateRepliesRequest;
use App\Models\Replies;
use App\Models\Tweet;
use App\Models\User;
use App\Services\RepliesService;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RepliesController extends Controller
{
    public function __construct(private RepliesService $replyService){}

    public function store(CreateRepliesRequest $request, Tweet $tweet)
    {
        try {
            $replyDTO = $this->replyService->store(new RepliesDTO(
                body: $request->body,
                user_id: auth()->id(),
                tweet_id: $tweet->id,
                likes_count: 0,
                report_spam_count: 0,
            ));
            // i have to manually set these values
            $user = User::findOrFail(auth()->id());
            $replyDTO->author = new UserDTO(...$user->toArray());
            $replyDTO->author->avatar = $user->avatar;
            $replyDTO->tweet = new TweetDTO(...$tweet->toArray());
            $replyDTO->created_date = (new Carbon($replyDTO->created_at))->diffForHumans();
            $replyDTO->updated_date = (new Carbon($replyDTO->updated_at))->diffForHumans();
            return new JsonResponse([
                'success' => $replyDTO,
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

    public function update(UpdateRepliesRequest $request, Tweet $tweet, Replies $reply)
    {
        try {
            $this->replyService->update(new RepliesDTO(
                body: $request->body,
            ), $reply);
            session()->flash('success', 'Replies updated successfully');
            return redirect(route('frontend.tweets.show', $tweet->id));
        }catch(Exception $e) {
            session()->flash('error', 'Please change some value to update');
            return redirect()->back();
        }

    }
    public function destroy(Tweet $tweet, Replies $reply)
    {
        try {
            $reply->delete();
            return new JsonResponse([
                'success' => [
                    'message' => 'Replies Deleted Successfully!',
                ]
            ]);
        } catch(Exception $e) {
            return new JsonResponse([
                'error' => 'Some unexpected error ' . $e
            ]);
        }

    }
}
