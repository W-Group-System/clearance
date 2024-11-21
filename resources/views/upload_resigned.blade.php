@extends('layouts.header')

@section('content')

<form  method='post' onsubmit='show();' enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="row">
      <div class="col-md-7">
        <div class="card">
          <div class="card-body">
            <p class="text-uppercase text-sm">Employee Information</p>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Name</label>
                  {{-- <input class="form-control" type="text" value="" name='name' placeholder="Name" required> --}}
                  <select class='form-control select2' data-toggle="select2" onchange="change_name(this.value)" name='name' required>
                    <option >Employee Name</option>
                    @foreach($employees->sortBy('last_name') as $employee)
                    <option value='{{$employee->id}}'>{{$employee->last_name}}, {{$employee->first_name}}</option>
                    @endforeach
                </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                Company : <span id='company'></span>
              </div>
              <div class="col-md-6">
                Department :  <span id='department'></span>
              </div>
              <div class="col-md-6">
                Date Hired :  <span id='date_hired'></span>
              </div>
              <div class="col-md-6">
                Position : <span id='position'></span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Last Date of Employment</label>
                  <input class="form-control" type="date" value="" name='last_date_of_employment' required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Reason for Separation</label>
                  <select class='form-control js-example-basic-single chosen-select ' name='reason' >
                      <option value=''></option>
                      @foreach($reasons as $reason)
                      <option value='{{$reason->reason}}'>{{$reason->reason}}</option>
                      @endforeach
                  </select>
                  {{-- <input class="form-control" type="text" placeholder="Reason" name='reason' required> --}}
                </div>
              </div>
            </div>
            <hr class="horizontal dark">
            <p class="text-uppercase text-sm">Employee Contact Information</p>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Personal Email Address</label>
                  <input class="form-control" type="email" value="" name='personal_email_address' placeholder="Email" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Personal Phone #</label>
                  <input class="form-control" type="text" value="" name='personal_phone_number' placeholder="Contact #" required>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Address</label>
                  <input class="form-control" type="text" value="" name='address' placeholder="Address" required> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="card">
          <div class="card-body">
            <hr class="horizontal dark">
            <p class="text-uppercase text-sm">Attachments</p>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Resignation Letter</label>
                  <input class="form-control" type="file" value="" name='resignation_letter' required>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Acceptance Letter</label>
                  <input class="form-control" type="file" value="" name='acceptance_letter' required>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Handover List <i><small>(Can be uploaded later)</small></i></label>
                  <input class="form-control" type="file" value="" name='handoverlist' >
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <button type='submit'  class="btn btn-primary"  >Upload</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</form>
 
<script>
  function change_name(value)
  {
    var employees = {!! json_encode($employees->toArray()) !!};
    var employee = employees.find(emp => emp.id == value);

    document.getElementById("company").textContent=employee.company.company_code;
    document.getElementById("department").textContent=employee.department.name;
    document.getElementById("position").textContent=employee.position;
    document.getElementById("date_hired").textContent=employee.original_date_hired;
  }
</script>
@endsection
