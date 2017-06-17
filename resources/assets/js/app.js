require('./bootstrap');
$(document).ready(function() {

  setTimeout(function() {
    $('.optionSuccess').fadeOut(600);
  }, 4000);


  $('.closeOptionSuccess').click(function() {
    $('.optionSuccess').slideUp(300);
  })

  $('.copyAddressOptions').click(function() {
    var item = document.querySelector('.hiddenLink').select();
    var success = document.execCommand('copy');
    if(success) {
      $('.copySuccess').fadeIn(300, function() {
        setTimeout(function() {
          $('.copySuccess').fadeOut(600);
        }, 2000);
      })
    }
  })

  $('.copyAddressHome').click(function() {
    var survey = $(this).attr('survey');
    var item = document.querySelector('#hiddenLink-' + survey).select();
    var success = document.execCommand('copy');
    if(success) {
      $('.copySuccess').fadeIn(300, function() {
        setTimeout(function() {
          $('.copySuccess').fadeOut(600);
        }, 2000);
      })
    }
  })

});