@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>SMS Settings</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">
              <h3 class="tile-title ">Short Code</h3>
              <div class="tile-body">
                 <div class="table-responsive">
                    <table class="table table-striped table-hover">
                       <thead>
                          <tr>
                             <th> # </th>
                             <th> CODE </th>
                             <th> DESCRIPTION </th>
                          </tr>
                       </thead>
                       <tbody>
                          <tr>
                             <td> 1 </td>
                             <td>
                                <pre>&#123;&#123;message&#125;&#125;</pre>
                             </td>
                             <td> Details Text From Script</td>
                          </tr>
                          <tr>
                             <td> 2 </td>
                             <td>
                                <pre>&#123;&#123;number&#125;&#125;</pre>
                             </td>
                             <td> Users Number. Will Pull From Database</td>
                          </tr>
                       </tbody>
                    </table>
                 </div>
              </div>
           </div>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">
              <div class="tile-body">
                 <form role="form" method="POST" action="{{route('admin.UpdateSmsSetting')}}" >
                    {{csrf_field()}}
                    <div class="form-body">
                       <div class="form-group">
                          <label for="">SMS API</label>
                          <input type="text" name="smsApi" id="smsapi" class="form-control" value="{{$gs->sms_api}}">
                          @if ($errors->has('smsApi'))
                            <span style="color:red;">{{$errors->first('smsApi')}}</span>
                          @endif
                       </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Update</button>
                 </form>
              </div>
           </div>
        </div>
     </div>
  </main>
@endsection
