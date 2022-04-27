<?php if($service === 'all')

{ ?>
        <header class="c_header">
            <div class="w-100 pl-2 pr-2 h-100 d-flex flex-wrap align-content-center">
                <button onclick="set_session('service=new')" class="btn btn-sm btn_brand rounded-0">New Service</button>
            </div>
        </header>
        <article>
            <div class="w-100 h-100 overflow-auto container-fluid p-0">
                <div class="row no-gutters">
                    <?php while ($srv = $services->fetch(PDO::FETCH_ASSOC)):
                        $id = $srv['id'];
                        $desc = $srv['description'];
                    ?>
                        <div class="col-sm-4 p-1">
                            <div onclick="set_session('service=single,srv=<?php echo $id ?>')" class="card util_btn shadow-sm p-1">
                                <img src="" alt="" class="card-img">
                                <div class="card-body p-2">
                                    <strong class="card-text"><?php echo $srv['title'] ?></strong>
                                    <p class="card-text m-0 ellipsis_2">
                                        <?php echo $desc ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </article>
<?php }

elseif ($service === 'new') { ?>

    <div class="w-100 h-100 d-flex flex-wrap align-content-center justify-content-center">
        <div class="card w-50 shadow-lg">
            <div class="card-header">
                <strong class="card-title">Adding New Service</strong>
            </div>
            <form id="upload_file_form" method="post" enctype="multipart/form-data" action="backend/process/form.php" class="card-body p-2">
                <input type="hidden" name="function" value="add_service">
                <!-- -->
                <span>Select Service Cover Image</span>
                <div class="custom-file mb-2 rounded-0">
                    <input type="file" name="cover_image" required class="custom-file-input rounded-0" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>



                <!-- TITLE -->
                <div class="input-group mb-2">
                    <label class="w-100">Title
                        <input type="text" required name="title" class="form-control rounded-0">
                    </label>
                </div>

                <div class="input-group mb-2">

                    <label class="w-100" for="description">Description</label><textarea name="description" id="description" class="form-control rounded-0" rows="5"></textarea>

                </div>

                <div class="w-100 text-center">
                    <button class="btn btn_brand rounded-0">SUBMIT</button>
                </div>

                <script>
                    // Add the following code if you want the name of the file appear on select
                    $(".custom-file-input").on("change", function() {
                        var fileName = $(this).val().split("\\").pop();
                        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                    });
                </script>

            </form>
        </div>
    </div>

<?php }

elseif ($service === 'single'){ ?>

    <div class="w-100 h-100">
        <header>
            <div class="card-header">
                <strong class="card-title">Editing <?php echo $srv['title'] ?></strong>
            </div>
        </header>
        <article class="d-flex flex-wrap align-content-center justify-content-center">
            <div class="card w-75 shadow-lg">

                <form id="upload_file_form" method="post" enctype="multipart/form-data" action="backend/process/form.php" class="card-body p-2">
                    <input type="hidden" name="function" value="edit_service">
                    <input type="hidden" name="image" value="<?php echo $srv['img'] ?>">
                    <!-- -->
                    <span>Select Service Cover Image</span>
                    <div class="custom-file mb-2 rounded-0">
                        <input type="file" name="cover_image" class="custom-file-input rounded-0" id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>



                    <!-- TITLE -->
                    <div class="input-group mb-2">
                        <label class="w-100">Title
                            <input type="text" required name="title" value="<?php echo $srv['title'] ?>" class="form-control rounded-0">
                        </label>
                    </div>

                    <div class="input-group mb-2">
                        <label class="w-100" for="">Description</label><textarea name="description" id="description" class="form-control rounded-0" rows="5" required><?php echo html_entity_decode(base64_decode($srv['description'] ))?></textarea>

                    </div>

                    <div class="w-100 text-center">
                        <button class="btn btn_brand rounded-0">SUBMIT</button>
                    </div>

                    <script>
                        // Add the following code if you want the name of the file appear on select
                        $(".custom-file-input").on("change", function() {
                            var fileName = $(this).val().split("\\").pop();
                            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                        });
                    </script>

                </form>
            </div>
        </article>
    </div>

<?php } ?>
