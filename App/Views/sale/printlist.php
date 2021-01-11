
    <h3 class="text-center size-10">تقرير المبيعات</h3>
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th >رقم أمر البيع</th>
            <th >العميل</th>
            <th >حرر بواسطة</th>
            <th >التاريخ</th>
            <th >إجمالي المبلغ</th>
        </tr>
        </thead>

        <tbody>
        <?php
            $num = 1;
            foreach($sales as $sale):
        ?>
                <tr>
                    <td><?= $num ?></td>
                    <td><?= $sale->cust_name ?></td>
                    <td><?= $sale->FULLNAME ?></td>
                    <td dir="ltr" ><?= $sale->order_date ?></td>
                    <td><?= $sale->total_price ?></td>
                </tr>
        <?php   
            $num +=1;
            endforeach;
        ?>
        </tbody>
    </table>

