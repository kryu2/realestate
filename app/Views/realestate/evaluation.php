<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <title>夢のらしんばん：投資用不動産の評価 - ドリームハイブの不動産関連サービス</title>
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Cache-Control" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta name="description" content="夢のらしんばん:不動産投資用の価値評価を Web で行うための計算システムを、株式会社ドリームハイブ, DREAMHIVEが提供しています" />
        <meta name="keywords" content="夢のらしんばん,ドリームハイブ,DREAMHIVE,不動産,投資,評価,計算,積算,融資" />
        <meta name="robots" content="INDEX,FOLLOW" />
        <meta name="author" content="株式会社ドリームハイブ" />
        <meta name="Copyright" content="Copyright &#169; 2001-<?php echo date('Y'); ?> DREAMHIVE CO., LTD. All rights reserved." />
        <meta name="Identifier-URL" content="https://services.dreamhive.co.jp/" />
        <meta name="Identifier" content="DREAMHIVE CO., LTD." />
        <meta name="last-modified" content="<?php echo date('Y/m/d', filemtime(__FILE__)); ?>" />
	<meta property="og:title" content="投資用不動産の評価サービス『夢のらしんばん』：ドリームハイブの不動産関連サービス" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="https://services.dreamhive.co.jp/realestate/evaluation/" />
	<meta property="og:image" content="https://services.dreamhive.co.jp/wp-content/uploads/2014/07/yr_logo_210x210.jpg" />
	<meta property="og:image:width" content="210" />
	<meta property="og:image:height" content="210" />
	<meta property="og:site_name" content="ITを利用した仕組み作りのプロ集団：システム開発とITコンサルティングの株式会社ドリームハイブ" />
	<meta property="og:description" content="夢のらしんばん:不動産投資用の価値評価を Web で行うための計算システムを、株式会社ドリームハイブが提供しています。" />
	<meta property="article:tag" content="夢のらしんばん,ドリームハイブ,DREAMHIVE,不動産,投資,評価,計算,積算,融資" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:description" content="夢のらしんばん:不動産投資用の価値評価を Web で行うための計算システムを、株式会社ドリームハイブが提供しています。" />
        <link rev="made" href="mailto:info&#64;dreamhive.co.jp" />
        <link rel="start" href="./index.html" />
        <link rel="stylesheet" href="<?=base_url() ?>/css/y_rashinban.css" type="text/css" />
        <link rel="stylesheet" href="<?=base_url() ?>/css/jquery.cluetip.css" type="text/css" />
        <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?=base_url() ?>/images/yr/favicon.ico" />
        <style type="text/css">
