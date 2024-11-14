@extends('layouts.header')

@section('content')
<style>
  /* Dropdown Button */
.dropbtn {
  background-color: #3498DB;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

/* Dropdown button on hover & focus */
.dropbtn:hover, .dropbtn:focus {
  background-color: #2980B9;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #ffffff;}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show {display:block;}
</style>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-xl-2 col-sm-6 mb-xl-0 mb-3">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-12">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">For Clearance</p>
                    <h5 class="font-weight-bolder">
                      {{count($for_clearances->where('status','Pending'))}}
                    </h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-sm-6 mb-xl-0 mb-3">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-12">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Cleared</p>
                    <h5 class="font-weight-bolder">
                      <a href="{{url('for-clearance?status=Cleared')}}">{{count($for_clearances->where('status','Cleared'))}}</a>
                    </h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>For Clearance </h6>
            </div>
            <div class="card-body ">
              <div class="table-responsive ">
                <table class="table align-items-center justify-content-center ">
                  <thead>
                    <tr>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Name</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Company</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Department</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Position</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Date Started</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Effective Date</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Signatory as</th>
                    </tr>
                  </thead>
                  <tbody>
                        @foreach($for_clearances->where('status',$status) as $for_clearance)
                        <tr >
                            <td><a href='{{url("view-as-signatory/".$for_clearance->id)}}'>{{$for_clearance->clearance->resign->employee->last_name}}, {{$for_clearance->clearance->resign->employee->first_name}}</a></td>
                            <td>{{$for_clearance->clearance->resign->employee->company->company_code}}</td>
                            <td>{{$for_clearance->clearance->resign->employee->department->name}}</td>
                            <td>{{$for_clearance->clearance->resign->position}}</td>
                            <td>{{$for_clearance->clearance->resign->employee->original_date_hired}}</td>
                            <td>{{$for_clearance->clearance->resign->last_date}}</td>
                            <td> 
                                @if($for_clearance->department_id == "immediate_sup")
                                Immediate Head
                                @elseif($for_clearance->department_id == "dep_head")
                                Department Head
                                @endif
                                @if($for_clearance->clearance->department)
                                        {{ $for_clearance->clearance->department->name }}
                                    @endif
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
<script>
  function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>
@endsection
