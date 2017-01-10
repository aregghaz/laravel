var postId = 0;
var postBodyElement = null;
$('.post').find('.interaction').find('.edit').on('click', function (event) {
    event.preventDefault();
    postBodyElement = event.target.parentNode.parentNode.childNodes[1];
    var postBody = postBodyElement.textContent;
    postId = event.target.parentNode.parentNode.parentNode.dataset['postid'];
    $('#post-body').val(postBody);
    $('#edit-model').modal();
    //console.log(event.target.parentNode.parentNode.parentNode);
});

$('#modal-save').on('click', function () {
    //console.log($('#post-body').val());
    //console.log(postId);
    $.ajax({
        method: 'get',
        url: urlEdit,
        data: {body: $('#post-body').val(), postId: postId, _token: token}
    })
        .done(function (msg, message) {

            $(postBodyElement).text(msg['new_body']);
            $('#edit-model').modal('hide');
        });
});


$('#listUsers').find('li').find('a').on('click', function (event) {
    var users;

    users = event.target.childNodes[1].value;
    //console.log(users);
    $.ajax({
        method: 'get',
        url: userUrl,
        data: {userId: users, _token: token}
    })


});

$('#sendMessage').on('click', function (event) {

    var usersId = $('#email').val();

    var asd = $('#inputId').attr('value', usersId);


});
$('.like').on('click', function (event) {
    event.preventDefault();
    postId = event.target.parentNode.parentNode.parentNode.dataset['postid'];
    console.log(postId);
    var isLike = event.target.previousElementSibling == null ? true : false;
    $.ajax({
        method: "POST",
        url: urlLike,
        data: {isLike: isLike, postId: postId, _token: token}
    })
        .done(function () {
            event.target.innerText = isLike ? event.target.innerText == 'Like' ? "You like this post" : 'Like' : event.target.innerText == 'Dislike' ? 'You don`t like this posts': 'Dislike';
        if(isLike) {
            event.target.nextElementSibling.innerText = 'Dislike';
        }
        else {
            event.target.previousElementSibling.innerText = 'Like';
        }
        });
});