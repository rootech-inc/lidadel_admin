

function set_session(data)
{
    console.log(data);
    var form_data = {
        'function':'set_session',
        'session_data':data
    }
    $.ajax({
        url: '/backend/process/form.php',
        type: 'POST',
        data: form_data,
        success: function (response) {
            location.reload();
        }
    });

    return false;
}

function reload()
{
    location.reload();
}

function delete_event(event)
{
    $('#loader').modal('show');
    // prepare form data
    var form_data = {
        'function':'delete_event',
        'event':event
    }

    // send ajax request
    $.ajax({
        url: '/backend/process/form.php',
        type: 'POST',
        data: form_data,
        success: function (response) {
            location.reload();
        }
    });
}

$(function() {
    //hang on event of form with id=myform
    $("#text_form").submit(function(e) {

        var loading = "<button class=\"btn btn-primary w-100 h-100\" disabled>\n" +
            "  <span class=\"spinner-grow spinner-grow-sm\"></span>\n" +
            "  Processing Request..\n" +
            "</button>";

        //prevent Default functionality
        e.preventDefault();

        //get the action-url of the form
        var actionurl = e.currentTarget.action;
        var formData = $("#text_form").serialize();
        // console.log(actionurl)

        //do your own request an handle the results
        console.log('ajax ahead');
        $('#text_form').html(loading);
        $.ajax({
            url: actionurl,
            type: 'POST',
            data: formData,
            success: function (response)
            {

                console.log(response);

                // split response
                var response_type = response.split('%%');
                //console.log(response_type.length)
                if(response_type.length > 1)
                {
                    var action = response_type[0];
                    var message = response_type[1];
                    // console.log(action)
                    switch (action) {
                        case 'done':
                            // reload
                            reload();
                            break;
                        case 'book':
                            var sh = "<div class='alert alert-success text-center p-5 m-0'>" +
                                "<strong class='m-0'>Booking Successful</strong>" +
                                "<p class='m-0'>Our response team will contact you soon</p>" +
                                "</div>";
                            $('#text_form').html(sh);
                            $('#text_form').addClass('p-0 m-0');
                            setTimeout(function(){
                                $('#book').modal('hide');
                            }, 3000)
                            break;
                        case 'book_err':
                            var sh = "<div class='alert alert-danger text-center p-5 m-0'>" +
                                "<strong class='m-0'>System Busy</strong>" +
                                "<p class='m-0'>Sorry your request can't be processed now, please contact out office for suppurt</p>" +
                                "</div>";
                            $('#text_form').html(sh);
                            $('#text_form').addClass('p-0 m-0');
                            setTimeout(function(){
                                $('#book').modal('hide');
                            }, 5000)
                            break;
                        case 'err':
                            $('#form_err').text(message.toString());
                            // show error
                            break;
                        default:
                            reload()
                            // reload
                    }
                }

            }
        });

    });

});

// login form
$(function() {
    //hang on event of form with id=myform
    $("#login_form").submit(function(e) {



        //prevent Default functionality
        e.preventDefault();

        //get the action-url of the form
        var actionurl = e.currentTarget.action;
        var formData = $("#login_form").serialize();
        // console.log(actionurl)

        //do your own request an handle the results
        console.log('ajax ahead');
        $.ajax({
            url: actionurl,
            type: 'POST',
            data: formData,
            success: function (response)
            {

                console.log(response);
                // split response
                var r_split = response.split('%%');

                if(r_split.length > 1) {
                    var action = r_split[0];
                    var message = r_split[1];

                    if(action === 'err')
                    {
                        $('#login_err').text(message);
                    }

                    if(action === 'done')
                    {
                        location.reload()
                    }

                }


            }
        });

    });

});

// upload file
$(function() {
    //hang on event of form with id=myform
    $("#upload_file_form").submit(function(e) {


        $("#loader").modal("show");


        //prevent Default functionality
        e.preventDefault();
        //get the action-url of the form
        var actionurl = e.currentTarget.action;
        var formData = new FormData($(this).parents('form')[0]);

        var formData = new FormData($('#upload_file_form')[0]); // The form with the file inputs.
        var that = $(this),
            url = that.attr('action'),
            type = that.attr('method'),
            data = {};
         console.log(url)

        that.find('[name]').each(function (index,value){
            var that = $(this),
                name = that.attr('name'),
                value = that.val();
            data[name] = value;
        });

        $.ajax({

            xhr: function() {
                var progress = $('.progress'),
                    xhr = $.ajaxSettings.xhr();

                progress.show();

                xhr.upload.onprogress = function(ev) {
                    if (ev.lengthComputable) {
                        var percentComplete = parseInt((ev.loaded / ev.total) * 100);
                        progress.val(percentComplete);
                        if (percentComplete === 100) {
                            progress.hide().val(0);
                        }
                    }
                };

                return xhr;
            },

            url: url,
            type: type,
            data: formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success: function (response){
                // split response
                console.log(response)
                var response_type = response.split('%%');
                //console.log(response_type.length)
                if(response_type.length > 1)
                {
                    console.log(response)
                    var action = response_type[0];
                    var message = response_type[1];
                    console.log(action)
                    switch (action) {
                        case 'done':
                            // reload
                            reload();
                            break;
                        case 'err':
                            if (message === 'submit_again')
                            {
                                // submit form again
                                console.log('submit again')
                                $('form#upload_file_form').submit();
                            }
                            else
                            {
                                $('#form_err').text(message.toString());
                                // show error
                            }

                            break;
                        default:
                            //reload()
                        // reload
                    }
                }
            },

        });

        return false;

    });

});

// make book
function book(package)
{
    document.getElementById('booking_package').value = package;

    // show modal
    $('#book').modal('show');
}

// logout


$(document).ready(function() {
    $("#logout").click(function(){

        // form data
        var form_data = {
            'function':'logout'
        }

        // prepare ajax
        $.ajax(
            {
                url:'/backend/process/form.php',
                type: 'POST',
                data: form_data,
                success: function (response) {
                    location.reload()
                }
            }
        );

    });
});




