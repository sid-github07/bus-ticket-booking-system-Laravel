@extends('admin.layout.master')


@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>
             @if (request()->path() == 'admin/ad/all')
               All
             @elseif (request()->path() == 'admin/ad/pending')
               Pending
             @elseif (request()->path() == 'admin/ad/published')
               Published
             @elseif (request()->path() == 'admin/ad/featured')
               Featured
             @elseif (request()->path() == 'admin/ad/unfeatured')
               Unfeatured
             @elseif (request()->path() == 'admin/ad/hidden')
               Hidden
             @elseif (request()->path() == 'admin/ad/shown')
               Shown
             @else

             @endif
             Product Ads Managemenet</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($pros) == 0)
          <div class="tile">
            <h2 class="text-center">
              NO
              @if (request()->path() == 'admin/ad/pending')
                PENDING
              @elseif (request()->path() == 'admin/ad/published')
                PUBLISHED
              @elseif (request()->path() == 'admin/ad/featured')
                FEATURED
              @elseif (request()->path() == 'admin/ad/unfeatured')
                UNFEATURED
              @elseif (request()->path() == 'admin/ad/hidden')
                HIDDEN
              @elseif (request()->path() == 'admin/ad/shown')
                SHOWN
              @else
              @endif
              PRODUCT AD FOUND
            </h2>
          </div>
          @else
          <div class="tile">
             <h3 class="tile-title pull-left">
                 @if (request()->path() == 'admin/ad/all')
                   All
                 @elseif (request()->path() == 'admin/ad/all')
                   Pending
                 @elseif (request()->path() == 'admin/ad/published')
                   Published
                 @elseif (request()->path() == 'admin/ad/featured')
                   Featured
                 @elseif (request()->path() == 'admin/ad/unfeatured')
                   Unfeatured
                 @elseif (request()->path() == 'admin/ad/hidden')
                   Hidden
                 @elseif (request()->path() == 'admin/ad/shown')
                   Shown
                 @else
                 @endif
                Product Ads List
              </h3>
             <div class="pull-right icon-btn">
                <form method="get" class="form-inline" action="
                @if (request()->path() == 'admin/ad/all')
                  {{route('admin.ad.all')}}
                @elseif (request()->path() == 'admin/ad/pending')
                  {{route('admin.ad.pending')}}
                @elseif (request()->path() == 'admin/ad/published')
                  {{route('admin.ad.published')}}
                @elseif (request()->path() == 'admin/ad/featured')
                  {{route('admin.ad.featured')}}
                @elseif (request()->path() == 'admin/ad/unfeatured')
                  {{route('admin.ad.unfeatured')}}
                @elseif (request()->path() == 'admin/ad/hidden')
                  {{route('admin.ad.hidden')}}
                @elseif (request()->path() == 'admin/ad/shown')
                  {{route('admin.ad.shown')}}
                @endif
                ">
                   <input type="text" name="term" class="form-control" placeholder="search by ad title">
                   <button class="btn btn-outline btn-circle btn-success" type="submit"><i
                      class="fa fa-search"></i></button>
                </form>
             </div>
             <div class="table-responsive">
                <table class="table">
                   <thead>
                      <tr>
                        <th scope="col">Serial</th>
                         <th scope="col">Username</th>
                         <th scope="col">Title</th>
                         <th scope="col">Category</th>
                         <th scope="col">Price</th>
                         <th>Action</th>
                      </tr>
                   </thead>
                   <tbody>
                      @foreach ($pros as $key => $pro)
                      <tr>
                         <td data-label="">{{$key+1}}</td>
                         <td data-label=""><a target="_blank" href="{{route('admin.userDetails', $pro->user->id)}}">{{$pro->user->username}}</a></td>
                         <td data-label="">
                         <a target="_blank" href="{{route('user.product.details', $pro->id)}}">{{strlen($pro->title) > 40 ? substr($pro->title, 0, 40) . '...' : $pro->title}}</a>
                         </td>
                         <td data-label="">{{$pro->category}}</td>
                         <td data-label="">{{$gs->base_curr_symbol}} {{$pro->price}}</td>
                         <td data-label="">
                           @if ($pro->published == 0)
                           <button id="publishStatusBtn{{$pro->id}}" class="btn btn-info btn-sm" onclick="changePublishStatus(event, {{$pro->id}})">Publish</button>
                           @else
                           <button id="publishStatusBtn{{$pro->id}}" class="btn btn-warning btn-sm" onclick="changePublishStatus(event, {{$pro->id}})">Unpublish</button>
                           @endif
                           @if ($pro->a_hidden == 0)
                           <button id="hideShowBtn{{$pro->id}}" class="btn btn-danger btn-sm" onclick="showHide(event, {{$pro->id}})">Hide</button>
                           @else
                           <button id="hideShowBtn{{$pro->id}}" class="btn btn-success btn-sm" onclick="showHide(event, {{$pro->id}})">Show</button>
                           @endif

                         </td>
                      </tr>
                      @endforeach
                   </tbody>
                </table>
             </div>
             <div class="text-center">
               {{$pros->appends(['term' => $term])->links()}}
             </div>
          </div>
          @endif
        </div>
     </div>
  </main>
  @includeif('admin.adman.ajaxFunctions')
@endsection
