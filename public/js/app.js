const navbar = document.querySelector('#nav');
const navBtn = document.querySelector('#nav-btn');
const closeBtn = document.querySelector('#close-btn');
const sidebar = document.querySelector('#sidebar');


  // BUTTON Top
  const scrollBtn = document.querySelector('.top-btn');

  window.addEventListener('scroll', () => {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      scrollBtn.style.display = 'block';
    } else {
      scrollBtn.style.display = 'none';
    }
  });
  scrollBtn.addEventListener('click', () => {
    window.scroll({
      top: 0,
      behavior: 'smooth',
    });
  });

// Flash alert pop up
var alertList = document.querySelectorAll('.alert')
alertList.forEach(function (alert) {
  new bootstrap.Alert(alert)
})

tarteaucitron.init({
    	  "privacyUrl": "mentions", /* Privacy policy url */
          "bodyPosition": "bottom", /* or top to bring it as first element for accessibility */

    	  "hashtag": "#tarteaucitron", /* Open the panel with this hashtag */
    	  "cookieName": "tarteaucitron", /* Cookie name */
    
    	  "orientation": "middle", /* Banner position (top - bottom) */
       
          "groupServices": false, /* Group services by category */
          "serviceDefaultState": "wait", /* Default state (true - wait - false) */
                           
    	  "showAlertSmall": false, /* Show the small banner on bottom right */
    	  "cookieslist": false, /* Show the cookie list */
                           
          "closePopup": false, /* Show a close X on the banner */

          "showIcon": true, /* Show cookie icon to manage cookies */
          //"iconSrc": "", /* Optionnal: URL or base64 encoded image */
          "iconPosition": "BottomRight", /* BottomRight, BottomLeft, TopRight and TopLeft */

    	  "adblocker": false, /* Show a Warning if an adblocker is detected */
                           
          "DenyAllCta" : true, /* Show the deny all button */
          "AcceptAllCta" : true, /* Show the accept all button when highPrivacy on */
          "highPrivacy": true, /* HIGHLY RECOMMANDED Disable auto consent */
                           
    	  "handleBrowserDNTRequest": false, /* If Do Not Track == 1, disallow all */

    	  "removeCredit": false, /* Remove credit link */
    	  "moreInfoLink": true, /* Show more info link */

          "useExternalCss": false, /* If false, the tarteaucitron.css file will be loaded */
          "useExternalJs": false, /* If false, the tarteaucitron.js file will be loaded */

    	  //"cookieDomain": ".my-multisite-domaine.fr", /* Shared cookie for multisite */
                          
          "readmoreLink": "", /* Change the default readmore link */

          "mandatory": true, /* Show a message about mandatory cookies */
  "mandatoryCta": true /* Show the disabled accept button when mandatory on */
});
(tarteaucitron.job = tarteaucitron.job || []).push('simpleanalytics');
//  tarteaucitron.user.gajsUa = 'UA-XXXXXXXX-X';
//         tarteaucitron.user.gajsMore = function () { /* add here your optionnal _ga.push() */ };
//         (tarteaucitron.job = tarteaucitron.job || []).push('gajs');
(tarteaucitron.job = tarteaucitron.job || []).push('hotjar');
// tarteaucitron.user.hotjarId = hotjarId; tarteaucitron.user.HotjarSv = HotjarSv;
// <!-- Google Analytics -->
//   (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
//   (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
//   m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
//   })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

//   ga('create', 'GA_MEASUREMENT_ID', 'auto');
//   ga('send', 'pageview');

// <!-- End Google Analytics -->