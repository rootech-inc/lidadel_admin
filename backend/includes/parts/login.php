<div class="w-100 bg_brand">
    <div class="container" style="height: 100vh">
        <div class="row h-100 no-gutters d-flex flex-wrap align-content-center justify-content-center">

            <div class="col-sm-4">
                <form id="login_form" method="post" action="backend/process/form.php" class="card p-5 text-dark">

                    <input type="hidden" name="function" value="login">

                    <div class="w-20 mb-3 mx-auto">
                        <img
                                src="assets/icons/bank.png"
                                class="img-fluid"
                        >
                    </div>

                    <div class="d-flex flex-wrap align-content-center justify-content-center" style="height: 40px">
                        <p class="text-center font-weight-bolder">
                            Manage Website
                        </p>
                    </div>


                    <div class="input-group mb-3">
                        <input
                                type="text"
                                autocomplete="off"
                                autofocus
                                name="username"
                                required
                                placeholder="username"
                                class="form-control rounded-0"
                        >
                    </div>

                    <div class="input-group mb-3">
                        <input
                                type="password"
                                autocomplete="off"
                                autofocus
                                name="password"
                                required
                                placeholder="Password"
                                class="form-control rounded-0"
                        >
                    </div>

                    <div id="login_err" class="text-danger m-2"></div>


                    <div class="input-group">
                        <input type="submit" name="login" class="btn btn-info w-100" value="AUTH">
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>