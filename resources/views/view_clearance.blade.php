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
                @csrf
            <div class="card mb-4">
                <div class="card-header pb-0">
                  <h6>Clearance Form  <button type="button" class="btn btn-primary">Print</button></h6> 
                </div>
                <div class="card-body ">
                    <div class="table-responsive ">
                        <table class="table align-items-center justify-content-center " >
                          <thead>
                            <tr>
                              <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Department</th>
                              <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Checklist</th>
                              <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Signatories</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($resignEmployee->exit_clearance as $exit)
                            <tr>
                                
                                <td>
                                @if($exit->department_id == "immediate_sup")
                                Immediate Sup
                                @elseif($exit->department_id == "dep_head")
                                Dept Head
                                @endif
                                @if($exit->department)
                                        {{ $exit->department->name }}
                                    @endif
                                    </td>
                                <td>
                                    <small>
                                        @foreach($exit->checklists as $checklist)
                                            {{$checklist->checklist}} <span class="badge badge-white btn btn-danger">Pending</span><br>
                                        @endforeach
                                    </small>

                                </td>
                                <td>
                                    
                                    <small>
                                        @foreach($exit->signatories as $signatory)
                                            {{$signatory->employee->last_name}}, {{$signatory->employee->first_name}} 
                                            @if($signatory->status == "Pending")
                                            <span class="badge badge-white btn btn-danger">{{$signatory->status}}</span>
                                            @else
                                            <span class="badge badge-white btn btn-success">{{$signatory->status}}</span>
                                            @endif
                                            <br>
                                        @endforeach
                                    </small>

                                </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
