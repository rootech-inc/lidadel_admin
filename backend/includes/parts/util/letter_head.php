<?php if($letter_head === 'select'){ ?>

    <div class="container-fluid h-100">
        <div class="row no-gutters h-100 d-flex flex-wrap align-content-center justify-content-center">
            <div class="col-sm-2 p-2">
                <div onclick="set_session('letter_head=formal')" class="util_btn custom_shadow pointer d-flex flex-wrap align-content-center justify-content-center">
                    Formal Letter
                </div>
            </div>
            <div class="col-sm-2 p-2">
                <div onclick="set_session('letter_head=notice')" class="util_btn custom_shadow pointer d-flex flex-wrap align-content-center justify-content-center">
                    Notice
                </div>
            </div>
        </div>
    </div>

<?php } elseif ($letter_head === 'formal') { ?>

    <div class="w-100 h-100 d-flex flex-wrap align-content-center justify-content-center">
        <iframe src="assets/utils/letter_head/formal.pdf" width="100%" height="100%">
        </iframe>
    </div>

<?php } elseif ($letter_head === 'notice') { ?>

    <div class="w-100 h-100 d-flex flex-wrap align-content-center justify-content-center">
        <iframe src="assets/utils/letter_head/formal.pdf" width="100%" height="100%">
        </iframe>
    </div>

<?php }
