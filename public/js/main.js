var postId = 0;
var postBodyElement = null;
var commentBodyElement = null;

//Opening the edit modal
$(function() {
    $('.post').find('.interaction').find('.edit').click(function(event) {
        event.preventDefault();

        postBodyElement = event.target.parentNode.parentNode.childNodes[1];
        //Storing the post body as text
        var postBody = postBodyElement.textContent;
        postId = event.target.parentNode.parentNode.dataset['postid'];
        $('#post-body').val(postBody);
        $('#edit-modal').modal();
    });
  });

  //Saving the edit and closing the edit modal
$(function() {
    $('#edit-modal-save').click(function() {
        $.ajax({
                method: 'POST',
                url: urlEdit,
                data: {body: $('#post-body').val(), postId: postId, _token: token}
        })
        .done(function (msg) {
            $(postBodyElement).text(msg['new_body']);
            $('#edit-modal').modal('hide');
        });
    })
});

//Using ajax to display the like/liked
$(function() {
    $('.like').click(function(event) {
        event.preventDefault();
        postId = event.target.parentNode.parentNode.dataset['postid'];
        $.ajax({
            method: 'POST',
            url: urlLike,
            data: {postId: postId, _token: token}
        })
        .done(function() {
            event.target.innerText = event.target.innerText == 'Like' ? 'Liked' : 'Like';
        })
    })
})

  /*$(function() {
    $('#comment-modal-save').click(function() {

      let body = $("#body").val()
      let value = document.getElementsByClassName("comment")
      let post_id = value.getAttribute("value")

        $.ajax({
                method: 'POST',
                url: urlComment,
                data: {body: body, post_id: post_id, _token: token},
                success: function(response) {
                  if(response) {
                    $("#comment-table").append('<tbody><tr><td>'+ response.body +'</td></tr></tbody>');
                    //$("commentForm")[0].reset();
                    $('#comment-modal').modal('hide');
                    }
                },
                
        })
        
    })
});*/




