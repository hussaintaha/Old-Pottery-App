@php
  $shipping_address = json_decode($pending->shipping_address);
  $customer_full_details = json_decode($pending->customer_full_details);
  if(gettype($shipping_address) == 'array'){
      $shipping_address =  $customer_full_details->default_address;
  }
  $btn_class="";
   switch ($pending->status) {
     case 0:
     $btn_class = 'Acceptance';
     break;
     case 1:
     $btn_class = 'Ready';
     break;
     case 2:
     $btn_class = 'Shipped';
     break;

   }
   $singleOrderTotal=0;
   foreach($details as $item){
     $singleOrderTotal = $singleOrderTotal+$item->item_total;
   }
@endphp
<div class="cards">
   <div class="desc full-wid" style="width:56%">
      <p>Order {{$pending->order_name}} - {{date('g:i a', strtotime($pending->order_date))}}</p>
      <p>{{$pending->customer_name}}</p>
      <p>1 Products</p>
      <h6 class="card-title">{{ReturnCurrenyCode($currency)}} {{$singleOrderTotal}}</h6>
   </div>
   <div class="btn-opt">
      <p class="text-right">{{ ($pending->shipping_type == 'custom') ? 'DELIVERY' : 'PICKUP' }}</p>
      <button type="button" data-line="{{$pending->id}}" class="{{$btn}}-btn {{$btn_class}}">{{$btn_text}}</button>
   </div>
   <div class="show-hide text-center show-buttons">
      <a href="{{url('User/pos-print')}}?order_id={{$pending->id}}">
        <i class="fa fa-print"></i>
      </a>
      <span class="open-more">+ Show Details</span>
   </div>
    <div class="other-details">
     <div class="hide-det">
        <p class="text-left" style="display: inline;">Order Info</p>
        <p class="text-right right"style="display: inline;">{{$pending->financial_status}}</p>
        <ul class="food-desc">
          @foreach($details as $dt)
           <li>
              <div class="desc  one">
                 <span class="head">{{$dt->product_quantity}} x {{$dt->product_title}}:</span>
                 <span class="descrp" style="display:none;">French Fries , Soda Salad.</span>
              </div>
              <div style="display:none;" class="desc  checkbox"><input type="checkbox" class="input-assumpte"></div>
              <p style="display:none;" class="descrp">please send me ketchup and moyo</p>
           </li>
           @endforeach
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
       <a href="{{url('User/pos-print')}}?order_id={{$pending->id}}">
        <i class="fa fa-print"></i>
      </a>
        <span class="close-more">- Hide Details</span>
     </div>
 </div>
</div>
