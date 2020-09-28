
    <h3 class="text-center size-10">تقرير المنتجات</h3>
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th >الرقم</th>
            <th >إسم المنتج</th>
            <th >الصنف</th>
            <th >الوصف</th>
            <th >سعر الشراء</th>
            <th >سعر البيع</th>
            <th >حد المخزون</th>
        </tr>
        </thead>

        <tbody>
        <?php
            $num = 1;
            foreach($products as $product):
        ?>
                <tr>
                    <td><?= $num ?></td>
                    <td><?= $product->product_name ?></td>
                    <td><?= $product->cat_name ?></td>
                    <td><?= $product->product_dec ?></td>
                    <td><?= $product->purchase_price ?></td>
                    <td><?= $product->sale_price ?></td>
                    <td><?= $product->mini_stock ?></td>
                </tr>
        <?php   $num +=1;
            endforeach;
            ?>
        </tbody>
    </table>

