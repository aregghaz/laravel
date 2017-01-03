var postId = 0;
var postBodyElement = null;
$('.post').find('.interaction').find('.edit').on('click', function (event) {
    event.preventDefault();
    postBodyElement = event.target.parentNode.parentNode.childNodes[1];
    var postBody = postBodyElement.textContent;
    postId = event.target.parentNode.parentNode.dataset['postid'];
    $('#post-body').val(postBody);
    $('#edit-model').modal()
});
$('#modal-save').on('click', function () {
    $.ajax({
        method: 'post',
        url: url,
        data: {body: $('#post-body').val(), postId: postId, _token: token}
    })
        .done(function (msg) {
            $(postBodyElement).text(msg['new_body']);
            $('#edit-model').modal('hide');
        });
});


$('#listUsers').find('li').find('a').on('click', function (event) {
    var users;

  users = event.target.childNodes[1].value;
    console.log(users);
    $.ajax({
        method: 'get',
        url: userUrl,
        data: {userId: users, _token: token}
    })


});

$('#sendMessage').on('click', function (event) {

    var usersId =$('#email').val();

  var asd = $('#inputId').attr('value', usersId);



});
