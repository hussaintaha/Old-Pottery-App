<!DOCTYPE html>
<html lang="en"  class="fresh-html"  data-controller="account_lookup"  data-action="new">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Login Page</title>
      <meta name="description" content="The ecommerce platform made for you">
      <link rel="shortcut icon" type="image/x-icon"   href="{{url('/public/favicon.png')}}">
      <link rel="stylesheet" media="all" href="{{url('/public/loginuser.css')}}"  />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

   </head>
   <body id="body-content" class="page fresh-ui" data-trekkie-device-id="e40032cf-6070-43bd-b7b3-4a54da8cb3e6">
      <div class="login-card ">
         <header class="login-card__header">
            <h1 class="login-card__logo">
               <a href="https://shopify.com">
                  <img alt="Log in to DashBoard" src="{{url('/public/login-icon.png')}}" />
               </a>
            </h1>
         </header>
         <div class="login-card__content">
            <div class="main-card-section">
               <h1 class="ui-heading">Log in</h1>
               <h3 class="ui-subheading ui-subheading--subdued">Continue to ORDER MANAGER Dashboard</h3>
               <form id="login-form"  method="post">
                  <div class="ui-form__section">
                     <div class="ui-form__group type-ahead-wrapper">
                        <div class="next-input-wrapper">
                           <label class="next-label" for="account_email">Email</label>
                           <input class="next-input type-ahead-input email-typo-input" type="email"  size="30" name="email" id="account_email" />
                        </div>
                        <div class="next-input-wrapper">
                           <label class="next-label" for="account_password">Password</label>
                           <div class="next-field__connected-wrapper ui-password">
                              <input required="required" label="Password"  class="ui-password__input next-input js-password-input  ui-password--feedback" type="password" size="30" name="password" id="account_password">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="captcha-element captcha-loading--spinner ">
                     <span role="img" class="ui-spinner"></span>
                  </div>
                  <button class="ui-button ui-button--primary ui-button--size-large  captcha__submit"   type="submit" name="submit" >
                    Login
                  </button>
               </form>
               <p class="help-link"> New to Shopify? <a href="/signup?rid=ac528623-385c-4320-8e71-72a70d9a3dd9">Get started</a>
               </p>
            </div>
         </div>
      </div>
      <footer style="display:none;" class="login-footer">
         <a class="login-footer__link" target="_blank" href="https://help.shopify.com/en/manual/your-account/logging-in#desktop" title="Help Center">Help</a>
         <a class="login-footer__link" target="_blank" href="https://www.shopify.com/legal/privacy" title="Privacy Policy">Privacy</a>
         <a class="login-footer__link" target="_blank" href="https://www.shopify.com/legal/terms" title="Terms of service">Terms</a>
      </footer>
      <script>
        $(document).ready(function(){
          $(document).on("submit","#login-form",function(evt){
            evt.preventDefault();
            $('.captcha-element').show();
            $.ajax({
              url:'{{url("User/validatelocation")}}',
              data:$(this).serialize(),
              dataType:'json',
              type:'post',
              success:function(response){
                if(response.code == 200){
                  window.location.href = '{{url("User/dashboard")}}';
                }else{
                  alert(response.msg)
                }
              }
            })
          })
        });
    </script>
   </body>
</html>
