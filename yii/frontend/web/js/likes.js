$(document).ready(function () {

    // новости
   $('a.button-like').click(function () {
       let button = $(this);
       let button2 = $(this).siblings('.button-dislike');
       let params = {
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

    // новости
    $('a.button-dislike').click(function () {
        let button = $(this);
        let button2 = $(this).siblings('.button-like');
        let params = {
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

    // комментарии
    $('a.button-com-like').click(function () {
        let button = $(this);
        let button2 = $(this).siblings('.button-com-dislike');
        let params = {
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

    // комментарии
    $('a.button-com-dislike').click(function () {
        let button = $(this);
        let button2 = $(this).siblings('.button-com-like');
        let params = {
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

    // галлерея
    $('a.button-gal-like').click(function () {
        let button = $(this);
        let button2 = $(this).siblings('.button-gal-dislike');
        let params = {
            'id' : $(this).attr('data-id')
        };
        $.post('/gallery/like', params, function (data) {
            if (data.success) {
                button.children('.like-count').html(data.likeCount);
                button2.children('.dislike-count').html(data.dislikeCount);
            }
        });
        return false;
    });

    // галлерея
    $('a.button-gal-dislike').click(function () {
        let button = $(this);
        let button2 = $(this).siblings('.button-gal-like');
        let params = {
            'id' : $(this).attr('data-id')
        };
        $.post('/gallery/dislike', params, function (data) {
            if (data.success) {
                button.children('.dislike-count').html(data.dislikeCount);
                button2.children('.like-count').html(data.likeCount);
            }
        });
        return false;
    });
// редактирование комментария
    $('button.edit-comment').click(function(){
        let commentId = $(this).attr('data-id');
        let commentText = $(this).siblings('.comment-text').html();
        commentText = $.trim(commentText);

        $('#comment-id').val(commentId);
        $('#editComment').find('#comment-comment').html(commentText);

    });

    // добавление новости из галереи
    $('button.add-image-news').click(function(){
        let img_src = $(this).closest('.image-background').find('img').attr('src');
        let user_id = $(this).attr('data-id');

        $('#news-text').val(img_src);
        // let image = $('#image-news');
        $('#news-tags').val(user_id);
        $('#image-news').attr('src', img_src);
    });

});