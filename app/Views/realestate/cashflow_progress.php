<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <title>投資用不動産の評価 - ドリームハイブの不動産関連サービス</title>
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Cache-Control" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta name="description" content="不動産投資用の価値評価を Web で行うための計算システムを、株式会社ドリームハイブ, DREAMHIVEが提供しています" />
        <meta name="keywords" content="ドリームハイブ,DREAMHIVE,不動産,投資,評価,計算,積算,融資" />
        <meta name="robots" content="INDEX,FOLLOW" />
        <meta name="author" content="株式会社ドリームハイブ" />
        <meta name="Copyright" content="Copyright &#169; 2001-<?php echo date('Y'); ?> DREAMHIVE CO., LTD. All rights reserved." />
        <meta name="Identifier-URL" content="http://services.dreamhive.co.jp/" />
        <meta name="Identifier" content="DREAMHIVE CO., LTD." />
        <meta name="last-modified" content="<?php echo date('Y/m/d', filemtime(__FILE__)); ?>" />
        <link rev="made" href="mailto:info&#64;dreamhive.co.jp" />
        <link rel="start" href="./index.html" />
        <link href="<?=base_url() ?>../css/common.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?=base_url() ?>../css/jquery.cluetip.css" type="text/css" />
        <style type="text/css">
table{border:1px solid gray;border-collapse:collapse;}
th,td{border:1px solid gray;padding:2px 4px;}
th{background-color:#ddddff;}
td{text-align:right;}
#loading{
    display:none; /* hidden */
    position:absolute;
    top:0px;
    background-color:#ffff88;
    padding: 4 12px;
    font-weight:bold;
    font-size:large;
}
a.tip{
    color:green;
    background-color:#bbffbb;
    border:1px solid green;
    padding:2px 2px 0px 2px;
}
        </style>
        <script src="<?=base_url() ?>../js/jquery-1.4.2.min.js" type="text/javascript"></script>
        <script src="<?=base_url() ?>../js/lib/jquery.hoverIntent.js" type="text/javascript"></script>
        <script src="<?=base_url() ?>../js/lib/jquery.bgiframe.min.js" type="text/javascript"></script>
        <script src="<?=base_url() ?>../js/jquery.cluetip.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(
    function() {
        $('a.tip').cluetip({splitTitle: '|'});
    }
);
</script>
<script type="text/javascript" src="<?=base_url() ?>../js/swfobject.js"></script>
<script type="text/javascript">
swfobject.embedSWF(
  "<?=base_url() ?>../swf/open-flash-chart.swf", "cf_chart", "480", "320",
  "10.0.0", "expressInstall.swf",
  {"data-file":"<?=base_url() ?>../cashflow/index.php/cashflow/cf_data/"} );
</script>
    </head>
<body>



<a href="/realestate/" title="不動産関連サービス"><h1>ドリームハイブの不動産関連サービス</h1></a>
<h1>物件のキャッシュフローの推移 - <?=base_url() ?></h1>

<div id="contents">

<div style="color:red;font-size:1.5em;">※！！ご注意ください。本機能は現在ベータ版です！！</div>

<h2>物件の評価</h2>

