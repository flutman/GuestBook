$(function(){

    $('#form-data').submit(function(e){

       var route = $('#form-data').data('route');
       var form_data = $(this);
       $.ajax({
          type: 'POST',
          url: route,
          data: form_data.serialize(),
          success: function (Response) {
              //console.log(Response);
          }
       });
       e.preventDefault();
    });
});
