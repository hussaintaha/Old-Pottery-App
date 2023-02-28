<div class="row">
   <div class="column pending">
      <h4 class="title">Pending</h4>
      @foreach($orders['pending'] as $pending)
        @php
          $shipping_address = json_decode($pending->shipping_address);
          $customer_full_details = json_decode($pending->customer_full_details);
          if(gettype($shipping_address) == 'array'){
              $shipping_address =  $customer_full_details->default_address;
          }
        @endphp
      <div class="cards location{{$pending->shopify_location_id}}">
         <div class="desc full-wid">
            <p>Order {{$pending->order_name}} - {{date('g:i a', strtotime($pending->order_date))}}</p>
            <p>{{$pending->customer_name}}</p>
            <p>1 Products</p>
            <h6 class="card-title">{{ReturnCurrenyCode($currency)}} {{$pending->item_total}}</h6>
         </div>
         <div class="btn-opt">
            <p class="text-right">{{ ($pending->shipping_type == 'custom') ? 'DELIVERY' : 'PICKUP' }}</p>
            <button type="button" data-line="{{$pending->id}}" class="red-btn Acceptance">Accept</button>
         </div>
         <div class="show-hide text-center show-buttons">
            <a href="{{url('/pos-slip')}}?order_id={{$pending->id}}&shop={{$shop}}">
              <i class="fa fa-print"></i>
            </a>
            <span class="open-more" style="margin-left:22%">+ Show Details</span>
         </div>
          <div class="other-details">
           <div class="hide-det">
              <p class="text-left" style="display: inline;">Order Info</p>
              <p class="text-right right"style="display: inline;">{{$pending->financial_status}}</p>
              <ul class="food-desc">
                 <li>
                    <div class="desc  one">
                       <span class="head">{{$pending->product_quantity}} x {{$pending->product_title}}:</span>
                       <span class="descrp" style="display:none;">French Fries , Soda Salad.</span>
                    </div>
                    <div style="display:none;" class="desc  checkbox">
                      <input type="checkbox" class="input-assumpte">
                    </div>
                    <p style="display:none;" class="descrp">please send me ketchup and moyo</p>
                 </li>
              </ul>
              <p class="descrp note">
                Cart Notes: {{$pending->order_note}}.
              </p>
              <p>Delivery Info</p>
              <p class="head contact">Address : {{$shipping_address->address1}} {{$shipping_address->address2}} , {{$shipping_address->zip}} {{$shipping_address->city}} {{$shipping_address->province_code}} ,{{$shipping_address->country}}</p>
              <p class="head contact">Phone No : {{$customer_full_details->phone}}</p>
              <p class="head contact">Order Status : {{$pending->financial_status}}</p>
              <p class="head contact">Payment method : {{$pending->payment_method}}</p>
           </div>
           <div class="show-hide text-center">
             <a href="{{url('/pos-slip')}}?order_id={{$pending->id}}&shop={{$shop}}">
              <i class="fa fa-print"></i>
            </a>
              <span class="close-more">- Hide Details</span>
           </div>
       </div>
      </div>
      @endforeach
   </div>

   <div class="column processing">
      <h4 class="title">Processing</h4>
      <div class="border">
         @foreach($orders['processing'] as $pending)
           @php
             $shipping_address = json_decode($pending->shipping_address);
             $customer_full_details = json_decode($pending->customer_full_details);
             if(gettype($shipping_address) == 'array'){
                 $shipping_address =  $customer_full_details->default_address;
             }
           @endphp
         <div class="cards location{{$pending->shopify_location_id}}">
            <div class="desc full-wid">
               <p>Order {{$pending->order_name}} - {{date('g:i a', strtotime($pending->order_date))}}</p>
               <p>{{$pending->customer_name}}</p>
               <p>1 Products</p>
               <h6 class="card-title">{{ReturnCurrenyCode($currency)}} {{$pending->item_total}}</h6>
            </div>
            <div class="btn-opt">
               <p class="text-right">{{ ($pending->shipping_type == 'custom') ? 'DELIVERY' : 'PICKUP' }}</p>
               <button type="button" data-line="{{$pending->id}}" class="yellow-btn Ready">Ready</button>
            </div>
            <div class="show-hide text-center show-buttons">
               <a href="{{url('/pos-slip')}}?order_id={{$pending->id}}&shop={{$shop}}">
                 <i class="fa fa-print"></i>
               </a>
               <span class="open-more" style="margin-left:22%">+ Show Details</span>
            </div>
             <div class="other-details">
              <div class="hide-det">
                 <p class="text-left" style="display: inline;">Order Info</p>
                 <p class="text-right right"style="display: inline;">{{$pending->financial_status}}</p>
                 <ul class="food-desc">
                    <li>
                       <div class="desc  one">
                          <span class="head">{{$pending->product_quantity}} x {{$pending->product_title}}:</span>
                          <span class="descrp" style="display:none;">French Fries , Soda Salad.</span>
                       </div>
                       <div  class="desc  checkbox">
                         <input   type="checkbox" class="input-assumpte">
                       </div>
                       <p style="display:none;" class="descrp">please send me ketchup and moyo</p>
                    </li>
                 </ul>
                 <p class="descrp note">
                   Cart Notes: {{$pending->order_note}}.
                 </p>
                 <p>Delivery Info</p>
                 <p class="head contact">Address : {{$shipping_address->address1}} {{$shipping_address->address2}} , {{$shipping_address->zip}} {{$shipping_address->city}} {{$shipping_address->province_code}} ,{{$shipping_address->country}}</p>
                 <p class="head contact">Phone No : {{$customer_full_details->phone}}</p>
                 <p class="head contact">Order Status : {{$pending->financial_status}}</p>
                 <p class="head contact">Payment method : {{$pending->payment_method}}</p>
              </div>
              <div class="show-hide text-center">
                <a href="{{url('/pos-slip')}}?order_id={{$pending->id}}&shop={{$shop}}">
                 <i class="fa fa-print"></i>
               </a>
                 <span class="close-more">- Hide Details</span>
              </div>
          </div>
         </div>
         @endforeach
      </div>
   </div>

   <div class="column ship">
      <h4 class="title">Ready to Ship</h4>
      @foreach($orders['delivered'] as $pending)
        @php
          $shipping_address = json_decode($pending->shipping_address);
          $customer_full_details = json_decode($pending->customer_full_details);
          if(gettype($shipping_address) == 'array'){
              $shipping_address =  $customer_full_details->default_address;
          }
        @endphp
      <div class="cards location{{$pending->shopify_location_id}}">
         <div class="desc full-wid">
            <p>Order {{$pending->order_name}} - {{date('g:i a', strtotime($pending->order_date))}}</p>
            <p>{{$pending->customer_name}}</p>
            <p>1 Products</p>
            <h6 class="card-title">{{ReturnCurrenyCode($currency)}} {{$pending->item_total}}</h6>
         </div>
         <div class="btn-opt">
            <p class="text-right">{{ ($pending->shipping_type == 'custom') ? 'DELIVERY' : 'PICKUP' }}</p>
            <button data-line="{{$pending->id}}" type="button" class="green-btn Shipped">Ready</button>
         </div>
         <div class="show-hide text-center show-buttons">
            <a href="{{url('/pos-slip')}}?order_id={{$pending->id}}&shop={{$shop}}">
              <i class="fa fa-print"></i>
            </a>
            <span class="open-more" style="margin-left:22%">+ Show Details</span>
         </div>
          <div class="other-details">
           <div class="hide-det">
              <p class="text-left" style="display: inline;">Order Info</p>
              <p class="text-right right"style="display: inline;">{{$pending->financial_status}}</p>
              <ul class="food-desc">
                 <li>
                    <div class="desc  one">
                       <span class="head">{{$pending->product_quantity}} x {{$pending->product_title}}:</span>
                       <span class="descrp" style="display:none;">French Fries , Soda Salad.</span>
                    </div>
                    <div  class="desc  checkbox">
                      <input style="display:none;"  type="checkbox" class="input-assumpte">
                    </div>
                    <p style="display:none;" class="descrp">please send me ketchup and moyo</p>
                 </li>
              </ul>
              <p class="descrp note">
                Cart Notes: {{$pending->order_note}}.
              </p>
              <p>Delivery Info</p>
              <p class="head contact">Address : {{$shipping_address->address1}} {{$shipping_address->address2}} , {{$shipping_address->zip}} {{$shipping_address->city}} {{$shipping_address->province_code}} ,{{$shipping_address->country}}</p>
              <p class="head contact">Phone No : {{$customer_full_details->phone}}</p>
              <p class="head contact">Order Status : {{$pending->financial_status}}</p>
              <p class="head contact">Payment method : {{$pending->payment_method}}</p>
           </div>
           <div class="show-hide text-center">
             <a href="{{url('/pos-slip')}}?order_id={{$pending->id}}&shop={{$shop}}">
              <i class="fa fa-print"></i>
            </a>
              <span class="close-more">- Hide Details</span>
           </div>
       </div>
      </div>
      @endforeach

   </div>
</div>