<table style="border:0px;">
    <tr style="vertical-align:top;">
        <td style="border:0px;text-align:center;" rowspan="2">
            <div id="cf_chart"></div><br />
            <span style="color:#993300;">不動産価値</span>
            <span style="color:#0000ff;">税引き前収益積算(破線)</span>
            <span style="color:#0000ff;">税引き後収益積算(実線)</span>
            <span style="color:#ff0099;">残債</span>
            <span style="color:#ff6600;">NPV</span>
        </td>
        <td style="border:0px;">
            <table>
                <tr>
                    <th colspan="2">収益関係</th>
                </tr>
                <tr>
                    <th>購入予定年</th>
                    <td><?=$rd['purchaseYear'] ?> 年</td>
                </tr>
                <tr>
                    <th>販売価格</th>
                    <td><?=number_format($rd['retailPrice']) ?> 万</td>
                </tr>
                <tr>
                    <th>満室時家賃収入</th>
                    <td><?=number_format($rd['fullRentIncome']) ?> 万</td>
                </tr>
                <tr>
                    <th>空室率</th>
                    <td><?=$rd['emptyRoomRate'] ?> %</td>
                </tr>
                <tr>
                    <th>賃料下落率</th>
                    <td><?=$rd['incomeDropRate'] ?> %</td>
                </tr>
                <tr>
                    <th>管理費率</th>
                    <td><?=$rd['manageCostRate'] ?> %</td>
                </tr>
                <tr>
                    <th>修繕費率</th>
                    <td><?=$rd['repairCostRate'] ?> %</td>
                </tr>
                <tr>
                    <th>国債金利</th>
                    <td><?=$rd['publicInterestRate'] ?> %</td>
                </tr>
            </table>
        </td>

        <td style="border:0px;">
            <table>
                <tr>
                    <th colspan="2">資金関係</th>
                </tr>
                <tr>
                    <th>借入額</th>
                    <td><?=number_format($rd['loanAmount']) ?> 万</td>
                </tr>
                <tr>
                    <th>返済方式</th>
                    <td>元利均等</td>
                </tr>
                <tr>
                    <th>金利</th>
                    <td><?=$rd['interestRate'] ?> %</td>
                </tr>
                <tr>
                    <th>借入期間</th>
                    <td><?=$rd['loanTerm'] ?> 年</td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="border:0px;">
            <table>
                <tr>
                    <th colspan="2">建物関係</th>
                </tr>
                <tr>
                    <th>築年</th>
                    <td><?=$rd['buildYear'] ?> 年</td>
                </tr>
                <tr>
                    <th>築年数</th>
                    <td><?=$rd['buildingAge'] ?> 年</td>
                </tr>
                <tr>
                    <th>構造</th>
                    <td><?
                    $options = array(
                        '0' => '木造(W)',
                        '1' => '軽量鉄骨造(軽量S)',
                        '2' => '鉄骨造(S)',
                        '3' => '鉄筋コンクリート造(RC)',
                        '4' => '鉄骨鉄筋コンクリート造(SRC)',
                    );
                    echo $options[$rd['frameType']];
                    ?></td>
                </tr>
                <tr>
                    <th>税法上の残耐用年数</th>
                    <td><?=$rd['buildingLifeLeft'] ?> 年</td>
                </tr>
                <tr>
                    <th>定額法ベースの<br />建物評価額</th>
                    <td><?=number_format(round($rd['buildingEval'], 0)) ?> 万</td>
                </tr>
            </table>
        </td>

        <td style="border:0px;">
            <table>
                <tr>
                    <th colspan="2">土地関係</th>
                </tr>
                <tr>
                    <th>土地評価額</th>
                    <td><?=number_format(round($rd['groundEval'], 0)) ?> 万</td>
                </tr>
                <tr>
                    <th>土地下落率</th>
                    <td><?=$rd['groundValueDropRate'] ?> %</td>
                </tr>
            </table>
        </td>

    </tr>
</table>


<!--
<h3>初期投資額</h3>
<?=number_format($rd['selfFund']) ?>       //必要自己資金(万)<br>
-->



<h2>物件のキャッシュフローの推移</h2>

<table>
    <tr>
        <th rowspan="3">年度</th>
        <th rowspan="3">収入</th>
        <th colspan="11">P/L</th>
        <th colspan="6">B/S</th>
        <th colspan="6" rowspan="2">NPV</th>
    </tr>
    <tr>
        <th colspan="4">経費</th>
        <th colspan="3">借入内訳</th>
        <th colspan="2">税金</th>
        <th colspan="2">CF</th>
        <th colspan="2">現金</th>
        <th colspan="3">不動産</th>
        <th>借入</th>
    </tr>
    <tr>
        <th>管理費用</th>
        <th>固定資産税と都市計画税</th>
        <th>修繕費用</th>
        <th>減価償却費</th>
        <th>借入金返済額</th>
        <th>利息部分</th>
        <th>元金部分</th>
        <th>課税対象</th>
        <th>税額</th>
        <th>税引き前収益</th>
        <th>税引き後収益</th>
        <th>税引き前収益積算</th>
        <th>税引き後収益積算</th>
        <th>建物残存価値</th>
        <th>土地値</th>
        <th>土地と建物</th>
        <th>残債</th>
        <th>税引き前収益割り戻し</th>
        <th>税引き前収益割り戻し積算</th>
        <th>税引き後収益割り戻し</th>
        <th>税引き後収益割り戻し積算</th>
        <th>NPV</th>
        <th>残債割り戻し</th>
    </tr>

