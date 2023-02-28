@extends('superadmin.sadmin')
@section('content')
<div id="app">
   <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb;">
      <span>
         @include('superadmin.tabs',['shop'=>$shop,'page'=>$page])
         <div class="Polaris-Page">
            <div class="Polaris-Page__Content">
               <div class="Polaris-Layout">
                  <div class="Polaris-Layout__Section">
                     <div class="Polaris-Stack Polaris-Stack--vertical">
                        <div class="Polaris-Stack__Item">
                           <div class="Polaris-Stack Polaris-Stack--vertical Polaris-Stack--spacingExtraTight">
                              <div class="Polaris-Stack__Item">
                                 <p class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">Locations</p>
                              </div>
                              <div class="Polaris-Stack__Item"><span class="Polaris-TextStyle--variationSubdued">Manage pickup and delivery settings for each location</span></div>
                           </div>
                        </div>
                        <div class="Polaris-Stack__Item">
                           <div class="Polaris-Card">
                              <div class="Polaris-ResourceList__ResourceListWrapper">
                                 <div class="Polaris-ResourceList__FiltersWrapper">
                                    <div class="Polaris-Filters">
                                       <div class="Polaris-Filters-ConnectedFilterControl__ProxyButtonContainer" aria-hidden="true"></div>
                                       <div class="Polaris-Filters-ConnectedFilterControl__Wrapper">
                                          <div class="Polaris-Filters-ConnectedFilterControl Polaris-Filters-ConnectedFilterControl--right">
                                             <div class="Polaris-Filters-ConnectedFilterControl__CenterContainer">
                                                <div class="Polaris-Filters-ConnectedFilterControl__Item">
                                                   <div class="Polaris-Labelled--hidden">
                                                      <div class="Polaris-Labelled__LabelWrapper">
                                                         <div class="Polaris-Label"><label id="PolarisTextField1Label" for="PolarisTextField1" class="Polaris-Label__Text">Filter locations</label></div>
                                                      </div>
                                                      <div class="Polaris-Connected">
                                                         <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                            <div class="Polaris-TextField">
                                                               <div class="Polaris-TextField__Prefix" id="PolarisTextField1Prefix">
                                                                  <span class="Polaris-Filters__SearchIcon">
                                                                     <span class="Polaris-Icon">
                                                                        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                           <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8m9.707 4.293l-4.82-4.82A5.968 5.968 0 0 0 14 8 6 6 0 0 0 2 8a6 6 0 0 0 6 6 5.968 5.968 0 0 0 3.473-1.113l4.82 4.82a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414" fill-rule="evenodd"></path>
                                                                        </svg>
                                                                     </span>
                                                                  </span>
                                                               </div>
                                                               <input id="PolarisTextField1" placeholder="Filter locations" class="Polaris-TextField__Input Polaris-TextField__Input--hasClearButton" aria-labelledby="PolarisTextField1Label PolarisTextField1Prefix" aria-invalid="false" aria-multiline="false" value="">
                                                               <div class="Polaris-TextField__Backdrop"></div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="Polaris-Filters-ConnectedFilterControl__RightContainer"></div>
                                             <div class="Polaris-Filters-ConnectedFilterControl__MoreFiltersButtonContainer">
                                                <div class="Polaris-Filters-ConnectedFilterControl__Item">
                                                   <div><button type="button" class="Polaris-Button"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">More filters</span></span></button></div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <?php if($locations){
                                    ?>
                                 <ul class="Polaris-ResourceList" aria-live="polite" aria-busy="false">
                                    <?php
                                    foreach ($locations as $single_locations) {
                                       ?>
                                    <li class="Polaris-ResourceList__ItemWrapper">
                                       <div class="Polaris-ResourceItem locationlist" data-href="{{URL('edit-location')}}?shop={{$shop}}&location_id={{$single_locations->shopify_location->id}}">
                                          <a aria-describedby="{{$single_locations->shopify_location->id}}" aria-label="View details for location" class="Polaris-ResourceItem__Link" tabindex="0" id="ResourceListItemOverlay1"
                                             href="{{URL('edit-location')}}?shop={{$shop}}&location_id={{$single_locations->shopify_location->id}}" data-polaris-unstyled="true"></a>
                                          <div class="Polaris-ResourceItem__Container" id="{{$single_locations->shopify_location->id}}">
                                             <div class="Polaris-ResourceItem__Content">
                                                <h3>
                                                   <span class="Polaris-TextStyle--variationStrong">
                                                   {{$single_locations->shopify_location->name}}
                                                   </span>
                                                </h3>
                                                <span class="Polaris-TextStyle--variationSubdued">
                                                {{$single_locations->shopify_location->address1}}, {{$single_locations->shopify_location->city}} {{$single_locations->shopify_location->province}}, {{$single_locations->shopify_location->zip}}  {{$single_locations->shopify_location->country}}</span>
                                             </div>
                                          </div>
                                       </div>
                                    </li>
                                    <?php } ?>
                                 </ul>
                                 <?php
                                    } ?>
                              </div>
                              <div class="outletsHelpTextBorderedTop">
                                 <div class="Polaris-Card__Section Polaris-Card__Section--subdued">
                                    <div class="Polaris-Stack Polaris-Stack--distributionTrailing Polaris-Stack--alignmentCenter">
                                       <div class="Polaris-Stack__Item Polaris-Stack__Item--fill"></div>
                                       <div class="Polaris-Stack__Item">
                                         <a target="_blank" href="https://{{$shop}}/admin/settings/locations">
                                            <button type="button" class="Polaris-Button Polaris-Button--primary">
                                               <span class="Polaris-Button__Content">
                                                  <span class="Polaris-Button__Icon">
                                                     <span class="Polaris-Icon">
                                                        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                           <path d="M17 9h-6V3a1 1 0 1 0-2 0v6H3a1 1 0 1 0 0 2h6v6a1 1 0 1 0 2 0v-6h6a1 1 0 1 0 0-2" fill-rule="evenodd"></path>
                                                        </svg>
                                                     </span>
                                                  </span>
                                                  <span class="Polaris-Button__Text">Add location</span>
                                               </span>
                                            </button>
                                        </a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
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
         <span></span>
      </span>
   </div>
</div>
<script>
   $(document).ready(function(){
     $('.locationlist').on('click',function(){
       window.location.href=$(this).attr('data-href');
     });
   });
</script>
@endsection
