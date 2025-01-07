@extends('layouts.header')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-3">
          <div class="card text-center">
            <div class="card-body">
                <img src="{{get_avatar($resignEmployee->employee->id)}}" onerror="this.src='{{ URL::asset('/images/no_image.png') }}';"  class="rounded-circle avatar-lg img-thumbnail " alt="profile-image">

                <h4 class="mb-0 mt-2">{{$resignEmployee->employee->last_name}}, {{$resignEmployee->employee->first_name}}</h4>
                <p class="text-muted font-14">{{$resignEmployee->employee->position}}</p>

                <a href="{{url($resignEmployee->resignation_letter)}}" target='_blank'><button type="button" class="btn btn-success btn-sm mb-2">Resignation Letter</button></a>
                <a href="{{url($resignEmployee->acceptance_letter)}}" target='_blank'><button type="button" class="btn btn-danger btn-sm mb-2">Acceptance Letter</button></a>
            </div> <!-- end card-body -->
          </div>
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Employment Information</h6>
            </div>
            <div class="card-body ">
              <div class='row'>
                <div class='col-md-12'>
                    Employee ID: {{$resignEmployee->employee->employee_code}}

                </div>
                {{-- <div class='col-md-12'>
                    Name: {{$resignEmployee->employee->last_name}}, {{$resignEmployee->employee->first_name}}
                </div> --}}
                <div class='col-md-12'>
                    Company: {{$resignEmployee->company->company_code}}
                </div>
                <div class='col-md-12'>
                    Department: {{$resignEmployee->department->name}}
                </div>
                <div class='col-md-12'>
                    Date Hired: {{date('M d, Y',strtotime($resignEmployee->date_hired))}}
                </div>
                <div class='col-md-12'>
                    Last date: <b>{{date('M d, Y',strtotime($resignEmployee->last_date))}}</b>
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
        </div>
        
        <div class="col-9">
                @csrf
            <div class="card mb-4">
                <div class="card-header pb-0">
                  <h6>Clearance Form  
                    <button type="button" class="btn btn-primary">Print</button></h6> 
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
                                
                                <td >
                                  
                                @if($exit->department_id == "immediate_sup")
                                Immediate Sup
                                @elseif($exit->department_id == "dep_head")
                                Dept Head
                                @endif
                                @if($exit->department)
                                        {{ $exit->department->name }}
                                    @endif
                                    <br>
                                    <a href="{{url('view-comments/'.$exit->id)}}" target="_blank">
                                      <span class="text-nowrap mb-2 d-inline-block">
                                        <i class="mdi mdi-comment-multiple-outline text-muted"></i>
                                        <b>{{count($exit->comments)}}</b> Comments
                                      </span>
                                    </a>
                                    </td>
                                <td>
                                    <small>
                                        @foreach($exit->checklists as $checklist)
                                        <span class="badge badge-white btn @if($checklist->status == "Pending") btn-danger @else btn-success @endif" data-toggle="modal" data-target="#checklistStatus{{$checklist->id}}">{{$checklist->status}}</span> {{$checklist->checklist}} <br>
                                        @endforeach
                                    </small>

                                </td>
                                <td>
                                    
                                    <small>
                                        @foreach($exit->signatories as $signatory)
                                            @if($signatory->status == "Pending")
                                            <span class="badge badge-white btn btn-danger" data-bs-toggle="modal" data-bs-target="#edit{{$signatory->id}}">{{$signatory->status}}</span>
                                            @else
                                            <span class="badge badge-white btn btn-success">{{$signatory->status}}</span>
                                            @endif
                                            {{$signatory->employee->last_name}}, {{$signatory->employee->first_name}} 
                                            
                                            <br>

                                            @include('edit_signatory')
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
