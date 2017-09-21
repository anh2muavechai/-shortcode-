UPDATE t_ctg_section as c_section
SET section_name='「適応コントローラ」', upd_datetime = NOW()
FROM t_ctg_head as c_head
WHERE c_section.t_ctg_head_id = c_head.t_ctg_head_id AND c_section.section_name ='「適応コントローラー」' AND c_head.ctg_id IN ('Hung_test')