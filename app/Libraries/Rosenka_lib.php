<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rosenka_lib {
    var $_rosenka_table;
    var $_rosenka_search_log_table;

	//constructor
	public function __construct() {
	        $this->_rosenka_table  = 're_rosenka';
	        $this->_rosenka_search_log_table = 're_rosenka_search_log';
	}

	/*
	 *検索結果の件数を戻り値とする
	 * getCount()
	*/
	function getCount($addr) {
		$CI =& get_instance();
	        $rosenka_table = $this->_rosenka_table;

//		$CI->load->database();

		$sql =<<<_EOT_
SELECT count( `prefecture` ) AS cnt
FROM $rosenka_table
WHERE concat( `prefecture` , `city` , `addr` ) LIKE ?
_EOT_;

		$query = $CI->db->query($sql, '%' . $this->_clean($addr) . '%');

		$row = $query->row();

		return $row->cnt + 0;
	}

	/*
	 *検索結果のDB参照を戻り値とする
	 * getList()
	*/
	function getList($addr) {
	    $CI =& get_instance();
        $rosenka_table = $this->_rosenka_table;
        $rosenka_search_log_table = $this->_rosenka_search_log_table;

//		$CI->load->database();

		$params['address'] = $addr;
//		if ($CI->dx_auth->is_logged_in()) {
//		    $params['user_id'] = $CI->dx_auth->get_user_id();
//            $params['created'] = date('Y/m/d H:i:s');
//		}
		//log_message('debug', print_r($params, True));
		$CI->db->insert($rosenka_search_log_table, $params);

		$sql =<<<_EOT_
SELECT *
FROM $rosenka_table
WHERE concat( `prefecture` , `city` , `addr` ) LIKE ?
_EOT_;

		$query = $CI->db->query($sql, '%' . $this->_clean($addr) . '%');

		return $query;
	}

    /*
     *ログインしたユーザーが持つ検索履歴の件数を戻り値とする
     * getHistoryCount()
    */
    function getHistoryCount($user_id) {
        $CI =& get_instance();
        $rosenka_search_log_table = $this->_rosenka_search_log_table;

//        $CI->load->database();

        $sql =<<<_EOT_
SELECT count( `user_id` ) AS cnt
FROM $rosenka_search_log_table
WHERE `user_id` = ?
_EOT_;

        $query = $CI->db->query($sql, $user_id);

        $row = $query->row();

        return $row->cnt + 0;
    }

    /*
     *ログインしたユーザーが持つ検索履歴のDB参照を戻り値とする
     * getHistoryList()
    */
    function getHistoryList($user_id) {
        $CI =& get_instance();
        $rosenka_search_log_table = $this->_rosenka_search_log_table;

//        $CI->load->database();

//        $params['address'] = $addr;
        if ($CI->dx_auth->is_logged_in()) {
            $params['user_id'] = $CI->dx_auth->get_user_id();
        }

        $sql =<<<_EOT_
SELECT *
FROM $rosenka_search_log_table
WHERE `user_id` = ?
ORDER BY `created` DESC
LIMIT 50
_EOT_;

        $query = $CI->db->query($sql, $user_id);

        return $query;
    }

    /*
     *ログインしたユーザーが持つ検索履歴の件数を戻り値とする
     * deleteHistory()
    */
    function deleteHistory($id, $user_id) {
        $CI =& get_instance();
        $rosenka_search_log_table = $this->_rosenka_search_log_table;

//        $CI->load->database();

        return $CI->db->delete(
                $rosenka_search_log_table,
                array('id'=>$id, 'user_id'=>$user_id)
                );
    }

    /*
	 *検索結果のDB参照を戻り値とする
	 * getCandidate()
	*/
	function getCandidate($addr) {
	    $CI =& get_instance();
        $rosenka_table = $this->_rosenka_table;

//		$CI->load->database();

		$sql =<<<_EOT_
SELECT DISTINCT `prefecture` , `city`
FROM $rosenka_table
WHERE concat( `prefecture` , `city` , `addr` ) LIKE ?
_EOT_;

		$query = $CI->db->query($sql, '%' . $this->_clean($addr) . '%');

		return $query;
	}

	/*
	 *検索結果のDB参照を戻り値とする
	 * getSupportedPrefectureList()
	*/
	function getSupportedPrefectureList() {
		$CI =& get_instance();
        $rosenka_table = $this->_rosenka_table;

//		$CI->load->database();

		$sql =<<<_EOT_
SELECT DISTINCT `prefecture`
FROM $rosenka_table
_EOT_;

		$query = $CI->db->query($sql);

		return $query;
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

	//setter
	function __set($name, $value) {
		$field = '_' . $name;
		$this->{$field} = $value;
	}

	//getter
	function __get($name) {
		$field = '_' . $name;
		return $this->{$field};
	}
}
?>
