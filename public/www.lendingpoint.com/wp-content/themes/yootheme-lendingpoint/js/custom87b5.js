/**
 * dom is ready
 */
(function customFunction() {


  /**
   * contact-us leave only one card open
   */
  document.querySelectorAll('.lp-team-card .uk-inline-clip').forEach(function (el) {
    el.addEventListener('click', function (event) {
      document.querySelectorAll('.lp-team-box').forEach(function (el) {
        if (el.className.indexOf('uk-animation-enter') === -1) {
          el.setAttribute('hidden', '')
        }

      })
    })
  })

  jQuery(".phoneNumber").keypress(function (e) {
    var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,3})/);
    e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
  });

  /**
   * set current year to footer
   */
  if (document.querySelector('.lp-footer-year')) {
    document.querySelector('.lp-footer-year').innerHTML = document.querySelector('.lp-footer-year').innerHTML.replace('2021', new Date().getFullYear())
  }

  /**
   * get auth
   */
  let token;
  let access_token;

  function getToken(){
    fetch("/apirest/apply/setup/token", {
      headers: { "app-name": "APP" },
      method: "GET",
    })
      .then((res) => {
        token = res.headers.get("x-csrf-token");
        return res.json();
      })
      .then((json) => {
        access_token = json.access_token
      });    
  }

  // refresh token every 5 minutos if element exists
  if( jQuery(".btnTextmeLink").length ) {
    setInterval(getToken, 60 * 1000 * 5);  
    getToken();
  }  
  
  /**
   * api rest to send sms from home
   */
  jQuery(".btnTextmeLink").click(function () {

    let phoneNumber = unmaskInput(jQuery(".phoneNumber").val())
    jQuery(".lp-success").addClass("uk-hidden");

    if (inputValidation(phoneNumber)) {

      jQuery(".btnTextmeLink").prop('disabled', true).text("Sending");

      fetch("/apirest/apply/sms/send-message", {
        headers: {
          "app-name": "APP",
          "x-csrf-token": token,
          authorization: "Bearer " + access_token,
        },
        body: JSON.stringify({
          phoneNumber: "+1" + phoneNumber,
          body: "LendingPoint: Here is the link to our app that you requested https://app.lendingpoint.com/app",
        }),
        method: "POST",
      })
        .then((res) => {
          return res.json();
        })
        .then((json) => {
          if (json.success) {
            jQuery(".btnTextmeLink").prop('disabled', false).text("Text Me The Link");
            jQuery(".lp-success").addClass("uk-margin-top");
            jQuery(".lp-success").css("color", "green");
            jQuery(".lp-success").html("<p>sms send success</p>");
            jQuery(".lp-success").removeClass("uk-hidden");
          } else {
            jQuery(".btnTextmeLink").prop('disabled', false).text("Text Me The Link");
            jQuery(".lp-success").addClass("uk-margin-top");
            jQuery(".lp-success").css("color", "red");
            jQuery(".lp-success").html("<p>" + json.errors + "</p>");
            jQuery(".lp-success").removeClass("uk-hidden");
          }
        });
    }
  });

  /**
   * funtion to validate input
   */
  function inputValidation(input) {
    jQuery(".lp-error").addClass("uk-hidden");
      if (!input.match(/\d{10}/)) {
      jQuery(".lp-error").removeClass("uk-hidden");
      return false;
    }
    return true;
  }

  function unmaskInput(maskedInput) {
    return maskedInput.replace(/\D/g, "")
  }


})();

