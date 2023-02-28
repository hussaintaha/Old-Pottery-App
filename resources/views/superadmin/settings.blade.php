@extends('superadmin.sadmin')
@section('content')
<div id="app">
   <form id="provider_form" method="post">
      <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb;">
         <span>
           @include('superadmin.tabs',['shop'=>$shop,'page'=>$page])

            <div></div>
            <div>
               <div class="Polaris-Page Polaris-Page--narrowWidth">
                  <div class="Polaris-Page__Content">
                     <div class="Polaris-Layout">
                        <div class="Polaris-Layout__Section">
                           <div class="Polaris-Page__Header Polaris-Page__Header--hasSeparator Polaris-Page__Header--hasBreadcrumbs">
                              <div class="Polaris-Page__MainContent">
                                 <div class="Polaris-Page__TitleAndActions">
                                    <div class="Polaris-Page__Title ZapietHeading">
                                       <p class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">Setup guide</p>
                                       <div class="Polaris-Stack Polaris-Stack--alignmentCenter"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="Polaris-Layout__Section">
                           <div class="Polaris-Card">
                              <div class="Polaris-Card__Section">
                                 <div class="Polaris-Stack Polaris-Stack--vertical Polaris-Stack--distributionCenter Polaris-Stack--alignmentCenter">
                                    <div class="Polaris-Stack__Item"><img src="{{ URL::asset('resources/images/setup.jpg') }}" width="240px"></div>
                                    <div class="Polaris-Stack__Item">
                                       <h2 class="Polaris-Heading">Welcome to Order Manager For Local Deliveries</h2>
                                    </div>
                                    <div class="Polaris-Stack__Item">
                                       <p>Please answer the questions below to get started</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="Polaris-Card">
                              <div class="Polaris-Card__Header">
                                 <h2 class="Polaris-Heading">Local Delivery</h2>
                              </div>
                              <div class="Polaris-Card__Section">
                                 <div class="Polaris-FormLayout">
                                    <div class="Polaris-FormLayout__Item">
                                       <p>Would you like to offer local delivery?</p>
                                    </div>
                                    <div class="Polaris-FormLayout__Item">
                                       <div class="Polaris-ButtonGroup Polaris-ButtonGroup--segmented" data-buttongroup-segmented="true">
                                          <div class="Polaris-ButtonGroup__Item"><button type="button" data-delivery="yes" class="Polaris-Button delivery <?php if(isset($settings->is_local_delivery)){ if($settings->is_local_delivery==1){ echo "Polaris-Button--primary";}}?>"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Yes</span></span></button></div>
                                          <div class="Polaris-ButtonGroup__Item"><button type="button"  data-delivery="no"  class="Polaris-Button delivery <?php if(isset($settings->is_local_delivery)){ if($settings->is_local_delivery==1){ echo "";}else{echo "Polaris-Button--primary";} }else{echo "Polaris-Button--primary";} ?>"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">No</span></span></button></div>
                                          <input type="hidden" value="<?php if(isset($settings->is_local_delivery)){ if($settings->is_local_delivery==1){ echo "yes";}else{echo "no";} }else{echo "no";} ?>" name="delivery"  id="storedelivery">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="Polaris-Card">
                              <div class="Polaris-Card__Header">
                                 <h2 class="Polaris-Heading">Store Pickup</h2>
                              </div>
                              <div class="Polaris-Card__Section">
                                 <div class="Polaris-FormLayout">
                                    <div class="Polaris-FormLayout__Item">
                                       <p>Would you like to offer in-store pickup?</p>
                                    </div>
                                    <div class="Polaris-FormLayout__Item">
                                       <div class="Polaris-ButtonGroup Polaris-ButtonGroup--segmented" data-buttongroup-segmented="true">
                                          <div class="Polaris-ButtonGroup__Item"><button type="button" data-pickup="yes" class="Polaris-Button pickup <?php if(isset($settings->is_store_pickup)){ if($settings->is_store_pickup==1){ echo "Polaris-Button--primary";} } ?>"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Yes</span></span></button></div>
                                          <div class="Polaris-ButtonGroup__Item"><button type="button" data-pickup="no" class="Polaris-Button pickup <?php if(isset($settings->is_store_pickup)){ if($settings->is_store_pickup==1){ echo "";}else{echo "Polaris-Button--primary";} }else{echo "Polaris-Button--primary";} ?>"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">No</span></span></button></div>
                                          <input type="hidden" value="<?php if(isset($settings->is_store_pickup)){ if($settings->is_store_pickup==1){ echo "yes";}else{echo "no";} }else{echo "no";} ?>" name="pickup" id="storepickup">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="Polaris-Card">
                              <div class="Polaris-Card__Section">
                                 <div class="Polaris-FormLayout">
                                    <div class="Polaris-FormLayout__Item">
                                       <p>Update Google Maps API Key.</p>
                                    </div>
                                    <div class="Polaris-FormLayout__Item">
                                       <div class="">
                                          <div class="Polaris-Connected">
                                             <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                <div class="Polaris-TextField">
                                                   <input id="PolarisTextField1" placeholder="Google api key" name="apikey" class="Polaris-TextField__Input" aria-labelledby="PolarisTextField1Label" aria-invalid="false" aria-multiline="false"
                                                   value="<?php if(isset($settings->google_api_key)){
                                                     echo $settings->google_api_key;
                                                   } ?>">
                                                   <div class="Polaris-TextField__Backdrop"></div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="Polaris-Card">
                              <div class="Polaris-Card__Section">
                                 <div class="Polaris-FormLayout">
                                    <div class="Polaris-FormLayout__Item">
                                       <p>Out Of Stock Mesasage </p>
                                    </div>
                                    <div class="Polaris-FormLayout__Item">
                                       <div class="">
                                          <div class="Polaris-Connected">
                                             <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                <div class="Polaris-TextField">
                                                   <input id="out_of_stock_message" placeholder="Out Of Stock" name="out_of_stock_message" class="Polaris-TextField__Input" aria-labelledby="out_of_stock_messageLabel" aria-invalid="false" aria-multiline="false"
                                                   value="<?php if(isset($settings->out_of_stock_message)){
                                                     echo $settings->out_of_stock_message;
                                                   } ?>">
                                                   <div class="Polaris-TextField__Backdrop"></div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>


                           <div class="Polaris-Card">
                              <div class="Polaris-Card__Section">
                                 <div class="Polaris-FormLayout">
                                    <div class="Polaris-FormLayout__Item">
                                       <p>Time zone.</p>
                                    </div>
                                    <div class="Polaris-FormLayout__Item">
                                       <div class="">
                                          <div class="Polaris-Select">
                                             <select name="timezone" id="PolarisSelect2" class="Polaris-Select__Input" aria-invalid="false">
                                                <?php
                                                   $firstTime='';
                                                   $sd=0;
                                                   foreach($timezone as $single_timezone){
                                                     if($sd==0){
                                                       $firstTime=$single_timezone->time_zone;
                                                     }
                                                     ?>
                                                <option value="<?php echo $single_timezone->time_zone; ?>"><?php echo $single_timezone->time_zone; ?></option>
                                                <?php $sd++;} ?>
                                             </select>
                                             <div class="Polaris-Select__Content" aria-hidden="true">
                                                <span class="Polaris-Select__SelectedOption slectedtimee">
                                                <?php
                                                if(isset($settings->timezone)){
                                                  if($settings->timezone!=''){
                                                    echo $settings->timezone;
                                                  }else{
                                                    echo $firstTime;
                                                  }
                                                }else{
                                                  echo $firstTime;
                                                } ?></span>
                                                <span class="Polaris-Select__Icon">
                                                   <span class="Polaris-Icon">
                                                      <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                         <path d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z" fill-rule="evenodd"></path>
                                                      </svg>
                                                   </span>
                                                </span>
                                             </div>
                                             <div class="Polaris-Select__Backdrop"></div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="Polaris-Layout__Section">
                           <button type="submit" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge Polaris-Button--fullWidth">
                              <span class="Polaris-Button__Content">
                                 <span class="Polaris-Button__Icon">
                                    <span class="Polaris-Icon">
                                       <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                          <path d="M8 16a.999.999 0 0 1-.707-1.707L11.586 10 7.293 5.707a.999.999 0 1 1 1.414-1.414l5 5a.999.999 0 0 1 0 1.414l-5 5A.997.997 0 0 1 8 16" fill-rule="evenodd"></path>
                                       </svg>
                                    </span>
                                 </span>
                                 <span  class="Polaris-Button__Text">Continue</span>
                              </span>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="Polaris-FooterHelp">
               <div class="Polaris-FooterHelp__Content">
                  <div class="Polaris-FooterHelp__Icon">
                     <span class="Polaris-Icon Polaris-Icon--colorTeal Polaris-Icon--isColored Polaris-Icon--hasBackdrop">
                        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                           <circle cx="10" cy="10" r="9" fill="currentColor"></circle>
                           <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m0-4a1 1 0 1 0 0 2 1 1 0 1 0 0-2m0-10C8.346 4 7 5.346 7 7a1 1 0 1 0 2 0 1.001 1.001 0 1 1 1.591.808C9.58 8.548 9 9.616 9 10.737V11a1 1 0 1 0 2 0v-.263c0-.653.484-1.105.773-1.317A3.013 3.013 0 0 0 13 7c0-1.654-1.346-3-3-3"></path>
                        </svg>
                     </span>
                  </div>
                  <div class="Polaris-FooterHelp__Text">
                     Need help? Visit our
                     <a target="_blank" class="Polaris-Link" href="#" rel="noopener noreferrer" data-polaris-unstyled="true">
                        Help Center
                        <span class="Polaris-Link__IconLockup">
                           <span class="Polaris-Link__IconLayout">
                              <span class="Polaris-Icon" aria-label="(opens a new window)">
                                 <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                    <path d="M13 12a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H6c-.575 0-1-.484-1-1V7a1 1 0 0 1 1-1h1a1 1 0 0 1 0 2v5h5a1 1 0 0 1 1-1zm-2-7h4v4a1 1 0 1 1-2 0v-.586l-2.293 2.293a.999.999 0 1 1-1.414-1.414L11.586 7H11a1 1 0 0 1 0-2z"></path>
                                 </svg>
                              </span>
                           </span>
                        </span>
                     </a>
                  </div>
               </div>
            </div>
            <span></span>
         </span>
      </div>
   </form>
   @section('scripts')
   <script>
      $(document).ready(function(){
        $('#PolarisSelect2').on('change',function(){
          $('.slectedtimee').html($('#PolarisSelect2 option:selected').text());
        });

        $('.delivery').on('click',function(){
            $(this).attr('data-delivery');
            $('.delivery').each(function() {
            $(this).removeClass('Polaris-Button--primary');
            });
           $(this).addClass('Polaris-Button--primary');
          $('#storedelivery').val($(this).attr('data-delivery'));
        });

        $('.pickup').on('click',function(){
          $(this).attr('data-pickup');
          $( '.pickup' ).each(function() {
          $(this).removeClass('Polaris-Button--primary');
          });
         $(this).addClass('Polaris-Button--primary');
          $('#storepickup').val($(this).attr('data-pickup'));
        });

        $('#provider_form').on('submit', function(e) {
          e.preventDefault();
          //loaderOn();
          var $data = new FormData($(this)[0]);
          var url = '{{URL("submit_settings")}}?shop={{$shop}}';

          $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            cache:false,
            processData:false,
            contentType:false,
            data: $data,
            success: function(res) {
             // loaderOff();
              if (res.code == 200) {
                var flashOptions = {
                  message: res.msg,
                  duration: 5000,
                  isDismissible: true,

                };
              } else {
                var flashOptions = {
                  message: res.msg,
                  duration: 5000,
                  isDismissible: true,
                  isError: true
                };

              }
              var flash = Flash.create(app, flashOptions);
              flash.dispatch(Flash.Action.SHOW);
            }
          })
        });

        $('.select_time').on('change',function(){
         var id= $(this).attr('id');
         var timeshowattri= $(this).attr('data-select');
         var timeselected=$('#'+id+' option:selected').text();
         $('#'+timeshowattri).html(timeselected);

        });


      });

   </script>
   @endsection
</div>
@endsection
