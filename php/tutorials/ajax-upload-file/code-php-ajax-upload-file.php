<script>
function upd_excel_func() {
    var formData = new FormData();
    Argo_ajax.ok_cancel_box('','「価格表」 を取り込みます。処理を実行すると、既存シリーズへデータの反映と差し替えが行われます。開始してもよろしいですか',function(){//Edit BP_IAI_CATALOG-2 MinhVnit 20170818
        if( $('#select_file_upload')[0].files[0] != undefined ){
            formData.append('file_upload',$('#select_file_upload')[0].files[0] );
            formData.append('m_lang_id',$('#select_lang').val());
            $.ajax({
                type: "POST",
                url: "<%$smarty.const.ACW_BASE_URL%>ImportCablePrice/upload",
                data: formData,
                dataType: 'json',
                cache : false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    Argo_ajax.loading(true);
                },
                success: function(data) {
                    Argo_ajax.loading(false);
                    if (data.status == 'NG') {
                        var err_msg = data.msg;
                        Argo_ajax.message_box_error('', err_msg);
                    }else if( data.status == 'OK' ){
                        var err_msg = data.msg;
                        Argo_ajax.message_box('', err_msg, function(){
                            window.location.reload();
                        });
                    }
                }
            });
        }else{
            Argo_ajax.message_box_error('', 'ファイルを選択してください');
        }
    });
    return false;
}
</script>