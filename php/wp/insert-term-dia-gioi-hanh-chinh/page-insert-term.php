<?php
/**
 * Insert term cho địa giới hành chính
 */
class Taxonomy_Diagioihanhchinh {
	public $taxonomy = 'city-realty';
	public $file     = '';
	public $tinh_tp  = array(
		 '01:Hà Nội'
		,'02:Hà Giang'
		,'04:Cao Bằng'
		,'06:Bắc Kạn'
		,'08:Tuyên Quang'
		,'10:Lào Cai'
		,'11:Điện Biên'
		,'12:Lai Châu'
		,'14:Sơn La'
		,'15:Yên Bái'
		,'17:Hoà Bình'
		,'19:Thái Nguyên'
		,'20:Lạng Sơn'
		,'22:Quảng Ninh'
		,'24:Bắc Giang'
		,'25:Phú Thọ'
		,'26:Vĩnh Phúc'
		,'27:Bắc Ninh'
		,'30:Hải Dương'
		,'31:Hải Phòng'
		,'33:Hưng Yên'
		,'34:Thái Bình'
		,'35:Hà Nam'
		,'36:Nam Định'
		,'37:Ninh Bình'
		,'38:Thanh Hóa'
		,'40:Nghệ An'
		,'42:Hà Tĩnh'
		,'44:Quảng Bình'
		,'45:Quảng Trị'
		,'46:Thừa Thiên Huế'
		,'48:Đà Nẵng'
		,'49:Quảng Nam'
		,'51:Quảng Ngãi'
		,'52:Bình Định'
		,'54:Phú Yên'
		,'56:Khánh Hòa'
		,'58:Ninh Thuận'
		,'60:Bình Thuận'
		,'62:Kon Tum'
		,'64:Gia Lai'
		,'66:Đắk Lắk'
		,'67:Đắk Nông'
		,'68:Lâm Đồng'
		,'70:Bình Phước'
		,'72:Tây Ninh'
		,'74:Bình Dương'
		,'75:Đồng Nai'
		,'77:Bà Rịa - Vũng Tàu'
		,'79:Hồ Chí Minh'
		,'80:Long An'
		,'82:Tiền Giang'
		,'83:Bến Tre'
		,'84:Trà Vinh'
		,'86:Vĩnh Long'
		,'87:Đồng Tháp'
		,'89:An Giang'
		,'91:Kiên Giang'
		,'92:Cần Thơ'
		,'93:Hậu Giang'
		,'94:Sóc Trăng'
		,'95:Bạc Liêu'
		,'96:Cà Mau'
	);
	public function __construct($file){
		$this->startSesstion();
		$this->file = $file;
	}

	public function startSesstion() {
	    if(!session_id()) {
	        session_start();
	    }
	}

	public function DeleteTerms(){
		global $wpdb;
		$query = '
			SELECT DISTINCT
                t.term_id
            FROM
                '.$wpdb->prefix.'terms t
            INNER JOIN
                '.$wpdb->prefix.'term_taxonomy tax
            ON
             `tax`.term_id = `t`.term_id
            WHERE
                ( `tax`.taxonomy = "'.$this->taxonomy.'")
        ';
		$result =  $wpdb->get_results($query , ARRAY_A);
		if( count($result) > 0 ){
			foreach ($result as $term) {
		        wp_delete_term( $term['term_id'], $this->taxonomy );
		    }
		    echo "Delete term succesfully !";
		}else{
			echo "Term not found!";
		}
	}

