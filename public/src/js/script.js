/*  insertind post in to the modal */
var postId = 0;
var postBodyElement = null;
$('.post').find('.interaction').find('.edit').on('click', function (event) {
    event.preventDefault();
    /*  getting post */
    postBodyElement = event.target.parentNode.parentNode.childNodes[1];
    var postBody = postBodyElement.textContent;
    /*  getting post id */
    postId = event.target.parentNode.parentNode.parentNode.dataset['postid'];
    /*  insertig post in to the modal */
    $('#post-body').val(postBody);
    $('#edit-model').modal();

});
/*  editing post  */
$('#modal-save').on('click', function () {
    /*  sendig ajax   */
    $.ajax({
        method: 'get',
        url: urlEdit,
        data: {body: $('#post-body').val(), postId: postId, _token: token}
    })
    /*  Request editing post     */
        .done(function (msg, message) {
            /* inserting in to the post body  */
            $(postBodyElement).text(msg['new_body']);
            /*  closing modal */
            $('#edit-model').modal('hide');
        });
});

/*  changing users   */
$('#listUsers').find('li').find('a').on('click', function (event) {
    /*  getting event  */
    var  users = event.target.childNodes[1].value;
    /*  sending Ajax     */
    $.ajax({
        method: 'get',
        url: userUrl,
        data: {userId: users, _token: token}
    })
});

/*  like   */
$('.like').on('click', function (event) {

    event.preventDefault();
    /*  getting post id    */
    postId = event.target.parentNode.parentNode.parentNode.dataset['postid'];
    /*  sending ajax request   */
    var isLike = event.target.previousElementSibling == null ? true : false;
    /*  sending ajax request   */
    $.ajax({
        method: "POST",
        url: urlLike,
        data: {isLike: isLike, postId: postId, email: $('#userEmailforLike').val(), _token: token}
    })
        .done(function () {
            /*  on click changing like in to you like this post or you dont like this post    */
            event.target.innerText = isLike ? event.target.innerText == 'Like' ? " This post like you" : 'Like' : event.target.innerText == 'Dislike' ? 'You don`t like this posts': 'Dislike';
        if(isLike) {
            /*  changing text to dislike  */
            event.target.nextElementSibling.innerText = 'Dislike';
        }
        else {
            /*  changing text to like  */
            event.target.previousElementSibling.innerText = 'Like';
        }
        });
});
$('.like').on('click', function (event) {
    event.preventDefault();
    postId = event.target.parentNode.parentNode.parentNode.dataset['postid'];
    //console.log(postId);
    var isLike = event.target.previousElementSibling == null ? true : false;
    $.ajax({
        method: "POST",
        url: urlLike,
        data: {isLike: isLike, postId: postId, email: $('#userEmailforLike').val(), _token: token}
    })
        .done(function () {
            event.target.innerText = isLike ? event.target.innerText == 'Like' ? " This post like you" : 'Like' : event.target.innerText == 'Dislike' ? 'You don`t like this posts': 'Dislike';
        if(isLike) {
            event.target.nextElementSibling.innerText = 'Dislike';
        }
        else {
            event.target.previousElementSibling.innerText = 'Like';
        }
        });
});
