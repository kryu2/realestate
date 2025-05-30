<?php
namespace App\Controllers;
use App\Models\RosenkaModel;

class Rosenka extends BaseController {
	var $xr;

	public function __construct()
	{
		// parent::__construct();
		date_default_timezone_set('Asia/Tokyo'); 

		// $this->load->library('rosenka_lib', '', 'rosenka');
		// $this->load->library('useXajax');

		// $this->xa->register(XAJAX_FUNCTION, array($this, '_getRosenka'));
	        // $this->xa->register(XAJAX_FUNCTION, array($this, '_sendNotFoundAddress'));
//	        $this->xa->register(XAJAX_FUNCTION, array($this, '_getRosenkaHistory'));
//	        $this->xa->register(XAJAX_FUNCTION, array($this, '_deleteRosenkaHistory'));
//		$this->xa->register(XAJAX_FUNCTION, array(&$this, '_getRosenka'));
//	        $this->xa->register(XAJAX_FUNCTION, array(&$this, '_getRosenkaHistory'));
//	        $this->xa->register(XAJAX_FUNCTION, array(&$this, '_deleteRosenkaHistory'));
//	        $this->xa->register(XAJAX_FUNCTION, array(&$this, '_sendNotFoundAddress'));
//		$this->xa->register(XAJAX_FUNCTION, array(&$this, '_getSupportedPrefectureList'));
		//$this->xa->register(XAJAX_FUNCTION, array($this, 'test'));

		// $this->xa->processRequest();
	}

	/**
	 *
	**/
	public function index()
	{
//		echo $this->xa->getJavascript();
		$temp = array();
		// $data['header_data'] = $this->load->view('realestate/header_data', $temp, True);
		// $data['footer_data'] = $this->load->view('realestate/footer_data', $temp, True);
        return view('realestate/rosenka');
		// $this->load->view('realestate/rosenka', $data);
	}

	public function getCount()
	{
		$db = \Config\Database::connect();

		$sql =<<<_EOT_
		SELECT count( `prefecture` ) AS cnt
		FROM re_rosenka
		_EOT_;
		$query = $db->query($sql);
		$row = $query->getRow();
		echo $row->cnt + 0;
	}

	/**
	 *
	**/
	public function getRosenka()
	{
		$rosenkaModel = new RosenkaModel();
		// var_dump($_GET);
		// echo $this->request->getVar('addr'); //リクエストパラメータ

		$res = '';
		$cnt = $rosenkaModel->getCount( $this->request->getVar('addr') );
		if ($cnt == 0) {
			$res = '住所が間違っているか、路線価のない住所です。<br /><br />';
			// $res .= '<input type="button" onClick="xajax__sendNotFoundAddress(xajax.getFormValues(\'InputForm\'));" value="→ 正しい住所なのに見つからないことを報告" alt="住所が正しいのに見つからない方は、次のボタンをクリックして検索精度の向上にご協力いただけると助かります。"/><br />';
		} elseif ($cnt <= 50) {
			$result = json_decode( $rosenkaModel->getByAddress( $this->request->getVar('addr') ) );
			// var_dump($result);
			$res = "$cnt 件見つかりました<br />";
			$res .= '<table>';
			$res .= '<th>住所</th><th>地図No</th><th>R3 年度の路線価図</th><th>R2 年度の路線価図</th><th>R1 年度の路線価図</th>';
			foreach ($result as $row) {
				$pdfurl = preg_replace('@^(.+)html\/.*$@i', '\1',  $row->url) . "pdf/{$row->no}.pdf";
				$res .= "<tr><td>{$row->prefecture}{$row->city}{$row->addr}</td><td>$row->no</td>" .
                        "<td><a href='http://www.rosenka.nta.go.jp/main_r03/{$row->url}' target='_blank'>→ 路線価図</a> <a href='http://www.rosenka.nta.go.jp/main_r03/{$pdfurl}' target='_blank'>→ PDF</a></td>" .
                        "<td><a href='http://www.rosenka.nta.go.jp/main_r02/{$row->url}' target='_blank'>→ 路線価図</a> <a href='http://www.rosenka.nta.go.jp/main_r02/{$pdfurl}' target='_blank'>→ PDF</a></td>" .
                        "<td><a href='http://www.rosenka.nta.go.jp/main_r01/{$row->url}' target='_blank'>→ 路線価図</a> <a href='http://www.rosenka.nta.go.jp/main_r01/{$pdfurl}' target='_blank'>→ PDF</a></td>";
			}
			$res .= '</table>';
		} else {
			$res = "$cnt 件あり、すべてを表示できません。絞り込むための住所情報を追加で入力してください";
			//$this->xr->assign('addrList', 'innerHTML', '候補<br />');
		}
		// $this->xr->assign('rosenkaTable', 'innerHTML', $res);

		// return $this->xr;
		echo $res;
	}

