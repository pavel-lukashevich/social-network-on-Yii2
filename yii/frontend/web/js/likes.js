$(document).ready(function () {
   $('a.button-like').click(function () {
       var button = $(this);
       var button2 = $(this).siblings('.button-dislike');
       var params = {
           'id' : $(this).attr('data-id')
       };
        $.post('/news/like', params, function (data) {
            if (data.success) {
                button.children('.like-count').html(data.likeCount);
                button2.children('.dislike-count').html(data.dislikeCount);
            }
        });
       return false;
   });

    $('a.button-dislike').click(function () {
        var button = $(this);
        var button2 = $(this).siblings('.button-like');
        var params = {
            'id' : $(this).attr('data-id')
        };
        $.post('/news/dislike', params, function (data) {
            if (data.success) {
                button.children('.dislike-count').html(data.dislikeCount);
                button2.children('.like-count').html(data.likeCount);
            }
        });
        return false;
    });

    $('a.button-com-like').click(function () {
        var button = $(this);
        var button2 = $(this).siblings('.button-com-dislike');
        var params = {
            'id' : $(this).attr('data-id')
        };
        $.post('/comment/like', params, function (data) {
            if (data.success) {
                button.children('.like-count').html(data.likeCount);
                button2.children('.dislike-count').html(data.dislikeCount);
            }
        });
        return false;
    });

    $('a.button-com-dislike').click(function () {
        var button = $(this);
        var button2 = $(this).siblings('.button-com-like');
        var params = {
            'id' : $(this).attr('data-id')
        };
        $.post('/comment/dislike', params, function (data) {
            if (data.success) {
                button.children('.dislike-count').html(data.dislikeCount);
                button2.children('.like-count').html(data.likeCount);
            }
        });
        return false;
    });

    // $('button.edit-comment').click(function(){
    //     var hidden = $(this).siblings('.row').children('p');
    //     var params = {
    //         'id': $(this).attr('data-id')
    //     }
    // });


});