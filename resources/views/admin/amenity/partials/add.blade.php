<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="" action="{{route('admin.amenity.store')}}" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Amenity</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              {{csrf_field()}}
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Font Awesome Icon Code</strong>
                     <div class="input-group mb-3">
                       <div class="input-group-prepend">
                         <span class="input-group-text" id="basic-addon1">fa fa-</span>
                       </div>
                       <input name="code" type="text" class="form-control" placeholder="Enter font awesome code" aria-label="Username" aria-describedby="basic-addon1">
                     </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <strong>Amenity Name</strong>
                      <input type="text" value="{{old('name')}}" class="form-control" id="name" name="name" placeholder="Enter Amenity Name" >
                    </div>

                    <div class="form-group">
                      <strong>Status</strong>
                      <select class="form-control" name="status">
                        <option value="" selected disabled>Select a status</option>
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">ADD</button>
          </div>
      </form>
    </div>
  </div>
</div>
