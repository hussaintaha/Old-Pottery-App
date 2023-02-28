<html>
   <head>
      <title>Location Dashboard </title>
      <link rel="stylesheet"  href="https://unpkg.com/@shopify/polaris@5.2.1/dist/styles.css"/>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;500&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="{{ URL::asset('public/css/style.css') }}">

      <style>
       .move-icon {
         height: 2rem;
         width: 2rem;
         max-height: 100%;
         max-width: 100%;
       }
       .IQjZ8{
         width: 97%;
         display: flex;
       }
       .new-heading {
         display: flex;
         height: 43px;
       }
       .IQjZ8  span{
        display: block;
        height: 2rem;
        width: 2rem;
        max-height: 100%;
        max-width: 100%;
        margin-right: 2%
       }
       .menu-anchor{
           text-decoration: none;
         }
      .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
      }
      .switch input {
      opacity: 0;
      width: 0;
      height: 0;
      }
      .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
      }
      .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
      }
      .switch input:checked+.slider {
      background-color: #5967c3;
      }
      .switch input:focus+.slider {
      box-shadow: 0 0 1px #2196F3;
      }
      .switch input:checked+.slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
      }
      .slider.round {
      border-radius: 34px;
      }
      .slider.round:before {
      border-radius: 50%;
      }
      .switch-div {
      display: flex;
      margin-left: 6%;
      }
      .custom-heading {
      text-align: center;
      width: 50%;
      }
      .main-div {
      display: flex;
      }
      .para-text {
      font-size: 15px;
      font-weight: 600;
      margin-top: 7px;
      }
      .NewSelector {
      flex: 1 1;
      width: 100%;
      min-width: 0;
      min-height: 3.6rem;
      margin: 0;
      padding: .5rem 1.2rem;
      background: #ffffff;
      border: .1rem solid #c4cdd5;
      font-size: inherit;
      -moz-appearance: none;
      border-radius: 3px;
      }

      </style>
   </head>
   <body>
      <div>
         <div style="--top-bar-background:#357997; --top-bar-color:rgb(255, 255, 255); --top-bar-border:rgb(196, 205, 213); --top-bar-background-lighter:hsla(198, 33%, 55%, 1); --p-frame-offset:0px;">
            <div class="Polaris-Frame Polaris-Frame--hasNav Polaris-Frame--hasTopBar" data-polaris-layer="true" data-has-navigation="true">
               <div class="Polaris-Frame__Skip">
                  <a href="#AppFrameMainContent" class="Polaris-Frame__SkipAnchor">Skip to content</a>
               </div>
               <div class="Polaris-Frame__TopBar" data-polaris-layer="true" data-polaris-top-bar="true" id="AppFrameTopBar">
                  <div class="Polaris-TopBar">
                     <button type="button" class="Polaris-TopBar__NavigationIcon" aria-label="Toggle menu">
                        <span class="Polaris-Icon">
                           <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                              <path d="M19 11H1a1 1 0 1 1 0-2h18a1 1 0 1 1 0 2zm0-7H1a1 1 0 0 1 0-2h18a1 1 0 1 1 0 2zm0 14H1a1 1 0 0 1 0-2h18a1 1 0 1 1 0 2z"></path>
                           </svg>
                        </span>
                     </button>
                     <div class="Polaris-TopBar__LogoContainer">
                        <a class="Polaris-TopBar__LogoLink" style="width: 124px;" href="http://jadedpixel.com" data-polaris-unstyled="true">
                            <img src="https://cdn.shopify.com/s/files/1/0446/6937/files/jaded-pixel-logo-color.svg?6215648040070010999" alt="Jaded Pixel" class="Polaris-TopBar__Logo" style="width: 124px;">
                        </a>
                     </div>
                     <div class="Polaris-TopBar__Contents">
                        <div class="Polaris-TopBar__SearchField" >
                           <div style="display:none;" class="Polaris-TopBar-SearchField">
                              <span class="Polaris-VisuallyHidden">
                              <label for="PolarisSearchField1">Search</label>
                              </span>
                              <input id="PolarisSearchField1" class="Polaris-TopBar-SearchField__Input" placeholder="Search" type="search" autocapitalize="off" autocomplete="off" autocorrect="off" value="">
                              <span class="Polaris-TopBar-SearchField__Icon">
                                 <span class="Polaris-Icon">
                                    <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                       <path d="M8 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8m9.707 4.293l-4.82-4.82A5.968 5.968 0 0 0 14 8 6 6 0 0 0 2 8a6 6 0 0 0 6 6 5.968 5.968 0 0 0 3.473-1.113l4.82 4.82a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414" fill-rule="evenodd"></path>
                                    </svg>
                                 </span>
                              </span>
                              <div class="Polaris-TopBar-SearchField__Backdrop"></div>
                           </div>
                           <div class="Polaris-TopBar-Search">
                              <div class="Polaris-TopBar-Search__Results">
                                 <div class="Polaris-Card">
                                    <div class="Polaris-ActionList">
                                       <div class="Polaris-ActionList__Section--withoutTitle">
                                          <ul class="Polaris-ActionList__Actions">
                                             <li>
                                                <button type="button" class="Polaris-ActionList__Item">
                                                   <div class="Polaris-ActionList__Content">Shopify help center</div>
                                                </button>
                                             </li>
                                             <li>
                                                <button type="button" class="Polaris-ActionList__Item">
                                                   <div class="Polaris-ActionList__Content">Community forums</div>
                                                </button>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="Polaris-TopBar__SecondaryMenu">
                        </div>
                        <div>
                           <div class="Polaris-TopBar-Menu__ActivatorWrapper">
                              <button id="actionbtn" style="position:relative" type="button" class="Polaris-TopBar-Menu__Activator" tabindex="0" aria-controls="Polarispopover1" aria-owns="Polarispopover1" aria-expanded="false">
                                 <div class="Polaris-MessageIndicator__MessageIndicatorWrapper">
                                    <span aria-label="Avatar with initials D" role="img" class="Polaris-Avatar Polaris-Avatar--sizeSmall Polaris-Avatar--styleThree">
                                       <span class="Polaris-Avatar__Initials">
                                          <svg class="Polaris-Avatar__Svg" viewBox="0 0 40 40">
                                             <text x="50%" y="50%" dy="0.35em" fill="currentColor" font-size="20" text-anchor="middle">D</text>
                                          </svg>
                                       </span>
                                    </span>
                                 </div>
                                 <span class="Polaris-TopBar-UserMenu__Details">
                                    <p class="Polaris-TopBar-UserMenu__Name">
                                       @if(Session::has('userData'))
                                       {{ Session::get('userData')->location_name}}
                                       @endif
                                    </p>
                                    <p class="Polaris-TopBar-UserMenu__Detail">
                                       Jaded Pixel
                                    </p>
                                 </span>
                              </button>
                              <div id="actions"  style="right: 2px;position: absolute;top: 3.5em;display: block;padding: 0 35px;display:none;" class="Polaris-Card">
                                 <div class="Polaris-ActionList">
                                    <div class="Polaris-ActionList__Section--withoutTitle">
                                       <ul class="Polaris-ActionList__Actions">
                                          <li>
                                             <a href="{{url('User/Logout')}}">
                                                <button type="button" class="Polaris-ActionList__Item">
                                                   <div class="Polaris-ActionList__Content">Logout</div>
                                                </button>
                                             </a>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div>
                  <div class="Polaris-Frame__Navigation" id="AppFrameNav" hidden="">
                     <nav class="Polaris-Navigation">
                        <div class="Polaris-Navigation__PrimaryNavigation Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true">
                           <ul style="display:none;" class="Polaris-Navigation__Section">
                              <li class="Polaris-Navigation__ListItem">
                                 <button type="button" class="Polaris-Navigation__Item">
                                    <div class="Polaris-Navigation__Icon">
                                       <span class="Polaris-Icon">
                                          <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                             <path d="M17 9H5.414l3.293-3.293a.999.999 0 1 0-1.414-1.414l-5 5a.999.999 0 0 0 0 1.414l5 5a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L5.414 11H17a1 1 0 1 0 0-2" fill-rule="evenodd">
                                             </path>
                                          </svg>
                                       </span>
                                    </div>
                                    <span class="Polaris-Navigation__Text">Back to Shopify</span>
                                 </button>
                              </li>
                           </ul>
                           <ul class="Polaris-Navigation__Section Polaris-Navigation__Section--withSeparator">
                              <li  style="display:none;" class="Polaris-Navigation__SectionHeading">
                                 <span class="Polaris-Navigation__Text">Jaded Pixel App</span>
                                 <button type="button" class="Polaris-Navigation__Action" aria-label="Contact support">
                                    <span class="Polaris-Icon">
                                       <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                          <path d="M13 11h2V9h-2v2zm-4 0h2V9H9v2zm-4 0h2V9H5v2zm5-9c-4.411 0-8 3.589-8 8 0 1.504.425 2.908 1.15 4.111l-1.069 2.495a1 1 0 0 0 1.314 1.313l2.494-1.069A7.939 7.939 0 0 0 10 18c4.411 0 8-3.589 8-8s-3.589-8-8-8z" fill-rule="evenodd"></path>
                                       </svg>
                                    </span>
                                 </button>
                              </li>

                              <li class="Polaris-Navigation__ListItem">
                                <a class="menu-anchor" href="{{url('User/dashboard')}}">
                                 <button type="button" class="Polaris-Navigation__Item">
                                    <div class="Polaris-Navigation__Icon">
                                       <span class="Polaris-Icon">
                                          <svg  viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                             <path <?=((strtolower($page) == 'dashboard') ? 'fill="#1d249b"' : 'fill="#637381"')?> d="M19.664 8.252l-9-8a1 1 0 0 0-1.328 0L8 1.44V1a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v5.773L.336 8.252a1.001 1.001 0 0 0 1.328 1.496L2 9.449V19a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9.449l.336.299a.997.997 0 0 0 1.411-.083 1.001 1.001 0 0 0-.083-1.413zM16 18h-2v-5a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v5H4V7.671l6-5.333 6 5.333V18zm-8 0v-4h4v4H8zM4 2h2v1.218L4 4.996V2z" fill-rule="evenodd"></path>
                                          </svg>
                                       </span>
                                    </div>
                                    <span class="Polaris-Navigation__Text" <?=((strtolower($page) == 'dashboard') ? 'style="color:#1d249b"' : "")?> >Dashboard</span>
                                 </button>
                               </a>
                              </li>


                              <li   class="Polaris-Navigation__ListItem">
                                <a class="menu-anchor" href="{{url('User/orders')}}?status=0">
                                   <button type="button" class="Polaris-Navigation__Item">
                                      <div class="Polaris-Navigation__Icon">
                                         <span class="Polaris-Icon">
                                            <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                               <path <?=((strtolower($page) == 'orders') ? 'fill="#1d249b"' : 'fill="#637381"')?>  d="M1 13h5l1 2h6l1-2h5v6H1z"></path>
                                               <path d="M2 18v-4h3.382l.723 1.447c.17.339.516.553.895.553h6c.379 0 .725-.214.895-.553L14.618 14H18v4H2zM19 1a1 1 0 0 1 1 1v17a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h4a1 1 0 0 1 0 2H2v9h4c.379 0 .725.214.895.553L7.618 14h4.764l.723-1.447c.17-.339.516-.553.895-.553h4V3h-3a1 1 0 0 1 0-2h4zM6.293 6.707a.999.999 0 1 1 1.414-1.414L9 6.586V1a1 1 0 0 1 2 0v5.586l1.293-1.293a.999.999 0 1 1 1.414 1.414l-3 3a.997.997 0 0 1-1.414 0l-3-3z" fill-rule="evenodd"></path>
                                            </svg>
                                         </span>
                                      </div>
                                      <span class="Polaris-Navigation__Text" <?=((strtolower($page) == 'pending') ? 'style="color:#1d249b"' : "")?>  >Pending Orders</span>
                                   </button>
                                </a>
                              </li>



                              <li  class="Polaris-Navigation__ListItem">
                                <a class="menu-anchor" href="{{url('User/orders')}}?status=1">
                                   <button type="button" class="Polaris-Navigation__Item">
                                      <div class="Polaris-Navigation__Icon">
                                         <span class="Polaris-Icon">
                                            <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                               <path <?=((strtolower($page) == 'a_orders') ? 'fill="#1d249b"' : 'fill="#637381"')?>  d="M1 13h5l1 2h6l1-2h5v6H1z"></path>
                                               <path d="M2 18v-4h3.382l.723 1.447c.17.339.516.553.895.553h6c.379 0 .725-.214.895-.553L14.618 14H18v4H2zM19 1a1 1 0 0 1 1 1v17a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h4a1 1 0 0 1 0 2H2v9h4c.379 0 .725.214.895.553L7.618 14h4.764l.723-1.447c.17-.339.516-.553.895-.553h4V3h-3a1 1 0 0 1 0-2h4zM6.293 6.707a.999.999 0 1 1 1.414-1.414L9 6.586V1a1 1 0 0 1 2 0v5.586l1.293-1.293a.999.999 0 1 1 1.414 1.414l-3 3a.997.997 0 0 1-1.414 0l-3-3z" fill-rule="evenodd"></path>
                                            </svg>
                                         </span>
                                      </div>
                                      <span class="Polaris-Navigation__Text" <?=((strtolower($page) == 'processing') ? 'style="color:#1d249b"' : "")?>  >Processing</span>
                                   </button>
                                </a>
                              </li>

                              <li  class="Polaris-Navigation__ListItem">
                                <a class="menu-anchor" href="{{url('User/orders')}}?status=2">
                                   <button type="button" class="Polaris-Navigation__Item">
                                      <div class="Polaris-Navigation__Icon">
                                         <span class="Polaris-Icon">
                                            <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                               <path <?=((strtolower($page) == 'a_orders') ? 'fill="#1d249b"' : 'fill="#637381"')?>  d="M1 13h5l1 2h6l1-2h5v6H1z"></path>
                                               <path d="M2 18v-4h3.382l.723 1.447c.17.339.516.553.895.553h6c.379 0 .725-.214.895-.553L14.618 14H18v4H2zM19 1a1 1 0 0 1 1 1v17a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h4a1 1 0 0 1 0 2H2v9h4c.379 0 .725.214.895.553L7.618 14h4.764l.723-1.447c.17-.339.516-.553.895-.553h4V3h-3a1 1 0 0 1 0-2h4zM6.293 6.707a.999.999 0 1 1 1.414-1.414L9 6.586V1a1 1 0 0 1 2 0v5.586l1.293-1.293a.999.999 0 1 1 1.414 1.414l-3 3a.997.997 0 0 1-1.414 0l-3-3z" fill-rule="evenodd"></path>
                                            </svg>
                                         </span>
                                      </div>
                                      <span class="Polaris-Navigation__Text" <?=((strtolower($page) == 'ready') ? 'style="color:#1d249b"' : "")?>  >Ready To ship</span>
                                   </button>
                                </a>
                              </li>


                              <li   class="Polaris-Navigation__ListItem">
                                  <a class="menu-anchor" href="{{url('User/orders')}}?status=3">
                                   <button type="button" class="Polaris-Navigation__Item">
                                      <div class="Polaris-Navigation__Icon">
                                         <span class="Polaris-Icon">
                                            <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                               <path <?=((strtolower($page) == 'd_orders') ? 'fill="#1d249b"' : 'fill="#637381"')?>  d="M1 13h5l1 2h6l1-2h5v6H1z"></path>
                                               <path d="M2 18v-4h3.382l.723 1.447c.17.339.516.553.895.553h6c.379 0 .725-.214.895-.553L14.618 14H18v4H2zM19 1a1 1 0 0 1 1 1v17a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h4a1 1 0 0 1 0 2H2v9h4c.379 0 .725.214.895.553L7.618 14h4.764l.723-1.447c.17-.339.516-.553.895-.553h4V3h-3a1 1 0 0 1 0-2h4zM6.293 6.707a.999.999 0 1 1 1.414-1.414L9 6.586V1a1 1 0 0 1 2 0v5.586l1.293-1.293a.999.999 0 1 1 1.414 1.414l-3 3a.997.997 0 0 1-1.414 0l-3-3z" fill-rule="evenodd"></path>
                                            </svg>
                                         </span>
                                      </div>
                                      <span class="Polaris-Navigation__Text" <?=((strtolower($page) == 'delivered') ? 'style="color:#1d249b"' : "")?>  >Delivered</span>
                                   </button>
                                </a>
                              </li>


                              @if(Session::get('userData')->store_hours == 'menual')
                              <li class="Polaris-Navigation__ListItem">
                                <a class="menu-anchor" href="{{url('User/settings')}}">
                                   <button type="button" class="Polaris-Navigation__Item">
                                      <div class="Polaris-Navigation__Icon">
                                         <span class="Polaris-Icon">
                                            <svg class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"  viewBox="0 0 20 20">
                                              <path fill-rule="evenodd" <?=((strtolower($page) == 'settings') ? 'fill="#1d249b"' : 'fill="#637381"')?>  d="M19.492 11.897l-1.56-.88a7.8 7.8 0 0 0 0-2.035l1.56-.879a1.001 1.001 0 0 0 .37-1.38L17.815 3.26a1.001 1.001 0 0 0-1.353-.362l-1.491.841A8.078 8.078 0 0 0 13 2.586V1a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v1.586a8.053 8.053 0 0 0-1.97 1.152l-1.492-.84a1 1 0 0 0-1.352.361L.139 6.723a1.001 1.001 0 0 0 .37 1.38l1.559.88A7.829 7.829 0 0 0 2 10c0 .335.023.675.068 1.017l-1.56.88a.998.998 0 0 0-.37 1.38l2.048 3.464a.999.999 0 0 0 1.352.362l1.492-.842A7.99 7.99 0 0 0 7 17.413V19a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-1.587a8.014 8.014 0 0 0 1.97-1.152l1.492.842a1 1 0 0 0 1.353-.362l2.047-3.464a1.002 1.002 0 0 0-.37-1.38m-3.643-3.219c.1.448.15.893.15 1.322a6.1 6.1 0 0 1-.15 1.322 1 1 0 0 0 .484 1.09l1.287.725-1.03 1.742-1.252-.707a1 1 0 0 0-1.183.15 6.023 6.023 0 0 1-2.44 1.425 1 1 0 0 0-.715.96V18H9v-1.294a1 1 0 0 0-.714-.959 6.01 6.01 0 0 1-2.44-1.425 1.001 1.001 0 0 0-1.184-.15l-1.252.707-1.03-1.742 1.287-.726a.999.999 0 0 0 .485-1.089A6.043 6.043 0 0 1 4 10c0-.429.05-.874.152-1.322a1 1 0 0 0-.485-1.09L2.38 6.862 3.41 5.12l1.252.707a1 1 0 0 0 1.184-.149 6.012 6.012 0 0 1 2.44-1.426A1 1 0 0 0 9 3.294V2h2v1.294a1 1 0 0 0 .715.958c.905.27 1.749.762 2.44 1.426a1 1 0 0 0 1.183.15l1.253-.708 1.029 1.742-1.287.726a1 1 0 0 0-.484 1.09M9.999 6c-2.205 0-4 1.794-4 4s1.795 4 4 4c2.207 0 4-1.794 4-4s-1.793-4-4-4m0 6c-1.102 0-2-.897-2-2s.898-2 2-2c1.104 0 2 .897 2 2s-.896 2-2 2"/>
                                            </svg>

                                         </span>
                                      </div>
                                      <span class="Polaris-Navigation__Text" <?=((strtolower($page) == 'settings') ? 'style="color:#1d249b"' : "")?>  >
                                        Location Switch
                                      </span>
                                   </button>
                                </a>
                              </li>
                              @endif




                           </ul>
                        </div>
                     </nav>
                     <button type="button" class="Polaris-Frame__NavigationDismiss" aria-hidden="true" aria-label="Close navigation" tabindex="-1">
                        <span class="Polaris-Icon">
                           <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                              <path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                           </svg>
                        </span>
                     </button>
                  </div>
               </div>
               <div class="Polaris-Frame__ContextualSaveBar Polaris-Frame-CSSAnimation--startFade"></div>
               <main class="Polaris-Frame__Main" id="AppFrameMain" data-has-global-ribbon="false">
                  <a id="AppFrameMainContent" tabindex="-1"></a>
                  <div class="Polaris-Frame__Content">
                    @yield('content')
                  </div>
            </div>
            </main>
         </div>
      </div>
      </div>
      <script>
         $("#actionbtn").on('click',function(){
             $('#actions').toggle();
         })
         $(document).on('click','.close-more',function(){
           $(this).parents('.cards').find('.other-details').slideUp("slow");
           $(this).parents('.cards').find('.show-buttons').show()
         })
         $(document).on('click','.open-more',function(){
           $(this).parents('.cards').find('.other-details').slideDown("slow");
           $(this).parents('.cards').find('.show-buttons').hide();
         })
      </script>
   </body>
</html>
