/*----------------------------------------------------------------------------------------------------------*/
function download_file(historyid){
	var json_ajax = new Argo_ajax("json");
    json_ajax.done_func = function(data) {
    	console.log(data);
        if (data.status == "NG") {
            Argo_ajax.message_box_error("", data.error); //Edit ZZZZ-1071 TinVNIT 02/27/2015
        } else {
			location.href = '<%$smarty.const.ACW_BASE_URL%>UploadItemNoHistory/dl/' + historyid;
        }
    };
    json_ajax.connect('POST', 'UploadItemNoHistory/dlcheck/',{'historyid':historyid});
}
/*----------------------------------------------------------------------------------------------------------*/
/** php */

public static function action_dldetail(){
		$param = self::get_param(array(
			 'acw_url'
		));
		$history_id = $param["acw_url"][0];
		$model      = new UploadItemNoHistory_model();
		$csv_file   = date('Ymd_His').uniqid().'.csv';
		$sql = "
			select
				gh.t_series_head_id
			, gh.t_series_mei_id
			, sver.major_ver || '.' || sver.minor_ver as ver
			, split_part(series_id,'|',1) as ctg
			, split_part(series_id,'|',2) as series
			, gh.gen_fail
			, gh.gen_success
			, CASE item_no.status_generate_header_excel WHEN 0 THEN '処理待ち中 ' WHEN 1 THEN '実行中'  WHEN 6 THEN '失敗' ELSE '完了' END AS status
			from t_generate_header_excel gh
			join t_series_ver sver on sver.t_series_mei_id = gh.t_series_mei_id
			join t_series_head head on head.t_series_head_id = gh.t_series_head_id
			join t_import_item_no item_no on item_no.t_import_item_no_id = gh.t_import_item_no_id
			where gh.t_import_item_no_id =:t_import_item_no_id
		";
		$data = $model->query($sql,array('t_import_item_no_id' => $history_id));
		$result = "ctg, series, version_series, total_section_success, total_section_failed, status \r\n";
		// $result = mb_convert_encoding($result, "Shift_JIS", "UTF-8");
		if( count($data) > 0 ){
			foreach( $data as $k => $v ){
				$result.= "'" . $v['ctg'] . "'," . $v['series'] . ",'" . $v['ver'] . "'," . $v['gen_success'] . "," . $v['gen_fail'] . "," . $v['status'] . " \n";
			}
		}
		$result = mb_convert_encoding($result, "SJIS-WIN", "UTF-8");
		// header('Content-Encoding: UTF-8');
		// header('Content-type: text/csv; charset=UTF-8');
		// header("Content-Disposition: attachment; filename=\"$csv_file\"");
		header('Content-Description: File Transfer');
		header('Content-Type: text/html');
		header('Content-Disposition: attachment; filename="'.$csv_file.'"');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		print_r($result);
		return ACWView::OK;
	}