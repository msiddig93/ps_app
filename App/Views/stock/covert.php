<?php

$value = [
        '25' => ' 25 %' ,
        '50' => ' 50 % ',
        '75' => ' 75 % ',
];

?>

<section class="content-header">
    <span class="content-title"> <i class="fa fa-building-o"></i> شركات التامين <i class="fa fa-chevron-left"></i> <h3><?= $company->NAME ?></h3>   <i class="fa fa-chevron-left"></i> <h3>الادوية تحت التامين</h3> </span>
    <ul class="header-btns">
        <li>
            <a id="add-element" action="CovertItems.add" class="btn btn-success">
                <i class="fa fa-plus-circle"></i>
                <span class="hidden-xs hidden-sm">إضافة</span>
            </a>
        </li>
        <li>
            <a href="" class="btn btn-info" onclick="searchToggle('form-search-wrap',event);">
                <i class="fa fa-search"></i>
                <span class="hidden-xs hidden-sm">بحث</span>
            </a>
        </li>
        <li>
            <a  target="_blank" class="btn btn-default">
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
                    <form name="form-emp-search" id="form-element-search">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <?= $form->input("FULLNAME","الاسم الكامل",[
                                    "type" => "text",
                                    "id" => "FULLNAME",
                                    "class" => "form-control",
                                    "placeholder" => "الاسم الكامل",
                                    "data-validation" => "length",
                                    'data-validation-optional' => 'true',
                                    "data-validation-length" => "1-255",
                                    "data-validation-error-msg" => "عزراً ... لايمكن ترك الاسم الكامل فارغ !"
                                ]) ?>
                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <?= $form->select('TYPE','نوع المستخدم',$type,[
                                    'class' => 'form-control',
                                    'id' => 'type',
                                    'data-validation' => 'length',
                                    'data-validation-optional' => 'true',
                                    'data-validation-length' => '1-50',
                                    'data-validation-error-msg' => 'عزراً ... يجب تحديد نوع المستخدم !'
                                ],true);?>
                            </div>

                            <?= $form->input("ajax_action","",[
                                "type" => "hidden",
                                "value" => "emp.search",
                            ]) ?>

                            <div class="col-md-4 col-sm-6 col-xs-6">
                                <?= $form->select('BRANSH_ID','فرع العمــل',$bransh,[
                                    'class' => 'form-control',
                                    'id' => 'BRANSH_ID',
                                    'data-validation' => 'length',
                                    'data-validation-optional' => 'true',
                                    'data-validation-length' => '1-50',
                                    'data-validation-error-msg' => 'عزراً ... يجب تحديد فرع العمــل !'
                                ],true);?>
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
                        <th >إسم الشركة</th>
                        <th >الاسم التجاري</th>
                        <th >قيمة التامين</th>
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
    <div class="modal-dialog" style="width: 515px !important;">
        <div class="modal-content">
            <div class="modal-body">
                <section class="content-header">
                    <span class="content-title"> <i class="fa fa-building-o"></i> شركات التامين <i class="fa fa-chevron-left"></i> <h3>هل أنت متاكد من حذف بيانات الشركة ؟</h3> </span>
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

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog" style="width: 500px !important;">
        <div class="modal-content" >
            <div class="modal-body row" id="modal-add-element">
                <section class="content-header title-top">

                </section>

                <section class="">
                    <form method="post" enctype="multipart/form-data" id="form-save-element">

                        <div class="row" >
                            <div class="col-xs-12" >
                                <?= $form->select("ITEM_ID","الدواء",$items,[
                                    "type" => "text",
                                    "id" => "ITEM_ID",
                                    "class" => "form-control",
                                    "placeholder" => "الدواء",
                                    "data-validation" => "length",
                                    "data-validation-length" => "1-255",
                                    "data-validation-error-msg" => "عزراً ... لايمكن ترك الدواء فارغ !"
                                ],true) ?>

                                <?= $form->select("VALUE","القيمة",$value,[
                                    "type" => "text",
                                    "id" => "VALUE",
                                    "class" => "form-control",
                                    "placeholder" => "القيمة",
                                    "data-validation" => "length",
                                    "data-validation-length" => "1-255",
                                    "data-validation-error-msg" => "عزراً ... لايمكن ترك القيمة فارغ !"
                                ],true) ?>


                                <?= $form->input("ajax_action","",[
                                    "type" => "hidden",
                                    "id" => "action",
                                    "value" => "CovertItems.add",
                                    "class" => "form-control",
                                ]) ?>

                                <?= $form->input("COMPANY_ID","",[
                                    "type" => "hidden",
                                    "id" => "COMPANY_ID",
                                    "value" => $company->ID,
                                    "class" => "form-control",
                                ]) ?>

                                <?= $form->input("ID","",[
                                    "type" => "hidden",
                                    "id" => "idElementID",

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
