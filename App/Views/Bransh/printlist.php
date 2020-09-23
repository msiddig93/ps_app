<link href="<?= ROOT ?>/Public/css/pdf-style.css" type="text/css" rel="stylesheet" />
<page backtop="20mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <?php
        require_once ROOT.'/App/Views/PDF/pdf-header-footer.php';
    ?>
    <br>
    <h3>لائحة فروع الصيدلية</h3>
    <br>
    <table class="table-pdf" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th style="width: 20%;">الرقم</th>
            <th style="width: 30%;" >إسم الفرع</th>
            <th style="width: 50%;">موقع الفرع</th>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach($branshes as $bransh):?>
            <tr>
                <td><?= $bransh->ID ?></td>
                <td><?= $bransh->NAME ?></td>
                <td><?= $bransh->LOCATION ?></td>
            </tr>
        <?php endforeach;
            ?>
        </tbody>
    </table>
</page>


