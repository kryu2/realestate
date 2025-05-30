<?php 
namespace App\Models;
use CodeIgniter\Model;
 
class RosenkaModel extends Model
{
  protected $table = 're_rosenka';
  protected $allowedFields = ['name', 'email'];
  
  public function getRosenka($id = false) {
    if($id === false) {
      return $this->findAll();
    } else {
        return $this->getWhere(['id' => $id]);
    }
  }

	/*
	 *検索結果の件数を戻り値とする
	 * getCount()
	*/
  public function getCount($address = '') {
      $db = \Config\Database::connect();

      $sql =<<<_EOT_
      SELECT count( `prefecture` ) AS cnt
      FROM $this->table
      WHERE concat( `prefecture` , `city` , `addr` ) LIKE ?
      _EOT_;

	  	$query = $db->query($sql, ['%' . $db->escapeLikeString( $this->_clean($address) ) . '%']);
      // echo $db->getLastQuery(); //最後に実行したSQL
  		$result = $query->getRow();
      return $result->cnt + 0;
    }

	/*
	 *検索結果のDB参照を戻り値とする
	 * getByAddress($address)
	*/
	public function getByAddress($address = '')
  {
    $db = \Config\Database::connect();

    $params['address'] = $address;
    //		if ($CI->dx_auth->is_logged_in()) {
    //		    $params['user_id'] = $CI->dx_auth->get_user_id();
    //            $params['created'] = date('Y/m/d H:i:s');
    //		}
    //log_message('debug', print_r($params, True));
    $db->table('re_rosenka_search_log')->insert($params);

    $sql =<<<_EOT_
    SELECT *
    FROM $this->table
    WHERE concat( `prefecture` , `city` , `addr` ) LIKE ?
    _EOT_;

    $query = $db->query($sql, ['%' . $db->escapeLikeString( $this->_clean($address) ) . '%']);
    // $result = $query->getResult();

    foreach( $query->getResult() as $row ) {
      $result[] = array(
        'prefecture' => $row->prefecture,
        'city' => $row->city,
        'addr' => $row->addr,
        'no' => $row->no,
        'url' => $row->url
      );
    }

    return json_encode( $result );
    // return 0;
  }

	/*
	 *全角の記号等を半角に変換し、路線価情報として検索可能な戻り値とする
	 * _clean()
	*/
	function _clean($s) {
		if ($s == '') { return $s; }

		$search  = array(
			'丁目', '番地', '号室', '号棟', 'ー', '－', '（', '）');
		$replace = array(
			'-', '-', '', '-', '-', '-', '(', ')');

		$s = str_replace($search, $replace, $s);

		$heystack  = array(
			'１', '２', '３', '４', '５', '６', '７', '８', '９', '０',
			'一', '二', '三', '四', '五', '六', '七', '八', '九', '〇',
			'1', '2', '3', '4', '5', '6', '7', '8', '9',
			'-');

		$addrAfter = '';
		for ($i = mb_strlen($s); 0 <= $i; $i--) {
			$char = mb_substr($s, $i - 1, 1);
			if (in_array($char, array('番','号'))) {
				$c_next = mb_substr($s, $i - 2, 1);
				if (in_array($c_next, $heystack)) {
					$addrAfter = $char . $addrAfter;
					continue;
				}
			}
			if (!in_array($char, $heystack)) {
				$addrBefore = mb_substr($s, 0, $i);
				break;
			}
			$addrAfter = $char . $addrAfter;
		}

		$search  = array(
			'１', '２', '３', '４', '５', '６', '７', '８', '９', '０',
			'一', '二', '三', '四', '五', '六', '七', '八', '九', '〇');
		$replace = array(
			'1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
			'1', '2', '3', '4', '5', '6', '7', '8', '9', '0');

		$addrAfter = str_replace($search, $replace, $addrAfter);

		//add mkoba
		$search  = array(
			'ヶ', 'ケ',
		);
		$replace = array(
			'%', '%',
		);

		$addrBefore = str_replace($search, $replace, $addrBefore);

//		$s = $addrBefore . $addrAfter;
		$s = $addrBefore;

//		$s = preg_replace('/^(.+?)([-\d]).*$/', '$1$2', $s);
		$s = preg_replace('/^(.+?)([-\d]).*$/', '$1', $s);

		//add mkoba
		$search  = array(
			'１', '２', '３', '４', '５', '６', '７', '８', '９', '０',
//			'一', '二', '三', '四', '五', '六', '七', '八', '九', '〇',
		);
		$replace = array(
			'1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
//			'1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
		);
		$s = str_replace($search, $replace, $s);
		return $s;
	}
}