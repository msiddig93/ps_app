
    <h3 class="text-center size-10">تقرير المنتجات</h3>
    <table class="table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th >الرقم</th>
            <th >الاسم</th>
            <th >الوصف</th>
        </tr>
        </thead>

        <tbody>
        <?php
            $num = 1;
            foreach($categories as $category):
        ?>
                <tr>
                    <td><?= $num ?></td>
                    <td><?= $category->cat_name ?></td>
                    <td><?= $category->cat_desc ?></td>
                </tr>
        <?php   $num +=1;
            endforeach;
            ?>
        </tbody>
    </table>

