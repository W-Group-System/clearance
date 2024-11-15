@extends('layouts.header')

@section('content')
<script src="https://cdn.tiny.cloud/1/yemsbvzrf507kpiivlpanbssgxsf1tatzwwtu81qli4yre3p/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({
    selector:'textarea',
    content_style: "p { margin: 0; }",    
    });</script>
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
                    <b>Last date: {{date('M d, Y',strtotime($resignEmployee->last_date))}}</b>
                </div>

              </div>
            </div>
          </div>
          {{-- <div class="card mb-4">
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
          </div> --}}
          @if(($for_clearances->department_id == "immediate_sup") || ($for_clearances->department_id == "dept_head"))
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
          @endif
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>@if($for_clearances->department_id == "immediate_sup")
                Immediate Head
                @elseif($for_clearances->department_id == "dep_head")
                Department Head
                @endif
                @if($for_clearances->clearance->department)
                        {{ $for_clearances->clearance->department->name }}
                    @endif 
                    (Checklist)</h6>
            </div>
            <div class="card-body ">
              <div class='row'>
                <div class='col-md-12'>
                    <small>
                        @foreach($for_clearances->clearance->checklists as $checklist)
                            {{$checklist->checklist}} <span class="badge badge-white btn @if($checklist->status == "Pending") btn-danger @else btn-success @endif" data-toggle="modal" data-target="#checklistStatus{{$checklist->id}}">{{$checklist->status}}</span><br>
                            
                            @include('checklist_change_status')
                        @endforeach
                        
                    </small>

                </div>
                

              </div>
            </div>
          </div>
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Complete List of Signatories in 
                @if($for_clearances->department_id == "immediate_sup")
                @elseif($for_clearances->department_id == "dep_head")
                 Department Head
                @endif
                @if($for_clearances->clearance->department)
                        {{ $for_clearances->clearance->department->name }}
                    @endif</h6>
            </div>
            <div class="card-body ">
              <div class='row'>
                <div class='col-md-12'>
                    <small>
                        <small>
                            @foreach($for_clearances->clearance->signatories as $signatory)
                                {{$signatory->employee->last_name}}, {{$signatory->employee->first_name}} @if($signatory->employee->user_id == auth()->user()->id) (You) @endif
                                @if($signatory->status == "Pending")
                                <span class="badge badge-white btn btn-danger">{{$signatory->status}}</span>
                                @else
                                <span class="badge badge-white btn btn-success">{{$signatory->status}}</span>
                                @endif
                                <br>
                            @endforeach
                        </small>
                    </small>
                    
                </div>
              </div>
              @if($for_clearances->status == "Pending")
              <div class='row'>
                <div class='col-md-12'>
                    <button type="button" class="btn btn-success btn-sm align-items-right" data-toggle="modal" data-target="#markasdone">Confirm '<i>{{$resignEmployee->employee->first_name}}</i>' as CLEARED</button>
                </div>
              </div>
              @include('mark_as_done')
              @endif
            </div>
          </div>
         
        </div>
        <div class='col-4'>
            <div class="card mb-4">
                <div class="card-header pb-0">
                  <h6>Comments</h6>
                </div>
                <form method='post' action="{{url('new-comment/'.$for_clearances->clearance->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body ">
                    <div class='row'>
                        <div class='col-md-12'>
                            <textarea name='observation' class='observation' id='observation' placeholder="Input your comment here" ></textarea>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-12 text-right'>
                            <br>    
                            <button type='submit'  class="btn btn-primary" >Submit</button>
                        </div>
                    </div>
                    </div>
                </form>
              </div>

        </div>
        
        <div class='col-4'>
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Activities</h6>
                  </div>
                  <div class="card-body ">
                    @foreach($for_clearances->clearance->comments->sortByDesc('created_at') as $comment)
                    <div class="d-flex px-2 py-1">
                        <div>
                          <img src="../assets/img/team-2.jpg" onerror="this.src='{{ URL::asset('/images/no_image.png') }}';" class="avatar avatar-sm me-3" alt="user1">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{$comment->user->name}}</h6>
                          <p class="text-xs text-secondary mb-0">{{date('h:i A - M d, Y',strtotime($comment->updated_at))}}</p>
                          <small>
                            <div class="well">
                            
                                    {!! $comment->remarks !!}
                
                            </div>
                        </small>
                        </div>
                      </div>
                      <hr>
                      @endforeach
                  </div>
              </div>

        </div>
        
    </div>
</div>

@endsection