	public function setSession(){
		$_SESSION['tinh_tp'] = $this->tinh_tp;
	}
	/**
	 * Warning: Có thể bị timeout
	 */
	public function insert_all(){
		$data_tmp = file_get_contents($this->file);
		$data     = json_decode($data_tmp, true);
		if( count($data) > 0 ){
			//variable check insert fully
			$count_tp = 0;
			$count_qh = 0;
			$count_xa = 0;
			foreach($data as $k => $v){
				$city_tmp     = explode(':', $k);
				$city_id      = $city_tmp[0];
				$city         = $city_tmp[1];
				$term_exists  = term_exists( $city, $taxonomy, 0 );
				if ( $term_exists === 0 || $term_exists === null ) {
					$city_term_id = wp_insert_term( $city, $taxonomy );
					if ( is_wp_error($city_term_id) ) {
						echo '<pre>';
						print_r($city_term_id);
					  echo '<br>1-Error insert city: '.$k;
					  continue;
					}
					$count_tp++;
					foreach($v as $a => $b){
						$qh_tmp         = explode(':', $a);
						$qh_id          = $qh_tmp[0];
						$qh             = $qh_tmp[1];
						$qh_term_exists = term_exists( $qh, $taxonomy, $city_term_id['term_id'] );
						if ( $qh_term_exists === 0 || $qh_term_exists === null ) {
							$qh_term_id = wp_insert_term( $qh, $taxonomy, array('parent'=>$city_term_id['term_id']) );
							if ( is_wp_error($qh_term_id) ) {
							  echo '<br>2-Error insert qh: '.$a;
							  continue;
							}
							$count_qh++;
							foreach($b as $key => $value){
								$xa_term_exists = term_exists( $value['tenxa'], $taxonomy, $qh_term_id['term_id'] );
								if ( $xa_term_exists === 0 || $xa_term_exists === null ) {
									$xa_term_id = wp_insert_term( $value['tenxa'], $taxonomy, array('parent'=>$qh_term_id['term_id']) );
									if ( is_wp_error($xa_term_id) ) {
									  echo '<br>3-Error insert xa: '.$value['xaid'];
									  continue;
									}
								}else{
									$i = 1;
									foreach( $xa_term_exists as $key_dup => $value_dup ){
										if( $value_dup == $qh_term_id['term_id'] ){
											$xa_term_id = wp_insert_term( $value['tenxa'].'_'.$i, $taxonomy, array('parent'=>$qh_term_id['term_id']) );
											if ( is_wp_error($xa_term_id) ) {
											  echo '<br>3-Error insert xa: '.$value['xaid'];
											  continue;
											}
										}
										$i++;
									}
								}
							}
						}else{
							echo '<br>2-Error qh duplicate: '.$a;
						}
					}
				}else{
					echo '<br>1-Error city duplicate: '.$k;
				}
			}
		}
	}

	/**
	 * Insert 1 tinh/thanhpho 1 lần
	 * use $_SESSION['tinh_tp']
	 */
	public function insert_step_by_step(){
		$data_tmp = file_get_contents($this->file);
		$data     = json_decode($data_tmp, true);
		if( isset($_SESSION['tinh_tp']) ){
			echo '<pre>';
			print_r( $_SESSION['tinh_tp'] );
			echo '</pre>';
			foreach($_SESSION['tinh_tp'] as $k => $v){
				$status = $this->insert_one($v);
				$_SESSION['status'][$v] = $status;
				unset($_SESSION['tinh_tp'][$k]);
				wp_redirect( site_url().'/insert-term/' );
			}
		}
	}

	public function insert_one($key_term){
		$data_tmp = file_get_contents($this->file);
		$data     = json_decode($data_tmp, true);
		$return = array(
			'status' => true,
			'msg' => array()
		);
		$flag = true;
		//variable check insert fully
		$count_qh = 0;
		$count_xa = 0;
		$city_tmp     = explode(':', $key_term);
		$city_id      = $city_tmp[0];
		$city         = $city_tmp[1];
		$term_exists  = term_exists( $city, $this->taxonomy, 0 );
		if ( $term_exists === 0 || $term_exists === null ) {
			$city_term_id = wp_insert_term( $city, $this->taxonomy );
			if ( is_wp_error($city_term_id) ) {
			  $return['status'] = false;
			  $return['msg'][] = '1-Error insert city: '.$key_term;
			  return $return;
			}
			foreach($data[$key_term] as $a => $b){
				$qh_tmp         = explode(':', $a);
				$qh_id          = $qh_tmp[0];
				$qh             = $qh_tmp[1];
				$qh_term_exists = term_exists( $qh, $this->taxonomy, $city_term_id['term_id'] );
				if ( $qh_term_exists === 0 || $qh_term_exists === null ) {
					$qh_term_id = wp_insert_term( $qh, $this->taxonomy, array('parent'=>$city_term_id['term_id']) );
					if ( is_wp_error($qh_term_id) ) {
					  $return['status'] = false;
					  $return['msg'][] = '2-Error insert qh: '.$a;
					  $return['count_qh'] = $count_qh;
					  continue;
					}
					$count_qh++;
					foreach($b as $key => $value){
						$xa_term_exists = term_exists( $value['tenxa'], $this->taxonomy, $qh_term_id['term_id'] );
						if ( $xa_term_exists === 0 || $xa_term_exists === null ) {
							$xa_term_id = wp_insert_term( $value['tenxa'], $this->taxonomy, array('parent'=>$qh_term_id['term_id']) );
							if ( is_wp_error($xa_term_id) ) {
								$return['status'] = false;
								$return['msg'][] = '3-Error insert xa: '.$value['xaid'];
							    continue;
							}
						}else{
							$i = 1;
							foreach( $xa_term_exists as $key_dup => $value_dup ){
								if( $value_dup == $qh_term_id['term_id'] ){
									$xa_term_id = wp_insert_term( $value['tenxa'].'_'.$i, $this->taxonomy, array('parent'=>$qh_term_id['term_id']) );
									if ( is_wp_error($xa_term_id) ) {
										$return['status'] = false;
										$return['msg'][] = '3-Error insert xa: '.$value['xaid'];
									    continue;
									}
								}
								$i++;
							}
						}
					}
				}else{
					$return['status'] = false;
					$return['msg'][] = '2-Error qh duplicate: '.$a;
					$return['count_qh'] = $count_qh;
				}
			}
		}else{
			$return['status'] = false;
			$return['msg'][] = '1-Error city duplicate: '.$key_term;
		}
		return $return;
	}

