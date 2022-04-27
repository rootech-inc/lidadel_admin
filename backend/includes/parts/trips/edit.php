<div class="container-fluid p-0 h-100 overflow-hidden">
    <form id="upload_file_form" class="row no-gutters h-100 overflow-hidden" method="post" action="backend/process/form.php" enctype="multipart/form-data">
        <input type="hidden" name="function" value="update_event_v2">

        <header class="">
            <div class="w-75 px-2 custom_shadow mx-auto h-100 d-flex flex-wrap justify-content-between align-content-center">
                <button class="btn btn-warning btn-sm" onclick="set_session('view=all')" type="button">Cancel</button>
                <button type="submit" class="btn btn-sm btn-primary">SAVE</button>
            </div>
        </header>

        <article class="overflow-auto pt-2">
            <div class="row no-gutters w-75 mx-auto">
                <input type="hidden" name="function" value="update_event_v2">
                <!-- TITLE -->
                <div class="input-group mb-2">
                    <label for="" class="w-100 text_brand">Title</label><input required autofocus autocomplete="off" value="<?php echo $event['title'] ?>" type="text" class="form-control form-control-sm rounded-0" name="title" id="">
                </div>

                <!-- COUNTRY CITY -->
                <div class="container-fluid mb-2 p-0">
                    <div class="row no-gutters">
                        <!-- COUNTRY -->
                        <div class="col-sm-6 pr-1">
                            <label class="w-100 text_brand">Country
                                <input type="text" value="<?php echo $event['country'] ?>" required class="form-control form-control-sm rounded-0" name="country">
                            </label>
                        </div>
                        <!-- CITY -->
                        <div class="col-sm-6 pl-1">
                            <label class="w-100 text_brand">City
                                <input type="text" value="<?php echo $event['city'] ?>"  required class="form-control form-control-sm rounded-0" name="city">
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
                                <input type="number" value="<?php echo $event['group_size'] ?>"  min="1" required class="form-control form-control-sm rounded-0" name="group_size">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="container p-0">
                    <div class="row mb-2 no-gutters">
                        <div class="col-sm-7 pr-1">
                            <label class="w-100 text_brand">Start Date
                                <input type="date" value="<?php echo $event['start_date'] ?>" name="star_date" class="form-control rounded-0" required>
                            </label>
                        </div>

                        <div class="col-sm-5 pl-1">
                            <label class="w-100 text_brand">Start Time
                                <input type="time" value="<?php echo $event['start_time'] ?>" id="time" name="star_time" class="form-control rounded-0" required>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="container p-0">
                    <div class="row no-gutters">
                        <div class="col-sm-7 pr-1">
                            <label class="w-100 text_brand">End Date
                                <input type="date" value="<?php echo $event['end_date'] ?>" name="end_date" class="form-control rounded-0" required>
                            </label>
                        </div>

                        <div class="col-sm-5 pl-1">
                            <label class="w-100 text_brand">End Time
                                <input type="time" value="<?php echo $event['end_time'] ?>" name="end_time" class="form-control rounded-0" required>
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
                            <textarea name="details" class="form-control" id="htmeditor"><?php echo base64_decode($event['overview'] )?></textarea>
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
                        <p >Every package should start on a nre line and separated by column. eg <kbd>kids:200.00</kbd></p>
                        <textarea required autofocus placeholder="package:value" name="packages" id="" required class="form-control rounded-0 custom_shadow" rows="3"><?php while ($pack = $package->fetch(PDO::FETCH_ASSOC)): ?><?php echo $pack['target'] . ':' . $pack['value'] ?><?php endwhile; ?></textarea>
                    </div>
                </div>

                <!-- SCHEDULE -->
                <div class="input-group custom_shadow mb-2 card">
                    <div class="card-header">
                        Schedules
                    </div>
                    <div class="card-body">
                        <label><p class="text-info">every schedule should be on a new line and details separated by <kbd>^</kbd> eg <br> <kbd>date ^ time ^ location ^ title ^ description</kbd></p></label>
                        <textarea required name="schedule" id="" required class="form-control rounded-0" rows="5"><?php while ($sch = $schedule->fetch(PDO::FETCH_ASSOC)): ?><?php echo $sch['date'] . '^' . $sch['time'] . '^' . $sch['title'] . '^' . $sch['location'] . '^' . $sch['description'] ?><?php endwhile; ?>

                        </textarea>
                    </div>
                </div>

                <!-- COVER IMAGE -->
                <div class="w-75 mx-auto card">
                    <div class="card-header">
                        <strong class="card-title">Cover Image</strong>
                    </div>
                    <div class="card-body">
                        <div class="custom-file mb-2">

                            <input type="file" accept="image/jpeg" name="cover_image" class="custom-file-input" id="cover_img">
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