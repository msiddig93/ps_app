<?php

$type = [
        '0' => 'نقداً' ,
        '1' => 'شيك',
];

?>

<section class="content-header">
    <span class="content-title"> <i class="fa fa-balance-scale"></i> الحسابات <i class="fa fa-chevron-left"></i> <h3>حسابات شركات التامين</h3> </span>
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
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#payed"  role="tab" data-toggle="tab">المدفوعات</a></li>
            <li><a href="#delay" role="tab" data-toggle="tab">المتاخرات</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="payed">
                <section class="content-header" style="padding-right: 0;">
                    <span class="content-title" style="font-size: 15px;"> <i class="fa  fa-ticket"></i> المدفوعات <i class="fa fa-chevron-left"></i>  <h3>مدفوعات شركات التامين</h3> <i class="fa fa-hand-o-left"></i>  </span>
                    <a href="<?= App::$path ?>report/printlist" target="_blank" class="btn btn-default pull-left" style="margin-top: 10px;">
                        <i class="fa fa-print"></i>
                        <span class="hidden-xs hidden-sm">طباعة</span>
                    </a>
                    <?= $form->select("COMPANY_ID","",$company,[
                        "id" => "COMPANY_ID",
                        "style" => "max-width: 400px;margin-top: 10px;margin-left: 5px;",
                        "class" => "form-control pull-left",
                        "data-validation" => "length",
                        "data-validation-optional" => "true",
                        "data-validation-length" => "1-255",
                        "data-validation-error-msg" => "عزراً ...يجب تحديد حالة التامين  لإتمام هذه العملية !"
                    ],true) ?>
                </section>

                <div id="payedCompany">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <section class="content-header" style="padding-right: 0;">
                                <span class="content-title" style="font-size: 15px;"> <i class="fa  fa-ticket"></i> شركة <i class="fa fa-chevron-left"></i>  <h3 class="pay_name"></h3> <i class="fa fa-hand-o-left"></i>  </span>

                                <?= $form->input("TOTAL_DELAY","",[
                                    "id" => "TOTAL_DELAY",
                                    "style" => "max-width: 200px;margin-top: 0px;margin-left: 0px;border-radius: 10px 0 0 0",
                                    "class" => "form-control pull-left",
                                    "readonly" => "readonly",
                                    "value" => "0.00",
                                ],true) ?>

                                <label class="btn btn-default pull-left"
                                   style="margin-top: 0px;border-radius: 0 0 10px 0">
                                    <span class="hidden-xs hidden-sm">إجمالي المتأخرات</span>
                                </label>
                            </section>
                        </div>
                        <div class="panel-body">

                            <div class="col-xs-12 text-center">
                                <a id="add-element" style="display: none" class="btn btn-success">
                                    <span class="hidden-xs hidden-sm">دفع متأخرات</span>
                                </a>
                            </div>
                            <div style="clear: both;margin-bottom: 10px"></div>


                            <div class="table-responsive">
                                <table class="table pay-table rtl_table data-table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th >تاريخ العملية</th>
                                        <th >طريقة السداد</th>
                                        <th >المبلغ</th>
                                        <th >حصل بواسطة</th>
                                        <th >المرفق</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Ajax Request Get Data here -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="alert alert-danger text-center" style="display: none" id="ticket-today-null">
                                عفواً ... لم يتم حجز أي تذاكر اليوم
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="delay">
                <section class="content-header" style="padding-right: 0;">
                    <span class="content-title" style="font-size: 15px;"> <i class="fa  fa-ticket"></i> المتاخرات <i class="fa fa-chevron-left"></i>  <h3>متاخرات شركات التامين</h3> <i class="fa fa-hand-o-left"></i>  </span>
                    <a href="<?= App::$path ?>report/printlist" target="_blank" class="btn btn-default pull-left" style="margin-top: 10px;">
                        <i class="fa fa-print"></i>
                        <span class="hidden-xs hidden-sm">طباعة</span>
                    </a>
                    <?= $form->select("DELAY_COMPANY_ID","",$company,[
                        "id" => "DELAY_COMPANY_ID",
                        "style" => "max-width: 400px;margin-top: 10px;margin-left: 5px;",
                        "class" => "form-control pull-left",
                    ],true) ?>
                </section>

                <div id="delayCompany">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title" style="text-align: right;">شركة  <i class="fa fa-hand-o-left"></i>  <span id="delay_name"></span></h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table delay-table rtl_table data-table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th >تاريخ العملية</th>
                                        <th >رقم الفاتورة</th>
                                        <th >إسم الدواء</th>
                                        <th >المبلغ المبدفوع</th>
                                        <th >المبلغ المتبقي</th>
                                        <th >الحالة</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Ajax Request Get Data here -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="alert alert-danger text-center" style="display: none" id="ticket-today-null">
                                عفواً ... لم يتم حجز أي تذاكر اليوم
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog model-lg" style="max-width: 500px;">
        <div class="modal-content" >
            <div class="modal-body row" id="modal-add-element">
                <section class="content-header item-header">
                    <span class="content-title" style="font-size: 15px;"> دفع متأخرات شركة <i class="fa fa-chevron-left"></i>  <h3 class="pay_name"></h3>   </span>
                </section>


                <section class="">
                    <form method="post" enctype="multipart/form-data" id="form-save-items">
                        <div class="row form-add-top">
                            <div class="col-xs-12" id="GetDataEdit">


                                <?=
                                $form->input("AMOUNT","المبلغ",[
                                    "type" => "text",
                                    "id" => "AMOUNT",
                                    "class" => "form-control",
                                    "placeholder" => "المبلغ",
                                    "data-validation" => "length",
                                    "data-validation-length" => "1-10",
                                    "data-validation-error-msg" => "عزراً ... لايمكن ترك المبلغ فارغ !"
                                ]) ?>

                                <?= $form->input("COMPANY_ID","",[
                                    "type" => "hidden",
                                    "id" => "ID",
                                ]) ?>

                                <?= $form->input("ajax_action","",[
                                    "type" => "hidden",
                                    "id" => "action",
                                ]) ?>

                                <?= $form->select("PAY_TYPE","طرقة الدفع",$type,[
                                    "id" => "PAY_TYPE",
                                    "class" => "form-control",
                                    "data-validation" => "length",
                                    "data-validation-length" => "1-255",
                                    "data-validation-error-msg" => "عزراً ...يجب تحديد طرقة الدفع لإتمام هذه العملية !"
                                ],true) ?>

                                <?=
                                $form->input("ATTACHMENT[]","المرفق",[
                                    "type" => "file",
                                    "id" => "ATTACHMENT",
                                    "class" => "form-control",
                                    "placeholder" => "السعر",
                                    "data-validation" => "length",
                                    "data-validation-optional" => "true",
                                    "data-validation-length" => "1-255",
                                    "data-validation-error-msg" => "عزراً ... يجب تحديد مرفق لاتمام هذه العملية !"
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

<div class="modal fade" id="comfirm" style="top: 25%" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 500px !important;">
        <div class="modal-content">
            <div class="modal-body">
                <section class="content-header">
                    <span class="content-title"> <i class="fa fa-file-text-o"></i> الفاتورة <i class="fa fa-chevron-left"></i> <h3>هل أنت متأكد من حذف هذا الدواء من الفاتورة</h3></a></span>
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

