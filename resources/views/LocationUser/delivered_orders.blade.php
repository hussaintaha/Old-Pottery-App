@extends('LocationUser.admin')
@section('content')
<div class="Polaris-Page">
   <div class="Polaris-Page-Header Polaris-Page-Header--mobileView">
      <div class="Polaris-Page-Header__MainContent">
         <div class="Polaris-Page-Header__TitleActionMenuWrapper">
            <div>
               <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">
                  <div class="Polaris-Header-Title">
                     <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">Delivered Orders</h1>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="Polaris-Page__Content">
     @if(count($orders) > 0)
       <div class="row">
         <div class="column pending">
            @foreach($orders as $k=>$order)
                @include('LocationUser.new_single_order',[
                'shop'=>$shop,
                'pending'=>$order[0],
                'details'=>$order,
                'currency'=>$currency,
                'btn'=>'yellow',
                'title'=>'Pending',
                'btn_text'=>'Deliver'
                ])
            @endforeach
          </div>
       </div>
      @else
        @include('LocationUser.empty_order_page')
     @endif
   </div>
</div>
@endsection
