<section class="content-header">
    <span class="content-title"> <i class="fa  fa-dropbox"></i> <a href="<?= App::$path ?>product">المنتجات</a> <i class="fa fa-chevron-left"></i> <h3>الاصناف</h3> </span>
    <ul class="header-btns">
        <li>
            <a href="" id="add-element" class="btn btn-success">
                <i class="fa fa-plus-circle"></i>
                <span class="hidden-xs hidden-sm">إضافة</span>
            </a>
        </li>
        <li>
            <a href="<?= App::$path ?>category/printlist" target="_blank" class="btn btn-default">
                <i class="fa fa-print"></i>
                <span class="hidden-xs hidden-sm">طباعة</span>
            </a>
        </li>
    </ul>   
</section>

<section class="content">
    <div class="col-lg-3 ds">
        <h3>التقــــــويم</h3>
        <!-- CALENDAR-->
        <div id="calendar" class="mb">
            <div class="panel green-panel no-margin">
                <div class="panel-body">
                    <div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
                        <div class="arrow"></div>
                        <h3 class="popover-title" style="disadding: none;"></h3>
                        <div id="date-popover-content" class="popover-content"></div>
                    </div>
                    <div id="my-calendar"></div>
                </div>
            </div>
        </div>
        <!-- / calendar -->
    </div>
    <div class="col-lg-9">
        <div class="row form-search-wrap">

            <div class="box-infos-search">
                <section class="content-header box-info-header">
                    <span class="content-title"> <i class="fa fa-home"></i> البحث</span>
                </section>

                <div class="box-infos">
                    <form id="form-element-search" method="post">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->input("NAME","الاسم ",[
                                    "type" => "text",
                                    "id" => "cat_name1",
                                    "class" => "form-control",
                                    "placeholder" => "إسم الصنف",
                                    "data-validation" => "length",
                                    "data-validation-optional" => "true",
                                    "data-validation-length" => "1-255",
                                    "data-validation-error-msg" => "عزراً ... لايمكن ترك إسم الصنف فارغ !"
                                ]) ?>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?=
                                $form->input("LOCATION","الوصف",[
                                    "type" => "text",
                                    "id" => "location1",
                                    "class" => "form-control",
                                    "placeholder" => "وصف الصنف",
                                    "data-validation" => "length",
                                    "data-validation-optional" => "true",
                                    "data-validation-length" => "1-255",
                                    "data-validation-error-msg" => "عزراً ... لايمكن ترك وصف الصنف فارغ !"
                                ]) ?>
                            </div>

                            <div class="col-lg-12 form-group text-center">
                                <?= $form->input('btn-search-emp','',[
                                    'type' => 'submit',
                                    'id' => 'btn-search-emp',
                                    'class' => 'btn btn-info',
                                    'value' => 'بحث'
                                ]);

                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table main-table rtl_table data-table table-striped table-hover">
                <thead>
                <tr>
                    <th >الرقم</th>
                    <th >الاسم</th>
                    <th >الوصف</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                    <!-- Ajax Request Get Data here -->
                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="modal fade" id="comfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 480px !important;">
        <div class="modal-content">
            <div class="modal-body">
                <section class="content-header">
                    <span class="content-title"> <i class="fa fa-map-marker"></i> الاصناف <i class="fa fa-chevron-left"></i> <h3>هل أنت متاكد من حذف بيانات الصنف ؟</h3> </span>
                </section>
                <div style="margin: 30px">
                    <input type="button" class="btn btn-success pull-right"  id="btn-delete" element_id="0"  style="width: 100px" value="نعم">
                    <input class="btn btn-danger pull-left" style="width: 100px" data-dismiss="modal" value="لا">
                </div>
                <div style="clear: both"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog model-lg" style="max-width: 500px;">
        <div class="modal-content" >
            <div class="modal-body row" id="modal-add-element">
                <section class="content-header title-top">

                </section>

                <section class="">
                    <form method="post" enctype="multipart/form-data" id="form-save-element">
                        <div class="row form-add-top">
                            <div class="col-xs-12" id="GetDataEdit">

                                <?= $form->input("ajax_action","",[
                                    "type" => "hidden",
                                    "id" => "action",
                                    "value" => "vendor.add",
                                    "class" => "form-control",
                                ]) ?>

                                <?= $form->input("ID","",[
                                    "type" => "hidden",
                                    "id" => "idElementID",

                                ]) ?>

                                <?= $form->input("cat_name","الاسم ",[
                                "type" => "text",
                                "id" => "cat_name",
                                "class" => "form-control",
                                "placeholder" => "إسم الصنف",
                                "data-validation" => "length",
                                "data-validation-length" => "1-255",
                                "data-validation-error-msg" => "عزراً ... لايمكن ترك إسم الصنف فارغ !"
                                ]) ?>

                                <?=
                                $form->textarea("cat_desc","الوصف",[
                                "id" => "cat_desc",
                                "class" => "form-control",
                                "placeholder" => "وصف الصنف",
                                "data-validation" => "length",
                                "data-validation-length" => "1-255",
                                "data-validation-error-msg" => "عزراً ... لايمكن ترك وصف الصنف فارغ !"
                                ]) ?>

                            </div>
                            <div class="col-xs-12">
                                <hr>

                                <div class="form-group text-center">
                                    <button type="submit" id="btn-save-element" status="1" class="btn btn-success">حفظ <ii class="fa fa-calendar-check-o"></ii> </button>
                                    <button data-dismiss="modal" class="btn btn-danger">إلغـــاء <i class="fa fa-outdent"></i> </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>

            </div>
        </div>
    </div>
</div>
