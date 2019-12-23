jQuery(document).ready(function($) {

    //Variables
    var createNote = $('.create-note');


    //Events
    $('.content__info--notes__container').on('click', '.edit-note' , editNoteFn);
    $('.content__info--notes__container').on('click', '.delete-note' , deleteNoteFn);
    $('.content__info--notes__container').on('click', '.update-note' , updateNoteFn);
    createNote.on('click',createNoteFn);


    //Functions
    function editNoteFn(e){
        var note = $(this).parent();

        if (note.data("editable") == "yes") {
          noteReadOnly(note);
        } else {
          noteEditable(note);
        }

    }

    function noteEditable(note) {
        note.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i> Cancel');
        note.find("input,textarea").removeAttr("readonly").addClass("editable");
        note.find(".update-note").addClass("active");
        note.data("editable", "yes");
    }
    
    function noteReadOnly(note) {
        note.find(".edit-note").html('<i class="fas fa-edit" aria-hidden="true"></i> Edit');
        note.find("input,textarea").attr("readonly", "readonly").removeClass("editable");
        note.find(".update-note").removeClass("active");
        note.data("editable", "no");
    }


    function deleteNoteFn(){
        var note = $(this).parent();

        $.ajax({
            beforeSend: function(xhr){
                xhr.setRequestHeader('X-WP-Nonce',data.nonce);
            },
            url: data.root_url + '/wp-json/wp/v2/note/'+note.data('id'),
            type: 'DELETE',
            success: function(response){
                note.slideUp();
                console.log("Congrats!");
                console.log(response);
                if (response.userNoteCount < 5) {
                    $(".note-limit").removeClass("active");
                }
            },error: function(response){
                console.log("Sorry!");
                console.log(response);
            }
        })
    }


    function updateNoteFn() {
        var note = $(this).parent();

        var updatedPost={
            'title': note.find('input').val(),
            'content': note.find('textarea').val()
        }

        $.ajax({
            beforeSend: function(xhr){
                xhr.setRequestHeader('X-WP-Nonce',data.nonce);
            },
            url: data.root_url + '/wp-json/wp/v2/note/'+note.data('id'),
            type: 'POST',
            data: updatedPost,
            success: function(response){
                noteReadOnly(note);
                console.log("Congrats!");
                console.log(response);
            },error: function(response){
                console.log("Sorry!");
                console.log(response);
            }
        })
    }


    function createNoteFn() {
        var newPost = {
          'title': $("#new-note-title").val(),
          'content': $("#new-note-body").val(),
          'status': 'publish'
        }
        
        $.ajax({
          beforeSend: (xhr) => {
            xhr.setRequestHeader('X-WP-Nonce', data.nonce);
          },
          url: data.root_url + '/wp-json/wp/v2/note/',
          type: 'POST',
          data: newPost,
          success: (response) => {
            $("#new-note-title, #new-note-body").val('');

            $('.content__info--notes__container h4').remove();

            $(`
                <div class="content__info--notes__content" data-id="${response.id}">
                    <input readonly value="${response.title.raw}">
                    <span class="edit-note"><i class="fas fa-edit"></i> Edit</span>
                    <span class="delete-note"><i class="fas fa-trash-alt"></i> Delete</span>
                    <textarea readonly>${response.content.raw}</textarea>
                    <span class="update-note"><i class="fas fa-arrow-right"></i> Save</span>
                </div>
              `).prependTo(".content__info--notes__container").hide().slideDown();
    
            console.log("Congrats");
            console.log(response);
          },
          error: (response) => {
            if(response.responseText == "You have reached your note limit.") {
              $(".note-limit").addClass("active");
            }
            console.log("Sorry");
            console.log(response);
          }
        });
      }

})