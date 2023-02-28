<div class="coloum-three">
   <h2 class="Polaris-Heading status-title">{{$title}}</h2>
   @foreach($orders as $key=>$pending)
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
   @endphp
     <div class="box-proce-read-pend">
       <div class="single-wrap">
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
                <button type="button" data-line="{{$pending->id}}"  class="order-btn {{$btn}}-btn  {{$btn_class}}">{{$btn_text}}</button>
             </div>
           </div>
           <div class="show-buttons" >
             <div style="width: 30%;">
              <a href="{{url('User/pos-print')}}?order_id={{$pending->id}}">
                 <i class="fa fa-print" style="font-size:24px"></i>
               </a>
             </div>
             <div>
               <span class="open-more">+Show Details</span>
             </div>
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
                  @php
                  if($pending->status == 1){
                    @endphp
                      <input  type="checkbox" class="is-prepared">
                    @php
                  }
                  @endphp
                </li>
              </ul>
            </div>

            <div style="margin-left: 4%;margin-top: 4%;" class="order-details">
              <p> Cart note : {{$pending->order_note}}</p>
            </div>
            <div class="order-details"  style="margin-left: 4%;margin-top: 4%;">
                <div style="font-size: 19px;font-weight: 600;"> Delivery Info </div>
                <p><span class="order-info-span">Address :  </span> {{$shipping_address->address1}} {{$shipping_address->address2}} , {{$shipping_address->zip}} {{$shipping_address->city}} {{$shipping_address->province_code}} ,{{$shipping_address->country}}</p>
                <p><span class="order-info-span">Phone No :  </span> {{$customer_full_details->phone}}</p>
                <p><span class="order-info-span">Order Status :  </span> {{$pending->financial_status}}</p>
                <p><span class="order-info-span">Payment method :  </span> {{$pending->payment_method}} </p>
            </div>
            <div style="margin-left: 4%;display:flex;">
              <div style="width: 30%;">
                <a  href="{{url('User/pos-print')}}?order_id={{$pending->id}}">
                  <i class="fa fa-print" style="font-size:24px"></i>
                </a>
              </div>
              <div>
                <span class="close-more"> - Hide Details</span>
              </div>
            </div>
        </div>
     </div>
   @endforeach
</div>