table.input{border:0px;background-color:#eeeecc;border-collapse:collapse;}
table.input td.check-around{padding:6px 8px;}
table.arrow{border:0px;background-color:#white;border-collapse:collapse;}
table.arrow td{text-align:center;padding:0px 12px;}
table.report{border:1px solid gray;border-collapse:collapse;}
table.report td{border-right:1px dotted gray;border-bottom:1px solid gray;padding:6px 8px;}
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
        <script src="<?=base_url() ?>/js/jquery-1.4.2.min.js" type="text/javascript"></script>
        <script src="<?=base_url() ?>/js/lib/jquery.hoverIntent.js" type="text/javascript"></script>
        <script src="<?=base_url() ?>/js/lib/jquery.bgiframe.min.js" type="text/javascript"></script>
        <script src="<?=base_url() ?>/js/jquery.cluetip.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(
    function() {
        $('a.tip').cluetip({splitTitle: '|'});
    }
);

$(function() {
    $(':input[class=inputValue]').blur(
        function() {
            $(this).val($(this).val().replace(/,/g, ''));
        }
    );
});

// xajax.callback.global.onRequest = function() {
//     xajax.$('loading').style.display = 'block';
// };
// xajax.callback.global.beforeResponseProcessing = function() {
//     xajax.$('loading').style.display='none';
// };

function clearInput() {
    if (confirm('入力した情報を破棄しますか？')){
        $(':input[class=inputValue]').val('');
    }
}
</script>
    </head>
<body>

<div id="header">
    <h1>夢のらしんばん:投資用不動産の評価額とキャッシュフローが無料で計算できるWebサービス</h1>
    <table style="width:100%;">
        <tr>
            <td>
                <a href="<?=base_url() ?>" title="夢のらしんばん - <?=base_url() ?>" style="text-indent:0px;height:auto;width:auto;"><img src="<?=base_url() ?>/images/yr_logo.jpg" width="140" height="54" border="0" alt="夢のらしんばん - <?=base_url() ?>" /></a>

            </td>
        </tr>
    </table>
    <div id="sns_buttons" style="height:24px;">
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId=182409001808736";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-like" data-href="https://www.facebook.com/pages/%E5%A4%A2%E3%81%AE%E3%82%89%E3%81%97%E3%82%93%E3%81%B0%E3%82%93/100540066703224" data-send="false" data-layout="button_count" data-width="76" data-show-faces="true"></div>

        <a href="https://twitter.com/share" class="twitter-share-button" data-url="https://services.dreamhive.co.jp/realestate/evaluation/" data-text="夢のらしんばん:投資用不動産の評価額とキャッシュフローが無料で計算できるWebサービス" data-via="dreamhive_jp" data-lang="ja" data-count="horizontal">ツイート</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

        <div class="g-plusone" data-size="medium" data-annotation="bubble"></div>
        <script type="text/javascript">
          window.___gcfg = {lang: 'ja'};

          (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/plusone.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
          })();
        </script>
        <a href="http://b.hatena.ne.jp/entry/https://services.dreamhive.co.jp/realestate/evaluation/" class="hatena-bookmark-button" data-hatena-bookmark-title="夢のらしんばん:投資用不動産の評価額とキャッシュフローが無料で計算できるWebサービス" data-hatena-bookmark-layout="standard-balloon" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
    </div>
    <div id="information">

    </div>
</div>

<div id="contents">

    <a href="/realestate/" title="不動産関連サービス"><h2>ドリームハイブの不動産関連サービス</h2></a>
    <span style="color:red;font-size:2em;">現在構築中です。動作の保証ができません。 2025/5/13</span><br>
    <span style="color:red;font-size:1.5em;">＊ひとまずすべての項目を埋めることで動作します</span>
    <h2>物件情報の入力</h2>

    <!-- ■情報入力 -->

    <form action="" method="post" name="inputForm" id="inputForm">

        <table class="input">
            <tr>
                <td valign="top" class="check-around" style="border-right:1px dotted #888888;">
                    <h3>
                        収支のチェック
                        <a class="tip" title="
                            収支のチェック|
                            ◎融資期間 = 法定耐用年数 - 築年数(最大で30年)<br />
                            ◎金利 = 2.8%<br />
                            ◎経費率 = 15%<br />
                            ◎空室率 = 15%<br />
                            として計算した結果を表示します。">?</a>
                    </h3>


                    <table>
                        <tr>
                            <td>
                                販売価格
                            </td>
                            <td>
                                <input type="text" name="RetailPrice" value="<?//=$this->ra_session->userdata('RetailPrice') ?>" size="8" class="inputValue" onblur="getEvaluationValues();" />万円
                            </td>
                        </tr>
                        <tr>
                            <td>
                                満室時の収入
                            </td>
                            <td>
                                <input type="text" name="FullRentIncome" value="<?//=$this->ra_session->userdata('FullRentIncome') ?>" size="8" class="inputValue" onblur="getEvaluationValues();" />万円/年
                            </td>
                        </tr>
                        <tr>
                            <td>
                                建築年月
                            </td>
                            <td>
