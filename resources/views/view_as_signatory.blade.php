@extends('layouts.header')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
      
        <div class="col-4">
          <div class="card text-center">
            <div class="card-body">
                <img src="{{get_avatar($resignEmployee->employee->id)}}" onerror="this.src='{{ URL::asset('/images/no_image.png') }}';"  class="rounded-circle avatar-lg img-thumbnail border-danger" alt="profile-image">

                <h4 class="mb-0 mt-2">{{$resignEmployee->employee->last_name}}, {{$resignEmployee->employee->first_name}}</h4>
                <p class="text-muted font-14">{{$resignEmployee->employee->position}}</p>
                @if(($for_clearances->department_id == "immediate_sup") || ($for_clearances->department_id == "dept_head"))
                <a href="{{url($resignEmployee->resignation_letter)}}" target='_blank'><button type="button" class="btn btn-success btn-sm mb-2">Resignation Letter</button></a>
                <a href="{{url($resignEmployee->acceptance_letter)}}" target='_blank'><button type="button" class="btn btn-danger btn-sm mb-2">Acceptance Letter</button></a>
                @endif
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
        
         
        </div>
        <div class='col-4'>
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
                            @if(in_array(auth()->user()->employee->id, $exitClearanceIds))
                            @include('checklist_change_status')
                            @endif
                        @endforeach
                        
                    </small>

                </div>
                

              </div>
            </div>
          </div>
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Signatories in 
                @if($for_clearances->department_id == "immediate_sup")
                  Immediate Head
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
                            @foreach($for_clearances->clearance->signatories as $signatory)
                       
                            <img src="{{get_avatar($signatory->employee->id)}}" onerror="this.src='{{ URL::asset('/images/no_image.png') }}';"  class="rounded-circle img-thumbnail avatar-sm @if($signatory->status == "Pending") border-danger @else border-success @endif" alt="profile-image"> {{$signatory->employee->last_name}}, {{$signatory->employee->first_name}} @if($signatory->employee->user_id == auth()->user()->id) (You) @endif
                                {{-- @if($signatory->status == "Pending")
                                <span class="badge badge-white btn btn-danger">{{$signatory->status}}</span>
                                @else
                                <span class="badge badge-white btn btn-success">{{$signatory->status}}</span>
                                @endif --}}
                                <br>
                            @endforeach
                    
                </div>
              </div>
              @if(in_array(auth()->user()->employee->id, $exitClearanceIds))
              @if($for_clearances->status == "Pending")
              <div class='row'>
                <div class='col-md-12'>
                    <button type="button" class="btn btn-success btn-sm align-items-right" data-toggle="modal" data-target="#markasdone">Confirm '<i>{{$resignEmployee->employee->first_name}}</i>' as CLEARED</button>
                </div>
              </div>
              @include('mark_as_done')
              @endif
              @endif
            </div>
          </div>
        </div>
        
        <div class='col-4'>
          <div class="card">
            <div class="card-body">
              <form method='post' action="{{url('new-comment/'.$for_clearances->clearance->id)}}" enctype="multipart/form-data">
                @csrf
                <h4 class="mt-0 mb-3">Comments ({{count($for_clearances->clearance->comments)}})</h4>

                <textarea class="form-control form-control-light mb-2" placeholder="Write message" id="example-textarea" name='observation' rows="5" required></textarea>
                <div class="text-end mb-2">
                     
                        <input type="file"  name='file' class="form-control">
                    <div class="btn-group mt-2 mb-2 ms-2">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </div>
              </form>
              @foreach($for_clearances->clearance->comments->sortByDesc('created_at') as $comment)
              <div class="border border-light rounded p-2 mb-3">
                <div class="d-flex">
                    <img class="me-2 rounded-circle"  src="" onerror="this.src='{{ URL::asset('/images/no_image.png') }}';" alt="Generic placeholder image" height="32">
                    <div>
                        <h5 class="m-0">{{$comment->user->name}}</h5>
                        <p class="text-muted"><small>{{date('h:i A - M d, Y',strtotime($comment->updated_at))}}</small></p>
                    </div>
                </div>
                <p> {!! $comment->remarks !!}</p>
              </div>
              @endforeach
               

            </div> <!-- end card-body-->
          </div>
        </div>
    </div>
</div>
<script>
function displayFileName(event) {
  const fileInput = event.target;  // The file input element
  const fileName = fileInput.files[0]?.name || 'No file selected';  // Get the file name or default text
  
  // Update the text input with the file name
  document.getElementById('fileName').value = fileName;
}
</script>
@endsection
