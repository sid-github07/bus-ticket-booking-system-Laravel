<div class="comments">
  <div class="row">
    <div class="col-md-12 text-center">
      <h2 class="mt-2" style="color:#f0932b">{{round(\App\HotelReview::where('hotel_id', $hotel->id)->avg('rating'), 2)}}/5.0</h2>
      Based on {{\App\HotelReview::where('hotel_id', $hotel->id)->count()}} reviews
    </div>
  </div>
  @foreach ($hotel->hotelreviews()->orderBy('id', 'DESC')->get() as $hotelreview)
    <div class="comment-wrap">
       <div class="photo">
         @if (empty($hotelreview->user->pro_pic))
           <div class="avatar" style="background-image: url('{{asset('assets/user/img/pro-pic/nopic.png')}}')"></div>
         @else
           <div class="avatar" style="background-image: url('{{asset('assets/user/img/pro-pic/'.$hotelreview->user->pro_pic)}}')"></div>
         @endif
       </div>
       <div class="comment-block">
          <p class="comment-text">
            {{$hotelreview->comment}}
          </p>
          <div class="bottom-comment">
             <div class="comment-date">{{date('M d, Y @ g:i A', strtotime($hotelreview->created_at))}}</div>
             <ul class="comment-actions">
                <div id="rateYo{{$hotelreview->id}}"></div>
             </ul>
          </div>
       </div>
    </div>
    <script>
    $(document).ready(function() {
      $("#rateYo{{$hotelreview->id}}").rateYo({
        rating: {{$hotelreview->rating}},
        readOnly: true,
        starWidth: "16px"
      });
    });
    </script>
  @endforeach
</div>
