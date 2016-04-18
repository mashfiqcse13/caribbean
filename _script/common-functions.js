function saveComment(elem) {
    alert('aa')
    var id = $(elem).find('input[name=profile_id]').val();
    var comment = $(elem).find('textarea[name=comment]').val();
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: 'add_comments.php',
        data: 'ajax=1&profile_id=' + encodeURIComponent(id) + '&comment_text=' + encodeURIComponent(comment),
        success: function (resp) {
            console.log(resp)
            if (resp.Error == 0) {
                $.fn.fancybox.close();
            } else {
                alert("Comment could not be saved. Please try again later.");
            }
        }
    })
    return false;
}