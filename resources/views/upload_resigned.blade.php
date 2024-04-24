@extends('layouts.header')

@section('content')
<div class="container-fluid py-4">
  <form  method='post' onsubmit='show();' enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-7">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Upload</p>
              </div>
            </div>
            <div class="card-body">
              <p class="text-uppercase text-sm">Employee Information</p>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Name</label>
                    <input class="form-control" type="text" value="" name='name' placeholder="Name" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Company Email address</label>
                    <input class="form-control" type="company_email" value="" name='company_email_address'  placeholder="jesse@example.com">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Company</label>
                    <select class='form-control' name='company' required>
                        <option value=''>Company</option>
                        @foreach($companies as $company)
                        <option value='{{$company->id}}'>{{$company->code}} - {{$company->name}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Department</label>
                    <select class='form-control' name='department' required>
                        <option value=''>Department</option>
                        @foreach($departments as $department)
                        <option value='{{$department->code}}'>{{$department->name}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Date Hired</label>
                    <input class="form-control" type="date" value="" name='date_hired' required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Last Date of Employment</label>
                    <input class="form-control" type="date" value="" name='last_date_of_employment' required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Reasone for Separation</label>
                    <input class="form-control" type="text" placeholder="Reason" name='reason' required>
                  </div>
                </div>
              </div>
              <hr class="horizontal dark">
              <p class="text-uppercase text-sm">Contact Information</p>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Address</label>
                    <input class="form-control" type="text" value="" name='address' placeholder="Address" required> 
                  </div>
                </div>
                
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
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Alternative Phone #(optional)</label>
                    <input class="form-control" type="text" value="" name='alternative_phone_number' placeholder="Contact #" >
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
</div>
@endsection
