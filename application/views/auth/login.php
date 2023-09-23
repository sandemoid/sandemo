<section id="wrapper">
    <div class="login-register" style="background-image:url(<?php echo base_url('assets'); ?>/img/background/login-register.jpg);">
        <div class="login-box card">
            <div class="card-body">
                <?php echo $this->session->flashdata('message') ?>
                <form class="form-horizontal form-material" id="loginform" method="POST" action="<?php echo site_url('admin/auth') ?>">
                    <h3 class="text-center m-b-20">Sign In</h3>
                    <p class="mb-3 text-center"><em class="text-primary">Solusi ngoding tanpa ribet</em></p>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input type="text" class="form-control form-control-lg" placeholder="Email" id="email" name="email" value="<?= set_value('email') ?>">
                            <?= form_error('email', '<small class="text-danger" pl-3>', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="password" class="form-control form-control-lg" placeholder="Password" id="password" name="password">
                            <?= form_error('password', '<small class="text-danger" pl-3>', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="d-flex no-block align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember_me">
                                    <label class="form-check-label" for="customCheck1">Remember me</label>
                                </div>
                                <div class="ms-auto">
                                    <a href="javascript:void(0)" id="to-recover" class="text-muted"><i class="fa-solid fa-lock"></i> Forgot pwd?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="col-xs-12 p-b-20">
                            <button class="btn w-100 btn-lg btn-info btn-rounded text-white" type="submit">Log In</button>
                        </div>
                    </div>
                    <!-- <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            Don't have an account? <a href="<?php echo site_url('admin/auth/registration') ?>" class="text-info m-l-5"><b>Sign Up</b></a>
                        </div>
                    </div> -->
                </form>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                        <div class="social">
                            <a href="<?php echo site_url('admin/auth/google_login'); ?>" class="btn btn-success" data-bs-toggle="tooltip" data-bs-original-title="Login with Google"> <i aria-hidden="true" class="fa-brands fa-google"></i> </a>
                        </div>
                    </div>
                </div>
                <form class="form-horizontal" id="recoverform" method="POST" action="<?php echo site_url('admin/auth/forgotpassword') ?>">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Masukan email bro, nanti dikirim link recovery </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input type="text" class="form-control form-control-lg" placeholder="Email" id="email" name="email" value="<?= set_value('email') ?>">
                            <?= form_error('email', '<small class="text-danger" pl-3>', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-danger btn-lg w-100 text-uppercase waves-effect waves-light" type="submit">Reset</button>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <a href="javascript:void(0)" id="to-login" class="text-info m-l-5"><b>Back Login</b></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>