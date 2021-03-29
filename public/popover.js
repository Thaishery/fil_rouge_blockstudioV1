// Select all elements with data-toggle="popover" in the document
$('[data-toggle="popover"]').popover();

// Select a specified element
$('#myPopover').popover();

// $('#myModal').popover();

$(document).ready(function(){
    $("#myBtn").click(function(){
      $("#myModal").modal();
    });
  });