
    <h3 class="text-center size-10">تقرير العملاء</h3>
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="num" >الرقم</th>
            <th class="fname" >الاسم الكامل</th>
            <th class="role" >العنوان</th>
            <th class="phone" >الهاتف</th>
            <th class="function" >البريد الالكتروني</th>
        </tr>
        </thead>

        <tbody>
        <?php
            $num = 1;
            foreach($customers as $customer):
        ?>
                <tr>
                    <td><?= $num ?></td>
                    <td><?= $customer->cust_name ?></td>
                    <td><?= $customer->address ?></td>
                    <td><?= $customer->phone ?></td>
                    <td><?= $customer->email ?></td>
                </tr>
        <?php   $num +=1;
            endforeach;
            ?>
        </tbody>
    </table>

