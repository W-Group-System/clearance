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
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Ongoing Clearance </h6>
            </div>
            <div class="card-body ">
              <div class="table-responsive ">
                <table class="table align-items-center justify-content-center ">
                  <thead>
                    <tr>
                      <th ></th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Name</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Company</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Department</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Position</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Date Started</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Effective Date</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Type</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Percent</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($resigns->sortByDesc('created_at') as $resign)
                    <tr>
                      <td>
                         
                          <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn btn btn-primary dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                            <div id="myDropdown" class="dropdown-content">
                              @if($resign->status === "For Clearance")
                              <a href="{{url('setup-clearance/'.$resign->id)}}" target='_blank'>Setup Clearance</a>
                              @endif
                              <a href="#">View</a>
                            </div>
                          </div>
                      </td>
                      <td>{{$resign->employee->last_name.", ".$resign->employee->first_name}}</td>
                      <td>{{$resign->company->company_code}}</td>
                      <td>{{$resign->department->name}}</td>
                      <td>{{$resign->position}}</td>
                      <td>{{$resign->date_hired}}</td>
                      <td>{{$resign->last_date}}</td>
                      <td>{{$resign->type}}</td>
                      <td>
                            @php
                                $total = 0;
                                $cleared = 0;
                            @endphp
                            @foreach($resign->exit_clearance as $exit)
                                @foreach($exit->signatories as $signatory)
                                    @php
                                        $total++;
                                    @endphp
                                @endforeach
                                @php
                                    $cleared = $cleared+count(($exit->signatories)->where('status','Completed'));
                                    // dd($cleared);
                                @endphp
                            @endforeach
                            @if($cleared != 0)
                                @php
                                    $cleared = number_format(($cleared/$total)*100);
                                @endphp
                            @endif
                            <span class="me-2 text-xs font-weight-bold">{{$cleared}}%</span>
                            <div>
                              <div class="progress">
                                <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="{{$cleared}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$cleared}}%;"></div>
                              </div>
                            </div>
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
