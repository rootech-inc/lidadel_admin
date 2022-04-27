<?php if($event_stage == 'core'): ?>

<div class="container-fluid h-100 overflow-auto">
    <form id="upload_file_form" method="post" action="backend/process/form.php" enctype="multipart/form-data" class="container-fluid h-100 overflow-hidden p-0">
        <header class="">
            <div class="w-75 px-2 custom_shadow mx-auto h-100 d-flex flex-wrap justify-content-between align-content-center">
                <button class="btn btn-warning btn-sm" onclick="set_session('view=all')" type="button">Cancel</button>
                <button type="submit" class="btn btn-sm btn-primary">SAVE</button>
            </div>
        </header>

        <article class="overflow-auto pt-2">
            <div class="row no-gutters w-75 mx-auto">
                <input type="hidden" name="function" value="general_event_v2">
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

                <div class="container p-0">
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
                </div>

                <div class="container p-0">
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
                </div>
                <hr>


                <!-- OVERVIEW -->
                <div class="card mb-5 w-100">
                    <div class="card-header">
                        <a class="card-link" data-toggle="collapse" href="#event_overview">
                            Overview
                        </a>
                    </div>
                    <div id="event_overview" class="collapse show" data-parent="#accordion">
                        <div class="card-body">
                            <textarea name="details" class="form-control" id="htmeditor"></textarea>
                        </div>
                    </div>
                </div>
                <script src="js/htmeditor.min.js"      htmeditor_textarea="htmeditor"      full_screen="no"      editor_height="350"     run_local="no">
                </script>

                <!-- PACKAGING -->
                <div class="input-group mb-5 shadow bg-primary text-light card">
                    <div class="card-header">
                        Packages
                    </div>
                    <div class="card-body">
                        <p class="">Every package should start on a nre line and separated by column. eg <kbd>kids:200.00</kbd></p>
                        <textarea required autofocus placeholder="package:value" name="packages" id="" required class="form-control rounded-0 custom_shadow" rows="3"><?php echo get_session('description') ?></textarea>
                    </div>
                </div>

                <!-- SCHEDULE -->
                <div class="input-group custom_shadow mb-2 card">
                    <div class="card-header">
                        Schedules
                    </div>
                    <div class="card-body">
                        <p class="text-info">every schedule should be on a new line and details separated by <kbd>:</kbd> eg <i>date:time:location:title:description</i></p></label>
                        <textarea required name="schedule" id="" required class="form-control rounded-0" rows="5"><?php echo get_session('description') ?></textarea>
                    </div>
                </div>

                <!-- COVER IMAGE -->
                <div class="w-75 mx-auto card">
                    <div class="card-header">
                        <strong class="card-title">Cover Image</strong>
                    </div>
                    <div class="card-body">
                        <div class="custom-file mb-2">

                            <input required type="file" accept="image/jpeg" name="cover_image" class="custom-file-input" id="cover_img">
                            <label class="custom-file-label" for="customFile">Choose Cover Image</label>
                        </div>
                        <div class="mx-auto w-75 mb-2">
                            <img id="imgPreview" src="https://via.placeholder.com/150X100/1b3276/F9461D?text=Cover Image" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>


            </div>
        </article>
    </form>
</div>

<?php endif; ?>

<?php if($event_stage === 'secondary'): ?>

    <div class="container-fluid h-100 overflow-auto">
        <form method="post" action="backend/process/form.php" enctype="multipart/form-data" class="container-fluid h-100 overflow-hidden p-0">
            <header class="">
                <div class="w-75 mx-auto h-100 d-flex flex-wrap justify-content-between align-content-end">
                    <button class="btn btn-warning btn-sm" onclick="set_session('event_stage=core')" type="button">BACK</button>

                    <button type="submit" class="btn btn-sm btn-primary">NEXT</button>

                </div>
            </header>

            <article class="overflow-auto">
                <div class="row no-gutters w-50 mx-auto">
                    <input type="hidden" name="function" value="new_event">
                    <!-- PACKAGING -->
                    <div class="input-group mb-5 shadow bg-primary text-light card">
                        <div class="card-header">
                            Packages
                        </div>
                        <div class="card-body">
                            <p class="">Every package should start on a nre line and separated by column. eg <kbd>kids:200.00</kbd></p>
                            <textarea required autofocus placeholder="package:value" name="packages" id="" required class="form-control rounded-0 custom_shadow" rows="3"><?php echo get_session('description') ?></textarea>
                        </div>
                    </div>

                    <!-- PACKAGING -->
                    <div class="input-group custom_shadow mb-2 card">
                        <div class="card-header">
                            Schedules
                        </div>
                        <div class="card-body">
                            <p class="text-info">every schedule should be on a new line and details separated by <kbd>:</kbd> eg <i>date:time:location:title:description</i></p></label>
                            <textarea required name="schedule" id="" required class="form-control rounded-0" rows="5"><?php echo get_session('description') ?></textarea>
                        </div>
                    </div>

                </div>
            </article>
        </form>
    </div>

<?php endif; ?>


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