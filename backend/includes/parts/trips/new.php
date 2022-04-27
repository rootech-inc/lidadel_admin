<header class="d-flex flex-wrap c_header pl-2 pr-2 align-content-center justify-content-between">
    <strong>New Trip</strong>
    <i id="form_err" class="text_brand_danger">Strictly JPG Images only</i>
</header>
<article class="">
    <div class="container-fluid d-flex flex-wrap align-content-center justify-content-center p-2 h-100">


        <?php if($stage == 'text'): ?>

            <form id="text_form" action="backend/process/form.php" method="POST" class="w-75 p-2 shadow-lg">

            <input type="hidden" name="function" value="event_text">
            <!-- TITLE -->
            <div class="input-group mb-2">
                <label for="" class="w-100 text_brand">Title</label><input required autofocus autocomplete="off" value="<?php echo get_session('title') ?>" type="text" class="form-control rounded-0" name="title" id="">
            </div>

            <!-- DESCRIPTION -->
            <div class="input-group mb-2">
                <label for="" class="w-100 text_brand">Description</label>
                <textarea name="description" id="" required class="form-control rounded-0" rows="5"><?php echo get_session('description') ?></textarea>
            </div>
            <hr>
            
            <div class="row mb-2 no-gutters">
                <div class="col-sm-7 pr-1">
                    <label class="w-100 text_brand">Start Date
                        <input type="date" name="star_date" class="form-control rounded-0" required>
                    </label>
                </div>

                <div class="col-sm-5 pl-1">
                    <label class="w-100 text_brand">Start Time
                        <input type="time" name="star_time" class="form-control rounded-0" required>
                    </label>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-sm-7 pr-1">
                    <label class="w-100 text_brand">End Date
                        <input type="date" name="end_date" class="form-control rounded-0" required>
                    </label>
                </div>

                <div class="col-sm-5 pl-1">
                    <label class="w-100 text_brand">End Time
                        <input type="time" name="end_time" class="form-control rounded-0" required>
                    </label>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <button type="submit" class="btn btn_brand rounded-0">NEXT</button>
            </div>
        </form>

        <?php endif; ?>

        <?php if($stage == 'packages'): ?>

            <form id="text_form" action="backend/process/form.php" method="POST" class="w-75 p-2 shadow-lg">

                <input type="hidden" name="function" value="packages">
                <p class="font-weight-bolder">Packages</p>
                <hr>

                <table class="table table-info table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th>Package</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <span class="fa fa-male"></span> | <span class="fa fa-female"></span> Adult
                        </td>
                        <td>
                            <input type="number" value="<?php echo get_session('adult') ?>" step="any" required class="form-control form-control-sm rounded-0" autocomplete="off" name="adult">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="fa fa-rings-wedding"></span> Couple
                        </td>
                        <td>
                            <input type="number" value="<?php echo get_session('couple') ?>" step="any" class="form-control form-control-sm rounded-0" autocomplete="off" name="couple">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="fa fa-child"></span> Kids
                        </td>
                        <td>
                            <input type="number" value="<?php echo get_session('kids') ?>" step="any" class="form-control form-control-sm rounded-0" autocomplete="off" name="kids">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <hr>

                <div class="d-flex flex-wrap align-content-center justify-content-between">
                    <button onclick="set_session('stage=text')" class="w-45 btn btn_brand_danger rounded-0 fa fa-arrow-alt-circle-left" type="button"> Go Back</button>
                    <button class="w-45 btn btn_brand rounded-0" type="submit">Next <span class="fa fa-arrow-alt-circle-right"></span></button>

                </div>
            </form>

        <?php endif; ?>

        <?php if($stage == 'media'): ?>
            <form action="backend/process/form.php" enctype="multipart/form-data" method="POST" class="w-75 p-2 shadow-lg">
                <input type="hidden" name="function" value="media">
                <div class="row no-gutters mb-4">
                    <div class="col-sm-6 p-2 d-flex flex-wrap align-content-center">
                        <div class="custom-file">

                            <input required type="file" accept="image/jpeg" name="cover_image" class="custom-file-input" id="cover_img">
                            <label class="custom-file-label" for="customFile">Choose Cover Image</label>
                        </div>

                    </div>

                    <div class="col-sm-6 custom_shadow p-2">

                        <div class="mx-auto">
                            <img id="imgPreview" src="https://via.placeholder.com/150X100/1b3276/F9461D?text=Cover Image" alt="" class="img-fluid">
                        </div>

                    </div>

                </div>

                <!-- Gallery Images -->
                <div class="mb-4">

                    <div class="custom-file">
                        <input required type="file" multiple="multiple" accept="image/jpeg" name="gall_images[]" class="custom-file-input" id="file[]">
                        <label class="custom-file-label" for="customFile">Choose Images for gallery</label>
                    </div>
                </div>


                <div class="d-flex flex-wrap align-content-center justify-content-between">
                    <button onclick="set_session('stage=packages')" class="w-45 btn btn_brand_danger rounded-0 fa fa-arrow-alt-circle-left" type="button"> Go Back</button>
                    <button class="w-45 btn btn_brand rounded-0" type="submit">Finish <span class="fa fa-arrow-alt-circle-right"></span></button>

                </div>


            </form>
        <?php endif; ?>

    </div>
</article>

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