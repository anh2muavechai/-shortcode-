$sql = " INSERT INTO t_term_search_history
			(
				 excel_flg
				,m_lang_id
				,status
				,del_flg
				,add_user_id
				,add_datetime
				,upd_user_id
				,upd_datetime
			)
			VALUES (
				:excel_flg
				,:m_lang_id
				,0
				,0
				,:add_user_id
				,now()
				,:upd_user_id
				,now()
			)
			RETURNING t_term_search_history_id ";