<?
$options = array(
'1970' => '1970(昭和45)',
'1971' => '1971(昭和46)',
'1972' => '1972(昭和47)',
'1973' => '1973(昭和48)',
'1974' => '1974(昭和49)',
'1975' => '1975(昭和50)',
'1976' => '1976(昭和51)',
'1977' => '1977(昭和52)',
'1978' => '1978(昭和53)',
'1979' => '1979(昭和54)',
'1980' => '1980(昭和55)',
'1981' => '1981(昭和56)',
'1982' => '1982(昭和57)',
'1983' => '1983(昭和58)',
'1984' => '1984(昭和59)',
'1985' => '1985(昭和60)',
'1986' => '1986(昭和61)',
'1987' => '1987(昭和62)',
'1988' => '1988(昭和63)',
'1989' => '1989(平成1)',
'1990' => '1990(平成2)',
'1991' => '1991(平成3)',
'1992' => '1992(平成4)',
'1993' => '1993(平成5)',
'1994' => '1994(平成6)',
'1995' => '1995(平成7)',
'1996' => '1996(平成8)',
'1997' => '1997(平成9)',
'1998' => '1998(平成10)',
'1999' => '1999(平成11)',
'2000' => '2000(平成12)',
'2001' => '2001(平成13)',
'2002' => '2002(平成14)',
'2003' => '2003(平成15)',
'2004' => '2004(平成16)',
'2005' => '2005(平成17)',
'2006' => '2006(平成18)',
'2007' => '2007(平成19)',
'2008' => '2008(平成20)',
'2009' => '2009(平成21)',
'2010' => '2010(平成22)',
'2011' => '2011(平成23)',
'2012' => '2012(平成24)',
'2013' => '2013(平成25)',
'2014' => '2014(平成26)',
'2015' => '2015(平成27)',
'2016' => '2016(平成28)',
'2017' => '2017(平成29)',
'2018' => '2018(平成30)',
'2019' => '2019(平成31/令和1)',
'2020' => '2020(令和2)',
'2021' => '2021(令和3)',
'2022' => '2022(令和4)',
'2023' => '2023(令和5)',
'2024' => '2024(令和6)',
'2025' => '2025(令和7)',
);
//$default = ($this->ra_session->userdata('BuildDate') !== false) ? $this->ra_session->userdata('BuildDate') : '1989';
$default = '1989';
echo form_dropdown('BuildDate', $options, $default, 'onChange="xajax_setAll(xajax.getFormValues(\'InputForm\'));" class="inputValue" id="BuildDate"');
?>
                                (築 <span id="BuildingAge"></span>年)<br />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                建物構造
                            </td>
                            <td>
<?
$options = array(
'0' => '木造(W)',
'1' => '軽量鉄骨造(軽量S)',
'2' => '鉄骨造(S)',
'3' => '鉄筋コンクリート造(RC)',
'4' => '鉄骨鉄筋コンクリート造(SRC)',
);
//$default = ($this->ra_session->userdata('FrameType') !== false) ? $this->ra_session->userdata('FrameType') : '3';
echo form_dropdown('FrameType', $options, $default, 'onChange="xajax_setAll(xajax.getFormValues(\'InputForm\'));" class="inputValue"')
?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td valign="top" class="check-around" style="border-right:1px dotted #888888;">
                    <h3>
                        資産性のチェック
                        <a class="tip" title="
                            資産性のチェック|
                            ◎融資期間 = 法定耐用年数 - 築年数(最大で30年)<br />
                            ◎金利 = 2.8%<br />
                            ◎経費率：概算で計算した数値<br />
                            ◎空室率 = 15%<br />
                            として計算した結果を表示します。">?</a>
                    </h3>


                    <table>
                        <tr>
                            <td>
                                延床面積
                            </td>
                            <td>
                                <input type="text" name="TotalFloorArea" value="<?//=$this->ra_session->userdata('TotalFloorArea') ?>" size="8" class="inputValue" onblur="getEvaluationValues();" />m<sup>2</sup><br />
                            </td>
                        </tr>
                        <!-- tr>
                            <td>
                               用途地域
                            </td>
                            <td>
<?
$options = array(
'1L' => '第1種低層住居専用地域',
'2L' => '第2種低層住居専用地域',
'1M' => '第1種中高層住居専用地域',
'2M' => '第2種中高層住居専用地域',
'1R' => '第1種住居専用地域',
'2R' => '第2種住居専用地域',
'R' => '準住居地域',
'BN' => '近隣商業地域',
'B' => '商業地域',
'SI' => '準工業地域',
'I' => '工業地域',
'O' => 'その他地域',
);
//$default = ($this->ra_session->userdata('RegionForUse') !== false) ? $this->ra_session->userdata('RegionForUse') : '1M';
echo form_dropdown('RegionForUse', $options, $default, 'onChange="xajax_setAll(xajax.getFormValues(\'InputForm\'));" class="inputValue"');
?>
                            </td>
                        </tr -->
                        <tr>
                            <td>
                               容積率
                            </td>
                            <td>
                                <input type="text" name="CapacityRatio" value="<?//=$this->ra_session->userdata('CapacityRatio') ?>" size="8" class="inputValue" onblur="getEvaluationValues();" />%<br />
                            </td>
                        </tr>
                        <tr>
                            <td>
                               道路付け
                            </td>
                            <td>
                                幅員4m以上の接道状況<br />
