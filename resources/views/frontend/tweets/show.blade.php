@extends('layouts.frontend.layout')

@section('title', 'View Tweet')

@section('hero-header-left')
    <h2 class="hero-title m-0">Tweet</h2>
@endsection

@section('hero-header-right')
    <a href="{{route('frontend.tweets.create')}}" class="btn btn-primary py12 px20">Ask a tweet</a>
@endsection

@section('hero-body')
    <div class="section-card mt20 p16">
        <div class="section-details">
            <div class="section-header justify-content-between">
                <div class="section-header-left">
                    {{-- <h2 class="section-title">{{$tweet->title}}</h2> --}}
                    <div class="section-subtitle">
                        <div class="tags-container">
                            <span>Asked {{$tweet->created_date}}</span>
                            <span class="ml12">Tags:</span>
                            <div class="tags">
                                @foreach ($tweet->tags as $tag)
                                    <a href="{{route('frontend.tags.show', $tag->id)}}"  class="tag badge badge-pill bg-outline-info">{{$tag->name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-header-right">
                    <div class="author-actions">
                        @can('performAuthorActions', $tweet->toModel())
                            <a href="{{route('frontend.tweets.edit', $tweet->id)}}" class="btn btn-sm btn-outline-info  mr8">
                                <i class="bi bi-pencil-square"></i>Edit
                            </a>
                            <button
                                type="button"
                                onclick="displayDeleteTweetModal({{$tweet->id}})"
                                class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                data-target="#deleteTweetModal">
                                <i class="bi-x-square mr-1"></i> Delete
                            </button>
                        @endcan
                    </div>
                </div>

            </div>

            <div class="section-body mb16">
                <div class="section-content">
                    {!!$tweet->body!!}
                </div>
            </div>
            <hr>
            <div class="section-footer d-flex py12">
                <div class="section-action-bar">
                    @auth
                        <form id="tweetUpvoteForm" method="POST">
                            @csrf
                            <button type="submit"
                                    title="Up Vote"
                                    class="action upvote btn {{auth()->user()->hasTweetUpvote($tweet->id) ? 'btn-success': 'btn-outline-success'}}"
                            >
                                <i class="bi bi-caret-up mr8"></i>{{$tweet->likes_count}}
                            </button>
                        </form>
                    @else
                        <a href="{{route('login')}}" title="Up Vote" class="action upvote btn-outline-success">
                            <i class="bi bi-caret-up mr8"></i>{{$tweet->likes_count}}
                        </a>
                    @endauth
                    @auth
                        <form id="tweetDownvoteForm" method="POST">
                            @csrf
                            <button type="submit"
                                    title="Down Vote"
                                    class="action downvote btn {{auth()->user()->hasTweetDownvote($tweet->id) ? 'btn-danger': 'btn-outline-danger'}}"
                            >
                                <i class="bi bi-caret-down mr8"></i>{{$tweet->report_spam_count}}
                            </button>
                        </form>
                    @else
                        <a href="{{route('login')}}" title="Down Vote" class="action downvote btn-outline-danger">
                            <i class="bi bi-caret-down mr8"></i>{{$tweet->report_spam_count}}
                        </a>
                    @endauth
                    <span class="action comment" title="Comments">
                        {{-- <i class="bi bi-chat mr8"></i>{{$tweet->comments_count}} --}}
                    </span>
                    <span class="action views">
                        {{-- <i class="bi bi-eye mr8"></i>{{$tweet->views_count}} --}}
                    </span>
                    <a href="" class="action bookmark" title="Bookmark this tweet">
                        <i class="bi bi-bookmark"></i>
                    </a>
                    <a href="" class="action flag" title="Flag as inappropriate">
                        <i class="bi bi-flag"></i>
                    </a>
                </div>
                <div class="user-info-container">
                    <span class="mr12">Asked by : </span>
                    <div class="author-info">
                        <div class="author-image mr8">
                            <img src="{{$tweet->author->avatar}}" alt="Author image">
                        </div>
                        <div>
                            <a href="{{route('frontend.users.show', $tweet->author->id)}}" class="author-name">{{$tweet->author->name}}</a>
                            {{-- <span class="reputation">Reputation: 123</span> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="comments-section">
                <hr>
                <div class="post-comment-section mt12">
                    <input type="text" class="form-control mr16 br-10 comment-field" placeholder="Leave a comment...">
                    <a href="" class="btn btn-sm btn-outline-primary ">Tweet replies</a>
                </div>
                <div class="comments mt12">
                    <h6 class="mb8">{{$tweet->replies_count}} Replies</h6>

                    {{-- @foreach ($tweet->comments as $comment)
                        <div class="comment mb4">
                            <span class="comment-body">{{$comment->body}}</span>
                            <a href="" class="comment-author ml2"> - {{$comment->author}}</a>
                            <span class="date mx2">{{$tweet->created_date}}</span>
                            <a href="" class="comment-action comment-upvote btn-outline-success">
                                <i class="bi bi-caret-up"></i> {{$tweet->likes_count}}
                            </a>
                            <a href="" class="comment-action comment-downvote btn-outline-danger">
                                <i class="bi bi-caret-down"></i> {{$tweet->report_spam_count}}
                            </a>
                            <a href="" class="comment-action comment-flag">
                                <i class="bi bi-flag"></i>
                            </a>
                        </div>
                    @endforeach --}}
                    {{-- <div class="comment mb4">
                        <span class="comment-body">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nam, illum.</span>
                        <a href="" class="comment-author ml2"> - Jane Doe</a>
                        <span class="date mx2">{{$tweet->created_date}}</span>
                        <a href="" class="comment-action comment-upvote btn-outline-success">
                            <i class="bi bi-caret-up"></i> {{$tweet->likes_count}}
                        </a>
                        <a href="" class="comment-action comment-downvote btn-outline-danger">
                            <i class="bi bi-caret-down"></i> {{$tweet->report_spam_count}}
                        </a>
                        <a href="" class="comment-action comment-flag">
                            <i class="bi bi-flag"></i>
                        </a>
                    </div>
                    <a href="" class="show-more-btn">Show more comments</a> --}}
                </div>

            </div>


        </div>
    </div>

    <div class="your-reply-section mt20">
        <h3 class="section-heading">Replies this tweet</h3>
        <form id="replyForm" class="reply-form my12" method="POST">
            <input id="replyBody" type="hidden" name="body">
            <trix-editor input="replyBody" placeholder="Write your reply here ..." id="trixReplies"></trix-editor>
            @error('body')
                <small id="errorHelp" class="form-text text-danger">{{ $message }}</small>
            @enderror
            <div class="text-right mt-2">
                <button type="submit"
                        class="btn btn-info">
                        Post Replies
                </button>
            </div>
        </form>
    </div>
    @include('frontend.tweets.partials._replies',['tweet'=> $tweet])
    @include('frontend.tweets.partials._modals')
@endsection

@section('page-level-scripts')
    <script type="text/javascript">

        function displayDeleteTweetModal($tweetId) {
            var url = '/tweets/' + $tweetId;
            $('#deleteTweetForm').attr('action', url);
        }

        function displayDeleteRepliesModal(e, $tweetId, $replyId) {
            const replySectionCard = $(e.target).parents('.section-card');
            document.getElementById('deleteReplies').addEventListener('click', function(e) {
                deleteReplies(e, $tweetId, $replyId, replySectionCard);
            });
        }
        // AJAX for deleting reply
        function deleteReplies(e, $tweetId, $replyId, replySectionCard){
            e.preventDefault();
            var $url = '/tweets/' + $tweetId + '/replies/' + $replyId;
            $.ajax({
                method: "DELETE",
                url: $url,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    $("#deleteRepliesModal").modal('toggle');
                    $(replySectionCard).remove();
                    const message = response.success.message;
                    const alert = `<div class="alert alert-success alert-dismissible fade show my-5" role="alert">
                                    <div class="flex">
                                        ${message}
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        &times;
                                    </button>
                                </div>`;
                    $('.hero-body').prepend(alert);

                },
                error: function(response) {
                    console.error(response);
                }
            });
        }

        registerEvents();
        // AJAX for submiting new reply
        $("#replyForm").submit((e) => {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('tweets.replies.store', $tweet->id) }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    body: $('input[name=body]').val(),
                },
                success: function(response) {
                    $('#trixReplies').val('');
                    const reply = response.success;
                    const tweet = response.success.tweet;
                    // URLS
                    let editUrl = '{{route("frontend.tweets.replies.edit", [":tweetId", ":replyId"])}}';
                    editUrl = editUrl.replace(':tweetId', tweet.id);
                    editUrl = editUrl.replace(':replyId', reply.id);;
                    let upvoteClass = '{{auth()->user() ? (auth()->user()->hasRepliesUpvote(":replyId") ? "btn-success" : "btn-outline-success") : "btn-outline-success"}}';
                    upvoteClass = upvoteClass.replace(':replyId', reply.id);
                    let downvoteClass = '{{auth()->user() ? (auth()->user()->hasRepliesDownvote(":replyId") ? "btn-danger" : "btn-outline-danger") : "btn-outline-danger"}}';
                    downvoteClass = downvoteClass.replace(':replyId', reply.id);
                    let html = `<div class="section-card mt16 p16">
                                    <div class="section-details">
                                        <div class="section-header justify-content-between">
                                            <div class="section-header-left">
                                                <div class="user-info-container">
                                                    <div class="author-info">
                                                        <div class="author-image mr8">
                                                            <img src="${reply.author.avatar}" alt="Author image">
                                                        </div>
                                                        <div>
                                                            <a href="" class="author-name">${reply.author.name}    <span class="reputation">Reputation: 123</span> </a>
                                                            <span class="date">Repliesed ${reply.created_date}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="section-header-right">
                                                <div class="author-actions">
                                                    <a href="${editUrl}" class="btn btn-sm btn-outline-info  mr8">
                                                        <i class="bi bi-pencil-square"></i>Edit
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="displayDeleteRepliesModal(event, ${tweet.id}, ${reply.id})"
                                                            data-toggle="modal"
                                                            data-target="#deleteRepliesModal">
                                                        <i class="bi bi-trash"></i>Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="section-body">
                                            <div class="section-content">
                                                ${reply.body}
                                            </div>
                                        </div>
                                        <div class="section-footer mt16">
                                            <hr>
                                            <div class="section-action-bar py12">
                                                @auth
                                                    <form class="reply-upvote-form" data-id="${reply.id}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                                title="Up Vote"
                                                                class="action upvote btn ${upvoteClass}"
                                                        >
                                                            <i class="bi bi-caret-up mr8"></i>${reply.likes_count}
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{route('login')}}" title="Up Vote" class="action upvote btn-outline-success">
                                                        <i class="bi bi-caret-up mr8"></i>${reply.likes_count}
                                                    </a>
                                                @endauth
                                                @auth
                                                    <form class="reply-downvote-form" data-id="${reply.id}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                                title="Down Vote"
                                                                class="action downvote btn ${downvoteClass}"
                                                        >
                                                            <i class="bi bi-caret-down mr8"></i>${reply.report_spam_count}
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{route('login')}}" title="Down Vote" class="action downvote btn-outline-danger">
                                                        <i class="bi bi-caret-down mr8"></i>${reply.report_spam_count}
                                                    </a>
                                                @endauth
                                                <a href="" class="action flag" title="Flag as inappropriate">
                                                    <i class="bi bi-flag"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                    $('#replies').prepend(html);
                    registerEvents();
                },
                statusCode: {
                    401: function(response) {
                        window.location.href = "{{route('login')}}";
                    }
                },
                error: function(response) {
                    console.log(response);
                },
            });
        });
        function registerEvents() {
            document.querySelectorAll(".reply-upvote-form .upvote").forEach(element => {
                element.addEventListener('click', upvoteReplies);
            });
            document.querySelectorAll('.reply-downvote-form .downvote').forEach(element => {
                element.addEventListener('click', downvoteReplies);
            });
        }

        // AJAX for upvoting reply
        function upvoteReplies(e){
            e.preventDefault();
            let form, upvoteBtn;
            if(e.target.parentElement.classList.contains('reply-upvote-form')) {
                form  = $(e.target.parentElement);
            } else {
                form = $(e.target.parentElement.parentElement);
            }
            if(e.target.classList.contains('upvote')) {
                upvoteBtn = $(e.target);
            } else {
                upvoteBtn = $(e.target.parentElement);
            }
            const replyId = form.data('id');
            let upvoteUrl = "{{route('tweets.replies.vote', [$tweet->id, ':replyId', 1])}}";
            upvoteUrl = upvoteUrl.replace(':replyId', replyId);
            $.ajax({
                method: 'POST',
                url: upvoteUrl,
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    const reply = response.success.reply;
                    let upvoteClass = reply.has_reply_upvote ? 'btn-success' : 'btn-outline-success';
                    // // By default removing both the classes
                    if(upvoteBtn.hasClass('btn-success')) {
                        upvoteBtn.removeClass("btn-success")
                    }
                    if(upvoteBtn.hasClass('btn-outline-success')) {
                        upvoteBtn.removeClass("btn-outline-success");
                    }
                    upvoteBtn.addClass(upvoteClass);
                    upvoteBtn.html(`<i class="bi bi-caret-up mr8"></i>${reply.likes_count}`);
                    upvoteClass = "";

                    // We also need to update the downvote btn
                    const downvoteBtn = form.siblings('.reply-downvote-form').children('.downvote');
                    downvoteBtn.removeClass('btn-danger');
                    downvoteBtn.addClass('btn-outline-danger');
                    downvoteBtn.html(`<i class="bi bi-caret-down mr8"></i>${reply.report_spam_count}`);

                },
                error: function(response) {
                    console.log(response);
                },
            });
        }

        // AJAX for downvoting reply
        function downvoteReplies(e){
            e.preventDefault();
            let form, downvoteBtn;
            if(e.target.parentElement.classList.contains('reply-downvote-form')) {
                form  = $(e.target.parentElement);
            } else {
                form = $(e.target.parentElement.parentElement);
            }
            if(e.target.classList.contains('downvote')) {
                downvoteBtn = $(e.target);
            } else {
                downvoteBtn = $(e.target.parentElement);
            }
            const replyId = form.data('id');
            let downvoteUrl = "{{route('tweets.replies.vote', [$tweet->id, ':replyId', -1])}}";
            downvoteUrl = downvoteUrl.replace(':replyId', replyId);
            $.ajax({
                method: 'POST',
                url: downvoteUrl,
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    console.log(response);
                    const reply = response.success.reply;
                    let downvoteClass = reply.has_reply_downvote ? 'btn-danger' : 'btn-outline-danger';
                    // // By default removing both the classes
                    if(downvoteBtn.hasClass('btn-danger')) {
                        downvoteBtn.removeClass("btn-danger")
                    }
                    if(downvoteBtn.hasClass('btn-outline-danger')) {
                        downvoteBtn.removeClass("btn-outline-danger");
                    }
                    downvoteBtn.addClass(downvoteClass);
                    downvoteBtn.html(`<i class="bi bi-caret-down mr8"></i>${reply.report_spam_count}`);
                    downvoteClass = "";

                    // We also need to update the upvote btn
                    const upvoteBtn = form.siblings('.reply-upvote-form').children('.upvote');
                    upvoteBtn.removeClass('btn-success');
                    upvoteBtn.addClass('btn-outline-success');
                    upvoteBtn.html(`<i class="bi bi-caret-up mr8"></i>${reply.likes_count}`);
                },
                error: function(response) {
                    console.log(response);
                },
            });
        }

        // AJAX for upvoting tweet
        $("#tweetUpvoteForm").submit((e) => {
            e.preventDefault();
            const upvoteBtn = $("#tweetUpvoteForm .upvote");
            const downvoteBtn = $("#tweetDownvoteForm .downvote");
            $.ajax({
                method: "POST",
                url: "{{route('tweets.vote', [$tweet->id, 1])}}",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    const tweet = response.success.tweet;
                    let upvoteClass = tweet.has_tweet_upvote ? 'btn-success' : 'btn-outline-success';
                    // By default removing both the classes
                    if(upvoteBtn.hasClass('btn-success')) {
                        upvoteBtn.removeClass("btn-success")
                    }
                    if(upvoteBtn.hasClass('btn-outline-success')) {
                        upvoteBtn.removeClass("btn-outline-success");
                    }
                    upvoteBtn.addClass(upvoteClass);
                    upvoteBtn.html(`<i class="bi bi-caret-up mr8"></i>${tweet.likes_count}`);
                    upvoteClass = "";

                    // We also need to update the downvote btn
                    downvoteBtn.removeClass('btn-danger');
                    downvoteBtn.addClass('btn-outline-danger');
                    downvoteBtn.html(`<i class="bi bi-caret-down mr8"></i>${tweet.report_spam_count}`);
                },
                error: function(response) {
                    console.error(response);
                }
            });
        });
        // AJAX for downvoting tweet
        $("#tweetDownvoteForm").submit((e) => {
            e.preventDefault();
            const upvoteBtn = $("#tweetUpvoteForm .upvote");
            const downvoteBtn = $("#tweetDownvoteForm .downvote");
            $.ajax({
                method: "POST",
                url: "{{route('tweets.vote', [$tweet->id, -1])}}",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    const tweet = response.success.tweet;
                    let downvoteClass = tweet.has_tweet_downvote ? 'btn-danger' : 'btn-outline-danger';
                    // By default removing both the classes
                    if(downvoteBtn.hasClass('btn-danger')) {
                        downvoteBtn.removeClass("btn-danger")
                    }
                    if(downvoteBtn.hasClass('btn-outline-danger')) {
                        downvoteBtn.removeClass("btn-outline-danger");
                    }
                    downvoteBtn.addClass(downvoteClass);
                    downvoteBtn.html(`<i class="bi bi-caret-down mr8"></i>${tweet.report_spam_count}`);
                    downvoteClass = "";

                    // We also need to update the downvote btn
                    upvoteBtn.removeClass('btn-success');
                    upvoteBtn.addClass('btn-outline-success');
                    upvoteBtn.html(`<i class="bi bi-caret-up mr8"></i>${tweet.likes_count}`);
                },
                error: function(response) {
                    console.error(response);
                }
            });
        });

        // AJAX for Mark as Best Replies
        // // PENDING
        // function markAsBestReplies(e, tweetId, replyId) {
        //     e.preventDefault();
        //     const replySectionCard = $(e.target).parents('.section-card');
        //     $.ajax({
        //         method: "PUT",
        //         data: {
        //             _token: "{{csrf_token()}}"
        //         }
        //     });
        // }
    </script>
@endsection
