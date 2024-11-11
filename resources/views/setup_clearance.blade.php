@extends('layouts.header')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-4">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Employment Information</h6>
            </div>
            <div class="card-body ">
              <div class='row'>
                <div class='col-md-12'>
                    Employee ID: {{$resignEmployee->employee->employee_code}}

                </div>
                <div class='col-md-12'>
                    Name: {{$resignEmployee->employee->last_name}}, {{$resignEmployee->employee->first_name}}
                </div>
                <div class='col-md-12'>
                    Company: {{$resignEmployee->company->company_code}}
                </div>
                <div class='col-md-12'>
                    Department: {{$resignEmployee->department->name}}
                </div>
                <div class='col-md-12'>
                    Date Started: {{date('M d, Y',strtotime($resignEmployee->date_hired))}}
                </div>
                <div class='col-md-12'>
                    Last date: {{date('M d, Y',strtotime($resignEmployee->last_date))}}
                </div>

              </div>
            </div>
          </div>
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Employee Contact Information</h6>
            </div>
            <div class="card-body ">
              <div class='row'>
                <div class='col-md-12'>
                    Personal Email Address: {{$resignEmployee->personal_email}}

                </div>
                <div class='col-md-12'>
                    Personal Phone #: {{$resignEmployee->personal_number}}
                </div>
                <div class='col-md-12'>
                   Address: {{$resignEmployee->address}}
                </div>
                

              </div>
            </div>
          </div>
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Attachments</h6>
            </div>
            <div class="card-body ">
              <div class='row'>
                <div class='col-md-12'>
                    Resignation Letter: <a href="{{url($resignEmployee->resignation_letter)}}" target='_blank'><i class="fas fa-file text-success" aria-hidden="true"></i></a>
                </div>
                <div class='col-md-12'>
                    Acceptance Letter: <a href="{{url($resignEmployee->acceptance_letter)}}" target='_blank'><i class="fas fa-file text-success" aria-hidden="true"></i></a>
                </div>
                

              </div>
            </div>
          </div>
        </div>
        
        <div class="col-8">
            <form method='post' enctype="multipart/form-data">
                @csrf
            <div class="card mb-4">
                <div class="card-header pb-0">
                  <h6>Clearance Form  <button type="submit" class="btn btn-primary">Submit</button></h6> 
                </div>
                <div class="card-body ">
                    <div class="table-responsive ">
                        <table class="table align-items-center justify-content-center " >
                          <thead>
                            <tr>
                              <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Department</th>
                              <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Checklist</th>
                              <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Name</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                                <td>IMMEDIATE SUPERIOR</td>
                                <td> <input type='checkbox' name='checklists[immediate_sup][]' checked value='Hand-over Document'> Hand-over Document</td>
                                <td>
                                    <select data-placeholder="Select Employees" class="form-control form-control-sm required js-example-basic-single"  name='employees[immediate_sup][]' multiple required>
                                        <option value="">-- Select Employees --</option>
                                        @foreach($employees as $employee)
                                        <option value="{{$employee->id}}" >{{$employee->last_name}}, {{$employee->first_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>DEPARTMENT HEAD</td>
                                <td>
                                    <input type='checkbox' check name='checklists[dep_head][]' checked value='Hand-over Document'> Hand-over Document <br>
                                    <input type='checkbox' check name='checklists[dep_head][]' checked value='Department-related System(s)'> Department-related System(s)<br>
                                    <input type='checkbox' check name='checklists[dep_head][]' checked value='File to Clear book'> File to Clear book <br>
                                </td>
                                <td>
                                    <select data-placeholder="Select Employees" class="form-control form-control-sm required js-example-basic-single"  name='employees[dep_head][]' multiple required>
                                        <option value="">-- Select Employees --</option>
                                        @foreach($employees as $employee)
                                        <option value="{{$employee->id}}" >{{$employee->last_name}}, {{$employee->first_name}}</option>
                                        @endforeach
                                    </select>

                                </td>
                            </tr>
                            @foreach($signatories as $signatory)
                            <tr>
                                <td>{{$signatory->department->name}}</td>
                                <td>
                                    @foreach($signatory->checklists as $checklist)
                                    
                                    <input type='checkbox' checked name='checklists[{{$signatory->department_id}}][]' value='{{$checklist->checklist}}'> {{$checklist->checklist}}<br>
                                    @endforeach
                                </td>
                                <td>
                                    <select data-placeholder="Select Employees" class="form-control form-control-sm required js-example-basic-single"  name='employees[{{$signatory->department_id}}][]' multiple required>
                                        <option value="">-- Select Employees --</option>
                                        @foreach($employees as $employee)
                                        <option value="{{$employee->id}}" @if (in_array($employee->id,($signatory->signatories)->pluck('employee_id')->toArray())) selected @endif>{{$employee->last_name}}, {{$employee->first_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>
       
            </form>
        </div>
    </div>
</div>
@endsection
