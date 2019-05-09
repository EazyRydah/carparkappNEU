var sendMailLink = document.querySelector('#link-exports-sendMail');
var emailPlaceholder = document.querySelector('#email-input').placeholder;
var profileSelector = document.querySelector('select');
var email;

// document.querySelector('select').selectedIndex

sendMailLink.addEventListener('click', sendMail);


function sendMail(){
  var exportsProfile = profileSelector.options[profileSelector.selectedIndex].text;
  var emailInput = document.querySelector('#email-input').value;

  if(emailInput == '') {
    email = emailPlaceholder;
  } else {
    email = emailInput;
  }

  // AJAX REQUEST call sendmailfunction in exportsphp
  fetch(url + '/exports/sendMail/' + exportsProfile + '/' + email + '/')
    .then(function(res){
       return res.text();
    })
    .then(function(data){
      console.log(data);
    });

}

