@extends('LocationUser.admin')
@section('content')
<div class="Polaris-Page">
   <div class="Polaris-Page-Header Polaris-Page-Header--mobileView">
      <div class="Polaris-Page-Header__MainContent">
         <div class="Polaris-Page-Header__TitleActionMenuWrapper">
            <div>
               <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">
                  <div class="Polaris-Header-Title">
                     <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">Shipped  orders</h1>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="Polaris-Page__Content">
     @if(count($orders) > 0)
       <div class="row">
         <div class="column pending">
            @foreach($orders as $k=>$order)
                @include('LocationUser.new_single_order',[
                'shop'=>$shop,
                'pending'=>$order[0],
                'details'=>$order,
                'currency'=>$currency,
                'btn'=>'green',
                'title'=>'Pending',
                'btn_text'=>'Shipped'
                ])
            @endforeach
          </div>
       </div>
      @else
        @include('LocationUser.empty_order_page')
     @endif
   </div>
</div>
<script>
$(document).on('click','.Shipped',function(){
  window.line = $(this).data('line');
  swal({
    title: "Accept",
    text: "Are you sure to mark this order as Shipped",
    icon: "success",
    buttons: true,
    dangerMode: false,
    buttons: ['cancel', 'accept'],
  }).then((willDelete) => {
    if (willDelete) {
      $url = "{{url('User/update-order-status')}}";
      $.ajax({
        'url':$url,
        'data':{id:window.line,status:3},
        'dataType':'json',
        'type':'get',
        success:function(response){
          if(response.code == 200){
            swal(response.msg, {
              icon: "success",
            });
          }else{
            swal(response.msg, {
              icon: "error",
            });
          }
            location.reload();
        }
      })
    } else {
      swal("You pressed Cancell");
    }
  });
})
</script>
@endsection
