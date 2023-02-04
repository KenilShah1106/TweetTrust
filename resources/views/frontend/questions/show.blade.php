@extends('layouts.frontend.layout')

@section('title', 'View Question')

@section('hero-header-left')
    <h2 class="hero-title m-0">Question</h2>
@endsection

@section('hero-header-right')
    <a href="{{route('frontend.questions.create')}}" class="btn btn-primary py12 px20">Ask a question</a>
@endsection

@section('hero-body')
    <div class="section-card mt20 p16">
        <div class="section-details">
            <div class="section-header justify-content-between">
                <div class="section-header-left">
                    <h2 class="section-title">{{$question->title}}</h2>
                    <div class="section-subtitle">
                        <div class="tags-container">
                            <span>Asked {{$question->created_date}}</span>
                            <span class="ml12">Tags:</span>
                            <div class="tags">
                                @foreach ($question->tags as $tag)
                                    <a href="{{route('frontend.tags.show', $tag->id)}}"  class="tag badge badge-pill bg-outline-info">{{$tag->name}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-header-right">
                    <div class="author-actions">
                        @can('performAuthorActions', $question->toModel())
                            <a href="{{route('frontend.questions.edit', $question->id)}}" class="btn btn-sm btn-outline-info  mr8">
                                <i class="bi bi-pencil-square"></i>Edit
                            </a>
                            <button
                                type="button"
                                onclick="displayDeleteQuestionModal({{$question->id}})"
                                class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                data-target="#deleteQuestionModal">
                                <i class="bi-x-square mr-1"></i> Delete
                            </button>
                        @endcan
                    </div>
                </div>

            </div>

            <div class="section-body mb16">
                <div class="section-content">
                    {!!$question->body!!}
                </div>
            </div>
            <hr>
            <div class="section-footer d-flex py12">
                <div class="section-action-bar">
                    @auth
                        <form id="questionUpvoteForm" method="POST">
                            @csrf
                            <button type="submit"
                                    title="Up Vote"
                                    class="action upvote btn {{auth()->user()->hasQuestionUpvote($question->id) ? 'btn-success': 'btn-outline-success'}}"
                            >
                                <i class="bi bi-caret-up mr8"></i>{{$question->upvotes_count}}
                            </button>
                        </form>
                    @else
                        <a href="{{route('login')}}" title="Up Vote" class="action upvote btn-outline-success">
                            <i class="bi bi-caret-up mr8"></i>{{$question->upvotes_count}}
                        </a>
                    @endauth
                    @auth
                        <form id="questionDownvoteForm" method="POST">
                            @csrf
                            <button type="submit"
                                    title="Down Vote"
                                    class="action downvote btn {{auth()->user()->hasQuestionDownvote($question->id) ? 'btn-danger': 'btn-outline-danger'}}"
                            >
                                <i class="bi bi-caret-down mr8"></i>{{$question->downvotes_count}}
                            </button>
                        </form>
                    @else
                        <a href="{{route('login')}}" title="Down Vote" class="action downvote btn-outline-danger">
                            <i class="bi bi-caret-down mr8"></i>{{$question->downvotes_count}}
                        </a>
                    @endauth
                    <span class="action comment" title="Comments">
                        <i class="bi bi-chat mr8"></i>{{$question->comments_count}}
                    </span>
                    <span class="action views">
                        <i class="bi bi-eye mr8"></i>{{$question->views_count}}
                    </span>
                    <a href="" class="action bookmark" title="Bookmark this question">
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
                            <img src="{{$question->author->avatar}}" alt="Author image">
                        </div>
                        <div>
                            <a href="{{route('frontend.users.show', $question->author->id)}}" class="author-name">{{$question->author->name}}</a>
                            <span class="reputation">Reputation: 123</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="comments-section">
                <hr>
                <div class="post-comment-section mt12">
                    <input type="text" class="form-control mr16 br-10 comment-field" placeholder="Leave a comment...">
                    <a href="" class="btn btn-sm btn-outline-primary ">Post comment</a>
                </div>
                <div class="comments mt12">
                    <h6 class="mb8">{{$question->comments_count}} Comments</h6>

                    {{-- @foreach ($question->comments as $comment)
                        <div class="comment mb4">
                            <span class="comment-body">{{$comment->body}}</span>
                            <a href="" class="comment-author ml2"> - {{$comment->author}}</a>
                            <span class="date mx2">{{$question->created_date}}</span>
                            <a href="" class="comment-action comment-upvote btn-outline-success">
                                <i class="bi bi-caret-up"></i> {{$question->upvotes_count}}
                            </a>
                            <a href="" class="comment-action comment-downvote btn-outline-danger">
                                <i class="bi bi-caret-down"></i> {{$question->downvotes_count}}
                            </a>
                            <a href="" class="comment-action comment-flag">
                                <i class="bi bi-flag"></i>
                            </a>
                        </div>
                    @endforeach --}}
                    {{-- <div class="comment mb4">
                        <span class="comment-body">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nam, illum.</span>
                        <a href="" class="comment-author ml2"> - Jane Doe</a>
                        <span class="date mx2">{{$question->created_date}}</span>
                        <a href="" class="comment-action comment-upvote btn-outline-success">
                            <i class="bi bi-caret-up"></i> {{$question->upvotes_count}}
                        </a>
                        <a href="" class="comment-action comment-downvote btn-outline-danger">
                            <i class="bi bi-caret-down"></i> {{$question->downvotes_count}}
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

    <div class="your-answer-section mt20">
        <h3 class="section-heading">Answer this question</h3>
        <form id="answerForm" class="answer-form my12" method="POST">
            <input id="answerBody" type="hidden" name="body">
            <trix-editor input="answerBody" placeholder="Write your answer here ..." id="trixAnswer"></trix-editor>
            @error('body')
                <small id="errorHelp" class="form-text text-danger">{{ $message }}</small>
            @enderror
            <div class="text-right mt-2">
                <button type="submit"
                        class="btn btn-info">
                        Post Answer
                </button>
            </div>
        </form>
    </div>
    @include('frontend.questions.partials._answers',['question'=> $question])
    @include('frontend.questions.partials._modals')
@endsection

@section('page-level-scripts')
    <script type="text/javascript">

        function displayDeleteQuestionModal($questionId) {
            var url = '/questions/' + $questionId;
            $('#deleteQuestionForm').attr('action', url);
        }

        function displayDeleteAnswerModal(e, $questionId, $answerId) {
            const answerSectionCard = $(e.target).parents('.section-card');
            document.getElementById('deleteAnswer').addEventListener('click', function(e) {
                deleteAnswer(e, $questionId, $answerId, answerSectionCard);
            });
        }
        // AJAX for deleting answer
        function deleteAnswer(e, $questionId, $answerId, answerSectionCard){
            e.preventDefault();
            var $url = '/questions/' + $questionId + '/answers/' + $answerId;
            $.ajax({
                method: "DELETE",
                url: $url,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    $("#deleteAnswerModal").modal('toggle');
                    $(answerSectionCard).remove();
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
        // AJAX for submiting new answer
        $("#answerForm").submit((e) => {
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{ route('questions.answers.store', $question->id) }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    body: $('input[name=body]').val(),
                },
                success: function(response) {
                    $('#trixAnswer').val('');
                    const answer = response.success;
                    const question = response.success.question;
                    // URLS
                    let editUrl = '{{route("frontend.questions.answers.edit", [":questionId", ":answerId"])}}';
                    editUrl = editUrl.replace(':questionId', question.id);
                    editUrl = editUrl.replace(':answerId', answer.id);;
                    let upvoteClass = '{{auth()->user() ? (auth()->user()->hasAnswerUpvote(":answerId") ? "btn-success" : "btn-outline-success") : "btn-outline-success"}}';
                    upvoteClass = upvoteClass.replace(':answerId', answer.id);
                    let downvoteClass = '{{auth()->user() ? (auth()->user()->hasAnswerDownvote(":answerId") ? "btn-danger" : "btn-outline-danger") : "btn-outline-danger"}}';
                    downvoteClass = downvoteClass.replace(':answerId', answer.id);
                    let html = `<div class="section-card mt16 p16">
                                    <div class="section-details">
                                        <div class="section-header justify-content-between">
                                            <div class="section-header-left">
                                                <div class="user-info-container">
                                                    <div class="author-info">
                                                        <div class="author-image mr8">
                                                            <img src="${answer.author.avatar}" alt="Author image">
                                                        </div>
                                                        <div>
                                                            <a href="" class="author-name">${answer.author.name}    <span class="reputation">Reputation: 123</span> </a>
                                                            <span class="date">Answered ${answer.created_date}</span>
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
                                                            onclick="displayDeleteAnswerModal(event, ${question.id}, ${answer.id})"
                                                            data-toggle="modal"
                                                            data-target="#deleteAnswerModal">
                                                        <i class="bi bi-trash"></i>Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="section-body">
                                            <div class="section-content">
                                                ${answer.body}
                                            </div>
                                        </div>
                                        <div class="section-footer mt16">
                                            <hr>
                                            <div class="section-action-bar py12">
                                                @auth
                                                    <form class="answer-upvote-form" data-id="${answer.id}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                                title="Up Vote"
                                                                class="action upvote btn ${upvoteClass}"
                                                        >
                                                            <i class="bi bi-caret-up mr8"></i>${answer.upvotes_count}
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{route('login')}}" title="Up Vote" class="action upvote btn-outline-success">
                                                        <i class="bi bi-caret-up mr8"></i>${answer.upvotes_count}
                                                    </a>
                                                @endauth
                                                @auth
                                                    <form class="answer-downvote-form" data-id="${answer.id}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                                title="Down Vote"
                                                                class="action downvote btn ${downvoteClass}"
                                                        >
                                                            <i class="bi bi-caret-down mr8"></i>${answer.downvotes_count}
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{route('login')}}" title="Down Vote" class="action downvote btn-outline-danger">
                                                        <i class="bi bi-caret-down mr8"></i>${answer.downvotes_count}
                                                    </a>
                                                @endauth
                                                <a href="" class="action flag" title="Flag as inappropriate">
                                                    <i class="bi bi-flag"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                    $('#answers').prepend(html);
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
            document.querySelectorAll(".answer-upvote-form .upvote").forEach(element => {
                element.addEventListener('click', upvoteAnswer);
            });
            document.querySelectorAll('.answer-downvote-form .downvote').forEach(element => {
                element.addEventListener('click', downvoteAnswer);
            });
        }

        // AJAX for upvoting answer
        function upvoteAnswer(e){
            e.preventDefault();
            let form, upvoteBtn;
            if(e.target.parentElement.classList.contains('answer-upvote-form')) {
                form  = $(e.target.parentElement);
            } else {
                form = $(e.target.parentElement.parentElement);
            }
            if(e.target.classList.contains('upvote')) {
                upvoteBtn = $(e.target);
            } else {
                upvoteBtn = $(e.target.parentElement);
            }
            const answerId = form.data('id');
            let upvoteUrl = "{{route('questions.answers.vote', [$question->id, ':answerId', 1])}}";
            upvoteUrl = upvoteUrl.replace(':answerId', answerId);
            $.ajax({
                method: 'POST',
                url: upvoteUrl,
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    const answer = response.success.answer;
                    let upvoteClass = answer.has_answer_upvote ? 'btn-success' : 'btn-outline-success';
                    // // By default removing both the classes
                    if(upvoteBtn.hasClass('btn-success')) {
                        upvoteBtn.removeClass("btn-success")
                    }
                    if(upvoteBtn.hasClass('btn-outline-success')) {
                        upvoteBtn.removeClass("btn-outline-success");
                    }
                    upvoteBtn.addClass(upvoteClass);
                    upvoteBtn.html(`<i class="bi bi-caret-up mr8"></i>${answer.upvotes_count}`);
                    upvoteClass = "";

                    // We also need to update the downvote btn
                    const downvoteBtn = form.siblings('.answer-downvote-form').children('.downvote');
                    downvoteBtn.removeClass('btn-danger');
                    downvoteBtn.addClass('btn-outline-danger');
                    downvoteBtn.html(`<i class="bi bi-caret-down mr8"></i>${answer.downvotes_count}`);

                },
                error: function(response) {
                    console.log(response);
                },
            });
        }

        // AJAX for downvoting answer
        function downvoteAnswer(e){
            e.preventDefault();
            let form, downvoteBtn;
            if(e.target.parentElement.classList.contains('answer-downvote-form')) {
                form  = $(e.target.parentElement);
            } else {
                form = $(e.target.parentElement.parentElement);
            }
            if(e.target.classList.contains('downvote')) {
                downvoteBtn = $(e.target);
            } else {
                downvoteBtn = $(e.target.parentElement);
            }
            const answerId = form.data('id');
            let downvoteUrl = "{{route('questions.answers.vote', [$question->id, ':answerId', -1])}}";
            downvoteUrl = downvoteUrl.replace(':answerId', answerId);
            $.ajax({
                method: 'POST',
                url: downvoteUrl,
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    const answer = response.success.answer;
                    let downvoteClass = answer.has_answer_downvote ? 'btn-danger' : 'btn-outline-danger';
                    // // By default removing both the classes
                    if(downvoteBtn.hasClass('btn-danger')) {
                        downvoteBtn.removeClass("btn-danger")
                    }
                    if(downvoteBtn.hasClass('btn-outline-danger')) {
                        downvoteBtn.removeClass("btn-outline-danger");
                    }
                    downvoteBtn.addClass(downvoteClass);
                    downvoteBtn.html(`<i class="bi bi-caret-down mr8"></i>${answer.downvotes_count}`);
                    downvoteClass = "";

                    // We also need to update the upvote btn
                    const upvoteBtn = form.siblings('.answer-upvote-form').children('.upvote');
                    upvoteBtn.removeClass('btn-success');
                    upvoteBtn.addClass('btn-outline-success');
                    upvoteBtn.html(`<i class="bi bi-caret-up mr8"></i>${answer.upvotes_count}`);
                },
                error: function(response) {
                    console.log(response);
                },
            });
        }

        // AJAX for upvoting question
        $("#questionUpvoteForm").submit((e) => {
            e.preventDefault();
            const upvoteBtn = $("#questionUpvoteForm .upvote");
            const downvoteBtn = $("#questionDownvoteForm .downvote");
            $.ajax({
                method: "POST",
                url: "{{route('questions.vote', [$question->id, 1])}}",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    const question = response.success.question;
                    let upvoteClass = question.has_question_upvote ? 'btn-success' : 'btn-outline-success';
                    // By default removing both the classes
                    if(upvoteBtn.hasClass('btn-success')) {
                        upvoteBtn.removeClass("btn-success")
                    }
                    if(upvoteBtn.hasClass('btn-outline-success')) {
                        upvoteBtn.removeClass("btn-outline-success");
                    }
                    upvoteBtn.addClass(upvoteClass);
                    upvoteBtn.html(`<i class="bi bi-caret-up mr8"></i>${question.upvotes_count}`);
                    upvoteClass = "";

                    // We also need to update the downvote btn
                    downvoteBtn.removeClass('btn-danger');
                    downvoteBtn.addClass('btn-outline-danger');
                    downvoteBtn.html(`<i class="bi bi-caret-down mr8"></i>${question.downvotes_count}`);
                },
                error: function(response) {
                    console.error(response);
                }
            });
        });
        // AJAX for downvoting question
        $("#questionDownvoteForm").submit((e) => {
            e.preventDefault();
            const upvoteBtn = $("#questionUpvoteForm .upvote");
            const downvoteBtn = $("#questionDownvoteForm .downvote");
            $.ajax({
                method: "POST",
                url: "{{route('questions.vote', [$question->id, -1])}}",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    const question = response.success.question;
                    let downvoteClass = question.has_question_downvote ? 'btn-danger' : 'btn-outline-danger';
                    // By default removing both the classes
                    if(downvoteBtn.hasClass('btn-danger')) {
                        downvoteBtn.removeClass("btn-danger")
                    }
                    if(downvoteBtn.hasClass('btn-outline-danger')) {
                        downvoteBtn.removeClass("btn-outline-danger");
                    }
                    downvoteBtn.addClass(downvoteClass);
                    downvoteBtn.html(`<i class="bi bi-caret-down mr8"></i>${question.downvotes_count}`);
                    downvoteClass = "";

                    // We also need to update the downvote btn
                    upvoteBtn.removeClass('btn-success');
                    upvoteBtn.addClass('btn-outline-success');
                    upvoteBtn.html(`<i class="bi bi-caret-up mr8"></i>${question.upvotes_count}`);
                },
                error: function(response) {
                    console.error(response);
                }
            });
        });

        // AJAX for Mark as Best Answer
        // // PENDING
        // function markAsBestAnswer(e, questionId, answerId) {
        //     e.preventDefault();
        //     const answerSectionCard = $(e.target).parents('.section-card');
        //     $.ajax({
        //         method: "PUT",
        //         data: {
        //             _token: "{{csrf_token()}}"
        //         }
        //     });
        // }
    </script>
@endsection
