<div class="w-100 h-100 d-flex flex-wrap align-content-center justify-content-center">
    <div class="w-50 card shadow-lg">
        <div class="card-header">
            <strong class="card-title">Select Event Images</strong>
        </div>

        <div class="card-body p-5">
            <form id="upload_file_form" action="backend/process/form.php" method="post" enctype="multipart/form-data">
                <p>Strictly JPEG images only</p>
                <input type="hidden" name="function" value="upload_images_after">
                <div class="custom-file">
                    <input name="gall_images[]" required multiple="multiple" accept="image/jpeg" type="file" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose Files</label>
                </div>

                <div class="mt-2 d-flex flex-wrap justify-content-between">
                    <button onclick="set_session('view=all')" class="w-25 btn btn-warning rounded-0" type="button">CANCEL</button>
                    <button class="w-25 btn btn_brand rounded-0" type="submit">UPLOAD</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>