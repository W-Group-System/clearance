<div class="modal" id="edit{{$signatory->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit signatory</h5>
            </div>
            <form method="POST" action="{{url('update-signatories/'.$signatory->id)}}" onsubmit="show()">
                @csrf 

                <div class="modal-body">
                    <div class="form-group">
                        Employee
                        <select data-placeholder="Choose employee" name="employee" class="form-control chosen-select">
                            <option value=""></option>
                            @foreach ($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>