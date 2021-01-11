
    <h3 class="text-center size-10">تقرير الموظفين</h3>
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="num" >الرقم</th>
            <th class="fname" >الاسم الكامل</th>
            <th class="role" >العنوان</th>
            <th class="phone" >الهاتف</th>
            <th class="function" >الوظيفة</th>
        </tr>
        </thead>

        <tbody>
        <?php
            $num = 1;
            foreach($emps as $emp):
        ?>
                <tr>
                    <td><?= $num ?></td>
                    <td><?= $emp->FULLNAME ?></td>
                    <td><?= $emp->ADDRSS ?></td>
                    <td><?= $emp->PHONE ?></td>
                    <td><?= $emp->TYPE ?></td>
                </tr>
        <?php   $num +=1;
            endforeach;
            ?>
        </tbody>
    </table>

