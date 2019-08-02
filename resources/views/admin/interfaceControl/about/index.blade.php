@extends('admin.layout.master')

@push('nicedit-scripts')
  <script src="{{asset('assets/nic-edit/nicEdit.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
      new nicEditor({iconsPath : '{{asset('assets/nic-edit/nicEditorIcons.gif')}}', fullPanel : true}).panelInstance('content');
    });
  </script>
@endpush

@push('styles')
<style media="screen">
  h3 {
    margin: 0px;
  }
</style>
@endpush

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>About Page</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">

          <div class="tile">
            <div class="row">

              <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="form-horizontal" action="{{route('admin.about.update')}}" method="post" enctype="multipart/form-data">
                   {{csrf_field()}}
                   <div class="form-body">
                     <div class="form-group">

                       <div class="fileinput fileinput-new" data-provides="fileinput">
                          <div class="fileinput-new thumbnail">
                             <img style="width:555px;" src="{{ asset('assets/user/img/'.$gs->about_img) }}" alt="" />
                          </div>
                          <div class="fileinput-preview fileinput-exists thumbnail"> </div>
                          <div>
                             <span class="btn btn-success btn-file">
                             <span class="fileinput-new"> Change Image </span>
                             <span class="fileinput-exists"> Change </span>
                             <input type="file" name="image">
                             </span>
                             <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                          </div>
                       </div>
                       <p class="no-margin">* Image will be resized to 555X325</p>

                       @if ($errors->has('image'))
                         <p class="no-margin">{{$errors->first('image')}}</p>
                       @endif
                     </div>

                     <div class="form-group">
                        <label><strong>CONTENT: </strong></label>
                        <textarea id="content" class="form-control" name="content" id="emailTemplate" rows="10">{{$gs->about_content}}</textarea>
                        @if ($errors->has('content'))
                          <p class="no-margin">{{$errors->first('content')}}</p>
                        @endif
                     </div>
                      <div class="form-group">
                          <button type="submit" class="btn btn-info btn-block btn-lg">UPDATE</button>
                      </div>
                   </div>
                </form>
              </div>

            </div>
          </div>
        </div>
     </div>
  </main>
@endsection
