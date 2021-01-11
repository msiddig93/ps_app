
    <h3 class="text-center size-10">تقرير المخزون</h3>
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th >الرقم</th>
            <th >إسم المنتج</th>
            <th >الصنف</th>
            <th >سعر الشراء</th>
            <th >سعر البيع</th>
            <th >الكمية المتوفرة</th>
        </tr>
        </thead>

        <tbody>
        <?php
            $num = 1;
            foreach($items as $item):
        ?>
                <tr>
                    <td><?= $num ?></td>
                    <td><?= $item->product_name ?></td>
                    <td><?= $item->cat_name ?></td>
                    <td><?= $item->purchase_price ?></td>
                    <td><?= $item->sale_price ?></td>
                    <td><?= $item->qte ?></td>
                </tr>
        <?php   $num +=1;
            endforeach;
            ?>
        </tbody>
    </table>

