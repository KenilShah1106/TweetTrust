<!-- Delete Tweet Modal -->
<div class="modal fade" id="deleteTweetModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleTweetModalLabel">Delete Tweet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="deleteTweetForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    This post will be permanently deleted. Are you sure you want to Delete?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete Tweet</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Replies Modal -->
<div class="modal fade" id="deleteRepliesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleRepliesModalLabel">Delete Replies</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="deleteRepliesForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    This answer will be permanently deleted. Are you sure you want to Delete?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="deleteReplies" class="btn btn-danger">Delete Replies</button>
                </div>
            </form>
        </div>
    </div>
</div>

