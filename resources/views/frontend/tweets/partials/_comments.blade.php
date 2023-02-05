<div class="comments-section">
    <hr>
    <div class="post-comment-section mt12">
        <input type="text" class="form-control mr16 br-10 comment-field" placeholder="Leave a comment...">
        <a href="" class="btn btn-sm btn-outline-primary">Tweets comment</a>
    </div>
    <div class="comments mt12">
        <h6 class="mb8">{{$tweet->comments_count}} Comments</h6>

        <div class="comment mb4">
            <span class="comment-body">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Architecto corrupti dicta nemo repellat vitae soluta dolor beatae ullam quo aliquid. Lorem ipsum dolor sit amet.</span>
            <a href="" class="comment-author ml2"> - Jimmy Doe</a>
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

        <a href="" class="show-more-btn">Show more comments</a>
    </div>
</div>
