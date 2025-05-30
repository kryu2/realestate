<?php
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta http-equiv="Content-Script-Type" content="text/javascript" />
		<title>投資用不動産の路線価検索 - ドリームハイブの不動産関連サービス</title>
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
		<meta name="description" content="路線価情報を取得するためのサポートシステムを、株式会社ドリームハイブ, DREAMHIVEが提供しています" />
		<meta name="keywords" content="ドリームハイブ,DREAMHIVE,不動産,路線価,投資,評価,計算,積算" />
		<meta name="robots" content="INDEX,FOLLOW" />
		<meta name="author" content="株式会社ドリームハイブ" />
		<meta name="Copyright" content="Copyright &#169; 2001-<?php echo date('Y'); ?> DREAMHIVE CO., LTD. All rights reserved." />
		<meta name="Identifier-URL" content="https://services.dreamhive.co.jp/" />
		<meta name="Identifier" content="DREAMHIVE CO., LTD." />
		<meta name="last-modified" content="<?php echo date('Y/m/d', filemtime(__FILE__)); ?>" />
		<meta property="og:title" content="投資用不動産の路線価検索サービス：ドリームハイブの不動産関連サービス" />
		<meta property="og:type" content="article" />
		<meta property="og:url" content="https://services.dreamhive.co.jp/realestate/rosenka/" />
		<meta property="og:image" content="https://services.dreamhive.co.jp/wp-content/uploads/2014/07/rosenka_logo_200x200.jpg" />
		<meta property="og:image:width" content="200" />
		<meta property="og:image:height" content="200" />
		<meta property="og:site_name" content="ITを利用した仕組み作りのプロ集団：システム開発とITコンサルティングの株式会社ドリームハイブ" />
		<meta property="og:description" content="投資用不動産の路線価検索サービス:路線価情報を取得するためのサポートシステムを、株式会社ドリームハイブが提供しています。" />
		<meta property="article:tag" content="ドリームハイブ,DREAMHIVE,不動産,路線価,投資,評価,計算,積算" />
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:description" content="投資用不動産の路線価検索サービス:路線価情報を取得するためのサポートシステムを、株式会社ドリームハイブが提供しています。" />
		<link rev="made" href="mailto:info&#64;dreamhive.co.jp" />
		<link rel="start" href="./index.html" />
        <link rel="stylesheet" href="<?=base_url() ?>/css/y_rashinban.css" type="text/css" />
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- link href="<?=base_url() ?>/css/common.css" rel="stylesheet" type="text/css" / -->
<script type="text/javascript">
//   xajax.callback.global.onRequest = function() {xajax.$('loading').style.display = 'block';};
//   xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loading').style.display='none';};

function openGoogle() {
    addr = 'http://maps.google.co.jp/maps?q=' + encodeURI( $('#addr').val() );
    window.open(addr, '_blank');
}
</script>
		<style type="text/css">
#contents table{border:0px solid silver;border-collapse:collapse;}
#contents th, #contents td{background-color:#f5f5f5;border-top:1px solid silver;border-bottom:1px solid silver;padding:4px 12px;}
#loading {
    display: none; /* hidden */
    font-weight: bold;
    font-size: large;
}
		</style>
	</head>
<body onload="xajax__getSupportedPrefectureList();">

<div id="header">
    <h1>路線価検索:住所を入力するだけで全国27万件の地域情報(PDF)へアクセスできるWebサービス</h1>

    <table style="width:100%;">
        <tr>
            <td>
                <a href="<?=base_url() ?>" title="路線価検索 - <?=base_url() ?>" style="text-indent:0px;height:auto;width:auto;"><img src="<?=base_url() ?>/images/rosenka_logo.jpg" width="200" height="48" border="0" alt="路線価検索 - <?=base_url() ?>" /></a>

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

        <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?=base_url() ?>" data-text="路線価検索:住所を入力するだけで全国27万件の地域情報(PDF)へアクセスできるWebサービス" data-via="dreamhive_jp" data-lang="ja" data-count="horizontal">ツイート</a>
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
    </div>
    <div id="information">

    </div>
</div>

<div id="contents">
    <a href="/realestate/" title="不動産関連サービス"><h2>ドリームハイブの不動産関連サービス</h2></a>
    <h3>路線価検索 - 住所を入力するだけで全国27万件の地域情報(PDF)へアクセスできるWebサービス</h3>

    <form action="" method="post" name="inputForm" id="inputForm" onsubmit="getRosenka();return false;">

        住所：<input type="text" id="addr" name="addr" value="" size="64" />
        <input type="button" value="検索" onclick="getRosenka();" />
        <input type="button" value="Googleマップ" onclick="openGoogle();" />

        <br />
        ※都道府県から入力してください<br />

        <br />

        <div id="getRosenka" onClick=""></div>
<script>
    function getRosenka() {
      var formValues = document.forms['inputForm'];
      $.ajax({
        url: "<?php echo base_url('Rosenka/getRosenka'); ?>",
        data: $(formValues).serialize(),
        beforeSend: function (f) {
          $('#getRosenka').html('<img src="<?=base_url(); ?>/images/spinner.gif" alt="loading..." />処理中...');
        },
        success: function (data) {
          $('#getRosenka').html(data);
        }
      })
    }
</script>
    </form>

    <hr />※国税庁 財産評価基準 からデータを取得しております<br />

</div>
<br />
<br />
<?php //$this->load->view('realestate/footer_data'); ?>

</body>
</html>