<?
//$f = ($this->ra_session->userdata('RoadBorderCount') !== false) ? $this->ra_session->userdata('RoadBorderCount') : '1';
$f = 1;
?>
                                <label><?=form_radio('RoadBorderCount', '0', $f == '0', ' class="inputValue"') ?>無し</label>
                                <label><?=form_radio('RoadBorderCount', '1', $f == '1', ' class="inputValue"') ?>1面</label>
                                <label><?=form_radio('RoadBorderCount', '2', $f == '2', ' class="inputValue"') ?>2面</label>
                                <label><?=form_radio('RoadBorderCount', '9', $f == '9', ' class="inputValue"') ?>3面以上</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                路線価
                            </td>
                            <td>
                                <input type="text" name="RoadRating" value="<?//=$this->ra_session->userdata('RoadRating') ?>" size="8" class="inputValue" onblur="getEvaluationValues();" />万円/m<sup>2</sup><br />
                                →<a href="/rosenka/" target="_blank">路線価検索で調べる</a><br />
                                →<a href="https://www.rosenka.nta.go.jp/main_h22/index.htm" target="_blank">国税庁で調べる</a><br />
                                →<a href="https://www.chikamap.jp/" target="_blank">全国地価マップで調べる</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                土地面積
                            </td>
                            <td>
                                <input type="text" name="GroundArea" value="<?//=$this->ra_session->userdata('GroundArea') ?>" size="8" class="inputValue" onblur="getEvaluationValues();" />m<sup>2</sup><br />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                建物の戸数
                            </td>
                            <td>
                                <input type="text" name="ResidenceCount" value="<?//=$this->ra_session->userdata('ResidenceCount') ?>" class="inputValue" size="8" onblur="getEvaluationValues();" />戸<br />
                            </td>
                        </tr>
                    </table>
                </td>
                <td valign="top" class="check-around" style="">
                    <h3>
                        融資情報を入力してチェック
                        <a class="tip" title="
                            融資情報を入力してチェック|
                            ◎融資期間：指定した年数<br />
                            ◎金利：指定した%<br />
                            ◎経費率：概算で計算した数値を用います<br />
                            ◎空室率 = 15%<br />
                            として計算した結果を表示します。">?</a>
                    </h3>

                    <table>
                        <tr>
                            <td>
                                借入期間
                            </td>
                            <td>
                                <input type="text" name="LoanTerm" value="<?//=$this->ra_session->userdata('LoanTerm') ?>" size="8" class="inputValue" onblur="getEvaluationValues();" />年
                            </td>
                        </tr>
                        <tr>
                            <td>
                                金利
                            </td>
                            <td>
                                <input type="text" name="InterestRate" value="<?//=$this->ra_session->userdata('InterestRate') ?>" class="inputValue" size="8" onblur="getEvaluationValues();" />%
                            </td>
                        </tr>
                        <tr>
                            <td>
                                借入額
                            </td>
                            <td>
                                <input type="text" name="LoanAmount" value="<?//=$this->ra_session->userdata('LoanAmount') ?>" class="inputValue" size="8" onblur="getEvaluationValues();" />万円
                            </td>
                        </tr>
                        <tr>
                            <td>-
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                想定空室率
                            </td>
                            <td>
                                <input type="text" name="EmptyRoomRate" value="<?//=$this->ra_session->userdata('EmptyRoomRate') ?>" class="inputValue" size="8" onblur="getEvaluationValues();" />%
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
            </tr>
        </table>




        <table class="arrow">
            <tr>
                <td style="">
                    <img src="<?=base_url() ?>/images/step_arrow.jpg" />
                </td>
                <td style="">
                    <input type="button" name="SubmitCheck" id="SubmitCheck" value="チェック" onclick="getEvaluationValues();" style="width:120px;height:28px;margin-top:8px;" />
                    <input type="button" value="クリア" style="height:28px;" onclick="clearInput();" />
                </td>
            </tr>
        </table>