    /**
     *
    **/
    private function _getRosenkaHistory()
    {
        $this->xr = new xajaxResponse;

        $res = '';
        $cnt = $this->rosenka->getHistoryCount($this->dx_auth->get_user_id());
        if ($cnt == 0) {
            $res = '履歴はありません。<br /><br />';
        } else {
            $query = $this->rosenka->getHistoryList($this->dx_auth->get_user_id());
            $res = "$cnt 件<br />";
            $res .= '<table>';
            $res .= '<th>住所</th><th>操作</th><th>検索日</th>';
            foreach ($query->result() as $row) {
                $putaddr_jscode = 'onclick="xajax.$(' . "'addr'" . ').value=' . "'{$row->prefecture}{$row->city}{$row->addr}{$row->address}'" . '"';
                $delete_jscode = 'onclick="if (confirm(' . "'履歴を削除しますか？この処理は元に戻せません'" . ')) { xajax__deleteRosenkaHistory(' . $row->id . '); xajax__getRosenkaHistory(); }"';
                $createdate = date('Y/m/d H:i:s', strtotime($row->created));
                $res .= "<tr><td><a {$putaddr_jscode}>{$row->prefecture}{$row->city}{$row->addr}{$row->address}</a></td><td><a {$delete_jscode}>削除</a></td><td>{$createdate}</td></tr>";
            }
            $res .= '</table>';
        }
        $this->xr->assign('historyList', 'innerHTML', $res);

        return $this->xr;
    }

    /**
     *
    **/
    private function _deleteRosenkaHistory($id)
    {
        $this->xr = new xajaxResponse;

        $this->rosenka->deleteHistory($id, $this->dx_auth->get_user_id());

        return $this->xr;
    }

    /**
	 *
	**/
	private function _getSupportedPrefectureList()
	{
		$this->xr = new xajaxResponse;

		$res = '';
		$query = $this->rosenka->getSupportedPrefectureList();
		foreach ($query->result() as $row) {
			$res .= "{$row->prefecture}, ";
		}

		$this->xr->assign('supportedPrefectureList', 'innerHTML', $res);

		return $this->xr;
	}

	/**
	 *
	**/
	public function _sendNotFoundAddress($formValues)
	{
		$this->xr = new xajaxResponse;

		$error_level = error_reporting(0);
		$this->load->library('UseQdmail');
		if ($this->mail->easyText(
				array('support@dreamhive.co.jp', '路線価検索'),
				'住所が見つからない：' . $this->stripspaces($formValues['addr']),
				'検索ができない住所：' . $this->stripspaces($formValues['addr']),
				array('support@dreamhive.co.jp', '路線価検索')
			)) {
			$this->xr->alert("ご協力ありがとうございます。\n検索できない住所情報を受け付けました。");
		} else {
			$this->xr->alert("登録時にエラーが発生しました。\n時間を空けて再度ご協力をお願いいたします。");
		}
		error_reporting($error_level);

//		$this->load->library('email');
//		$this->email->from('support@dreamhive.co.jp', 'dHive 路線価検索');
//		$this->email->to('support@dreamhive.co.jp');
//		$this->email->subject('住所が見つからない：' . $this->stripspaces($formValues['addr']));
//		$this->email->message(
//			'検索ができない住所：' . $this->stripspaces($formValues['addr'])
//		);

//		if ($this->email->send()) {
//			$this->xr->alert("ご協力ありがとうございます。\n検索できない住所情報を受け付けました。");
//		} else {
//			$this->xr->alert("登録時にエラーが発生しました。\n時間を空けて再度ご協力をお願いいたします。");
//		}

		return $this->xr;
	}

