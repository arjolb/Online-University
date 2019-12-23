jQuery(document).ready(function($) {

    //Variables
    var likeProfessor = $('.like-professor');

    //Events
    likeProfessor.on('click',likeProfessorFn);

    //Functions
    function likeProfessorFn(e) {
        var like = $(e.target).closest('.like-professor');

        if (like.attr('data-liked') == 'yes') {
            deleteLikeFn(like);
          } else {
            createLikeFn(like);
          }
    }

    function createLikeFn(like) {
        $.ajax({
            beforeSend: function(xhr){
                xhr.setRequestHeader('X-WP-Nonce',data.nonce);
            },
            url: data.root_url + '/wp-json/likeroute/v2/manageLike',
            type: 'POST',
            data: {'professorID': like.attr('data-professor')},
            success: function (response) {
                like.attr('data-liked','yes');
                var likeCount = parseInt(like.find(".like-professor-count").html(), 10);
                likeCount++;
                like.find(".like-professor-count").html(likeCount);
                like.attr("data-like", response);
                console.log(response);
            },
            error: (response) => {
              console.log(response);
            }
        })
    }

    function deleteLikeFn(like) {
        $.ajax({
            beforeSend: (xhr) => {
              xhr.setRequestHeader('X-WP-Nonce', data.nonce);
            },
            url: data.root_url + '/wp-json/likeroute/v2/manageLike',
            data: {'like': like.attr('data-like')},
            type: 'DELETE',
            success: (response) => {
              like.attr('data-liked', 'no');
              var likeCount = parseInt(like.find(".like-professor-count").html(), 10);
              likeCount--;
              like.find(".like-professor-count").html(likeCount);
              like.attr("data-like", '');
              console.log(response);
            },
            error: (response) => {
              console.log(response);
            }
        });
    }
});