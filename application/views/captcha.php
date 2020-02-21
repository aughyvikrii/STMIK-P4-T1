<html>
    <head>
        <title>Captcha</title>
        <link rel="stylesheet" href="<?= base_url("/assets/css/bootstrap.min.css"); ?>">
        <script src="<?= base_url("/assets/js/bootstrap.min.js"); ?>"></script>
    </head>
    <body>
        <div class="container" style="margin-top:20px;">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        Captcha Helper
                    </div>
                    <div class="card-body">

                        <?php if( isset($error_msg) ){ ?>
                            <div class="alert alert-danger"><?= $error_msg ?></div>
                        <?php } else if( isset($success_msg) ){ ?>
                            <div class="alert alert-success"><?= $success_msg ?></div>
                        <?php } ?>

                        <form action="" method="post">
                            <div  class="form-group">
                                <label for="captcha">Captcha: </label>
                                <?= $captcha['image'] ?>
                            </div>
                            <div  class="form-group">
                                <label for="input">Input captcha: </label>
                                <input type="text" name="captcha" class="form-control <?= form_error('captcha') ? 'is-invalid' : '' ?>" value="<?= set_value("captcha"); ?>">
                                <?= form_error('captcha', '<div class="invalid-feedback">', '</div>'); ?>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-md btn-primary btn-block" value="submit">
                                <input type="submit" name="new_captcha" class="btn btn-md btn-success btn-block" value="New Captcha">
                                <a href="<?= base_url('/') ?>" class="btn btn-md btn-warning btn-block">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>