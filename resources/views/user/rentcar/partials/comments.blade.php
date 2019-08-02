<div class="comments">
  <div class="row">
    <div class="col-md-12 text-center">
      <h2 class="mt-2" style="color:#f0932b">{{round(\App\RentCarReview::where('rent_car_id', $rentcar->id)->avg('rating'), 2)}}/5.0</h2>
      Based on {{\App\RentCarReview::where('rent_car_id', $rentcar->id)->count()}} reviews
    </div>
  </div>
  @foreach ($rentcar->rentcarreviews()->orderBy('id', 'DESC')->get() as $rentcarreview)
    <div class="comment-wrap">
      <div class="photo">
        @if (empty($rentcarreview->user->pro_pic))
          <div class="avatar" style="background-image: url('{{asset('assets/user/img/pro-pic/nopic.png')}}')"></div>
        @else
          <div class="avatar" style="background-image: url('{{asset('assets/user/img/pro-pic/'.$rentcarreview->user->pro_pic)}}')"></div>
        @endif
      </div>
       <div class="comment-block">
          <p class="comment-text">
            {{$rentcarreview->comment}}
          </p>
          <div class="bottom-comment">
             <div class="comment-date">{{date('M d, Y @ g:i A', strtotime($rentcarreview->created_at))}}</div>
             <ul class="comment-actions">
                <div id="rateYo{{$rentcarreview->id}}"></div>
             </ul>
          </div>
       </div>
    </div>
    <script>
    $(document).ready(function() {
      $("#rateYo{{$rentcarreview->id}}").rateYo({
        rating: {{$rentcarreview->rating}},
        readOnly: true,
        starWidth: "16px"
      });
    });
    </script>
  @endforeach
</div>
