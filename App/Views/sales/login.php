<section class="content-header">
    <span class="content-title"> <i class="fa fa-sign-out"></i> الموظفين <i class="fa fa-chevron-left"></i> <h3>تسجيل الدخول</h3> </span>
</section>

<section class="content" style="padding-top: 150px;">
        <div style="max-width: 400px;margin: auto" >
            <form method="post" name="form-user-login" enctype="multipart/form-data" id="form-user-login">
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <span>عفواً ... البيانات المدخلة لم تطابق أي مستخدم ! </span>
                    </div>
                <?php endif; ?>

                <div class="panel panel-primary panel-login">
                    <div class="panel panel-heading login-header">
                        <h3> تسجيل الدخول</h3>
                    </div>

                    <div class="panel-body">
                        <?= $form->input('login','إسم المستخدم',[
                            'type' => 'text',
                            'class' => 'form-control',
                            'placeholder' => 'إسم المستخدم',
                            'data-validation' => 'custom',
                            'data-validation-regexp' => '^([A-Za-z0-9]+)$',
                            'data-validation-length' => 'max100',
                            'data-validation-error-msg' => 'إسم المستخدم يجب أن يكون حروف لاتنية أو أرقام فقط !'
                        ]);?>

                        <?= $form->input('pass','كلمة المرور',[
                            'type' => 'password',
                            'class' => 'form-control',
                            'placeholder' => 'كلمة المرور',
                            'data-validation' => 'length',
                            'data-validation-length' => '3-255',
                            'data-validation-error-msg' => 'كلمة المرور يجب أن تتراوح ما بين 3 - 255 حرف'
                        ]);?>

                        <hr>

                        <div class="form-group text-center">
                            <?= $form->input('btn-user-login','',[
                                'id' => 'btn-user-login',
                                'type' => 'submit',
                                'value' => 'تسجيل الدخول',
                                'class' => 'btn btn-primary bt-lg form-control',
                            ]);?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
</section>

