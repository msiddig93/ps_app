
<style>
    .text-blank{
        border-bottom: 1px dotted #000000;
        font-weight: bold ;
    }

    .table-info thead tr,.table-info thead tr td{
        background-color: #ffffff;
        border: 0;

    }
</style>
<h4 class="text-center">شركات التامين <i class="fa fa-hand-o-left"></i> شركة جديدة </h4>
<!--<div class="row">-->
<!--    <div class="col-md-6 بخقة-لقخعح">-->
<!--        <div class="col-md-6">-->
<!--            .............-->
<!--        </div>-->
<!--        <div class="col-md-6">-->
<!--                الاسم :-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-md-6">-->
<!--        <div class="col-md-6">-->
<!--            ..........-->
<!--        </div>-->
<!--        <div class="col-md-6">-->
<!--            العنوان :-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<div class="data" >

    <table class="table table-info">
        <thead>
            <tr>
                <td class="text-left"> إسم الشركة : </td>
                <td class="">......................................................................................................</td>
                <td class="text-left">الاهاتف : </td>
                <td>..................................................................................</td>
            </tr>
            <tr>
                <td class="text-left"> العنوان : </td>
                <td class="">......................................................................................................</td>
                <td class="text-left">السقف الاعلي للديون : </td>
                <td>..................................................................................</td>
            </tr>
        </thead>
    </table>

    <table class="table">
        <thead>
        <tr>
            <th >الاسم العلمي</th>
            <th >الاسم التجاري</th>
            <th >تأمين / بدون</th>
            <th >قيمة التامين % </th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($details as $detail){
        ?>
            <tr>
                <td><?= $detail->SIEANCE_NAME ?></td>
                <td><?= $detail->COMMERCAL_NAME ?></td>
                <td> ( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</td>
                <td></td>
            </tr>
        <?php
            }
            ?>
        </tbody>
    </table>
</div>
