
    <h3 class="text-center size-10">تقرير الموردين</h3>
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
            foreach($vendors as $vendor):
        ?>
                <tr>
                    <td><?= $num ?></td>
                    <td><?= $vendor->vend_name ?></td>
                    <td><?= $vendor->address ?></td>
                    <td><?= $vendor->phone ?></td>
                    <td><?= $vendor->email ?></td>
                </tr>
        <?php   $num +=1;
            endforeach;
            ?>
        </tbody>
    </table>

