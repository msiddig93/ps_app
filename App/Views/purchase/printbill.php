    <header class="clearfix">
      <h1>فاتورة شراء</h1>
      <div class="row">
        <div class="col-sm-6">
            <table>
                <thead>
                <tr>
                    <th colspan="2" style="border-top: 0px">بيانات الفاتورة</th>
                </tr>
                </thead>  
                <tbody>
                    <tr>
                        <td class="">رقم الفاتورة</td>
                        <td class=""><?= $sale_order->id ?></td>
                    </tr>
                    <tr>
                        <td class="">موظف المبيعات</td>
                        <td class=""><?= $emp->FULLNAME ?></td>
                    </tr>
                    <tr>
                        <td class="">تاريخ الفاتورة</td>
                        <td class=""><?= $sale_order->order_date ?></td>
                    </tr>
                    <tr>
                        <td class="">إجمالي الفاتورة</td>
                        <td class=""><?= $sale_order->total_price ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <table>
                <thead>
                <tr>
                    <th colspan="2" style="border-top: 0px">بيانات المورد</th>
                </tr>
                </thead>  
                <tbody>
                    <tr>
                        <td class="">الاسم الكامل</td>
                        <td class=""><?= $customer->vend_name ?></td>
                    </tr>
                    <tr>
                        <td class="">الهاتف</td>
                        <td class=""><?= $customer->phone ?></td>
                    </tr>
                    <tr>
                        <td class="">البريد الاكتروني</td>
                        <td class=""><?= $customer->email ?></td>
                    </tr>
                    <tr>
                        <td class="">العنوان</td>
                        <td class=""><?= $customer->address ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
        

    </header>
    <main>
      <table>
        <thead>
          <tr>
              <th colspan="6" style="border: 0px" ><h3>تفاصيل الفاتورة</h3></th>
          </tr>
          <tr>
            <th >الرقم</th>
            <th >إسم المنتج</th>
            <th >السعر</th>
            <th >الكمية</th>
            <th >الخصم</th>
            <th >الاجمالي</th>
          </tr>
        </thead>
        <tbody>
            <?php
                $num = 1;
                $totalPrice = 0.0;
                foreach($order_details as $sale):
                    $totalPrice = ( $sale->price * $sale->quantity );
            ?>
                <tr>
                    <td><?= $num ?></td>
                    <td><?= $sale->product_name ?></td>
                    <td><?= $sale->price ?></td>
                    <td><?= $sale->quantity ?></td>
                    <td><?= $sale->discount ?> ( <?= $totalPrice ?> )</td>
                    <td><?= ( $totalPrice - $totalPrice * $sale->discount  / 100 ) ?></td>
                </tr>

            <?php   
                $num +=1;
                endforeach;
            ?>
            <tr>
                <td colspan="5" class="grand total">إجمالي الفاتورة</td>
                <td class="grand total" style="text-align: center">SDG <?= $sale_order->total_price ?></td>
            </tr>
        </tbody>
      </table>
        <div class="row" style="margin: 50px 10px">
                <div class="col-sm-6">
                    <table>
                        <tbody>
                            <td  style="border: 0px !important;text-align: left;background: #fff;">التاريخ</td>
                            <td dir="ltr" style="border: 0px !important;text-align: right;background: #fff;" ><strong><?= date("Y-m-d h:m:s") ?></strong></td>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table>
                        <tbody>
                            <td style="border: 0px !important;text-align: left;background: #fff;" >التوقيع :</td>
                            <td  style="border-bottom: 3px double #000 !important;text-align: right;background: #fff;"> </td>
                        </tbody>
                    </table>
                </div>
        </div>
    </main>

