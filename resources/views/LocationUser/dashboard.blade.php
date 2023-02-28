@extends('LocationUser.admin')
@section('content')
<div class="Polaris-Page">
   <div class="Polaris-Page-Header Polaris-Page-Header--mobileView">
      <div class="Polaris-Page-Header__MainContent">
         <div class="Polaris-Page-Header__TitleActionMenuWrapper">
            <div>
               <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">
                  <div class="Polaris-Header-Title">
                     <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">DashBoard</h1>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="Polaris-Page__Content">

     @if($new_orders > 0)
     <div class="Polaris-Card">
        <div class="Polaris-Card__Header">
            <a class="menu-anchor" href="{{url('User/orders')}}?status=0">
             <h2 class="Polaris-Heading new-heading">
               <span class="IQjZ8">
                 <span>
                    <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                       <path fill="#1d249b" d="M1 13h5l1 2h6l1-2h5v6H1z"></path>
                       <path d="M2 18v-4h3.382l.723 1.447c.17.339.516.553.895.553h6c.379 0 .725-.214.895-.553L14.618 14H18v4H2zM19 1a1 1 0 0 1 1 1v17a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h4a1 1 0 0 1 0 2H2v9h4c.379 0 .725.214.895.553L7.618 14h4.764l.723-1.447c.17-.339.516-.553.895-.553h4V3h-3a1 1 0 0 1 0-2h4zM6.293 6.707a.999.999 0 1 1 1.414-1.414L9 6.586V1a1 1 0 0 1 2 0v5.586l1.293-1.293a.999.999 0 1 1 1.414 1.414l-3 3a.997.997 0 0 1-1.414 0l-3-3z" fill-rule="evenodd"></path>
                    </svg>
                 </span>
                 <strong>{{$new_orders}} orders</strong>&nbsp;to fulfill
               </span>
               <span class="move-icon">
                 <svg class="Polaris-Icon__Svg_375hu" viewBox="0 0 20 20" style="fill: #c4cdd5;"  focusable="false" aria-hidden="true"><path d="M8 16a.999.999 0 0 1-.707-1.707L11.586 10 7.293 5.707a.999.999 0 1 1 1.414-1.414l5 5a.999.999 0 0 1 0 1.414l-5 5A.997.997 0 0 1 8 16" fill-rule="evenodd"></path></svg>
              </span>
             </h2>
           </a>
        </div>
     </div>
     @endif

      <div class="Polaris-Card">
        <div class="Polaris-Card__Section">
           <div class="Polaris-Stack Polaris-Stack--vertical Polaris-Stack--distributionCenter Polaris-Stack--alignmentCenter">
              <div class="Polaris-Stack__Item">
                <img src="https://amkwebsolutions.com/shopify-app/foodorder_manager/resources/images/setup.jpg" width="240px">
              </div>
              <div class="Polaris-Stack__Item">
                 <h2 class="Polaris-Heading">Welcome {{ Session::get('userData')->location_name}} </h2>
              </div>
              <div class="Polaris-Stack__Item">
                 <p>This is Your panel To accept Orders Nearest To Your Location</p>
              </div>
           </div>
        </div>
      </div>


   </div>
</div>
@endsection
