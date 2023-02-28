@extends('superadmin.sadmin')
@section('content')
<div id="app">
  <form id="provider_form" method="post">
   <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb;">
      <span>
        @include('superadmin.tabs',['shop'=>$shop,'page'=>$page])

         <div class="Polaris-Page">
            <div class="Polaris-Page__Content">
               <div class="Polaris-Layout">
                  <div class="Polaris-Layout__AnnotatedSection">
                     <div class="Polaris-Layout__AnnotationWrapper">
                        <div class="Polaris-Layout__Annotation">
                           <div class="Polaris-TextContainer">
                              <h2 class="Polaris-Heading">Location details</h2>
                              <div class="Polaris-Layout__AnnotationDescription">
                                 <p>This location’s name and address</p>
                              </div>
                           </div>
                        </div>
                        <div class="Polaris-Layout__AnnotationContent">
                           <div class="Polaris-Card">
                              <div class="Polaris-Card__Header">
                                 <h2 class="Polaris-Heading">Address</h2>
                              </div>
                              <input type="hidden" value="{{$shopify_location->body->location->id}}" name="location_id">
                              <div style="padding: 2rem;">
                                 <div class="Polaris-FormLayout">
                                    <div role="group" class="Polaris-FormLayout--grouped">
                                       <div class="Polaris-FormLayout__Items">
                                          <div class="Polaris-FormLayout__Item">
                                             <div class="">
                                                <div class="Polaris-Labelled__LabelWrapper">
                                                   <div class="Polaris-Label">
                                                     <label id="PolarisTextField1Label" for="PolarisTextField1" class="Polaris-Label__Text">
                                                       Company name
                                                     </label>
                                                   </div>
                                                </div>
                                                <div class="Polaris-Connected">
                                                   <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                      <div class="Polaris-TextField">
                                                         <input name="company_name" id="PolarisTextField1" placeholder="" value="{{$shopify_location->body->location->name}}" class="Polaris-TextField__Input" type="text" aria-labelledby="PolarisTextField1Label" aria-invalid="false" aria-multiline="false" >
                                                         <div class="Polaris-TextField__Backdrop"></div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="Polaris-FormLayout__Item">
                                             <div class="">
                                                <div class="Polaris-Labelled__LabelWrapper">
                                                   <div class="Polaris-Label">
                                                     <label id="PolarisTextField2Label" for="PolarisTextField2" class="Polaris-Label__Text">
                                                       Address line 1
                                                     </label>
                                                   </div>
                                                </div>
                                                <div class="Polaris-Connected">
                                                   <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                      <div class="Polaris-TextField">
                                                         <input name="address_line_1" id="PolarisTextField2" placeholder="" value="{{$shopify_location->body->location->address1}}" class="Polaris-TextField__Input" type="text" aria-labelledby="PolarisTextField2Label" aria-invalid="false" aria-multiline="false" >
                                                         <div class="Polaris-TextField__Backdrop"></div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div role="group" class="Polaris-FormLayout--grouped">
                                       <div class="Polaris-FormLayout__Items">
                                          <div class="Polaris-FormLayout__Item">
                                             <div class="">
                                                <div class="Polaris-Labelled__LabelWrapper">
                                                   <div class="Polaris-Label">
                                                     <label id="PolarisTextField3Label" for="PolarisTextField3" class="Polaris-Label__Text">
                                                       Address line 2
                                                     </label>
                                                   </div>
                                                </div>
                                                <div class="Polaris-Connected">
                                                   <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                      <div class="Polaris-TextField">
                                                         <input name="address_line_2" id="PolarisTextField3" placeholder="" value="{{$shopify_location->body->location->address2}}" class="Polaris-TextField__Input" type="text" aria-labelledby="PolarisTextField3Label" aria-invalid="false" aria-multiline="false" >
                                                         <div class="Polaris-TextField__Backdrop"></div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="Polaris-FormLayout__Item">
                                             <div class="">
                                                <div class="Polaris-Labelled__LabelWrapper">
                                                   <div class="Polaris-Label">
                                                     <label id="PolarisTextField4Label" for="PolarisTextField4" class="Polaris-Label__Text">
                                                       City
                                                     </label>
                                                   </div>
                                                </div>
                                                <div class="Polaris-Connected">
                                                   <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                      <div class="Polaris-TextField">
                                                         <input name="city" id="PolarisTextField4" placeholder="" value="{{$shopify_location->body->location->city}}" class="Polaris-TextField__Input" type="text" aria-labelledby="PolarisTextField4Label" aria-invalid="false" aria-multiline="false" >
                                                         <div class="Polaris-TextField__Backdrop"></div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div role="group" class="Polaris-FormLayout--grouped">
                                       <div class="Polaris-FormLayout__Items">
                                          <div class="Polaris-FormLayout__Item">
                                             <div class="">
                                                <div class="Polaris-Labelled__LabelWrapper">
                                                   <div class="Polaris-Label">
                                                     <label id="PolarisSelect1Label" for="PolarisSelect1" class="Polaris-Label__Text">
                                                       Country
                                                     </label>
                                                   </div>
                                                </div>
                                                <div class="Polaris-Connected">
                                                   <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                      <div class="Polaris-TextField">
                                                         <input name="country" id="PolarisTextField4" placeholder="" value="{{$shopify_location->body->location->country}}" class="Polaris-TextField__Input" type="text" aria-labelledby="PolarisTextField4Label" aria-invalid="false" aria-multiline="false" >
                                                         <div class="Polaris-TextField__Backdrop"></div>
                                                      </div>
                                                   </div>
                                                </div>

                                             </div>
                                          </div>
                                          <div class="Polaris-FormLayout__Item">
                                             <div class="">
                                                <div class="Polaris-Labelled__LabelWrapper">
                                                   <div class="Polaris-Label">
                                                     <label id="PolarisSelect2Label" for="PolarisSelect2" class="Polaris-Label__Text">
                                                       State
                                                     </label>
                                                   </div>
                                                </div>
                                                <div class="Polaris-Connected">
                                                   <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                      <div class="Polaris-TextField">
                                                         <input name="state" id="PolarisTextField4" placeholder="" value="{{$shopify_location->body->location->province}}" class="Polaris-TextField__Input" type="text" aria-labelledby="PolarisTextField4Label" aria-invalid="false" aria-multiline="false" >
                                                         <div class="Polaris-TextField__Backdrop"></div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div role="group" class="Polaris-FormLayout--grouped">
                                       <div class="Polaris-FormLayout__Items">
                                          <div class="Polaris-FormLayout__Item">
                                             <div class="">
                                                <div class="Polaris-Labelled__LabelWrapper">
                                                   <div class="Polaris-Label">
                                                     <label id="PolarisTextField5Label" for="PolarisTextField5" class="Polaris-Label__Text">
                                                       Zip code
                                                     </label>
                                                   </div>
                                                </div>
                                                <div class="Polaris-Connected">
                                                   <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                      <div class="Polaris-TextField">
                                                         <input name="postal_code" id="PolarisTextField5" placeholder="" class="Polaris-TextField__Input" type="text" aria-labelledby="PolarisTextField5Label" aria-invalid="false" aria-multiline="false" value="{{$shopify_location->body->location->zip}}">
                                                         <div class="Polaris-TextField__Backdrop"></div>
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
                  </div>
                  <div class="Polaris-Layout__AnnotatedSection">
                     <div class="Polaris-Layout__AnnotationWrapper">
                        <div class="Polaris-Layout__Annotation">
                           <div class="Polaris-TextContainer">
                              <h2 class="Polaris-Heading">Location User</h2>
                              <div class="Polaris-Layout__AnnotationDescription">
                                 <p>Manage this location’s by users</p>
                              </div>
                           </div>
                        </div>
                        <div class="Polaris-Layout__AnnotationContent">
                           <div class="cards-container"  style="position: relative; z-index: 1;">
                              <div class="Polaris-Card">
                                <div class="Polaris-Card__Section">
                                    <div class="Polaris-FormLayout">
                                      <div role="group" class="Polaris-FormLayout--grouped">
                                         <div class="Polaris-FormLayout__Items">
                                            <div class="Polaris-FormLayout__Item">
                                               <div class="">
                                                  <div class="Polaris-Labelled__LabelWrapper">
                                                     <div class="Polaris-Label">
                                                       <label id="useremai" for="useremail" class="Polaris-Label__Text">
                                                         Email
                                                       </label>
                                                     </div>
                                                  </div>
                                                  <div class="Polaris-Connected">
                                                     <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                        <div class="Polaris-TextField">
                                                           <input name="email" id="useremail" placeholder=""
                                                           value="{{isset($location_details) ?  $location_details->email : ""}}" class="Polaris-TextField__Input" type="text" aria-invalid="false" aria-multiline="false" >
                                                           <div class="Polaris-TextField__Backdrop"></div>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                            <div class="Polaris-FormLayout__Item">
                                               <div class="">
                                                  <div class="Polaris-Labelled__LabelWrapper">
                                                     <div class="Polaris-Label">
                                                       <label id="userpass" for="userpassword" class="Polaris-Label__Text">
                                                         Password
                                                       </label>
                                                     </div>
                                                  </div>
                                                  <div class="Polaris-Connected">
                                                     <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                        <div class="Polaris-TextField">
                                                           <input name="password" id="userpassword" placeholder=""
                                                           value="{{isset($location_details) ?  $location_details->password : ""}}" class="Polaris-TextField__Input" type="password"  aria-invalid="false" aria-multiline="false" >
                                                           <div class="Polaris-TextField__Backdrop"></div>
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
                     </div>
                  </div>

                  <div class="Polaris-Layout__AnnotatedSection">
                     <div class="Polaris-Layout__AnnotationWrapper">
                        <div class="Polaris-Layout__Annotation">
                           <div class="Polaris-TextContainer">
                              <h2 class="Polaris-Heading">Store Hours</h2>
                              <div class="Polaris-Layout__AnnotationDescription">
                                 <p>Manage this location’s open/close hours settings</p>
                              </div>
                           </div>
                        </div>
                        <div class="Polaris-Layout__AnnotationContent">
                           <div class="cards-container" data-polaris-layer="true" style="position: relative; z-index: 1;">

                              <div class="Polaris-Card">
                                 <div class="Polaris-Card__Section">
                                    <div class="Polaris-Card__SectionHeader">
                                       <h3 aria-label="Pickup availability" class="Polaris-Subheading">Store hours settings</h3>
                                    </div>
                                    <div class="Polaris-FormLayout">
                                       <div class="Polaris-FormLayout__Item">
                                          <fieldset class="Polaris-ChoiceList Polaris-ChoiceList--titleHidden" id="PolarisChoiceList7" aria-invalid="false">
                                             <ul class="Polaris-ChoiceList__Choices">
                                                <li>
                                                  <label class="Polaris-Choice" for="PolarisRadioButton9">
                                                  <span class="Polaris-Choice__Control">
                                                    <span class="Polaris-RadioButton">
                                                      <input id="PolarisRadioButton9"
                                                      {{(isset($location_details) && $location_details->store_hours == 'automatic') ? "checked" : ""}}
                                                       name="storehrstype" type="radio" class="Polaris-RadioButton__Input" value="automatic">
                                                      <span class="Polaris-RadioButton__Backdrop"></span>
                                                      <span class="Polaris-RadioButton__Icon"></span>
                                                    </span>
                                                  </span>
                                                  <span class="Polaris-Choice__Label">Automatic</span>
                                                </label>
                                              </li>
                                                <li>
                                                  <label class="Polaris-Choice" for="PolarisRadioButton10">
                                                    <span class="Polaris-Choice__Control">
                                                      <span class="Polaris-RadioButton">
                                                        <input id="PolarisRadioButton10"
                                                          {{(isset($location_details) && $location_details->store_hours == 'menual') ? "checked" : ""}}
                                                         name="storehrstype" type="radio" class="Polaris-RadioButton__Input" value="menual">
                                                        <span class="Polaris-RadioButton__Backdrop"></span>
                                                        <span class="Polaris-RadioButton__Icon"></span>
                                                      </span>
                                                    </span>
                                                    <span class="Polaris-Choice__Label">Menual</span>
                                                  </label>
                                                </li>
                                             </ul>
                                          </fieldset>
                                       </div>
                                       <div class="Polaris-FormLayout__Item">
                                          <fieldset class="Polaris-ChoiceList" id="PolarisChoiceList10[]" aria-invalid="false">
                                             <legend class="Polaris-ChoiceList__Title">Select days:</legend>
                                             <ul class="Polaris-ChoiceList__Choices">
                                               @foreach ($shop_timing as $days)
                                                <li>
                                                   <label class="Polaris-Choice" for="PolarisCheckbox_days{{$days->days_name}}">
                                                      <span class="Polaris-Choice__Control">
                                                         <span class="Polaris-Checkbox">
                                                            <input id="PolarisCheckbox_days{{$days->days_name}}" name="days[]"
                                                            type="checkbox" class="Polaris-Checkbox__Input"
                                                            {{isset($days->details) ? "checked" : ""}}
                                                            aria-invalid="false" role="checkbox" aria-checked="" value="{{$days->days_name}}">
                                                            <span class="Polaris-Checkbox__Backdrop"></span>
                                                            <span class="Polaris-Checkbox__Icon">
                                                               <span class="Polaris-Icon">
                                                                  <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                                     <path d="M8.315 13.859l-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.437.437 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path>
                                                                  </svg>
                                                               </span>
                                                            </span>
                                                         </span>
                                                      </span>
                                                      <span class="Polaris-Choice__Label">{{$days->days_title}}</span>
                                                   </label>
                                                </li>
                                            @endforeach

                                             </ul>
                                          </fieldset>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="Polaris-Card__Section">
                                    <div class="Polaris-Card__SectionHeader">
                                       <h3 aria-label="Pickup times" class="Polaris-Subheading">Pickup times</h3>
                                    </div>
                                    <div class="Polaris-FormLayout">

                                       <div class="Polaris-FormLayout__Item">
                                          <div class="pickupTimesContainer">
                                               @php
                                               $j=1;
                                                foreach ($shop_timing as $days) {
                                                  $checkopenTime = $days->open_time;
                                                  if(isset($days->details)){
                                                    $checkopenTime = date("h:i", strtotime($days->details->open_time));
                                                  }
                                                  $checkcloseTime = $days->close_time;
                                                  if(isset($days->details)){
                                                    $checkcloseTime = date("h:i", strtotime($days->details->close_time));
                                                  }
                                                @endphp
                                             <div role="group" class="Polaris-FormLayout--grouped" aria-labelledby="PolarisFormLayoutGroupTitleselect{{$j}}">
                                                <div id="PolarisFormLayoutGroupTitleselect{{$j}}" class="Polaris-FormLayout__Title">{{$days->days_title}}</div>
                                                <div class="Polaris-FormLayout__Items">
                                                   <div class="Polaris-FormLayout__Item">
                                                      <div class="">
                                                         <div class="Polaris-Select">
                                                            <select id="PolarisSelect{{$j}}open" data-select="days-{{$days->days_name}}-opentime" class="Polaris-Select__Input select_time" aria-invalid="false" name="open_time[{{$days->days_name}}]">
                                                              @foreach ($time_list as  $single_time)
                                                               <option value="{{$single_time->time24}}" {{($checkopenTime == $single_time->time24) ? "selected='selected'"  : ""}} >{{$single_time->time12}}</option>
                                                             @endforeach
                                                            </select>
                                                            <div class="Polaris-Select__Content" aria-hidden="true">
                                                               <span class="Polaris-Select__SelectedOption" id="days-{{$days->days_name}}-opentime">{{$checkopenTime}}</span>
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
                                                   <div class="Polaris-FormLayout__Item">
                                                      <div class="">
                                                         <div class="Polaris-Select">
                                                            <select id="PolarisSelect{{$j}}close" data-select="days-{{$days->days_name}}-closetime" class="Polaris-Select__Input select_time" aria-invalid="false" name="close_time[{{$days->days_name}}]">
                                                            @foreach ($time_list as  $single_time)
                                                              <option value="{{$single_time->time24}}" {{($checkcloseTime == $single_time->time24) ? "selected='selected'"  : ""}}  >{{$single_time->time12}}</option>
                                                            @endforeach
                                                            </select>
                                                            <div class="Polaris-Select__Content" aria-hidden="true">
                                                               <span class="Polaris-Select__SelectedOption" id="days-{{$days->days_name}}-closetime">{{$checkcloseTime}}</span>
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
                                          @php
                                          }
                                          @endphp


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
                              <h2 class="Polaris-Heading">Geolocation</h2>
                              <div class="Polaris-Layout__AnnotationDescription">
                                 <p>Set Geolocation data</p>
                              </div>
                           </div>
                        </div>
                        <div class="Polaris-Layout__AnnotationContent">
                           <div class="Polaris-Card">
                              <div class="Polaris-Card__Section">
                                <div role="group" class="Polaris-FormLayout--grouped">
                                   <div class="Polaris-FormLayout__Items">
                                      <div class="Polaris-FormLayout__Item">
                                         <div class="">
                                            <div class="Polaris-Labelled__LabelWrapper">
                                               <div class="Polaris-Label">
                                                 <label id="geolongitude" for="longitude" class="Polaris-Label__Text">
                                                   Longitude
                                                 </label>
                                               </div>
                                            </div>
                                            <div class="Polaris-Connected">
                                               <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                  <div class="Polaris-TextField">
                                                     <input name="longitude"  id="longitude" placeholder="" value="{{isset($location_details) ? $location_details->geo_langitude  : ""}}" class="Polaris-TextField__Input" type="text" aria-invalid="false" aria-multiline="false" >
                                                     <div class="Polaris-TextField__Backdrop"></div>
                                                  </div>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                      <div class="Polaris-FormLayout__Item">
                                         <div class="">
                                            <div class="Polaris-Labelled__LabelWrapper">
                                               <div class="Polaris-Label">
                                                 <label id="geolatitude" for="latitude" class="Polaris-Label__Text">Latitude</label></div>
                                            </div>
                                            <div class="Polaris-Connected">
                                               <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                  <div class="Polaris-TextField">
                                                     <input name="latitude" id="latitude" placeholder="" value="{{isset($location_details) ? $location_details->geo_latitiude  : ""}}" class="Polaris-TextField__Input" type="text"  aria-invalid="false" aria-multiline="false" >
                                                     <div class="Polaris-TextField__Backdrop"></div>
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
                  <div class="Polaris-Layout__Section">
                     <div class="Polaris-PageActions">
                        <div class="Polaris-Stack Polaris-Stack--spacingTight Polaris-Stack--distributionEqualSpacing">
                           <div class="Polaris-Stack__Item">
                              <div class="Polaris-ButtonGroup">
                                 <div class="Polaris-ButtonGroup__Item">
                                    <a class="Polaris-Button" href="{{url('/manage-locations')}}?shop={{$shop}}" data-polaris-unstyled="true">
                                       <span class="Polaris-Button__Content">
                                          <span class="Polaris-Button__Icon">
                                             <span class="Polaris-Icon">
                                                <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                   <path d="M12 16a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 0 1 0-1.414l5-5a.999.999 0 1 1 1.414 1.414L8.414 10l4.293 4.293A.999.999 0 0 1 12 16" fill-rule="evenodd"></path>
                                                </svg>
                                             </span>
                                          </span>
                                          <span class="Polaris-Button__Text">Cancel</span>
                                       </span>
                                    </a>
                                 </div>
                              </div>
                           </div>
                           <div class="Polaris-Stack__Item">
                             <button type="submit" class="Polaris-Button Polaris-Button--primary">
                               <span class="Polaris-Button__Content">
                                 <span class="Polaris-Button__Text">
                                   {{isset($location_details) ? "Save" : "Create"}}
                                 </span>
                               </span>
                             </button>
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
 </form>
 @section('scripts')
 <script>

 $(document).ready(function(){
   $('#provider_form').on('submit', function(e) {
     e.preventDefault();
     var $data = new FormData($(this)[0]);
     var url = '{{URL("submit_locations")}}?shop={{$shop}}';
     $.ajax({
       url: url,
       type: 'post',
       dataType: 'json',
       cache:false,
       processData:false,
       contentType:false,
       data: $data,
       success: function(res) {
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
