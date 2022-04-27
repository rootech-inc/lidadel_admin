<div class="container-fluid p-0 h-100 overflow-hidden">
    <form id="upload_file_form" class="row no-gutters h-100 overflow-hidden" method="post" action="backend/process/form.php" enctype="multipart/form-data">
        <input type="hidden" name="function" value="update_event_v2">
        <!-- TODO Test event against ajax insert -->
        <!-- EVENT DESCRIPTION -->
        <div class="col-sm-4 p-2 overflow-auto">

            <div class="card custom_shadow">
                <div class="card-body">
                    <div class="w-100 h-100 d-flex flex-wrap align-content-between">

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
                                        <input value="<?php echo $event['city'] ?>" type="text" required class="form-control form-control-sm rounded-0" name="city">
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
                                            <option ><?php echo $event['type'] ?></option>
                                            <option>Adventure</option>
                                            <option>Travel</option>
                                            <option>Vacation</option>
                                        </select>
                                    </label>
                                </div>
                                <!-- CITY -->
                                <div class="col-sm-6 pl-1">
                                    <label class="w-100 text_brand">Group Size
                                        <input type="number" value="<?php echo $event['group_size'] ?>" min="1" required class="form-control form-control-sm rounded-0" name="group_size">
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
                                    <input type="date" value="<?php echo $event['start_date'] ?>" name="star_date" class="form-control rounded-0" required>
                                </label>
                            </div>

                            <div class="col-sm-5 pl-1">
                                <label class="w-100 text_brand">Start Time
                                    <input type="time" value="<?php echo $event['start_time'] ?>" id="time" name="star_time" class="form-control rounded-0" required>
                                </label>
                            </div>
                        </div>
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
                            <label for="" class="w-100 text_brand text_sm">Overview <br> <span class="text-info">use <kbd>%~</kbd> and <kbd>~%</kbd> to start and close a list respectively</span></label>
                            <textarea name="overview" id="" required class="form-control rounded-0 text_sm" rows="9"><?php echo $event['overview'] ?></textarea>
                        </div>

                        <!-- HIGHLIGHTS -->
                        <div class="input-group mb-2">
                            <label for="" class="w-100 text_brand text_sm">Highlights <br> <span class="text-info">Every highlight should be on a new line</span></label>
                            <textarea name="highlights" id="" required class="form-control rounded-0 text_sm" rows="9"><?php
                                while ($light = $highlight->fetch(PDO::FETCH_ASSOC))
                                {
                                    echo $light['light'];
                                }
                                ?></textarea>
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

                            <!-- SCHEDULES -->
                            <div class="input-group mb-2">
                                <label for="" class="w-100 text_brand">Schedule <br>
                                    <span class="text-info">every schedule should be on a new line and details separated by <kbd>:</kbd> eg <i>date:time:location:title:description</i></span></label>
                                <textarea name="schedule" id="" required class="form-control rounded-0 text_sm" rows="5"><?php
                                    while ($sch = $schedule->fetch(PDO::FETCH_ASSOC))
                                    {
                                        echo $sch['date']."/".$sch['time']."/".$sch['location'].'/'.$sch['title'].'/'.$sch['description'];
                                    }
                                    ?></textarea>
                            </div>


                            <!-- PACKAGING -->
                            <div class="input-group mb-2">
                                <label for="" class="w-100 text_brand">
                                    Package <br>
                                    <span class="text-info text_sm">Every package should start on a nre line and separated by column. eg <kbd>kids:200.00</kbd></span>
                                </label>
                                <textarea name="packages" id="" required class="form-control rounded-0 text_sm" rows="5"><?php
                                    while ($pack = $package->fetch(PDO::FETCH_ASSOC))
                                    {
                                        echo $pack['target'].':'.$pack['value'];
                                    }
                                    ?></textarea>
                            </div>




                            <div class="custom-file mb-2">

                                <input type="file" accept="image/jpeg" name="cover_image" class="custom-file-input" id="cover_img">
                                <label class="custom-file-label" for="customFile">Choose Cover Image</label>
                            </div>
                        </div>

                        <div class="text-center w-100">
                            <button type="submit" class="btn btn_brand_danger rounded-0">UPDATE</button>
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