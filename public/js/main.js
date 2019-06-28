
//  console.log(export_profile);

var shareDatesStrings = [];
var shareDatesObjects = [];
var sharePeriods = [];
var dates = [];


 var parking_id = document.querySelector('#datepicker_parking_id').value;

 document.addEventListener("DOMContentLoaded", function(e) {

    // Get ServerDataJSONString using Fetch API
    fetch(url + '/shares/loadAjaxData/' + parking_id)
      .then(function(res){
        return res.text();
      })
      .then(function(data){

        // console.log(data);
        var serverData = JSON.parse(data);

        serverData.forEach(function(data) {
          shareDatesStrings.push(data);
          // console.log(data);
          // console.log(123);

        })

      })
      .catch(function(err){
        console.log(err);
      });
      
});



$( function() {

  // Declare important vars
  var creditItemPerDay = 0.75;

  let shareStart, shareEnd = 0;

 function checkAvailability(mydate){

  var $return = true;
  var $returnclass ="available";

  $checkdate = $.datepicker.formatDate(dateFormat, mydate);

  for(var i = 0; i < shareDatesStrings.length; i++){

    if(shareDatesStrings[i] == $checkdate){
      $return = false;
      $returnclass= "unavailable";
    }

  }

  return [$return,$returnclass];

  }

  const dateFormat = "yy-mm-dd",
    from = $( "#datepicker_share_start" )
      .datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,    
        dateFormat: dateFormat,
        minDate: +2,
        // dateFormat: 'dd MM yy',
        beforeShowDay: checkAvailability

      })
      .on( "change", function() {
        to.datepicker( "option", "minDate" , addDayToMinDate( getDate( this  ), 6) );
        shareStart =  this.value;

       
      if (shareStart == 0 || shareEnd == 0 ) {
        // Hide results
        document.getElementById('share-heading-amount-days').innerHTML = `Amount Days: `;
        document.getElementById('share-heading-credit-item').innerHTML= `Credit Item: `;
      } else {
        
        loadUpdateShareInfo();
      }

      }),

    to = $( "#datepicker_share_end" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      dateFormat: dateFormat,
      minDate: +8,
      beforeShowDay: checkAvailability

    })
    .on( "change", function() {
      from.datepicker( "option", "maxDate", subDayFromMaxDate( getDate( this ), 6 ) );
      shareEnd =  this.value;
   
      if (shareStart == 0 || shareEnd == 0 ) {
           // Hide results
           document.getElementById('share-heading-amount-days').innerHTML = `Amount Days: <i class="fa fa-spinner fa-spin">`;
           document.getElementById('share-heading-credit-item').innerHTML= `Credit Item: <i class="fa fa-spinner fa-spin">`;
      } else {

        loadUpdateShareInfo();
        
      }

    });
  
  function getDate( element ) {

    var date;
    try {
      date = $.datepicker.parseDate( dateFormat, element.value );
    } catch( error ) {
      date = null;
    }

    return date;
  }

  function addDayToMinDate(date, dayToAdd) {
    var result = date;
    result.setDate(result.getDate() + dayToAdd);
    return result;
  }

  function subDayFromMaxDate(date, dayToAdd) {
    var result = date;
    result.setDate(result.getDate() - dayToAdd);
    return result;
  }

  // Wenn beide Felder ausgefüllt sind, führe funktion aus
  function calculateDiffInDays (shareStart = "", shareEnd=""){
    
    if (shareStart != "" && shareEnd != "") {

    // Convert both string to Date in milliseconds
    shareStart = Date.parse(shareStart);
    shareEnd = Date.parse(shareEnd);

    // Calculate difference between both dates in milliseconds
    var diffInMs = shareEnd-shareStart;

    // Calculate difference in s
    diffInMs = diffInMs / 1000;
    var seconds = Math.floor(diffInMs % 60);
    // Calculate difference in min
    diffInMs = diffInMs / 60;
    var minutes = Math.floor(diffInMs % 60);
    // Calculate difference in h
    diffInMs = diffInMs / 60;
    var hours = Math.floor(diffInMs % 24);
    // Calculate difference from h to days
    var days = Math.floor(diffInMs / 24);

    return days + 1;
 
    } 
  }

  function calculateCreditItem(days, creditItemPerDay) {

    result = (days * creditItemPerDay);

    return result;
  }

  function loadUpdateShareInfo(){
      // Hide results
      document.getElementById('share-heading-amount-days').innerHTML = `Amount Days: <i class="fa fa-spinner fa-spin">`;
      document.getElementById('share-heading-credit-item').innerHTML= `Credit Item: <i class="fa fa-spinner fa-spin">`;

      setTimeout(updateShareInfo,2000);
  }

  function updateShareInfo() {

  document.getElementById('share-heading-amount-days').textContent = `Amount Days: ${calculateDiffInDays(shareStart, shareEnd)}`;
  document.getElementById('share-heading-credit-item').textContent = `Credit Item: ${calculateCreditItem(calculateDiffInDays(shareStart, shareEnd),creditItemPerDay)} €`;

  }

  });






