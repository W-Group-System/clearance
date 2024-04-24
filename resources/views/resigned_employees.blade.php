@extends('layouts.header')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Resigned Employees <a href='{{url("/upload")}}'><button class="btn btn-primary btn-sm ms-auto">Upload</button></a></h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Name</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Company</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Department</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Position</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Date Started</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Effective Date</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Location</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Type</th>
                      <th class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
