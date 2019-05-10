// var sendMailLink = document.querySelector('#link-exports-sendMail');
// Create UI Vars
var profileSelector = document.querySelector('#select-export-profile');
var emailInputValue = document.querySelector('#email-input').value;
var emailPlaceholder = document.querySelector('#email-input').placeholder;
var email;

// document.querySelector('select').selectedIndex

// sendMailLink.addEventListener('click', sendMail);


// Create Event Listeners
profileSelector.addEventListener("change", updateView);
// emailInputValue.addEventListener("change", updateView);

// Functions
function updateView(){

  var selectedProfile = profileSelector.value;
  var emailInput = document.querySelector('#email-input').value;

  // console.log(emailInput);

  // document.getElementById("demo").innerHTML = "You selected: " + x;
  // var exportsProfile = profileSelector.options[profileSelector.selectedIndex].text;
  // var emailInput = document.querySelector('#email-input').value;

  if(emailInput == '') {
    email = emailPlaceholder;
  } else {
    email = emailInput;
  }


  // console.log(selectedProfile);
  // console.log(email);

  //  AJAX REQUEST call updateView in exportsphp
  fetch(url + '/exports/updateView/' + selectedProfile + '/' + email + '/')
    .then(function(res){
       return res.text();
    })
    .then(function(data){
      console.log(data);
    });

}

// function sendMail(){
//   // get chosen option from select element
//   var exportsProfile = profileSelector.options[profileSelector.selectedIndex].text;
//   var emailInput = document.querySelector('#email-input').value;

//   if(emailInput == '') {
//     email = emailPlaceholder;
//   } else {
//     email = emailInput;
//   }

//   // AJAX REQUEST call sendmailfunction in exportsphp
//   fetch(url + '/exports/sendMail/' + exportsProfile + '/' + email + '/')
//     .then(function(res){
//        return res.text();
//     })
//     .then(function(data){
//       console.log(data);
//     });

// }

