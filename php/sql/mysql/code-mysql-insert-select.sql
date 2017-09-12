
			Insert into t_renkei_output_head(
				output_name
				,t_renkei_head_id
				,m_lang_id,image_size
				,del_flg
				,add_user_id
				,add_datetime
				,upd_user_id
				,upd_datetime
			)
			SELECT 
				output_name || 'のコピー'
				,t_renkei_head_id
				,m_lang_id
				,image_size
				,del_flg
				,:add_user_id
				,NOW()
				,:upd_user_id
				,NOW()
			FROM t_renkei_output_head
			Where t_renkei_output_head_id =:t_renkei_output_head_id
			RETURNING (t_renkei_output_head_id)