	/**
	 *
	**/
	public function getCityArrays() {
		set_time_limit(180);
		ini_set('user_agent', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)');

		$base = 'http://www.rosenka.nta.go.jp/main_h21/';
		$prefcity  = 'tokyo/tokyo/';
		//$prefcity  = 'osaka/osaka/';
		//$prefcity  = 'nagoya/aichi/';
		//$prefcity  = 'tokyo/kanagawa/';
		//$prefcity  = 'kanazawa/toyama/';
		//$prefcity  = 'kanazawa/isikawa/';
		//$prefcity  = 'kanazawa/fukui/';
		//$prefcity  = 'sapporo/hokkaido/';
		//$prefcity  = 'kanto/saitama/';
		//$prefcity  = 'tokyo/chiba/';
		//$prefcity  = 'kanto/ibaraki/';
		//$prefcity  = 'kanto/tochigi/';
		//$prefcity  = 'kanto/gunma/';
		//$prefcity  = 'tokyo/yamanasi/';
		//$prefcity  = 'sendai/aomori/';
		//$prefcity  = 'sendai/iwate/';
		//$prefcity  = 'sendai/miyagi/';
		//$prefcity  = 'sendai/akita/';
		//$prefcity  = 'sendai/yamagata/';
		//$prefcity  = 'sendai/fukusima/';
		//$prefcity  = 'kanto/niigata/';
		//$prefcity  = 'kanto/nagano/';
		//$prefcity  = 'nagoya/gifu/';
		//$prefcity  = 'nagoya/sizuoka/';
		//$prefcity  = 'nagoya/mie/';
		//$prefcity  = 'osaka/hyogo/';
		//$prefcity  = 'osaka/kyoto/';
		//$prefcity  = 'osaka/shiga/';
		//$prefcity  = 'osaka/nara/';
		//$prefcity  = 'osaka/wakayama/';
		//$prefcity  = 'hirosima/tottori/';
		//$prefcity  = 'hirosima/simane/';
		//$prefcity  = 'hirosima/okayama/';
		//$prefcity  = 'hirosima/hirosima/';
		//$prefcity  = 'hirosima/yamaguti/';
		//$prefcity  = 'takamatu/tokusima/';
		//$prefcity  = 'takamatu/kagawa/';
		//$prefcity  = 'takamatu/ehime/';
		//$prefcity  = 'takamatu/koti/';
		//$prefcity  = 'fukuoka/fukuoka/';
		//$prefcity  = 'fukuoka/saga/';
		//$prefcity  = 'fukuoka/nagasaki/';
		//$prefcity  = 'kumamoto/kumamoto/';
		//$prefcity  = 'kumamoto/oita/';
		//$prefcity  = 'kumamoto/miyazaki/';
		//$prefcity  = 'kumamoto/kagosima/';
		//$prefcity  = 'okinawa/okinawa/';

		$url = $base . $prefcity . 'prices/city_lst.htm';

		$s = mb_convert_encoding(file_get_contents($url), 'utf8', 'Shift-JIS');

		$search = array(
			'@^.*<table[^>]*>@si',
			'@</table>.*@si',
			'@<td[^>]*>[あ-ん]</td>@u',
			'@<td class="mark1">.*@',

			'@<br>@',
			'@<[/]?tr>@',
			'@<td[^>]*>\s+</td>@',
			'@<td[^>]*>(.*)</td>@',

			'@<td[^>]*>(.*)@',
			'@<a[^>]*href="(.+?)fr.htm">(.*)</a>@',
			'@^\s+@m',
			'@^\r\n@m',
		);

		$replace = array(
			'',
			'',
			'',
			'',

			'',
			'',
			'',
			'$1',

			'$1',
			'array("addr"=>"東京都,$2","url"=>"' . $base . $prefcity . 'prices/$1lt.htm"),<br />',
			'',
			'',
		);

		$s = preg_replace($search, $replace, $s);

		echo $s;
	}

