<div class="logo">
<div class="icon-wd-5 text-center">
<span>
<a href="{{ url('/web/lesson/'.$id.'/'.$code.'/results/graph') }}">
<img class="img-icon" src="{{asset('images/edit_profile_off.png')}}"
onmouseover="this.src='{{asset('images/edit_profile_on.png')}}';" 
onmouseout="this.src='{{asset('images/edit_profile_off.png')}}';"/>
</a>
</span></div>
<span>
<div class="icon-wd-5 text-center">
<a href="{{ url('/web/lesson/'.$id.'/'.$code.'/results/students') }}">
<img class="img-icon" src="{{asset('images/swap_off.png')}}"
onmouseover="this.src='{{asset('images/swap_on.png')}}';" 
onmouseout="this.src='{{asset('images/swap_off.png')}}';"/>
</a></div>
</span>
<div class="icon-wd-5 text-center">
<span>
<input type="hidden" value="{{ $id }}" id="lesson_id">
<img id="refresh" class="img-icon" src="{{asset('images/refresh_off.png')}}"
onmouseover="this.src='{{asset('images/refresh_on.png')}}';" 
onmouseout="this.src='{{asset('images/refresh_off.png')}}';"/>
</span></div>
<div class="icon-wd-5 text-center">
<span>
<a href="{{ url('/web/lesson/'.$id.'/'.$code.'/results/report') }}">
<img class="img-icon" src="{{asset('images/email_off.png')}}"
onmouseover="this.src='{{asset('images/email_on.png')}}';" 
onmouseout="this.src='{{asset('images/email_off.png')}}';"/>
</a>
</span></div>
<div class="icon-wd-5 text-center">
<span>
<a href="{{ url('web/lesson/'.$id.'/disable') }}">
<img class="img-icon" src="{{asset('images/close_off.png')}}"
onmouseover="this.src='{{asset('images/close_on.png')}}';" 
onmouseout="this.src='{{asset('images/close_off.png')}}';"/>
</a>
</span></div>
</div>

