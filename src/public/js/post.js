$(function(){
    $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    });

    $('#form-data').submit(function(e){

       var route = $('#form-data').data('route');
       var form_data = $(this);
       var postId = $("#post_text").data("post-id");

       if (postId == null) {
           createPost(route, form_data.serialize());
       } else {
           route = "/posts/" + postId;
           updatePost(route, form_data.serialize(), postId);
       }

       e.preventDefault();
    });

    function blockEditDeleteInclude(postId) {
        var path = window.location.href + "posts/";
        var blockEditDelete = $("<div class='col-md-4 text-right'>" +
            "<div class='btn-group' role='group' aria-label='...'>" +
            "<a href='" + path + postId + "/edit' class='btn btn-warning' data-post-id = '" + postId + "'>Редактировать</a>" +
            "<a href='" + path + postId + "' class='btn btn-danger' data-post-id = '"+ postId +"'>Удалить</a>" +
            "</div>" +
            "</div>");
        return blockEditDelete;
    }

    //Update Post
    function updatePost(route, request, postId) {
        $.ajax({
           type: "PUT",
           url: route,
           data: request,
           success: function (Response) {
               var editedPost = $(".post_list a.btn-warning[data-post-id = " + postId + "]").closest(".post");
               var textArea = $("#post_text");
               editedPost.find("p").text(textArea.val());
               textArea.removeData("post-id");
               textArea.val("");
           }
        });
    }

    //Create Post
    function createPost(route, request){
        $.ajax({
            type: 'POST',
            url: route,
            data: request,
            success: function (Response) {
                console.log(Response);
                var divEditDelete;
                var divContent = $("<div/>",{"class": "col-md-8"})
                    .append("<h4>" + Response.user + "</h4>")
                    .append("<h6>" + Response.date + "</h6>")
                    .append("<p>" + Response.text + "</p>");
                if (Response.user !== "Аноним") {
                    divEditDelete = blockEditDeleteInclude(Response.post_id);
                }
                var divRow = $("<div/>",{"class": "row"})
                    .append(divContent)
                    .append(divEditDelete);

                var divPost = $("<div/>",{"class": "post col-md-12"})
                    .append(divRow).append("<hr>");

                divPost.prependTo(".post_list");

                $("#post_text").val("");
            }
        });
    }

    //Delete Post Action Listener
    $(".post_list").on("click", "a.btn-danger", function (e) {
        var postId = $(this).data("postId");
        var delPost = $(this).closest(".post");
        $.ajax({
            type: "DELETE",
            url: "/posts/" + postId,
            data: postId,
            success: function (Response) {
                delPost.remove();
            }
        });
        e.preventDefault();
    });

    //Edit Post Action Listener
    $(".post_list").on("click", "a.btn-warning" , function (e) {
        var postId = $(this).data("postId");
        $.ajax({
            type: "GET",
            url: "/posts/" + postId + "/edit",
            data: postId,
            success: function (Response) {
                var textArea = $("#post_text");
                textArea.val(Response.text);
                textArea.attr("data-post-id", Response.post_id);
            }
        });
        e.preventDefault();
    });

});
