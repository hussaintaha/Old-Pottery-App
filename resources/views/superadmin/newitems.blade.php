<div class="page-wrap">
   <div class="grid">
      <div class="coloum-three">
         <h2 class="Polaris-Heading">Pending</h2>
         @foreach($orders['pending'] as $key=>$pending)
         @php
           $shipping_address = json_decode($pending->shipping_address);
           $customer_full_details = json_decode($pending->customer_full_details);
           if(gettype($shipping_address) == 'array'){
               $shipping_address =  $customer_full_details->default_address;
           }
         @endphp
           <div class="box-proce-read-pend">
              <div class="inner-wraps">
                 <div class="order-items">
                    <div class="order-item-inner">
                       <p class="o-id">
                         <span>Order {{$pending->order_name}} - {{date('g:i a', strtotime($pending->order_date))}}</span>
                         <span>{{ ($pending->shipping_type == 'custom') ? 'Delivery' : 'Pickup' }}</span>
                       </p>
                       <p class="o-pe-name">{{$pending->customer_name}}</p>
                       <p class="o-qty">1 Products</p>
                       <p class="o-price">{{ReturnCurrenyCode($currency)}} {{$pending->item_total}}</p>
                    </div>
                 </div>
                 <div class="order-pick-btn">
                    <button class="order-btn red-btn">Accept</button>
                 </div>
              </div>

              <div class="order-other-details">
                  <div class="order-details">
                    <div class="order-infoheading">
                      <span class="order-title">Order Info</span>
                      <span class="order-payment-status">{{$pending->financial_status}}</span>
                    </div>
                    <ul>
                      <li>
                        1 x {{$pending->product_title}}
                        <input class="checkbox" type="checkbox" checked>
                      </li>
                    </ul>
                  </div>

                  <div style="margin-left: 4%;margin-top: 4%;" class="order-details">
                    <p> Cart note : is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</p>
                  </div>
                  <div class="order-details"  style="margin-left: 4%;margin-top: 4%;">
                      <div style="font-size: 19px;font-weight: 600;"> Delivery Info </div>
                      <p><span class="order-info-span">Address :  </span> {{$shipping_address->address1}} {{$shipping_address->address2}} , {{$shipping_address->zip}} {{$shipping_address->city}} {{$shipping_address->province_code}} ,{{$shipping_address->country}}</p>
                      <p><span class="order-info-span">Phone No :  </span> {{$customer_full_details->phone}}</p>
                      <p><span class="order-info-span">Order Status :  </span> {{$pending->financial_status}}</p>
                      <p><span class="order-info-span">Payment method :  </span> {{$pending->payment_method}} </p>
                  </div>
              </div>
           </div>
         @endforeach
      </div>


      <div class="coloum-three">
         <h2 class="Polaris-Heading">
            Processing
         </h2>
         @php
          for($j=0;$j<10;$j++){
          @endphp
         <div class="box-proce-read-pend">
            <div class="inner-wraps">
               <div class="order-items">
                  <div class="order-item-inner">
                     <p class="o-id">Order #1102 - 4:31PM</p>
                     <p class="o-pe-name">Jyries Akle</p>
                     <p class="o-qty">1 Products</p>
                     <p class="o-price">$10,000</p>
                  </div>
               </div>
               <div class="order-pick-btn">
                  <button class="order-btn yellow-btn">Ready</button>
               </div>

            </div>
         </div>
         @php
       }
        @endphp


      </div>


      <div class="coloum-three">
         <h2 class="Polaris-Heading">
            Ready To ship
         </h2>

         @php
          for($k=0;$k<10;$k++){
          @endphp
         <div class="box-proce-read-pend">
            <div class="inner-wraps">
               <div class="order-items">
                  <div class="order-item-inner">
                     <p class="o-id">Order #1102 - 4:31PM</p>
                     <p class="o-pe-name">Jyries Akle</p>
                     <p class="o-qty">1 Products</p>
                     <p class="o-price">$10,000</p>
                  </div>
               </div>
               <div class="order-pick-btn">
                  <button class="order-btn green-btn">Ready</button>
               </div>
            </div>
         </div>
         @php
       }
        @endphp


      </div>


   </div>
</div>
