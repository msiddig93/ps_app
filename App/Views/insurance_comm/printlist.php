<link href="<?= ROOT ?>/Public/css/pdf-style.css" type="text/css" rel="stylesheet" />
<page backtop="20mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <?php
        require_once ROOT.'/App/Views/PDF/pdf-header-footer.php';
    ?>
    <br>
    <h3>لائحة المنتجات</h3>
    <br>
    <table class="table-pdf" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="num" >الرقم</th>
            <th class="fname" >الاسم الكامل</th>
            <th class="function" >الوظيفة</th>
            <th class="role" >حق الولوج</th>
            <th class="phone" >الهاتف</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $num = 1;
        foreach($users as $user):?>
            <?php if ( $user->id > 1 ) { ?>
                <tr>
                    <td><?= $num ?></td>
                    <td><?= $user->fname . " " . $user->lname ?></td>
                    <td><?= $user->function ?></td>
                    <td><?= $user->role_name ?></td>
                    <td><?= $user->phone ?></td>
                </tr>
                <?php
            }
            $num +=1;
            endforeach;
            ?>
        </tbody>
    </table>
</page>


