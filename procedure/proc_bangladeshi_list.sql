-- ================================================
-- Template generated from Template Explorer using:
-- Create Procedure (New Menu).SQL
--
-- Use the Specify Values for Template Parameters 
-- command (Ctrl-Shift-M) to fill in the parameter 
-- values below.
--
-- This block of comments will not be included in
-- the definition of the procedure.
-- ================================================
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER PROCEDURE proc_bangladeshi_list 
	-- Add the parameters for the stored procedure here
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

    -- Insert statements for procedure here
select '1' as list_id,o.ofac_sanction_id as sanction_id,o.sdn_type as sanction_type,(ISNULL(o.first_name,'')+ (CASE WHEN LEN(o.first_name)>0 then ' ' ELSE '' END)  +  ISNULL(o.last_name,'')) as sanction_name,o.sdn_title as sanction_title,'OFAC' from tbl_ofac_name_data o inner join tbl_ofac_address a on o.ofac_sanction_id=a.ofac_sanction_id where a.add_country='Bangladesh'
UNION
select '1' as list_id,o.ofac_sanction_id as sanction_id,o.sanction_type as sanction_type,(ISNULL(o.first_name,'')+ (CASE WHEN LEN(o.first_name)>0 then ' ' ELSE '' END)  +  ISNULL(o.last_name,'')) as sanction_name,null as sanction_title,'OFAC' from tbl_ofac_aka_data o inner join tbl_ofac_address a on o.ofac_sanction_id=a.ofac_sanction_id where a.add_country='Bangladesh'
UNION
select '2' as list_id,u.un_sanction_id as sanction_id,sanction_type as sanction_type,(ISNULL(first_name,'')+ (CASE WHEN LEN(first_name)>0 then ' ' ELSE '' END) + 
ISNULL(second_name,'')+ (CASE WHEN LEN(second_name)>0 then ' ' ELSE '' END) + ISNULL(third_name,'')+ (CASE WHEN LEN(third_name)>0 then ' ' ELSE '' END) + 
ISNULL(fourth_name,'')) as sanction_name,null as sanction_title,'UN' from tbl_un_name_data u inner join tbl_un_address a on u.un_sanction_id=a.un_sanction_id where a.add_country='Bangladesh'
UNION --UN ALIAS NAMES
select '2' as list_id,u.un_sanction_id as sanction_id,sanction_type as sanction_type,alias_name as sanction_name,null as sanction_title,'UN' from tbl_un_name_alias u inner join tbl_un_address a on u.un_sanction_id=a.un_sanction_id where a.add_country='Bangladesh'

UNION
select '3' as list_id,e.eu_sanction_id as sanction_id,  (CASE WHEN entity_type='E' then 'Entity' WHEN entity_type='P' then 'Individual' END) as sanction_type,
(ISNULL(first_name,'')+ (CASE WHEN LEN(first_name)>0 then ' ' ELSE '' END) + ISNULL(middle_name,'')+ (CASE WHEN LEN(middle_name)>0 then ' ' ELSE '' END) + 
ISNULL(last_name,'')+ (CASE WHEN LEN(last_name)>0 then ' ' ELSE '' END) + ISNULL(whole_name,'')) as sanction_name,
his_title as sanction_title,'EU' from tbl_eu_name_data e inner join tbl_eu_address a on e.eu_sanction_id=a.eu_sanction_id where a.add_country='BGD'

UNION
select '4' as list_id,sl_sanction_id as sanction_id,sanction_type as sanction_type,sixth_name as sanction_name,null as sanction_title,'UK' from tbl_uk_name_data u where u.country_name='Bangladesh'

UNION
select '5' as list_id,bb_sl_no as sanction_id,entity_type as sanction_type,
bb_sanction_name as sanction_name,'' as sanction_title,'BB' from tbl_bb_name_data

END
GO

exec proc_bangladeshi_list