	/**
	 *
	**/
	public function getCSVs() {
		$data = array(
array("addr"=>"東京都,足立区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d21104lt.htm"),
array("addr"=>"東京都,荒川区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d21106lt.htm"),
array("addr"=>"東京都,板橋区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d21201lt.htm"),
array("addr"=>"東京都,江戸川区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d21401lt.htm"),
array("addr"=>"東京都,大田区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d21503lt.htm"),
array("addr"=>"東京都,葛飾区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d22101lt.htm"),
array("addr"=>"東京都,北区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d22201lt.htm"),
array("addr"=>"東京都,江東区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d22502lt.htm"),
array("addr"=>"東京都,品川区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d23201lt.htm"),
array("addr"=>"東京都,渋谷区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d23203lt.htm"),
array("addr"=>"東京都,新宿区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d23204lt.htm"),
array("addr"=>"東京都,杉並区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d23301lt.htm"),
array("addr"=>"東京都,墨田区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d23303lt.htm"),
array("addr"=>"東京都,世田谷区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d23401lt.htm"),
array("addr"=>"東京都,台東区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d24101lt.htm"),
array("addr"=>"東京都,中央区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d24201lt.htm"),
array("addr"=>"東京都,千代田区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d24204lt.htm"),
array("addr"=>"東京都,豊島区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d24501lt.htm"),
array("addr"=>"東京都,中野区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d25101lt.htm"),
array("addr"=>"東京都,練馬区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d25401lt.htm"),
array("addr"=>"東京都,文京区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d26303lt.htm"),
array("addr"=>"東京都,港区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d27204lt.htm"),
array("addr"=>"東京都,目黒区","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d27401lt.htm"),
array("addr"=>"東京都,昭島市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d21102lt.htm"),
array("addr"=>"東京都,あきる野市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d21103lt.htm"),
array("addr"=>"東京都,稲城市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d21202lt.htm"),
array("addr"=>"東京都,青梅市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d21501lt.htm"),
array("addr"=>"東京都,大島町","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d21502lt.htm"),
array("addr"=>"東京都,清瀬市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d22202lt.htm"),
array("addr"=>"東京都,国立市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d22301lt.htm"),
array("addr"=>"東京都,小金井市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d22504lt.htm"),
array("addr"=>"東京都,国分寺市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d22505lt.htm"),
array("addr"=>"東京都,小平市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d22506lt.htm"),
array("addr"=>"東京都,狛江市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d22507lt.htm"),
array("addr"=>"東京都,立川市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d24104lt.htm"),
array("addr"=>"東京都,多摩市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d24103lt.htm"),
array("addr"=>"東京都,調布市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d24203lt.htm"),
array("addr"=>"東京都,西東京市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d25202lt.htm"),
array("addr"=>"東京都,八王子市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d26101lt.htm"),
array("addr"=>"東京都,羽村市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d26103lt.htm"),
array("addr"=>"東京都,東久留米市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d26201lt.htm"),
array("addr"=>"東京都,東村山市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d26202lt.htm"),
array("addr"=>"東京都,東大和市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d26203lt.htm"),
array("addr"=>"東京都,日野市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d26204lt.htm"),
array("addr"=>"東京都,府中市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d26301lt.htm"),
array("addr"=>"東京都,福生市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d26302lt.htm"),
array("addr"=>"東京都,町田市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d27101lt.htm"),
array("addr"=>"東京都,瑞穂町","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d27202lt.htm"),
array("addr"=>"東京都,三鷹市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d27203lt.htm"),
array("addr"=>"東京都,武蔵野市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d27301lt.htm"),
array("addr"=>"東京都,武蔵村山市","url"=>"http://www.rosenka.nta.go.jp/main_h21/tokyo/tokyo/prices/d27302lt.htm"),
	   );

		$preU = 'tokyo/tokyo/' . 'prices/html/';

		set_time_limit(180);
		foreach ($data as $row) {
			echo $row['addr'];
			flush();
			$cnt = $this->_getCSV($row['url'], $row['addr'], $preU);
			echo "($cnt) 終了<br>";
		}
		echo '<hr>すべて終了';
	}

