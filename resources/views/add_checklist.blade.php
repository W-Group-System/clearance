<div class="modal fade" id="addChecklist{{$signatory->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Checklist</h5>
        </div>
        <form method='post' action="{{url('add-checklist/'.$signatory->id)}}" enctype="multipart/form-data">
            <div class="modal-body">
                @csrf
                <div class=row>
                    <div class='col-md-12'>
                        <textarea type='text' class='form-control' name='checklist' placeholder="Checklist" required></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  