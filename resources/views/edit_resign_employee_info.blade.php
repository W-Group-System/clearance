<div class="modal" id="editResignEmployeeInformation{{ $resignEmployee->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit resign employee information</h5>
            </div>
            <form method="post" action="{{ url('edit_employee_info/'.$resignEmployee->id) }}" onsubmit="show()" enctype="multipart/form-data">
                @csrf
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            Edit Last Date :
                            <input type="date" name="last_date" value="{{ $resignEmployee->last_date }}" class="form-control form-control-sm" >
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