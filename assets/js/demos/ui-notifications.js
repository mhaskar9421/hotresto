$(function () {

  $('.howler').click(function (e) {

    $.howl({
      type: $(this).data('type')
      , title: 'Success'
      , content: 'Customer Info is saved successfully'
      , sticky: $(this).data('sticky')
      , lifetime: 7500
      , iconCls: $(this).data('icon')
    });

  });

});