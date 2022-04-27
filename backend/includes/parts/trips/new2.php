<div class="container-fluid p-0 h-100 overflow-hidden">
    <form id="upload_file_form" class="row no-gutters h-100 overflow-hidden" method="post" action="backend/process/form.php" enctype="multipart/form-data">
        <input type="hidden" name="function" value="general_event_v2">
        <!-- TODO Test event against ajax insert -->
        <!-- EVENT DESCRIPTION -->
        <div class="col-sm-4 p-2 overflow-auto">

            <div class="card custom_shadow">
                <div class="card-body">
                    <div class="w-100 h-100 d-flex flex-wrap align-content-between">

                        <!-- TITLE -->
                        <div class="input-group mb-2">
                            <label for="" class="w-100 text_brand">Title</label><input required autofocus autocomplete="off" value="<?php echo get_session('title') ?>" type="text" class="form-control form-control-sm rounded-0" name="title" id="">
                        </div>

                        <!-- COUNTRY CITY -->
                        <div class="container-fluid mb-2 p-0">
                            <div class="row no-gutters">
                                <!-- COUNTRY -->
                                <div class="col-sm-6 pr-1">
                                    <label class="w-100 text_brand">Country
                                        <input type="text" required class="form-control form-control-sm rounded-0" name="country">
                                    </label>
                                </div>
                                <!-- CITY -->
                                <div class="col-sm-6 pl-1">
                                    <label class="w-100 text_brand">City
                                        <input type="text" required class="form-control form-control-sm rounded-0" name="city">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- TYPE && GROUP SIZE -->
                        <div class="container-fluid mb-2 p-0">
                            <div class="row no-gutters">
                                <!-- COUNTRY -->
                                <div class="col-sm-6 pr-1">
                                    <label class="w-100 text_brand">Type
                                        <select required class="form-control form-control-sm rounded-0" name="type" id="">
                                            <option>Adventure</option>
                                            <option>Travel</option>
                                            <option>Vacation</option>
                                        </select>
                                    </label>
                                </div>
                                <!-- CITY -->
                                <div class="col-sm-6 pl-1">
                                    <label class="w-100 text_brand">Group Size
                                        <input type="number" min="1" required class="form-control form-control-sm rounded-0" name="group_size">
                                    </label>
                                </div>
                            </div>
                        </div>


                        <!-- DESCRIPTION -->
<!--                        <div class="input-group mb-2">-->
<!--                            <label for="" class="w-100 text_brand">Description</label>-->
<!--                            <textarea name="description" id="" required class="form-control rounded-0" rows="5">--><?php //echo get_session('description') ?><!--</textarea>-->
<!--                        </div>-->
<!--                        <hr>-->

                        <div class="row mb-2 no-gutters">
                            <div class="col-sm-7 pr-1">
                                <label class="w-100 text_brand">Start Date
                                    <input type="date" name="star_date" min="<?php echo date('Y-m-d'); ?>" class="form-control rounded-0" required>
                                </label>
                            </div>

                            <div class="col-sm-5 pl-1">
                                <label class="w-100 text_brand">Start Time
                                    <input type="time" id="time" name="star_time" class="form-control rounded-0" required>
                                </label>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-sm-7 pr-1">
                                <label class="w-100 text_brand">End Date
                                    <input type="date" name="end_date" min="<?php echo date('Y-m-d'); ?>" class="form-control rounded-0" required>
                                </label>
                            </div>

                            <div class="col-sm-5 pl-1">
                                <label class="w-100 text_brand">End Time
                                    <input type="time" name="end_time" class="form-control rounded-0" required>
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

                <div class="card-body">
                    <div class="w-100 d-flex flex-wrap align-content-between">
                        <!-- OVERVIEW -->
                        <div class="input-group mb-2">
                            <label for="" class="w-100 text_brand">Overview <br> <span class="text-info">use <kbd>%~</kbd> and <kbd>~%</kbd> to start and close a list respectively</span></label>
                            <textarea name="overview" id="" required class="form-control rounded-0" rows="3"><?php echo get_session('description') ?></textarea>
                        </div>

                        <!-- HIGHLIGHTS -->
                        <div class="input-group mb-2">
                            <label for="" class="w-100 text_brand">Highlights <br> <span class="text-info">Every highlight should be on a new line</span></label>
                            <textarea name="highlights" id="" required class="form-control rounded-0" rows="3"><?php echo get_session('highlights') ?></textarea>
                        </div>

                        <!-- SCHEDULES -->
                        <div class="input-group mb-2">
                            <label for="" class="w-100 text_brand">Schedule <br>
                                <span class="text-info">every schedule should be on a new line and details separated by <kbd>:</kbd> eg <i>date:time:location:title:description</i></span></label>
                            <textarea name="schedule" id="" required class="form-control rounded-0" rows="2"><?php echo get_session('description') ?></textarea>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- EVENT FILES -->
        <div class="col-sm-4 p-2 h-100 overflow-auto">



            <div class="card custom_shadow">
                <div class="card-body">
                    <div class="w-100 d-flex flex-wrap align-content-between">

                        <div class="w-100">

                            <!-- PACKAGING -->
                            <div class="input-group mb-2">
                                <label for="" class="w-100 text_brand">
                                    Overview <br>
                                    <span class="text-info">Every package should start on a nre line and separated by column. eg <kbd>kids:200.00</kbd></span>
                                </label>
                                <textarea name="packages" id="" required class="form-control rounded-0" rows="3"><?php echo get_session('description') ?></textarea>
                            </div>




                            <div class="custom-file mb-2">

                                <input required type="file" accept="image/jpeg" name="cover_image" class="custom-file-input" id="cover_img">
                                <label class="custom-file-label" for="customFile">Choose Cover Image</label>
                            </div>
                            <div class="mx-auto w-75 mb-2">
                                <img id="imgPreview" src="https://via.placeholder.com/150X100/1b3276/F9461D?text=Cover Image" alt="" class="img-fluid">
                            </div>
                        </div>

                        <div class="text-center w-100">
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