<section class="content-header">
<span class="content-title"> <i class="fa fa-edit"></i> <?= $profile->login ?> </span>
</section>

<section class="content">

    <div class="col-sm-9">
        <h3>معلومات المستخدم</h3>

        <div class="form-group">
            <label>إسم المستخدم</label>
            <span><?= $profile->login ?></span>
        </div>

        <div class="form-group">
            <label>البريد الالكتروني</label>
            <span><?= $profile->email ?></span>
        </div>

        <div class="form-group">
            <label>الاسم الكامل</label>
            <span><?= $profile->fname." ".$profile->lname ?></span>
        </div>

        <div class="form-group">
            <label>الوظيفة</label>
            <span><?= $profile->function ?></span>
        </div>

        <div class="form-group">
            <label>حق الولوج</label>
            <span><?= $profile->role_name ?></span>
        </div>

    </div>
    <div class="col-sm-3">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <img class="avatar avatar-lg" src="<?= App::$path ?>img/avatar/<?= $profile->avatar ?>">
                <h4> <?= $profile->fname." ".$profile->lname ?> </h4>
                <small> <?= $profile->function ?> </small>
            </div>

            <div class="panel-body ">
                <ul class="nav nav-pills text-center">
                    <li ><a href="<?= App::$path ?>user/profile-edit/<?= $profile->id ?>">تعديل البروفايل</a> </li>
                    <li ><a href="<?= App::$path ?>user/profile-edit/<?= $profile->id ?>">نعديل كلمة المرور</a> </li>
                </ul>
            </div>
        </div>
    </div>

</section>
