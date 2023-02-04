<div id="answers">
    @foreach ($question->answers as $answer)
        <div class="section-card border border-width-3 border-success mt16 p16">
            <div class="section-details">
                <div class="section-header justify-content-between">
                    <div class="section-header-left">
                        <div class="user-info-container">
                            <div class="author-info">
                                <div class="author-image mr8">
                                    <img src="{{$answer->author->avatar}}" alt="Author image">
                                </div>
                                <div>
                                    <a href="" class="author-name mr8">{{$answer->author->name}} <span class="reputation">Reputation: 123</span> </a>
                                    <span class="date">Answered {{$answer->created_date}}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-header-right">
                        <div class="author-actions">
                            @can('performAuthorActions', $answer->toModel())
                                <a href="{{route('frontend.questions.answers.edit', [$question->id, $answer->id])}}" class="btn btn-sm btn-outline-info  mr8">
                                    <i class="bi bi-pencil-square"></i>Edit
                                </a>
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger mr8"
                                        onclick="displayDeleteAnswerModal(event,{{$question->id}}, {{$answer->id}})"
                                        data-toggle="modal"
                                        data-target="#deleteAnswerModal">
                                    <i class="bi bi-trash"></i>Delete
                                </button>
                            @endcan
                            @can('performAuthorActions', $question->toModel())
                                <button type="button"
                                        id="markAsBestAnswer-{{$answer->id}}"
                                        onclick="markAsBestAnswer(event, {{$question->id}}, {{$answer->id}})"
                                        class="btn btn-sm btn-outline-success mr8">
                                    <i class="bi bi-check-circle"></i>Mark as best answer
                                </button>
                            @endcan
                        </div>
                    </div>

                </div>

                <div class="section-body">
                    <div class="section-content">
                        {!!$answer->body!!}
                    </div>
                </div>

                <div class="section-footer mt16">
                    <hr>
                    <div class="section-action-bar py12">
                        @auth
                            <form class="answer-upvote-form" data-id="{{$answer->id}}" method="POST">
                                @csrf
                                <button type="submit"
                                        title="Up Vote"
                                        class="action upvote btn {{auth()->user()->hasAnswerUpvote($answer->id) ? 'btn-success': 'btn-outline-success'}}"
                                >
                                    <i class="bi bi-caret-up mr8"></i>{{$answer->upvotes_count}}
                                </button>
                            </form>
                        @else
                            <a href="{{route('login')}}" title="Up Vote" class="action upvote btn-outline-success">
                                <i class="bi bi-caret-up mr8"></i>{{$answer->upvotes_count}}
                            </a>
                        @endauth
                        @auth
                            <form class="answer-downvote-form" data-id="{{$answer->id}}" method="POST">
                                @csrf
                                <button type="submit"
                                        title="Down Vote"
                                        class="action downvote btn {{auth()->user()->hasAnswerDownvote($answer->id) ? 'btn-danger': 'btn-outline-danger'}}"
                                >
                                    <i class="bi bi-caret-down mr8"></i>{{$answer->downvotes_count}}
                                </button>
                            </form>
                        @else
                            <a href="{{route('login')}}" title="Down Vote" class="action downvote btn-outline-danger">
                                <i class="bi bi-caret-down mr8"></i>{{$answer->downvotes_count}}
                            </a>
                        @endauth
{{--                        <a href="" class="action flag" title="Flag as inappropriate">--}}
{{--                            <i class="bi bi-flag"></i>--}}
{{--                        </a>--}}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
