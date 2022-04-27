<header class="d-flex flex-wrap c_header pl-2 align-content-center">
    <div class="w-100 h-100 d-flex flex-wrap justify-content-between align-content-center p-2">
        <strong>Youtube Video Links</strong>
        <button data-toggle="modal" data-target="#newLink" class="btn btn-sm btn_brand rounded-0">
            New Video
        </button>

        <div class="modal fade" id="newLink">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <strong class="modal-title">New Youtube Link</strong>
                    </div>
                    <div class="modal-body">
                        <form action="backend/process/form.php" method="post" id="upload_file_form">
                            <input type="hidden" name="function" value="youtube_link" id="upload_file_form">
                            <label class="w-100">Title
                                <input name="title" type="text" required class="form-control">
                            </label>
                            <label class="w-100">Video Link
                                <input name="link" type="url" required class="form-control">
                            </label>

                            <button type="submit" class="btn btn-success rounded-0 w-100">SAVE</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>