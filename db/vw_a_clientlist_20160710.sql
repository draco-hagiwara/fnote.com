2016.07.07

--
-- テーブルの構造 `vw_a_clientlist`
--

--
アドミン：クライアント一覧＆編集時に使用
JOIN して営業＆編集者の名前を取得
--


■ビュー名
vw_a_clientlist


■SELECT文

select
  T1.cl_seq,
  T1.cl_status,
  T1.cl_sales_id,
  T1.cl_editor_id,
  T1.cl_contract_str,
  T1.cl_contract_end,
  T1.cl_plan,
  T1.cl_siteid,
  T1.cl_id,
  T1.cl_pw,
  T1.cl_company,
  T1.cl_president01,
  T1.cl_president02,
  T1.cl_department,
  T1.cl_person01,
  T1.cl_person02,
  T1.cl_tel,
  T1.cl_mobile,
  T1.cl_fax,
  T1.cl_mail,
  T1.cl_mailsub,

  T2.ac_department,
  T2.ac_name01 as salsename01,
  T2.ac_name02 as salsename02,

  T3.ac_department,
  T3.ac_name01 as editorname01,
  T3.ac_name02 as editorname02

  from mb_client AS T1
    LEFT JOIN mb_account AS T2 ON T1.cl_sales_id = T2.ac_seq
    LEFT JOIN mb_account AS T3 ON T1.cl_editor_id = T3.ac_seq
;






■ビューSQL文

CREATE ALGORITHM = UNDEFINED VIEW vw_a_clientlist
  AS SELECT
  T1.cl_seq,
  T1.cl_status,
  T1.cl_sales_id,
  T1.cl_editor_id,
  T1.cl_admin_id,
  T1.cl_contract_str,
  T1.cl_contract_end,
  T1.cl_plan,
  T1.cl_siteid,
  T1.cl_id,
  T1.cl_pw,
  T1.cl_company,
  T1.cl_president01,
  T1.cl_president02,
  T1.cl_department,
  T1.cl_person01,
  T1.cl_person02,
  T1.cl_tel,
  T1.cl_mobile,
  T1.cl_fax,
  T1.cl_mail,
  T1.cl_mailsub,

  T2.ac_department as salsedep,
  T2.ac_name01 as salsename01,
  T2.ac_name02 as salsename02,

  T3.ac_department as editordep,
  T3.ac_name01 as editorname01,
  T3.ac_name02 as editorname02,

  T4.ac_department as admindep,
  T4.ac_name01 as adminname01,
  T4.ac_name02 as adminname02

  from mb_client AS T1
    LEFT JOIN mb_account AS T2 ON T1.cl_sales_id  = T2.ac_seq
    LEFT JOIN mb_account AS T3 ON T1.cl_editor_id = T3.ac_seq
    LEFT JOIN mb_account AS T4 ON T1.cl_admin_id  = T4.ac_seq
;




