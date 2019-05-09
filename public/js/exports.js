var sendMailLink = document.querySelector('#link-exports-sendMail');
var exportsProfileSelector = document.querySelector('select');

// document.querySelector('select').selectedIndex

sendMailLink.addEventListener('click', sendMail);


function sendMail(){
  var exportsProfileSelectorText = exportsProfileSelector.options[exportsProfileSelector.selectedIndex].text;

  // AJAX REQUEST call sendmailfunction in exportsphp
 
  fetch(url + '/exports/downloadCSV/')
    .then(function(res){
       return res.text();
    })
    .then(function(data){
      console.log(data);
    });
  
   
}

