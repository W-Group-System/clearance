<div class="modal fade modal" id="addSignatory{{$signatory->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Signatory</h5>
        </div>
        <form method='post' action="{{url('add-signatory/'.$signatory->id)}}" enctype="multipart/form-data">
            <div class="modal-body">
                @csrf
                <div class=row>
                    <div class='col-md-12'>
                        <div class="form-group">
                            <label class="text-right">Employee</label>
                            <select data-placeholder="Select Company" class="form-control modal-select form-control-sm required select2-multiple" data-toggle="select2" style='width:100%;' name='employees[]' multiple required>
                                <option value="">-- Select Department --</option>
                                @foreach($employees as $employee)
                                <option value="{{$employee->id}}" @if (in_array($employee->id,($signatory->signatories)->pluck('employee_id')->toArray())) selected @endif>{{$employee->last_name}}, {{$employee->first_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
 