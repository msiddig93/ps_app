<?php
/**
 * Created by PhpStorm.
 * User: ACER
 * Date: 10/5/2018
 * Time: 4:17 AM
 */

?>
<h3 class="text-center">الفاتورة</h3>
<div class="data" >
    <table class="table">
        <thead>
            <tr>
                <td class="text-center"> الفرع</td>
                <td><?= $Bransh->NAME ?></td>
            </tr>
            <tr>
                <td class="text-center">موظف البيع</td>
                <td><?= $invoic->FULLNAME ?></td>
            </tr>
        </thead>
    </table>
    <table class="table">
        <thead>
        <tr>
            <th >الدواء</th>
            <th >الكمية</th>
            <th >السعر</th>
            <th >الاجمالي</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $total = 0;
            foreach ($details as $detail){
        ?>
            <tr>
                <td><?= $detail->COMMERCAL_NAME ?></td>
                <td><?= $detail->QTE ?></td>
                <td><?= $detail->LAST_PRICE ?></td>
                <td><?= ( $detail->LAST_PRICE * $detail->QTE ) ?></td>
            </tr>
        <?php
            $total +=  ( $detail->LAST_PRICE * $detail->QTE );
            }
            ?>
        </tbody>
    </table>
    <table class="table">
        <thead>
        <tr>
            <td class="text-center">إجمالي الفاتورة</td>
            <td class="total"> SDG <?= $total ?></td>
        </tr>
        </thead>
    </table>
</div>

