<link href="<?= ROOT ?>/Public/css/pdf-style.css" type="text/css" rel="stylesheet" />
<page backtop="20mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <?php
        require_once ROOT.'/App/Views/PDF/pdf-header-footer.php';
    ?>
    <br>
        <h3>بيانات المنتج -  <?= $article->desing ?></h3>
    <br>
    <table class="table-article-infos">
        <tr>
            <td class="article-infos">
                <table class="table-pdf table-article-info" cellspacing="0" cellpadding="0">

                    <tr>
                        <td class="td-lable" >الكود</td>
                        <td class="td-info"><?= $article->ref ?></td>
                    </tr>
                    <tr>
                        <td class="td-lable" >الاسم</td>
                        <td class="td-info"><?= $article->desing ?></td>
                    </tr>
                    <tr>
                        <td class="td-lable" >الصنف</td>
                        <td class="td-info"><?= $article->category ?></td>
                    </tr>
                    <tr>
                        <td class="td-lable" >المورد</td>
                        <td class="td-info"><?= $article->supplier_name ?></td>
                    </tr>
                    <tr>
                        <td class="td-lable" >TAV</td>
                        <td class="td-info"><?= $article->tva ?></td>
                    </tr>
                    <tr>
                        <td class="td-lable" >الوحده</td>
                        <td class="td-info"><?= $article->unit ?></td>
                    </tr>

                </table>
            </td>
            <td class="article-img">
                <img src="<?= App::$path ?>img/thumbs/articles/<?=$article->thumb ?>" style="width: 280px;height: 250px;">
            </td>
        </tr>
    </table>

</page>


