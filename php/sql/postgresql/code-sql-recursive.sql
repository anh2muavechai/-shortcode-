//cú pháp đệ quy postgresql
WITH RECURSIVE temp_table AS (
    -- non-recursive term
    UNION (or UNION ALL)
    -- recursive term
    )
SELECT * FROM temp_table -- last select

-- non-recursive term //lấy ra những phần tử cha

-- recursive term //lấy ra những phần tử con với điều kiện là parent_id = với id lấy ra từ -- non-recursive term

-- last selected //join với temp_table để lấy ra các phần tử mong muốn

Example :
- oya_t_ctg_head_id : parent id

WITH RECURSIVE ctg_temp AS (
	SELECT t_ctg_head_id, oya_t_ctg_head_id, ctg_id, t_ctg_head_id AS top_id
	FROM t_ctg_head
	WHERE ctg_id IN ('Hung_test')
	AND del_flg = 0
	UNION ALL
	SELECT ch.t_ctg_head_id, ch.oya_t_ctg_head_id, ch.ctg_id, ct.top_id
	FROM ctg_temp ct, t_ctg_head ch
	WHERE ct.t_ctg_head_id = ch.oya_t_ctg_head_id AND ch.del_flg = 0
)
SELECT DISTINCT chead.ctg_id
FROM   t_ctg_head chead
JOIN ctg_temp ON ctg_temp.t_ctg_head_id = chead.t_ctg_head_id