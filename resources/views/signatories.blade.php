@extends('layouts.header')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-8">
          <div class="card mb-4">
            <div class="card-header pb-0">
                <form method='get' onsubmit='show();' enctype="multipart/form-data">
                    <div class=row>
                        <div class='col-md-4'>
                            <div class="form-group">
                                <label class="text-right">Company</label>
                                <select data-placeholder="Select Company" class="form-control form-control-sm required " style='width:100%;' name='company'  required>
                                    <option value="">-- Select Company --</option>
                                    @foreach($companies->sortBy('company_code') as $comp)
                                    <option value="{{$comp->id}}" @if ($comp->id == $company) selected @endif>{{$comp->company_code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class='col-md-3'>
                            <label class="text-right">&nbsp;</label>
                            <button type="submit" class="form-control form-control-sm btn btn-primary mb-2 btn-sm">Generate</button>
                        </div>
                        @if($company)
                            <div class='col-md-3'>
                                <label class="text-right">&nbsp;</label>
                                <button type="button" class="form-control form-control-sm btn btn-success mb-2 btn-sm" data-toggle="modal" data-target="#addDepartment">Add Department</button>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Departments</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Checklist</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Signatories</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($signatories as $signatory)
                        <tr>
                            <td>{{$signatory->department->name}}</td>
                            <td><button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#addChecklist{{$signatory->id}}"><i class="fas fa-plus" aria-hidden="true"></i></button>
                                @foreach($signatory->checklists as $checklist)
                                <div class="d-flex align-items-center">
                                    <span>{{$checklist->checklist}}</span>
                                    <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 btn-sm d-flex align-items-center justify-content-center" data-toggle="modal" 
                                    href="#" onclick="return doConfirm({{$checklist->id}});">
                                        <i class="fas fa-minus" aria-hidden="true"></i>
                                    </button>
                                </div>
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#addSignatory{{$signatory->id}}"><i class="fas fa-plus" aria-hidden="true"></i></button><br>
                              
                                @foreach($signatory->signatories as $sign)
                                <div class="d-flex align-items-center">
                                    <span>{{$sign->employee->last_name}}, {{$sign->employee->first_name}} </span> <br> 
                                </div>
                                @endforeach
                            </td>
                     
                        </tr>
                        @include('add_checklist')
                        @include('add_signatory')
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
        <div class="modal fade" id="addDepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Department</h5>
                </div>
                <form method='post' enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class=row>
                            <div class='col-md-12'>
                                <div class="form-group">
                                    <label class="text-right">Department</label>
                                    <select data-placeholder="Select Company" class="form-control form-control-sm required js-example-basic-single" style='width:100%;' name='departments[]' multiple required>
                                        <option value="">-- Select Department --</option>
                                        @foreach($departments as $dept)
                                        <option value="{{$dept->id}}" @if (in_array($dept->id,$department)) selected @endif>{{$dept->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
        
</div>
<script>
        
        function doConfirm(id) {
    // Using the standard JavaScript confirm dialog
    var returnvalue = window.confirm('Do you want to remove this checklist?');

    // Perform actions based on the user's choice
    if (returnvalue) {
        var baseUrl = window.location.origin;
        // If the user clicked OK
        window.location.href = baseUrl + '/remove-signatories/' + id;
    }

    return false; // This prevents the default behavior of the event (e.g., form submission)
}
        
    </script>
@endsection
