@extends('superadmin.sadmin')
<style>
</style>
@section('content')
<div id="app">
   <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb;">
      <span>
         @include('superadmin.tabs',['shop'=>$shop,'page'=>$page])
         <div id="ordersPage">
            <div class="Polaris-Page Polaris-Page--fullWidth">
               <div class="Polaris-Page__Content">
                  <hr>
                  <div class="Polaris-Layout">
                     <div class="Polaris-Layout__Section">

                        @if(count($new_orders) > 0)
                          @include('superadmin.order_view',['shop'=>$shop,'orders'=>$orders,'currency'=>$currency])
                        @else
                        <div class="Polaris-Card__Section">
                            <div class="Polaris-EmptyState Polaris-EmptyState--withinContentContainer">
                               <div class="Polaris-EmptyState__Section">
                                  <div class="Polaris-EmptyState__DetailsContainer">
                                     <div class="Polaris-EmptyState__Details">
                                        <div class="Polaris-TextContainer">
                                           <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">
                                             No Any Orders
                                           </p>
                                           <div class="Polaris-EmptyState__Content">
                                              <p>
                                                You can use the Files section to upload images, videos, and other documents
                                              </p>
                                           </div>
                                        </div>
                                        <div style="display:none;" class="Polaris-EmptyState__Actions">
                                           <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                                              <div class="Polaris-Stack__Item">
                                                <button type="button" class="Polaris-Button Polaris-Button--primary">
                                                  <span class="Polaris-Button__Content">
                                                    <span class="Polaris-Button__Text">Upload files</span>
                                                  </span>
                                                </button>
                                              </div>
                                           </div>
                                        </div>
                                     </div>
                                  </div>
                                  <div class="Polaris-EmptyState__ImageContainer">
                                    <img src="https://cdn.shopify.com/s/files/1/0262/4071/2726/files/emptystate-files.png" role="presentation" alt="" class="Polaris-EmptyState__Image">
                                  </div>
                               </div>
                            </div>
                         </div>
                        @endif



                     </div>
                     <div class="Polaris-Layout__Section">
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
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <span></span>
      </span>
   </div>
</div>
<script>
   $shop = '{{$shop}}';
</script>
<script>
$(document).on('change','.switch-checkbox',function(){
  $status=0;
  if($(this).prop('checked') == true){
    $status=1;
  }
  $url = "{{url('/swicth-locations')}}";
  $data={shop:$shop,status:$status};
  $.ajax({
    'url':$url,
    'data':$data,
    'dataType':'json',
    'type':'get',
    success:function(response){
      alert(response.msg);
       location.reload();
    }
  })
})
$(document).on('click','.close-more',function(){
	$(this).parents('.cards').find('.other-details').slideUp("slow");
	$(this).parents('.cards').find('.show-buttons').show()
})
$(document).on('click','.open-more',function(){
	$(this).parents('.cards').find('.other-details').slideDown("slow");
	$(this).parents('.cards').find('.show-buttons').hide();
})

$(document).on('change','#locations',function(){
  $val = $(this).val();
  if($val !=""){
    $('.cards').hide();
    if($val == 'all'){
      $('.cards').show();
    }else{
        $('.location'+$val).show();
    }
  }else{
    alert("Please Select Any From The List");
  }
})
</script>
@endsection