<? foreach ($cfp as $row): ?>
    <tr>
        <td><?=$row['year'] ?></td>
        <td style="color:<?=isMinus($row['income']) ? 'red' : '' ?>;">
            <?=number_format(round($row['income'], 0)) ?></td>
        <td style="color:<?=isMinus($row['manageCost']) ? 'red' : '' ?>;">
            <?=number_format(round($row['manageCost'], 0)) ?></td>
        <td style="color:<?=isMinus($row['costTax']) ? 'red' : '' ?>;">
            <?=number_format(round($row['costTax'], 0)) ?></td>
        <td style="color:<?=isMinus($row['repairCost']) ? 'red' : '' ?>;">
            <?=number_format(round($row['repairCost'], 0)) ?></td>
        <td style="color:<?=isMinus($row['depreciationCost']) ? 'red' : '' ?>;">
            <?=number_format(round($row['depreciationCost'], 0)) ?></td>
        <td style="color:<?=isMinus($row['payAmount']) ? 'red' : '' ?>;">
            <?=number_format(round($row['payAmount'], 0)) ?></td>
        <td style="color:<?=isMinus($row['payInterest']) ? 'red' : '' ?>;">
            <?=number_format(round($row['payInterest'], 0)) ?></td>
        <td style="color:<?=isMinus($row['payPrincipal']) ? 'red' : '' ?>;">
            <?=number_format(round($row['payPrincipal'], 0)) ?></td>
        <td style="color:<?=isMinus($row['taxTarget']) ? 'red' : '' ?>;">
            <?=number_format(round($row['taxTarget'], 0)) ?></td>
        <td style="color:<?=isMinus($row['incomeTax']) ? 'red' : '' ?>;">
            <?=number_format(round($row['incomeTax'], 0)) ?></td>
        <td style="color:<?=isMinus($row['returnBeforeTax']) ? 'red' : '' ?>;">
            <?=number_format(round($row['returnBeforeTax'], 0)) ?></td>
        <td style="color:<?=isMinus($row['returnAfterTax']) ? 'red' : '' ?>;">
            <?=number_format(round($row['returnAfterTax'], 0)) ?></td>
        <td style="color:#0000ff;color:<?=isMinus($row['returnBeforeTaxTotal']) ? 'red' : '' ?>;">
            <?=number_format(round($row['returnBeforeTaxTotal'], 0)) ?></td>
        <td style="color:#0000ff;color:<?=isMinus($row['returnAfterTaxTotal']) ? 'red' : '' ?>;">
            <?=number_format(round($row['returnAfterTaxTotal'], 0)) ?></td>
        <td style="color:<?=isMinus($row['buildingValueLeft']) ? 'red' : '' ?>;">
            <?=number_format(round($row['buildingValueLeft'], 0)) ?></td>
        <td style="color:<?=isMinus($row['groundValue']) ? 'red' : '' ?>;">
            <?=number_format(round($row['groundValue'], 0)) ?></td>
        <td style="color:#993300;color:<?=isMinus($row['realestateValue']) ? 'red' : '' ?>;">
            <?=number_format(round($row['realestateValue'], 0)) ?></td>
        <td style="color:#ff0099;color:<?=isMinus($row['debtLeft']) ? 'red' : '' ?>;">
            <?=number_format(round($row['debtLeft'], 0)) ?></td>
        <td style="color:<?=isMinus($row['returnBeforeTaxRebate']) ? 'red' : '' ?>;">
            <?=number_format(round($row['returnBeforeTaxRebate'], 0)) ?></td>
        <td style="color:<?=isMinus($row['returnBeforeTaxRebateTotal']) ? 'red' : '' ?>;">
            <?=number_format(round($row['returnBeforeTaxRebateTotal'], 0)) ?></td>
        <td style="color:<?=isMinus($row['returnAfterTaxRebate']) ? 'red' : '' ?>;">
            <?=number_format(round($row['returnAfterTaxRebate'], 0)) ?></td>
        <td style="color:<?=isMinus($row['returnAfterTaxRebateTotal']) ? 'red' : '' ?>;">
            <?=number_format(round($row['returnAfterTaxRebateTotal'], 0)) ?></td>
        <td style="color:#ff6600;color:<?=isMinus($row['npv']) ? 'red' : '' ?>;">
            <?=number_format(round($row['npv'], 0)) ?></td>
        <td style="color:<?=isMinus($row['debtLeftRebate']) ? 'red' : '' ?>;">
            <?=number_format(round($row['debtLeftRebate'], 0)) ?></td>
    </tr>
<? endforeach; ?>

</table>


    <hr />
    ※あくまでも一般的な数値を基に計算した数値であり、評価額の保証を行うものではありません<br />

</div>
<br />
<br />
<?=$footer_data; ?>

</body>
</html>
