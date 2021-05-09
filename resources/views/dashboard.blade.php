@extends('layouts.main')

@section('content')

<style>
h1{
  color:white;
  margin-top: 2em;
}
p{
  color:white;
}

/******************************

Stati - minimal statistical cards

*******************************/
.stati{
  background: #fff;
  height: 6em;
  padding:1em;
  margin:1em 0; 
    -webkit-transition: margin 0.5s ease,box-shadow 0.5s ease; / Safari /
    transition: margin 0.5s ease,box-shadow 0.5s ease; 
  -moz-box-shadow:0px 0.2em 0.4em rgb(0, 0, 0,0.8);
-webkit-box-shadow:0px 0.2em 0.4em rgb(0, 0, 0,0.8);
box-shadow:0px 0.2em 0.4em rgb(0, 0, 0,0.8);
}
.stati:hover{ 
  margin-top:0.5em;  
  -moz-box-shadow:0px 0.4em 0.5em rgb(0, 0, 0,0.8); 
-webkit-box-shadow:0px 0.4em 0.5em rgb(0, 0, 0,0.8); 
box-shadow:0px 0.4em 0.5em rgb(0, 0, 0,0.8); 
}
.stati i{
  font-size:3.5em; 
} 
.stati div{
  width: calc(100% - 3.5em);
  display: block;
  float:right;
  text-align:right;
}
.stati div b {
  font-size:2.2em;
  width: 100%;
  padding-top:0px;
  margin-top:-0.2em;
  margin-bottom:-0.2em;
  display: block;
}
.stati div span {
  font-size:1em;
  width: 100%;
  color: rgb(0, 0, 0,0.8); !important;
  display: block;
}

.stati.left div{ 
  float:left;
  text-align:left;
}

.stati.bg-turquoise { background: rgb(26, 188, 156); color:white;} 
.stati.bg-emerald { background: rgb(46, 204, 113); color:white;} 
.stati.bg-peter_river { background: rgb(52, 152, 219); color:white;} 
.stati.bg-amethyst { background: rgb(155, 89, 182); color:white;} 
.stati.bg-wet_asphalt { background: rgb(52, 73, 94); color:white;} 
.stati.bg-green_sea { background: rgb(22, 160, 133); color:white;} 
.stati.bg-nephritis { background: rgb(39, 174, 96); color:white;} 
.stati.bg-belize_hole { background: rgb(41, 128, 185); color:white;} 
.stati.bg-wisteria { background: rgb(142, 68, 173); color:white;} 
.stati.bg-midnight_blue { background: rgb(44, 62, 80); color:white;} 
.stati.bg-sun_flower { background: rgb(241, 196, 15); color:white;} 
.stati.bg-carrot { background: rgb(230, 126, 34); color:white;} 
.stati.bg-alizarin { background: rgb(231, 76, 60); color:white;} 
.stati.bg-clouds { background: rgb(236, 240, 241); color:white;} 
.stati.bg-concrete { background: rgb(149, 165, 166); color:white;} 
.stati.bg-orange { background: rgb(243, 156, 18); color:white;} 
.stati.bg-pumpkin { background: rgb(211, 84, 0); color:white;} 
.stati.bg-pomegranate { background: rgb(192, 57, 43); color:white;} 
.stati.bg-silver { background: rgb(189, 195, 199); color:white;} 
.stati.bg-asbestos { background: rgb(127, 140, 141); color:white;} 
  

.stati.turquoise { color: rgb(26, 188, 156); } 
.stati.emerald { color: rgb(46, 204, 113); } 
.stati.peter_river { color: rgb(52, 152, 219); } 
.stati.amethyst { color: rgb(155, 89, 182); } 
.stati.wet_asphalt { color: rgb(52, 73, 94); } 
.stati.green_sea { color: rgb(22, 160, 133); } 
.stati.nephritis { color: rgb(39, 174, 96); } 
.stati.belize_hole { color: rgb(41, 128, 185); } 
.stati.wisteria { color: rgb(142, 68, 173); } 
.stati.midnight_blue { color: rgb(44, 62, 80); } 
.stati.sun_flower { color: rgb(241, 196, 15); } 
.stati.carrot { color: rgb(230, 126, 34); } 
.stati.alizarin { color: rgb(231, 76, 60); } 
.stati.clouds { color: rgb(236, 240, 241); } 
.stati.concrete { color: rgb(149, 165, 166); } 
.stati.orange { color: rgb(243, 156, 18); } 
.stati.pumpkin { color: rgb(211, 84, 0); } 
.stati.pomegranate { color: rgb(192, 57, 43); } 
.stati.silver { color: rgb(189, 195, 199); } 
.stati.asbestos { color: rgb(127, 140, 141); } 
</style>

<div class="boxed">
    <div id="content-container">
        <!-- -->
        <div class="container" style="margin-top: 36px;">  
    <div class="row">
      <div class="col-md-3">
        <div class="stati bg-wet_asphalt ">
          <i class="icon-screen-tablet icons"></i>
          <div>
            <b>
				@if($total_parcels > 0)
					{{$total_parcels}}
				@else	
					0
				@endif
			</b>
            <span>Total Parcels</span>
          </div> 
        </div>
      </div> 
     <div class="col-md-3">
        <div class="stati bg-peter_river ">
          <i class="icon-energy icons"></i>
          <div>
            <b>{{$total_returns}}</b>
            <span>Total Returns</span>
          </div> 
        </div>
      </div>
      <div class="col-md-3">
        <div class="stati bg-turquoise ">
          <i class="icon-trophy icons"></i>
          <div>
		    
            <b>
				@if($total_returns_karachi != 0)
					{{($total_returns_karachi/$total_returns)*100}}%
				@else 
					0
				@endif
			</b>
            <span>Total Returns Ratio Karachi</span>
          </div> 
        </div>
      </div> 
      <div class="col-md-3">
        <div class="stati bg-emerald ">
          <i class="icon-notebook icons"></i>
          <div>
            <b>
				@if($total_returns_lahore != 0)
					{{($total_returns_lahore/$total_returns)*100}}%
				@else 
					0
				@endif
		    </b>		
            <span>Total Returns Ratio Lahore</span>
          </div> 
        </div>
      </div>
</div>
     
   
  </div>
        <!-- -->
    </div>
</div>
@endsection