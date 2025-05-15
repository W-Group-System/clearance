<div class="modal" id="editResignEmployee{{ $resignEmployee->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit resign employee</h5>
            </div>
            <form method="post" action="{{ url('edit_resignation_letter/'.$resignEmployee->id) }}" onsubmit="show()" enctype="multipart/form-data">
                @csrf
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            Edit Resignation Letter :
                            <input type="file" name="resignation_letter" class="form-control form-control-sm" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>