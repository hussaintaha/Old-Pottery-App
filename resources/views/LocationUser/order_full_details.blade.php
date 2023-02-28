@extends('LocationUser.admin')
@section('content')
<style>
.user-image {
  border-radius: 15px;
  float: right;
}
.order-section {
  border-top: 1px solid var(--p-border-subdued, #dfe3e8);
}
.order-details__summary.order-details__summary {
  margin-top: 0;
  line-height: 2rem;
}
table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
}
.order-details-summary-table {
  text-rendering: auto !important;
}
.ui-title-bar__title {
    font-size: 2.4rem;
    line-height: 2.8rem;
    font-weight: 600;
    margin-right: 0.8rem;
    overflow: hidden;
    overflow-wrap: break-word;
    word-wrap: break-word;
    white-space: normal;
}
</style>
<div class="Polaris-Page">
   <div class="Polaris-Page-Header Polaris-Page-Header--mobileView">
      <div class="Polaris-Page-Header__MainContent">
         <div class="Polaris-Page-Header__TitleActionMenuWrapper">
            <div>
               <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">
                  <div class="Polaris-Header-Title">
                     <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">
                       Order Details
                     </h1>
                     <p>
                       <span class="ui-title-bar__title">{{$order['name']}}</span>
                       <span style="margin: 0;font-size: 1em;font-weight: 400;">
                         {{date('d F Y \a\t g:i a', strtotime($order['created_at']))}}
                       </span>
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="Polaris-Page__Content">
      <div style="display:flex;">
         <div class="Polaris-Card" style="width:70%;margin-top:2%;">
            <div class="Polaris-Card__Header">
               <h2 class="Polaris-Heading">Order Details</h2>
            </div>
            <div class="Polaris-Card__Section">
               <div class="Polaris-DataTable">
                  <div class="Polaris-DataTable__ScrollContainer">
                     <table class="Polaris-DataTable__Table">
                        <thead>
                           <tr>
                              <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn Polaris-DataTable__Cell--header" scope="col">Product</th>
                              <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Quantity</th>
                              <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Price</th>
                              <th data-polaris-header-cell="true" class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--header Polaris-DataTable__Cell--numeric" scope="col">Total</th>
                           </tr>
                        </thead>
                        @php
                          $itemcont = 0;
                        @endphp
                        <tbody>
                           @foreach($order['line_items'] as $item)
                           @php
                           $itemcont = $item['quantity'] + $itemcont;
                           @endphp
                           <tr class="Polaris-DataTable__TableRow">
                              <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--firstColumn" scope="row">
                                 {{$item['title']}}
                              </th>
                              <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">
                                 {{$item['quantity']}}
                              </td>
                              <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">
                                 {{$order['currency']}} {{$item['price']}}
                              </td>
                              <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--verticalAlignTop Polaris-DataTable__Cell--numeric">
                                 {{$order['currency']}} {{$item['price']*$item['quantity']}}
                              </td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="Polaris-Card" style="width: 30%;margin-left: 8%;height: 100px;">
            <div class="Polaris-Card__Header">
               <h2 class="Polaris-Heading">Note</h2>
            </div>
            <div class="Polaris-Card__Section">
               <p>{{$order['note']}}</p>
            </div>
         </div>
      </div>
      <div style="display:flex;">
         <div class="Polaris-Card" style="width:70%;margin-top:2%;height: 190px;">
            <div class="Polaris-Card__Header">
               <h2 class="Polaris-Heading">
                  {{$order['financial_status']}}
               </h2>
            </div>
            <div class="Polaris-Card__Section">
               <div class="order-details__summary">
                  <table class="order-details-summary-table" role="table">
                     <tbody>
                        <tr>
                           <td>Subtotal</td>
                           <td class="type--subdued">
                              {{$itemcont}} items
                           </td>
                           <td>{{$order['currency']}} {{$order['subtotal_price']}}</td>
                        </tr>
                     </tbody>
                     <tbody class="order-details__summary__shipping"></tbody>
                     @foreach($order['tax_lines'] as $tax)
                     <tbody class="order-details__summary__tax">
                        <tr class="order-details__summary__detail-line-row">
                           <td>Tax</td>
                           <td class="type--subdued">
                              {{$tax['title']}} {{$tax['rate']*100}}%
                           </td>
                           <td>{{$order['currency']}} {{$tax['price']}}</td>
                        </tr>
                     </tbody>
                     @endforeach
                     <tbody>
                        <tr>
                           <td colspan="2">Total</td>
                           <td>{{$order['currency']}} {{$order['total_price']}}</td>
                        </tr>
                     </tbody>
                     <tbody class="order-details__summary__paid_by_customer">
                        <tr>
                           <td colspan="3" class="order-details-summary-table__separator">
                              <hr>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="2">Paid by customer</td>
                           <td>{{$order['currency']}} {{$order['total_price']}}</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="Polaris-Card" style="width:28%;margin-left:3%">
            <div class="Polaris-Card__Header">
               <h2 class="Polaris-Heading">Customer
                  <img class="user-image" src="https://i.ibb.co/5TpCQF3/customer-icon.png">
               </h2>
            </div>
            <div class="Polaris-Card__Section">
               <div class="Polaris-FormLayout">
                  <div class="Polaris-FormLayout__Item">
                     <p>John Doe</p>
                  </div>
               </div>
            </div>
            <div class="Polaris-Card__Section order-section">
               <h3 class="Polaris-Subheading">Contact Information</h3>
               <div class="Polaris-FormLayout">
                  <div class="Polaris-FormLayout__Item">
                     <p><b>Email  - </b>{{$order['customer']['email']}}</p>
                     <p><b>Phone No - </b>{{$order['customer']['phone']}}</p>
                  </div>
               </div>
            </div>
            <div class="Polaris-Card__Section order-section">
               <h3 class="Polaris-Subheading">Shipping Address</h3>
               <div class="Polaris-FormLayout">
                  <div class="Polaris-FormLayout__Item">
                     <div class="Polaris-FormLayout__Item">
                        <p>{{$order['shipping_address']['first_name']}} {{$order['shipping_address']['first_name']}}</p>
                        <p>{{$order['shipping_address']['address1']}} {{$order['shipping_address']['address2']}}</p>
                        <p>{{$order['shipping_address']['zip']}} {{$order['shipping_address']['city']}} {{$order['shipping_address']['province_code']}}</p>
                        <p>{{$order['shipping_address']['country']}}</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


@endsection
