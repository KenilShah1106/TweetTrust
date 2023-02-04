<!-- Delete Question Modal -->
<div class="modal fade" id="deleteQuestionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleQuestionModalLabel">Delete Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="deleteQuestionForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    This post will be permanently deleted. Are you sure you want to Delete?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete Question</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Answer Modal -->
<div class="modal fade" id="deleteAnswerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleAnswerModalLabel">Delete Answer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="deleteAnswerForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    This answer will be permanently deleted. Are you sure you want to Delete?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="deleteAnswer" class="btn btn-danger">Delete Answer</button>
                </div>
            </form>
        </div>
    </div>
</div>

