<div class="comments">
  <div class="row">
    <div class="col-md-12 text-center">
      <h2 class="mt-2" style="color:#f0932b">{{round(\App\PickupCarReview::where('pickup_car_id', $pickup->id)->avg('rating'), 2)}}/5.0</h2>
      Based on {{\App\PickupCarReview::where('pickup_car_id', $pickup->id)->count()}} reviews
    </div>
  </div>
  @foreach ($pickup->pickupreviews()->orderBy('id', 'DESC')->get() as $pickupreview)
    <div class="comment-wrap">
      <div class="photo">
        @if (empty($pickupreview->user->pro_pic))
          <div class="avatar" style="background-image: url('{{asset('assets/user/img/pro-pic/nopic.png')}}')"></div>
        @else
          <div class="avatar" style="background-image: url('{{asset('assets/user/img/pro-pic/'.$pickupreview->user->pro_pic)}}')"></div>
        @endif
      </div>
       <div class="comment-block">
          <p class="comment-text">
            {{$pickupreview->comment}}
          </p>
          <div class="bottom-comment">
             <div class="comment-date">{{date('M d, Y @ g:i A', strtotime($pickupreview->created_at))}}</div>
             <ul class="comment-actions">
                <div id="rateYo{{$pickupreview->id}}"></div>
             </ul>
          </div>
       </div>
    </div>
    <script>
    $(document).ready(function() {
      $("#rateYo{{$pickupreview->id}}").rateYo({
        rating: {{$pickupreview->rating}},
        readOnly: true,
        starWidth: "16px"
      });
    });
    </script>
  @endforeach
</div>
