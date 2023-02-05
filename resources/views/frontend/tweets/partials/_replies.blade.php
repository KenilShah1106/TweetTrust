<div id="replies">
    @foreach ($tweet->replies as $reply)
        <div class="section-card border border-width-3 border-success mt16 p16">
            <div class="section-details">
                <div class="section-header justify-content-between">
                    <div class="section-header-left">
                        <div class="user-info-container">
                            <div class="author-info">
                                <div class="author-image mr8">
                                    <img src="{{$reply->author->avatar}}" alt="Author image">
                                </div>
                                <div>
                                    <a href="" class="author-name mr8">{{$reply->author->name}} </a>
                                    <span class="date">Replied at: {{$reply->created_date}}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-header-right">
                        <div class="author-actions">
                            @can('performAuthorActions', $reply->toModel())
                                <a href="{{route('frontend.tweets.replies.edit', [$tweet->id, $reply->id])}}" class="btn btn-sm btn-outline-info  mr8">
                                    <i class="bi bi-pencil-square"></i>Edit
                                </a>
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger mr8"
                                        onclick="displayDeleteRepliesModal(event,{{$tweet->id}}, {{$reply->id}})"
                                        data-toggle="modal"
                                        data-target="#deleteRepliesModal">
                                    <i class="bi bi-trash"></i>Delete
                                </button>
                            @endcan
                            @can('performAuthorActions', $tweet->toModel())
                                <button type="button"
                                        id="markAsBestReplies-{{$reply->id}}"
                                        onclick="markAsBestReplies(event, {{$tweet->id}}, {{$reply->id}})"
                                        class="btn btn-sm btn-outline-success mr8">
                                    <i class="bi bi-check-circle"></i>Mark as best reply
                                </button>
                            @endcan
                        </div>
                    </div>

                </div>

                <div class="section-body">
                    <div class="section-content">
                        {!!$reply->body!!}
                    </div>
                </div>

                <div class="section-footer mt16">
                    <hr>
                    <div class="section-action-bar py12">
                        @auth
                            <form class="reply-upvote-form" data-id="{{$reply->id}}" method="POST">
                                @csrf
                                <button type="submit"
                                        title="Up Vote"
                                        class="action upvote btn {{auth()->user()->hasRepliesUpvote($reply->id) ? 'btn-success': 'btn-outline-success'}}"
                                >
                                    <i class="bi bi-caret-up mr8"></i>{{$reply->likes_count}}
                                </button>
                            </form>
                        @else
                            <a href="{{route('login')}}" title="Up Vote" class="action upvote btn-outline-success">
                                <i class="bi bi-caret-up mr8"></i>{{$reply->likes_count}}
                            </a>
                        @endauth
                        @auth
                            <form class="reply-downvote-form" data-id="{{$reply->id}}" method="POST">
                                @csrf
                                <button type="submit"
                                        title="Down Vote"
                                        class="action downvote btn {{auth()->user()->hasRepliesDownvote($reply->id) ? 'btn-danger': 'btn-outline-danger'}}"
                                >
                                    <i class="bi bi-caret-down mr8"></i>{{$reply->report_spam_count}}
                                </button>
                            </form>
                        @else
                            <a href="{{route('login')}}" title="Down Vote" class="action downvote btn-outline-danger">
                                <i class="bi bi-caret-down mr8"></i>{{$reply->report_spam_count}}
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
