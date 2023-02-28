  <div id="print-body">
     <style>
        #invoice-POS {
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        padding: 2mm;
        margin: 0 auto;
        width: 44mm;
        background: #FFF;
        }
        #invoice-POS ::selection {
        background: #f31544;
        color: #FFF;
        }
        #invoice-POS ::moz-selection {
        background: #f31544;
        color: #FFF;
        }
        #invoice-POS h1 {
        font-size: 1.5em;
        color: #222;
        }
        #invoice-POS h2 {
        font-size: .9em;
        }
        #invoice-POS h3 {
          font-size: 1.2em;
          font-weight: 300;
          line-height: 2em;
        }
        #invoice-POS p {
        font-size: .7em;
        color: #666;
        line-height: 1.2em;
        }
        #invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
          border-bottom: 1px solid #EEE;
        }
        #invoice-POS #top {
          min-height: 100px;
        }
        #invoice-POS #mid {
        min-height: 80px;
        }
        #invoice-POS #bot {
        min-height: 50px;
        }
        #invoice-POS #top .logo {
        height: 60px;
        width: 60px;
        background: url(https://michaeltruong.ca/images/logo1.png) no-repeat;
        background-size: 60px 60px;
        }
        #invoice-POS .clientlogo {
        float: left;
        height: 60px;
        width: 60px;
        background: url(https://michaeltruong.ca/images/client.jpg) no-repeat;
        background-size: 60px 60px;
        border-radius: 50px;
        }
        #invoice-POS .info {
          display: block;
          margin-left: 0;
        }
        #invoice-POS .title {
          float: right;
        }
        #invoice-POS .title p {
          text-align: right;
        }
        #invoice-POS table {
        width: 100%;
        border-collapse: collapse;
        }
        #invoice-POS .tabletitle {
          font-size: .5em;
          background: #EEE;
        }
        #invoice-POS .service {
          border-bottom: 1px solid #EEE;
       }
        #invoice-POS .item {
          width: 24mm;
        }
        #invoice-POS .itemtext {
          font-size: .5em;
        }
        #invoice-POS #legalcopy {
          margin-top: 5mm;
        }
     </style>
     @php
       $shipping_address = json_decode($order->shipping_address);
       $customer_full_details = json_decode($order->customer_full_details);
       if(gettype($shipping_address) == 'array'){
           $shipping_address =  $customer_full_details->default_address;
       }
     @endphp
      <div id="invoice-POS">
         <center id="top">
            <div class="logo"></div>
            <div class="info">
               <h2>{{$shop_name}}</h2>
            </div>
         </center>
         <div id="mid">
            <div class="info">
               <h2>Contact Info</h2>
               <p>
                  Address : {{$shipping_address->address1}} {{$shipping_address->address2}},{{$shipping_address->zip}} {{$shipping_address->city}} {{$shipping_address->province_code}} {{$shipping_address->country}}</br>
                  Email   : {{$customer_full_details->email}}</br>
                  Phone   : {{$customer_full_details->phone}}</br>
               </p>
            </div>
         </div>
         <div id="bot">
            <div id="table">
               <table>
                  <tr class="tabletitle">
                     <td class="item">
                        <h2>Item</h2>
                     </td>
                     <td class="Hours">
                        <h2>Qty</h2>
                     </td>
                     <td class="Rate">
                        <h2>Sub Total</h2>
                     </td>
                  </tr>
                  @php
                    $itemPrices=0;
                    $itemtax=0;
                  @endphp
                  @foreach($items as $item)
                    @php
                      $itemPrices=$itemPrices+$item['price'];
                    @endphp
                  <tr class="service">
                     <td class="tableitem">
                        <p class="itemtext">{{$item['name']}}</p>
                     </td>
                     <td class="tableitem">
                        <p class="itemtext">{{$item['quantity']}}</p>
                     </td>
                     <td class="tableitem">
                        <p class="itemtext">{{$currency}} {{$item['price']}}</p>
                     </td>
                  </tr>
                      @foreach($item['tax_lines'] as $tax)
                        @php
                          $itemtax= $itemtax+$tax['price'];
                        @endphp
                      @endforeach
                  @endforeach
                  <tr class="tabletitle">
                     <td></td>
                     <td class="Rate"><h2>tax</h2></td>
                     <td class="payment"><h2>{{ReturnCurrenyCode($currency)}} {{$itemtax}}</h2></td>
                   </tr>
                  <tr class="tabletitle">
                     <td></td>
                     <td class="Rate">
                        <h2>Total</h2>
                     </td>
                     <td class="payment">
                        <h2>{{ReturnCurrenyCode($currency)}} {{$itemPrices+$itemtax}}</h2>
                     </td>
                  </tr>
               </table>
            </div>
            <div id="legalcopy">
               <p class="legal">
                 <strong>Thank you for your business!</strong>
                 Payment is expected within 31 days; please process this invoice within that time. There will be a 5% interest charge per month on late invoices.
               </p>
            </div>
         </div>
      </div>
      </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

      <script>
      function PrintElem(){
          $html = $("#print-body").html();
          Popup($html);
      }
      PrintElem();
      function Popup(data)
      {
          var myWindow = window.open('', 'Receipt', 'height=400,width=600');
          myWindow.document.write('<html><head><title>Receipt</title>');
          myWindow.document.write('<style type="text/css"> *, html {margin:0;padding:0;} </style>');
          myWindow.document.write('</head><body>');
          myWindow.document.write(data);
          myWindow.document.write('</body></html>');
          myWindow.document.close();
          myWindow.onload=function(){
              myWindow.focus();
              myWindow.print();
              myWindow.close();
          };
      }
      </script>
