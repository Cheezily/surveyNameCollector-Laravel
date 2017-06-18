require('./bootstrap');
$(document).ready(function() {
  $('#universityList').change(function() {
    if($('#universityList').val() === 'notlisted') {
      $('.manualUniversityBox').slideDown(300);
    } else {
      $('.manualUniversityBox').slideUp(300);
    }
  })

  $('.backButton').click(function(e) {
    e.preventDefault();
    $('.altForm').slideUp(400, function() {
      $('.mainForm').slideDown(400);
    })
  })

  $('.notListed').click(function(e) {
    e.preventDefault();
    $('.mainForm').slideUp(400, function() {
      $('.altForm').slideDown(400);
    })
  })
});