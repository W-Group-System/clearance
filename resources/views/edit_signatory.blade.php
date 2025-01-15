<div class="modal" id="edit{{$signatory->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit signatory</h5>
            </div>
            <form method="POST" action="{{url('update-signatories/'.$signatory->id)}}" onsubmit="show()">
                @csrf 

                <input type="hidden" name="exit_clearance_id" value="{{$signatory->exit_clearance_id}}">
                <input type="hidden" name="department_id" value="{{$signatory->department_id}}">

                <div class="modal-body">
                    <div class="form-group">
                        Employee
                        @php
                            $signatories_array = ($exit->signatories)->where('status','Pending')->where('department_id', $signatory->department_id)->where('exit_clearance_id', $signatory->exit_clearance_id)->pluck('employee_id')->toArray();
                        @endphp
                        <select data-placeholder="Choose employee" name="employee[]" class="form-control chosen-select" multiple required>
                            <option value=""></option>
                            @foreach ($employees as $employee)
                                <option value="{{$employee->id}}" @if(in_array($employee->id, $signatories_array)) selected @endif>{{$employee->first_name.' '.$employee->last_name}}</option>
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