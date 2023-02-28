@php
  $shipping_address = json_decode($order->shipping_address);
  $customer_full_details = json_decode($order->customer_full_details);
  if(gettype($shipping_address) == 'array'){
      $shipping_address =  $customer_full_details->default_address;
  }
@endphp
<div class="Polaris-Card" style="width:30%;margin-top:2%;margin-right: 2%;">
   <div class="Polaris-Card__Header">
      <h2 class="Polaris-Heading">Customer
        <img class="user-image" src="https://i.ibb.co/5TpCQF3/customer-icon.png">
      </h2>
   </div>
   <div class="Polaris-Card__Section">
      <div class="Polaris-FormLayout">
         <div class="Polaris-FormLayout__Item">
            <p>{{$order->customer_name}}</p>
         </div>
      </div>
   </div>
   <div  class="Polaris-Card__Section order-section">
        <h3 class="Polaris-Subheading">Contact Information</h3>
      <div class="Polaris-FormLayout">
         <div class="Polaris-FormLayout__Item">
            <p><b>Email  - </b>{{$customer_full_details->email}}</p>
            <p><b>Phone No - </b>{{$customer_full_details->phone}}</p>
         </div>
      </div>
   </div>
   <div  class="Polaris-Card__Section order-section">
        <h3 class="Polaris-Subheading">Order Details</h3>
      <div class="Polaris-FormLayout">
         <div class="Polaris-FormLayout__Item">
            <p><b>Order no  - </b>{{$order->order_name}}</p>
            <p><b>Payment Status  - </b>{{$order->financial_status}}</p>
            <p><b>Payment Method  - </b>{{$order->payment_method}}</p>
            <p><b>Assigned Location  - </b>{{$order->location_name}}</p>
         </div>
      </div>
   </div>
   <div class="Polaris-Card__Section order-section">
        <h3 class="Polaris-Subheading">Order Item</h3>
      <div class="Polaris-FormLayout">
         <div class="Polaris-FormLayout__Item">
            <p><b>Item -</b> {{$order->product_title}}</p>
            <p><b>quantity -</b>  {{$order->product_quantity}}</p>
            <p><b>Total -</b> {{$order->item_total}}</p>
         </div>
      </div>
   </div>
   <div class="Polaris-Card__Section order-section">
        <h3 class="Polaris-Subheading">Order Time</h3>
      <div class="Polaris-FormLayout">
         <div class="Polaris-FormLayout__Item">
            <p>{{date('d F Y \a\t g:i a', strtotime($order->order_date))}}</p>
         </div>
      </div>
   </div>
   <div class="Polaris-Card__Section order-section">
        <h3 class="Polaris-Subheading">Delivery Address</h3>
      <div class="Polaris-FormLayout">
         <div class="Polaris-FormLayout__Item">
           <p>{{$shipping_address->first_name}} {{$shipping_address->first_name}}</p>
           <p>{{$shipping_address->address1}} {{$shipping_address->address2}}</p>
           <p>{{$shipping_address->zip}} {{$shipping_address->city}} {{$shipping_address->province_code}}</p>
           <p>{{$shipping_address->country}}</p>
         </div>
      </div>
   </div>

    <div style="display:none" class="Polaris-Card__Section order-section">
      <div class="Polaris-FormLayout">
         <div class="Polaris-FormLayout__Item">
            <p>Order Action</p>
         </div>
         <div class="Polaris-FormLayout__Item" >
            <div class="Polaris-ButtonGroup Polaris-ButtonGroup--segmented" data-buttongroup-segmented="true">
               <div class="Polaris-ButtonGroup__Item" style="margin-right: 5rem;">
                  <button type="button" data-accept="yes" data-line="{{$order->id}}" class="Polaris-Button Polaris-Button--primary Acceptance">
                    <span class="Polaris-Button__Content">
                        <span class="Polaris-Button__Text">Accept</span>
                    </span>
                  </button>
               </div>
               <div  class="Polaris-ButtonGroup__Item" >
                 <a class="menu-anchor" href="{{url('User/pos-print')}}?order_id={{$order->id}}">
                  <button type="button" data-accept="no"  class="Polaris-Button">
                    <span class="Polaris-Button__Content">
                      <span class="Polaris-Button__Text">Print</span>
                    </span>
                </button>
                </a>
               </div>
            </div>
         </div>
      </div>
   </div>

</div>
