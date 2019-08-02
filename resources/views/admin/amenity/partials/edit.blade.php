<!-- Modal -->
<div class="modal fade" id="editModal{{$am->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="" action="{{route('admin.amenity.update')}}" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Amenity</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              {{csrf_field()}}
              <input type="hidden" name="statusId" value="{{$am->id}}">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Font Awesome Icon Code</strong>
                     <div class="input-group mb-3">
                       <div class="input-group-prepend">
                         <span class="input-group-text" id="basic-addon1">fa fa-</span>
                       </div>
                       <input name="code" type="text" value="{{$am->code}}" class="form-control" placeholder="Enter font awesome code" aria-label="Username" aria-describedby="basic-addon1">
                     </div>
                  </div>
                  <div class="col-md-12 mb-10">
                     <strong>Amenity Name</strong>
                     <input type="text" value="{{$am->name}}" class="form-control" id="name" name="name" placeholder="Enter amenity name" >
                  </div>
                  <div class="col-md-12 mb-10">
                    <strong>Status</strong>
                    <select class="form-control" name="status">
                      <option value="1" {{($am->status==1) ? 'selected' : ''}}>Active</option>
                      <option value="0" {{($am->status==0) ? 'selected' : ''}}>Deactive</option>
                    </select>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">UPDATE</button>
          </div>
      </form>
    </div>
  </div>
</div>
