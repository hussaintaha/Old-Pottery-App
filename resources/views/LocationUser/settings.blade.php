@extends('LocationUser.admin')
@section('content')
<div class="Polaris-Page">
   <div class="Polaris-Page-Header Polaris-Page-Header--mobileView">
      <div class="Polaris-Page-Header__MainContent">
         <div class="Polaris-Page-Header__TitleActionMenuWrapper">
            <div>
               <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">
                  <div class="Polaris-Header-Title">
                     <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">Settings</h1>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="Polaris-Page__Content">
      <div class="Polaris-Layout">


         <div class="Polaris-Layout__AnnotatedSection">
            <div class="Polaris-Layout__AnnotationWrapper">
               <div class="Polaris-Layout__Annotation">
                  <div class="Polaris-TextContainer">
                     <h2 class="Polaris-Heading">Store switch</h2>
                     <div class="Polaris-Layout__AnnotationDescription">
                        <p>Store Switch Used to accept orders.</p>
                     </div>
                  </div>
               </div>
               <div class="Polaris-Layout__AnnotationContent">
                  <div class="Polaris-Card">
                     <div class="Polaris-Card__Header">
                        <h2 class="Polaris-Heading">Order Acceptance</h2>
                     </div>
                     <div class="Polaris-Card__Section">
                        <div class="Polaris-FormLayout">
                           <div class="Polaris-FormLayout__Item">
                              <p>Current Status Of Location</p>
                           </div>

                           @php
                           $ldata = ReturnLocationData(Session::get('userData')->id);
                           @endphp
                           <div class="Polaris-FormLayout__Item">
                             <div class="Polaris-Stack Polaris-Stack--vertical">
                                 <div class="Polaris-Stack__Item">
                                    <div>
                                       <label class="Polaris-Choice" for="disabled">
                                         <span class="Polaris-Choice__Control">
                                           <span class="Polaris-RadioButton">
                                             <input id="disabled" name="accounts" type="radio" class="Polaris-RadioButton__Input" aria-describedby="disabledHelpText" value="on"
                                             <?=(($ldata->is_open ==1) ? "checked" : "" )?>
                                              >
                                             <span class="Polaris-RadioButton__Backdrop">
                                             </span>
                                             <span class="Polaris-RadioButton__Icon"></span>
                                           </span>
                                         </span>
                                         <span class="Polaris-Choice__Label">Enable</span>
                                       </label>
                                       <div class="Polaris-Choice__Descriptions">
                                          <div class="Polaris-Choice__HelpText" id="disabledHelpText">Order's will Be Placed Automatically if store is on</div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="Polaris-Stack__Item">
                                    <div>
                                       <label class="Polaris-Choice" for="optional">
                                         <span class="Polaris-Choice__Control">
                                           <span class="Polaris-RadioButton">
                                             <input id="optional" name="accounts" type="radio" class="Polaris-RadioButton__Input"
                                                <?=((($ldata->is_open ==0) || ($ldata->is_open ==NULL)) ? "checked" : "" )?>
                                             aria-describedby="optionalHelpText" value="off">
                                             <span class="Polaris-RadioButton__Backdrop Polaris-RadioButton--hover">
                                             </span>
                                             <span class="Polaris-RadioButton__Icon"></span>
                                           </span>
                                         </span>
                                         <span class="Polaris-Choice__Label">Disable</span></label>
                                       <div class="Polaris-Choice__Descriptions">
                                          <div class="Polaris-Choice__HelpText" id="optionalHelpText">
                                            Order's will not Be Placed Automatically if store it is disabled
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>



         <div class="Polaris-Layout__AnnotatedSection">
            <div class="Polaris-Layout__AnnotationWrapper">
               <div class="Polaris-Layout__Annotation">
                  <div class="Polaris-TextContainer">
                     <h2 class="Polaris-Heading">Store Google location</h2>
                     <div class="Polaris-Layout__AnnotationDescription">
                        <p>Jaded Pixel will use this as your account information.</p>
                     </div>
                  </div>
               </div>
               <div class="Polaris-Layout__AnnotationContent">
                  <div class="Polaris-Card">
                     <div class="Polaris-Card__Header">
                        <h2 class="Polaris-Heading">Store On Map</h2>
                     </div>
                     <div class="Polaris-Card__Section">
                       <div id="map"></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>


      </div>
   </div>
</div>

<style>
#map {
  height: 100%;
}
</style>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{$api_key}}&callback=initMap&libraries=&v=weekly"   defer  ></script>
<script>
let map, infoWindow;
function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: parseFloat('{{$lat}}'), lng: parseFloat('{{$long}}') },
    zoom: 6
  });
  infoWindow = new google.maps.InfoWindow();

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      position => {
        const pos = {
          // lat: position.coords.latitude,
          // lng: position.coords.longitude
          lat: parseFloat('{{$lat}}'),
          lng: parseFloat('{{$long}}')
        };
        infoWindow.setPosition(pos);
        infoWindow.setContent("Location found.");
        infoWindow.open(map);
        map.setCenter(pos);
      },
      () => {
        handleLocationError(true, infoWindow, map.getCenter());
      }
    );
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(
    browserHasGeolocation
      ? "Error: The Geolocation service failed."
      : "Error: Your browser doesn't support geolocation."
  );
  infoWindow.open(map);
}

</script>

<script>

  $(document).on('change','.Polaris-RadioButton__Input',function(){
    $isopen = 0;
    if($('.Polaris-RadioButton__Input:checked').val() == 'on'){
      $isopen = 1;
    }
    $url = "{{url('User/update-settings')}}";
    $.ajax({
      'url':$url,
      'data':{status:$isopen},
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
        // window.location.href = '{{url("User/settings")}}';
      }
    })
  })
</script>
@endsection