	/**
	 *
	**/
	function test() {
		$s = $this->_getCSV("http://www.rosenka.nta.go.jp/main_h21/sapporo/hokkaido/prices/a16303lt.htm", "北海道,深川市", 'sapporo/hokkaido/prices/html/');
		var_dump($s);
	}

	/**
	 *
	**/
	function test2() {
		$url = 'http://www.rosenka.nta.go.jp/main_h21/osaka/osaka/prices/g38101lt.htm';
		$addr = '大阪,八尾市';
		$preU = 'osaka/osaka/prices/html/';

		$this->_getCSV($url, $addr, $preU);

		echo 'end';
	}

	/**
	 *
	**/
	function test3() {
		$fp = fsockopen('www.rosenka.nta.go.jp', 80, $errno, $errstr, 30);
		if (!$fp) {
			echo "$errstr ($errno)<br />\n";
		} else {
			$out = "GET /main_h21/osaka/osaka/prices/g31201lt.htm HTTP/1.1\r\n";
			$out .= "Host: www.example.com\r\n";
			$out .= "Connection: Close\r\n\r\n";

			fwrite($fp, $out);
			while (!feof($fp)) {
				echo fgets($fp, 128);
			}
			fclose($fp);
		}
	}

	/**
	 *
	**/
	public function _getCSV($url, $addr, $preU) {
		$this->load->helper('file');

		$s = file_get_contents($url);
		$s = mb_convert_encoding($s, 'utf8', 'Shift-JIS');

		//正規表現で動かないページがあったため、正規表現を使わないで操作する方法に(大阪府八尾市など)
		$s = substr($s, strripos($s, '<table'));
		$s = substr($s, stripos($s, '>') + 1);

//			  '@^.*<table[^>]*>@si',
		$search = array(
			'@</table>.*@si',
			'@<td[^>]*>[あ-ん]</td>@u',
			'@<td[^>]*>(.*)</td>@',
			'@<a[^>]*>(.*)</a>@',
			'@<[/]?tr>@',
			'@^\r\n@m',
		);

//			  '',
		$replace = array(
			'',
			'',
			'$1',
			'$1',
			'',
			'',
		);

		$s = preg_replace($search, $replace, $s);

		$search = array('１', '２', '３', '４', '５', '６', '７', '８', '９', '０', '（', '）');

		$replace = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '(', ')');

		$s = trim(str_replace($search, $replace, $s));

		$s = explode("\r\n", $s);

		$lines = array();
		foreach ($s as $row) {
			if (!preg_match('@^\d{5}$@u', $row)) {
				$cityName = $row;
			} else {
				$lines[] = "21," . mb_convert_encoding("$addr,$cityName", 'Shift-JIS', 'utf8') . ",$row,,,$preU${row}f.htm";
			}
		}

		$s = implode("\r\n", $lines) . "\r\n";

		write_file(mb_convert_encoding($addr, 'Shift-JIS', 'utf8') . '.csv', $s);

		return count($lines);
	}

	/**
	 * スペース削除フィルタ(add mkoba)
	**/
	private function stripspaces($string){
		$all="　";//全角スペース
		$half=" ";//半角スペース
		$tab="\t";//タブ
		$string=str_replace(array($all,$half,$tab),"",$string);
		return $string;
	}
}
?>