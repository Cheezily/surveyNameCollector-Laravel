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

  $('.deleteInstructorButton').click(function(e) {
    e.preventDefault();
    $('.confirmationWrapper').fadeIn(400, function() {
      $('.deleteInstructorDialog').fadeIn(400);
    });
    var instructor = $(this).attr('instructor');
    $('#deleteInstructorId').val(instructor);
    window.scrollTo(0, 0);
  })

  $('.deleteUniversityButton').click(function(e) {
    e.preventDefault();
    $('.confirmationWrapper').fadeIn(400, function() {
      $('.deleteUniversityDialog').fadeIn(400);
    });
    var university = $(this).attr('university');
    $('#deleteUniversityId').val(university);
    window.scrollTo(0, 0);
  })

  $('.cancelDeleteInstructor').click(function() {
    $('.confirmationWrapper').fadeOut(400);
    $('.deleteInstructorDialog').fadeOut(400);
    $('#deleteInstructorId').val('');
  })

  $('.cancelDeleteUniversity').click(function() {
    $('.confirmationWrapper').fadeOut(400);
    $('.deleteUniversityDialog').fadeOut(400);
    $('#deleteUniversityId').val('');
  })

});