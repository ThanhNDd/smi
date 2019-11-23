<?php

class Zone
{
	public function __construct()
    {
        
    }

	public function get_name_city($id = ''){
		global $tinh_thanhpho;
		if(!is_array($tinh_thanhpho) || empty($tinh_thanhpho)){
			include 'tinh_thanhpho.php';
		}
		$id_tinh = sprintf("%02d", intval($id));
		$tinh_thanhpho = (isset($tinh_thanhpho[$id_tinh]))?$tinh_thanhpho[$id_tinh]:'';
		return $tinh_thanhpho;
	}

	public function get_name_district($id = ''){
		include 'quan_huyen.php';
		$id_quan = sprintf("%03d", intval($id));
		if(is_array($quan_huyen) && !empty($quan_huyen)){
			$nameQuan = $this->search_in_array($quan_huyen,'maqh',$id_quan);
			$nameQuan = isset($nameQuan[0]['name'])?$nameQuan[0]['name']:'';
			return $nameQuan;
		}
		return false;
	}

	public function get_name_village($id = ''){
		include 'xa_phuong_thitran.php';
		$id_xa = sprintf("%05d", intval($id));
		if(is_array($xa_phuong_thitran) && !empty($xa_phuong_thitran)){
			$name = $this->search_in_array($xa_phuong_thitran,'xaid',$id_xa);
			$name = isset($name[0]['name'])?$name[0]['name']:'';
			return $name;
		}
		return false;
	}

	public function search_in_array($array, $key, $value)
	{
	    $results = array();

	    if (is_array($array)) {
	        if (isset($array[$key]) && is_numeric($array[$key]) && $array[$key] == $value) {
	            $results[] = $array;
	        } elseif(isset($array[$key]) && $this->is_serialized($array[$key]) && in_array($value, $this->maybe_unserialize($array[$key]))){
	            $results[] = $array;
	        }
	        foreach ($array as $subarray) {
	            $results = array_merge($results, $this->search_in_array($subarray, $key, $value));
	        }
	    }

	    return $results;
	}

	public function get_list_city() {
		global $tinh_thanhpho;
		if(!is_array($tinh_thanhpho) || empty($tinh_thanhpho)){
			include 'tinh_thanhpho.php';
		}
		$arr = array();
		foreach ($tinh_thanhpho as $key => $value)
		{
			$city = array(
				'id' => $key,
				'text' => $value
			);
			array_push($arr, $city);
		}
		$content = array();
		$content['results'] = $arr;
		return json_encode($content);
	}
	
	function get_list_district($matp = '') {
		if(!$matp) return false;
		include 'quan_huyen.php';
		$matp = sprintf("%02d", intval($matp));
		$result = $this->search_in_array($quan_huyen,'matp',$matp);
		$districts = array();
		foreach ($result as $key => $value)
		{
			$district = array(
				'id' => $value["maqh"],
				'text' => $value["name"]
			);
			array_push($districts, $district);
		}
		$content = array();
		$content['results'] = $districts;
		return json_encode($content);
	}

	function get_list_village($maqh = ''){
		if(!$maqh) return false;
		include 'xa_phuong_thitran.php';
		$id_xa = sprintf("%05d", intval($maqh));
		$result = $this->search_in_array($xa_phuong_thitran,'maqh',$id_xa);
		$villages = array();
		foreach ($result as $key => $value)
		{
			$village = array(
				'id' => $value["xaid"],
				'text' => $value["name"]
			);
			array_push($villages, $village);
		}
		$content = array();
		$content['results'] = $villages;
		return json_encode($content);
	}

    function get_list_district_select($matp = ''){
        $district_select  = array();
        $district_select_array = $this->get_list_district($matp);
        if($district_select_array && is_array($district_select_array)){
            foreach ($district_select_array as $district){
                $district_select[$district['maqh']] = $district['name'];
            }
        }
        return $district_select;
    }

	

    function get_list_village_select($maqh = ''){
        $village_select  = array();
        $village_select_array = $this->get_list_village($maqh);
        if($village_select_array && is_array($village_select_array)){
            foreach ($village_select_array as $village){
                $village_select[$village['xaid']] = $village['name'];
            }
        }
        return $village_select;
    }
	/**
	 * Unserialize value only if it was serialized.
	 *
	 * @since 2.0.0
	 *
	 * @param string $original Maybe unserialized original, if is needed.
	 * @return mixed Unserialized data can be any type.
	 */
	public function maybe_unserialize( $original ) {
		if ( is_serialized( $original ) ) { // don't attempt to unserialize data that wasn't serialized going in
			return @unserialize( $original );
		}
		return $original;
	}

	/**
	 * Check value to find if it was serialized.
	 *
	 * If $data is not an string, then returned value will always be false.
	 * Serialized data is always a string.
	 *
	 * @since 2.0.5
	 *
	 * @param string $data   Value to check to see if was serialized.
	 * @param bool   $strict Optional. Whether to be strict about the end of the string. Default true.
	 * @return bool False if not serialized and true if it was.
	 */
	public function is_serialized( $data, $strict = true ) {
		// if it isn't a string, it isn't serialized.
		if ( ! is_string( $data ) ) {
			return false;
		}
		$data = trim( $data );
		if ( 'N;' == $data ) {
			return true;
		}
		if ( strlen( $data ) < 4 ) {
			return false;
		}
		if ( ':' !== $data[1] ) {
			return false;
		}
		if ( $strict ) {
			$lastc = substr( $data, -1 );
			if ( ';' !== $lastc && '}' !== $lastc ) {
				return false;
			}
		} else {
			$semicolon = strpos( $data, ';' );
			$brace     = strpos( $data, '}' );
			// Either ; or } must exist.
			if ( false === $semicolon && false === $brace ) {
				return false;
			}
			// But neither must be in the first X characters.
			if ( false !== $semicolon && $semicolon < 3 ) {
				return false;
			}
			if ( false !== $brace && $brace < 4 ) {
				return false;
			}
		}
		$token = $data[0];
		switch ( $token ) {
			case 's':
				if ( $strict ) {
					if ( '"' !== substr( $data, -2, 1 ) ) {
						return false;
					}
				} elseif ( false === strpos( $data, '"' ) ) {
					return false;
				}
				// or else fall through
			case 'a':
			case 'O':
				return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
			case 'b':
			case 'i':
			case 'd':
				$end = $strict ? '$' : '';
				return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
		}
		return false;
	}
}