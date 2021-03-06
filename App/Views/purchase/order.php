<section class="content-header">
    <span class="content-title"> <i class="fa fa-cart-arrow-down"></i> المبيعات <i class="fa fa-chevron-left"></i> <h3>الرئيسية</h3> </span>
    <ul class="header-btns">
        <li>
            <a id="add-element" class="btn btn-success">
                <i class="fa fa-plus-circle"></i>
                <span class="hidden-xs hidden-sm">إضافة أمر</span>
            </a>
        </li>
        <li>
            <a href="" class="btn btn-info" onclick="searchToggle('form-search-wrap',event);">
                <i class="fa fa-search"></i>
                <span class="hidden-xs hidden-sm">بحث</span>
            </a>
        </li>
        <li>
            <a href="<?= App::$path ?>emp/printlist" target="_blank" class="btn btn-default">
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
        </div>
        <div class="table-responsive">
            <table class="table main-table rtl_table data-table table-striped table-hover">
                <thead>
                <tr>
                    <th >رقم أمر الشراء</th>
                    <th >المورد</th>
                    <th >حرر بواسطة</th>
                    <th >التاريخ</th>
                    <th >إجمالي المبلغ</th>
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




<div class="modal fade" id="add" style="top: 0%" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog model-lg" style="width: 90% !important;top: 0">
        <div class="modal-content" >
            <div class="modal-body row" id="modal-add-element">
                <section class="content-header title-top">

                </section>
                <section class="">
                    <form method="post" enctype="multipart/form-data" id="form-save-element">
                        <div class="col-sm-4 col-xs-12" >
                            <section  class="content-header box-info-header">
                                <span class="content-title"> <i class="fa fa-info-circle"></i> أمر الشراء</span>
                            </section>
                            <br>
                            <?= $form->input("INVOIC_ID","رقم أمر الشراء",[
                                "type" => "text",
                                "value" => "text",
                                "id" => "INVOIC_ID",
                                "readonly" => "readonly",
                                "class" => "form-control",
                                "data-validation" => "length",
                                "data-validation-length" => "1-255",
                                "data-validation-error-msg" => "عزراً ... لايمكن ترك الاسم الكامل فارغ !"
                            ]) ?>

                            <?= $form->select("vendor_id","المورد",$vendors,[
                                "id" => "vendor_id",
                                "class" => "form-control",
                                "data-validation" => "length",
                                "data-validation-length" => "1-255",
                                "data-validation-error-msg" => "عزراً ...يجب تحديد المورد  لإتمام هذه العملية !"
                            ],true) ?>

                            <?= $form->input("LOGIN","إسم الموظف",[
                                "type" => "text",
                                "id" => "login",
                                "class" => "form-control","readonly" => "readonly",
                                "value" => $_SESSION['emp']->FULLNAME ,
                                "data-validation" => "length",
                                "data-validation-length" => "1-255",
                                "data-validation-error-msg" => "عزراً ... لايمكن ترك إسم المستخدم فارغ !"
                            ]) ?>

                                <?= $form->input("CREATED_AT","التاريخ",[
                                "type" => "text",
                                "id" => "CREATED_AT",
                                "class" => "form-control",
                                "readonly" => "readonly",
                                "value" => date('d-M-Y'),
                                "data-validation" => "length",
                                "data-validation-length" => "1-255",
                                "data-validation-error-msg" => "عزراً ... لايمكن ترك اكلمة المرور فارغة !"
                            ]) ?>

                            <?= $form->input("TOTAL_AMOUNT","إجمالي أمر الشراء",[
                                "type" => "text",
                                "id" => "TOTAL_AMOUNT",
                                "value" => "0.00",
                                "class" => "form-control",
                                "readonly" => "readonly",
                                "data-validation" => "length",
                                "data-validation-length" => "1-255",
                                "data-validation-error-msg" => "عزراً ... لايمكن ترك اكلمة المرور فارغة !"
                            ]) ?>



                            <?= $form->input("ajax_action","",[
                                "type" => "hidden",
                                "id" => "action",
                                "value" => "sale.add",
                                "class" => "form-control",
                            ]) ?>
                        </div>

                        <div class="col-sm-8 col-xs-12 ">
                            <div class="box-infos-search">
                                <section class="content-header box-info-header">
                                    <span class="content-title"> <i class="fa fa-medkit"></i> تفاصيل أر الشراء</span>
                                    <a class="btn btn-default btn-search" id="btn-add-item" >
                                        إضافة
                                    </a>
                                </section>
                                <br>
                                <div class="table-responsive" style="max-height: 280px">
                                    <table class="table item-table rtl_table data-table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th >الرقم</th>
                                            <th >إسم المنتج</th>
                                            <th >السعر</th>
                                            <th >الكمية</th>
                                            <th >الخصم</th>
                                            <th >الاجمالي</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- Ajax Request Get Data here -->
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="col-xs-12">
                            <hr>

                            <div class="form-group text-center">
                                <button type="submit" id="btn-save-element" status="1" class="btn btn-success">حفظ <ii class="fa fa-calendar-check-o"></ii> </button>
                                <button data-dismiss="modal" class="btn btn-danger">إلغـــاء <i class="fa fa-outdent"></i> </button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog model-lg" style="max-width: 500px;">
        <div class="modal-content" >
            <div class="modal-body row" id="modal-add-element">
                <section class="content-header item-header">

                </section>


                <section class="">
                    <form method="post" enctype="multipart/form-data" id="form-save-items">
                        <div class="row form-add-top">
                            <div class="col-xs-12" id="GetDataEdit">
                                <?= $form->select("ITEM_ID","منتج ",$products,[
                                    "id" => "ITEM_ID",
                                    "class" => "form-control",
                                    "data-validation" => "length",
                                    "data-validation-length" => "1-255",
                                    "data-validation-error-msg" => "عزراً ...يجب تحديد دواء لإتمام هذه العملية !"
                                ],true) ?>

                                <?=
                                $form->input("price","سعر الشراء",[
                                    "type" => "text",
                                    "id" => "price",
                                    "class" => "form-control",
                                    "placeholder" => "سعر الشراء",
                                    "data-validation" => "length",
                                    "data-validation-length" => "1-255",
                                    "data-validation-error-msg" => "عزراً ... لايمكن ترك سعر الشراء الفرع فارغ !"
                                ]) ?>

                                <?=
                                $form->input("quantity","الكمية",[
                                    "type" => "number",
                                    "dir" => "auto",
                                    "value" => "1",
                                    "id" => "quantity",
                                    "class" => "form-control",
                                    "placeholder" => "الكمية",
                                    "data-validation" => "length",
                                    "data-validation-length" => "1-255",
                                    "data-validation-error-msg" => "عزراً ... لايمكن ترك الكمية فارغ !"
                                ]) ?>

                                <?= $form->input("discount","الخصم ( % )",[
                                    "type" => "number",
                                    "dir" => "auto",
                                    "value" => "0",
                                    "id" => "discount",
                                    "class" => "form-control",
                                    "placeholder" => "الخصم",
                                    "data-validation" => "length",
                                    "data-validation-length" => "1-2",
                                    "data-validation-error-msg" => "عزراً ... نسبة الخصم غير صالحة ,أفصي قيمة 99 !"
                                ]) ?>

                            </div>
                            <div class="col-xs-12">
                                <hr>

                                <div class="form-group text-center">
                                    <button type="submit" id="btn-item-save" status="1" class="btn btn-success">حفظ <ii class="fa fa-calendar-check-o"></ii> </button>
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

<div class="modal fade" id="comfirm" style="top: 25%" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 500px !important;">
        <div class="modal-content">
            <div class="modal-body">
                <section class="content-header">
                    <span class="content-title"> <i class="fa fa-file-text-o"></i> أمر الشراء <i class="fa fa-chevron-left"></i> <h3>هل أنت متأكد من حذف هذا منتج من أمر الشراء</h3></a></span>
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

<div class="modal fade" id="comfirm2" style="top: 25%" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 500px !important;">
        <div class="modal-content">
            <div class="modal-body">
                <section class="content-header">
                    <span class="content-title"> <i class="fa fa-file-text-o"></i> أمر الشراء <i class="fa fa-chevron-left"></i> <h3>هل أنت متأكد من حذف أمر الشراء</h3></a></span>
                </section>
                <div style="margin: 30px">
                    <input type="button" class="btn btn-success pull-right"  id="btn-delete-order" onclick='comfirmDeleteOrder(this ,event);' element_id="0"  style="width: 100px" value="نعم">
                    <input class="btn btn-danger pull-left" style="width: 100px" data-dismiss="modal" value="لا">
                </div>
                <div style="clear: both"></div>
            </div>
        </div>
    </div>
</div>

