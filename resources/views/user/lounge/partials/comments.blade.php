<div class="comments">
  <div class="row">
    <div class="col-md-12 text-center">
      <h2 class="mt-2" style="color:#f0932b">{{round(\App\LoungeReview::where('lounge_id', $lounge->id)->avg('rating'), 2)}}/5.0</h2>
      Based on {{\App\LoungeReview::where('lounge_id', $lounge->id)->count()}} reviews
    </div>
  </div>
  @foreach ($lounge->loungereviews()->orderBy('id', 'DESC')->get() as $loungereview)
    <div class="comment-wrap">
      <div class="photo">
        @if (empty($loungereview->user->pro_pic))
          <div class="avatar" style="background-image: url('{{asset('assets/user/img/pro-pic/nopic.png')}}')"></div>
        @else
          <div class="avatar" style="background-image: url('{{asset('assets/user/img/pro-pic/'.$loungereview->user->pro_pic)}}')"></div>
        @endif
      </div>
       <div class="comment-block">
          <p class="comment-text">
            {{$loungereview->comment}}
          </p>
          <div class="bottom-comment">
             <div class="comment-date">{{date('M d, Y @ g:i A', strtotime($loungereview->created_at))}}</div>
             <ul class="comment-actions">
                <div id="rateYo{{$loungereview->id}}"></div>
             </ul>
          </div>
       </div>
    </div>
    <script>
    $(document).ready(function() {
      $("#rateYo{{$loungereview->id}}").rateYo({
        rating: {{$loungereview->rating}},
        readOnly: true,
        starWidth: "16px"
      });
    });
    </script>
  @endforeach
</div>