	public function insert_to_huyen($key_term, $key_huyen){
		$data_tmp = file_get_contents($this->file);
		$data     = json_decode($data_tmp, true);
		$return = array(
			'status' => true,
			'msg' => array()
		);
		$flag = true;
		//variable check insert fully
		$count_qh = 0;
		$count_xa = 0;
		$city_tmp     = explode(':', $key_term);
		$city_id      = $city_tmp[0];
		$city         = $city_tmp[1];
		$term_exists  = term_exists( $city, $this->taxonomy, 0 );
		if ( $term_exists === 0 || $term_exists === null ) {
			$city_term_id = wp_insert_term( $city, $this->taxonomy );
			if ( is_wp_error($city_term_id) ) {
			  $return['status'] = false;
			  $return['msg'][] = '1-Error insert city: '.$key_term;
			  return $return;
			}
			foreach($data[$key_term] as $a => $b){
				if( $a == $key_huyen ){
					$qh_tmp         = explode(':', $a);
					$qh_id          = $qh_tmp[0];
					$qh             = $qh_tmp[1];
					$qh_term_exists = term_exists( $qh, $this->taxonomy, $city_term_id['term_id'] );
					if ( $qh_term_exists === 0 || $qh_term_exists === null ) {
						$qh_term_id = wp_insert_term( $qh, $this->taxonomy, array('parent'=>$city_term_id['term_id']) );
						if ( is_wp_error($qh_term_id) ) {
						  $return['status'] = false;
						  $return['msg'][] = '2-Error insert qh: '.$a;
						  $return['count_qh'] = $count_qh;
						  continue;
						}
						$count_qh++;
						foreach($b as $key => $value){
							$xa_term_exists = term_exists( $value['tenxa'], $this->taxonomy, $qh_term_id['term_id'] );
							if ( $xa_term_exists === 0 || $xa_term_exists === null ) {
								$xa_term_id = wp_insert_term( $value['tenxa'], $this->taxonomy, array('parent'=>$qh_term_id['term_id']) );
								if ( is_wp_error($xa_term_id) ) {
									$return['status'] = false;
									$return['msg'][] = '3-Error insert xa: '.$value['xaid'];
								    continue;
								}
							}else{
								$i = 1;
								foreach( $xa_term_exists as $key_dup => $value_dup ){
									if( $value_dup == $qh_term_id['term_id'] ){
										$xa_term_id = wp_insert_term( $value['tenxa'].'_'.$i, $this->taxonomy, array('parent'=>$qh_term_id['term_id']) );
										if ( is_wp_error($xa_term_id) ) {
											$return['status'] = false;
											$return['msg'][] = '3-Error insert xa: '.$value['xaid'];
										    continue;
										}
									}
									$i++;
								}
							}
						}
					}else{
						$return['status'] = false;
						$return['msg'][] = '2-Error qh duplicate: '.$a;
						$return['count_qh'] = $count_qh;
					}
				}
			}
		}else{
			$return['status'] = false;
			$return['msg'][] = '1-Error city duplicate: '.$key_term;
		}
		return $return;
	}

	public function debug_file($key_term=''){
		$data_tmp = file_get_contents($this->file);
		$data     = json_decode($data_tmp, true);
		foreach($data as $key => $v){
			// echo $key.'<br>';
			if( $key == $key_term ){
				foreach ($v as $a => $b) {
					echo $a .'<br>';
				}
			}
		}
	}
}
$file  = get_template_directory_uri().'/diagioihanhchinh.js';
$class = new Taxonomy_Diagioihanhchinh($file);
// $class->debug_file('79:Hồ Chí Minh');
// $class->taxonomy = 'city-project';
// $class->DeleteTerms();
$list_key = array(
	 '79:Hồ Chí Minh'
	,'74:Bình Dương'
	,'75:Đồng Nai'
	,'70:Bình Phước'
);
foreach ($list_key as $key) {
	$class->insert_one($key);
}
// $class->insert_to_huyen('79:Hồ Chí Minh', '783:Huyện Củ Chi');