<script>
    function getEvaluationValues() {
      var formValues = document.forms['inputForm'];
      $.ajax({
        url: "<?php echo base_url('Evaluation/getEvaluationValues'); ?>",
        data: $(formValues).serialize(),
        beforeSend: function (f) {
          $('#evaluationValues').html('<img src="<?=base_url(); ?>/images/spinner.gif" alt="loading..." />処理中...');
        },
        success: function (data) {
          $('#evaluationValues').html(data);
        }
      })
    }
</script>

    </form>


    <!-- ■評価出力 -->
    <div id="loading_background" style="position: absolute; top: 0pt; left: 0pt; z-index: 1000; width: 100%; height: 200%; min-height: 100%; background-color: #000000; opacity: 0.2;display:none"></div>
    <div id="loading"><img src="<?=base_url(); ?>/images/spinner.gif" alt="loading" />処理中...</div>

    <div id="evaluationValues">

        <h2>インフォメーション</h2>

        <table>
            <tr>
                <td valign="top" style="width:50%;padding:6px 8px;">
                    <h3>使い方</h3>
                    <p>
                        値を入力し、「チェック」ボタンをクリックしてください。<br />
                        ほとんどの項目は、値を入力して他の項目に移る段階で、結果に反映されます。
                    </p>
                    <p>
                        ●収支のチェック
                    </p>
                    <p>
                        ◎融資期間 = 法定耐用年数 - 築年数(最大で30年)<br />
                        ◎金利 = 2.8%<br />
                        ◎経費率 = 15%<br />
                        ◎空室率 = 15%<br />
                        として計算した結果を表示します。
                    </p>
                    <p>
                        ●資産性のチェック
                    </p>
                    <p>
                        ◎融資期間 = 法定耐用年数 - 築年数(最大で30年)<br />
                        ◎金利 = 2.8%<br />
                        ◎経費率：概算で計算した数値<br />
                        ◎空室率 = 15%<br />
                        として計算した結果を表示します。
                    </p>
                    <p>
                        ●融資情報を入力してチェック
                    </p>
                    <p>
                        ◎融資期間：指定した年数<br />
                        ◎金利：指定した%<br />
                        ◎経費率：概算で計算した数値を用います<br />
                        ◎空室率 = 15%<br />
                        として計算した結果を表示します。
                    </p>
                </td>

                <td valign="top" style="width:50%">
                    <h3>本サービスをご紹介いただいた方々(順不同)</h3>
                    <p>
			<a href="<?=base_url(); ?>/images/20100712_realestate_news_933.jpg" target="_blank">全国賃貸住宅新聞 No 933 8面</a><br />
			で本サービスが紹介されました。
                    </p>
                    <p>
                        <a href="https://tax.kanae-office.com/" target="_blank">不動産投資専門 - 税理士 叶 温の節税サイト</a><br />
                        税金塾と言ったらこの方ですね！
                    </p>
                    <p>
                        <a href="https://nakameguronozaka.blog40.fc2.com/" target="_blank">中目黒のざかさんマイペース不動産投資日記</a><br />
                        メルマガでいつもご紹介いただいています。ありがとうございます！
                    </p>
                    <p>
                        <a href="https://www.infotop.jp/click.php?aid=141138&iid=42664" target="_blank">空室対策コンサルタント 尾嶋さん</a><br />
                        空室対策は高利回り不動産投資の基本です！
                    </p>
                    <p>
                        <a href="https://realestatebusiness.seesaa.net/" target="_blank">不動産投資 問わず語り</a><br />
                        北海道でがんばる方は必見です！？
                    </p>
                </td>
            </tr>
        </table>


    </div>

    <hr />
    ※あくまでも一般的な数値を基に計算した数値であり、評価額の保証を行うものではありません<br />

</div>
<br />
<br />
<?//=$footer_data; ?>


</body>
</html>
