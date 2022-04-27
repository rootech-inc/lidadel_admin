<div class="container-fluid p-2 h-100 custom_shadow overflow-hidden">
    <form id="upload_file_form" class="row no-gutters h-100 overflow-hidden" method="post" action="backend/process/form.php" enctype="multipart/form-data">
        <input type="hidden" name="function" value="update_event">
        <!-- EVENT DESCRIPTION -->
        <div class="col-sm-4 p-2 h-100 overflow-auto">

            <div class="card h-100 custom_shadow">
                <div class="card-header">
                    <strong class="card-title">
                        Event Description
                    </strong>
                </div>
                <div class="card-body">
                    <div class="w-100 h-100 d-flex flex-wrap align-content-between">

                        <!-- TITLE -->
                        <div class="input-group mb-2">
                            <label for="" class="w-100 text_brand">Title</label><input required autofocus autocomplete="off" value="<?php echo $event['title'] ?>" type="text" class="form-control rounded-0" name="title" id="">
                        </div>

                        <!-- DESCRIPTION -->
                        <div class="input-group mb-2">
                            <label for="" class="w-100 text_brand">Description</label>
                            <textarea name="description" id="" required class="form-control rounded-0" rows="5"><?php echo $event['description']  ?></textarea>
                        </div>
                        <hr>

                        <div class="row mb-2 no-gutters">
                            <div class="col-sm-7 pr-1">
                                <label class="w-100 text_brand">Start Date
                                    <input type="date" name="star_date" value="<?php echo $event['start_date'] ?>" class="form-control rounded-0" required>
                                </label>
                            </div>

                            <div class="col-sm-5 pl-1">
                                <label class="w-100 text_brand">Start Time
                                    <input type="time" name="star_time" value="<?php echo $event['start_time'] ?>"  class="form-control rounded-0" required>
                                </label>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-sm-7 pr-1">
                                <label class="w-100 text_brand">End Date
                                    <input type="date" name="end_date" value="<?php echo $event['end_date'] ?>"  class="form-control rounded-0" required>
                                </label>
                            </div>

                            <div class="col-sm-5 pl-1">
                                <label class="w-100 text_brand">End Time
                                    <input type="time" name="end_time" value="<?php echo $event['end_time'] ?>"  class="form-control rounded-0" required>
                                </label>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>

        </div>

        <!-- EVENT PACKAGES -->
        <div class="col-sm-4 p-2 h-100 overflow-auto">

            <div class="card h-100 custom_shadow">
                <div class="card-header">
                    <strong class="card-title">
                        Event Packages
                    </strong>
                </div>
                <div class="card-body">
                    <div class="w-100 h-100 d-flex flex-wrap align-content-between">
                        <!-- ADULTS -->
                        <div class="h-25 w-100 card shadow-sm">
                            <div class="card-header">
                                <span class="card-title">Adult</span>
                            </div>
                            <div class="card-body p-1">
                                <input value="<?php if(strlen((string)$adult_value) > 0){echo $adult_value; } ?>" type="number" step="any" name="adult" class="form-control h-100 font-weight-bolder" placeholder="amount for adults" required>
                            </div>
                        </div>

                        <!-- COUPLE -->
                        <div class="h-25 w-100 card shadow-sm">
                            <div class="card-header">
                                <span class="card-title">Couple</span>
                            </div>
                            <div class="card-body p-1">
                                <input value="<?php if(strlen((string)$couple_value) > 0){echo $couple_value; } ?>" type="number" step="any" name="couple" class="form-control h-100 font-weight-bolder" placeholder="amount for couple">
                            </div>
                        </div>

                        <!-- KIDS -->
                        <div class="h-25 w-100 card shadow-sm">
                            <div class="card-header">
                                <span class="card-title">Kids</span>
                            </div>
                            <div class="card-body p-1">
                                <input value="<?php if(strlen((string)$kids_value) > 0){echo $kids_value; } ?>" type="number" step="any" name="kids" class="form-control h-100 font-weight-bolder" placeholder="amount for kids">
                            </div>
                        </div>

                        <hr>
                    </div>
                </div>
            </div>

        </div>

        <!-- EVENT FILES -->
        <div class="col-sm-4 p-2 h-100 overflow-auto">



            <div class="card h-100 custom_shadow">
                <div class="card-header">
                    <strong class="card-title">
                        Event Medias
                    </strong>
                </div>
                <div class="card-body">
                    <div class="w-100 h-100 d-flex flex-wrap align-content-between">

                        <div class="w-100">



                            <div class="custom-file">

                                <input type="file" accept="image/jpeg" name="cover_image" class="custom-file-input" id="cover_img">
                                <label class="custom-file-label" for="customFile">Choose Cover Image</label>
                            </div>
                            <div class="mx-auto mt-2">
                                <img id="imgPreview" src="https://via.placeholder.com/150X100/1b3276/F9461D?text=Cover Image" alt="" class="img-fluid">
                            </div>
                        </div>

                        <div class="text-center w-100 d-flex flex-wrap justify-content-between">
                            <button type="button" onclick="set_session('view=all')" class="btn btn_brand_danger rounded-0">Cancel</button>
                            <button type="submit" class="btn btn_brand rounded-0">Finish</button>
                            <div class="modal fade" id="loader">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-2 py-5 pb-2">
                                            <div class="spinner-grow text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <div class="spinner-grow text-secondary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <div class="spinner-grow text-success" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <div class="spinner-grow text-danger" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <div class="spinner-grow text-warning" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <div class="spinner-grow text-info" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <div class="spinner-grow text-light" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <div class="spinner-grow text-dark" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>

                                            <hr>
                                            <div id="msg" class="text-center">LOADING...</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </form>
</div>

<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $(document).ready(() => {
        $("#cover_img").change(function () {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $("#imgPreview")
                        .attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });

</script>