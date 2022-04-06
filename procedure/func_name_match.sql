-- ================================================
-- Template generated from Template Explorer using:
-- Create Multi-Statement Function (New Menu).SQL
--
-- Use the Specify Values for Template Parameters 
-- command (Ctrl-Shift-M) to fill in the parameter 
-- values below.
--
-- This block of comments will not be included in
-- the definition of the function.
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
ALTER FUNCTION func_name_match 
(
	-- Add the parameters for the function here
@entity varchar(1),@name_word char(50),@country_code char(2)
)
RETURNS @tblmatch_value TABLE 
(
	-- Add the column definitions for the TABLE variable here
	sanction_id int, 
	this_block_status CHAR(1),
	tbl_sanction varchar(50),
	tbl_name varchar(10),
	sanction_name varchar(255),
	search_name varchar(255)
)
AS

BEGIN
	-- Fill the table variable with the rows for your result set
	--CHECK tbl_ofac_name_data

	DECLARE @sanction_id INT,@sdnentity varchar(1),@sanction_name VARCHAR(255),@tbl_sanction varchar(50),@tbl_name varchar(50);

--DECLARE curs CURSOR FOR SELECT 'tbl_ofac_name_data' as tbl_sanction,ofac_sanction_id,ISNULL(first_name,'') + ' ' + ISNULL(last_name,'') as sanc_name  FROM tbl_ofac_name_data 
IF @country_code='Al'
BEGIN
DECLARE curs CURSOR FOR
SELECT 'tbl_ofac_name_data' as tbl_sanction,'OFAC' as tbl_name,ofac_sanction_id as sanction_id,(case when sdn_type='Entity' then 'E' else 'P' end) as sdntype,ISNULL(first_name,'') + ' ' + ISNULL(last_name,'') as sanc_name  FROM tbl_ofac_name_data 
union
SELECT 'tbl_ofac_name_data' as tbl_sanction,'OFAC' as tbl_name,ofac_sanction_id as sanction_id,(case when sanction_type='Entity' then 'E' else 'P' end)  as sdntype,ISNULL(first_name,'') + ' ' + ISNULL(last_name,'') as sanc_name FROM tbl_ofac_aka_data 
union
SELECT 'tbl_eu_name_data' as tbl_sanction,'EU' as tbl_name,eu_sanction_id as sanction_id,(case when entity_type='E' then 'E' else 'P' end)  as sdntype, ISNULL(first_name,'') + ' ' + ISNULL(middle_name,'') + ' ' + ISNULL(last_name,'') + ' ' + ISNULL(whole_name,'') as sanc_name FROM tbl_eu_name_data
union
SELECT 'tbl_un_name_data' as tbl_sanction,'UN' as tbl_name,un_sanction_id as sanction_id,(case when sanction_type='Entity' then 'E' else 'P' end)  as sdntype,ISNULL(first_name,'') + ' ' + ISNULL(second_name,'') + ' ' + ISNULL(third_name,'') + ' ' + ISNULL(fourth_name,'') + ' ' + ISNULL(name_short_key,'') as sanc_name FROM tbl_un_name_data 
union
SELECT 'tbl_un_name_data' as tbl_sanction,'UN' as tbl_name,un_sanction_id as sanction_id,(case when sanction_type='Entity' then 'E' else 'P' end)  as sdntype,ISNULL(alias_name,'') as sanc_name FROM tbl_un_name_alias
union
SELECT 'tbl_bb_name_data' as tbl_sanction,'BB' as tbl_name,bb_name_id as sanction_id,(case when entity_type='Entity' then 'E' else 'P' end)  as sdntype,ISNULL(bb_sanction_name,'') as sanc_name FROM tbl_bb_name_data
END
ELSE IF @country_code<>'Al'
BEGIN
DECLARE curs CURSOR FOR
SELECT 'tbl_ofac_name_data' as tbl_sanction,'OFAC' as tbl_name,tbl_ofac_name_data.ofac_sanction_id as sanction_id,(case when sdn_type='Entity' then 'E' else 'P' end) as sdntype,ISNULL(first_name,'') + ' ' + ISNULL(last_name,'') as sanc_name  FROM tbl_ofac_name_data 
inner join tbl_ofac_address on tbl_ofac_name_data.ofac_sanction_id=tbl_ofac_address.ofac_sanction_id
where tbl_ofac_address.add_country=(select country_name from tbl_country_code where country_2code=@country_code)
union
SELECT 'tbl_ofac_name_data' as tbl_sanction,'OFAC' as tbl_name,tbl_ofac_aka_data.ofac_sanction_id as sanction_id,(case when sanction_type='Entity' then 'E' else 'P' end)  as sdntype,ISNULL(tbl_ofac_aka_data.first_name,'') + ' ' + ISNULL(tbl_ofac_aka_data.last_name,'') as sanc_name FROM tbl_ofac_aka_data 
inner join tbl_ofac_name_data on tbl_ofac_name_data.ofac_sanction_id=tbl_ofac_aka_data.ofac_sanction_id
inner join tbl_ofac_address on tbl_ofac_name_data.ofac_sanction_id=tbl_ofac_address.ofac_sanction_id
where tbl_ofac_address.add_country=(select country_name from tbl_country_code where country_2code=@country_code)
union
SELECT 'tbl_eu_name_data' as tbl_sanction,'EU' as tbl_name,tbl_eu_name_data.eu_sanction_id as sanction_id,(case when entity_type='E' then 'E' else 'P' end)  as sdntype, ISNULL(first_name,'') + ' ' + ISNULL(middle_name,'') + ' ' + ISNULL(last_name,'') + ' ' + ISNULL(whole_name,'') as sanc_name FROM tbl_eu_name_data
inner join tbl_eu_address on tbl_eu_name_data.eu_sanction_id=tbl_eu_address.eu_sanction_id
where tbl_eu_address.add_country=(select country_3code from tbl_country_code where country_2code=@country_code)
union
SELECT 'tbl_un_name_data' as tbl_sanction,'UN' as tbl_name,tbl_un_name_data.un_sanction_id as sanction_id,(case when sanction_type='Entity' then 'E' else 'P' end)  as sdntype,ISNULL(first_name,'') + ' ' + ISNULL(second_name,'') + ' ' + ISNULL(third_name,'') + ' ' + ISNULL(fourth_name,'') + ' ' + ISNULL(name_short_key,'') as sanc_name FROM tbl_un_name_data 
inner join tbl_un_address on tbl_un_name_data.un_sanction_id=tbl_un_address.un_sanction_id
where tbl_un_address.add_country=(select country_name from tbl_country_code where country_2code=@country_code)
union
SELECT 'tbl_un_name_data' as tbl_sanction,'UN' as tbl_name,tbl_un_name_alias.un_sanction_id as sanction_id,(case when tbl_un_name_alias.sanction_type='Entity' then 'E' else 'P' end)  as sdntype,ISNULL(alias_name,'') as sanc_name FROM tbl_un_name_alias
inner join tbl_un_name_data on tbl_un_name_data.un_sanction_id=tbl_un_name_alias.un_sanction_id
inner join tbl_un_address on tbl_un_name_data.un_sanction_id=tbl_un_address.un_sanction_id
where tbl_un_address.add_country=(select country_name from tbl_country_code where country_2code=@country_code)
union
SELECT 'tbl_bb_name_data' as tbl_sanction,'BB' as tbl_name,bb_name_id as sanction_id,(case when entity_type='Entity' then 'E' else 'P' end)  as sdntype,ISNULL(bb_sanction_name,'') as sanc_name FROM tbl_bb_name_data
END

OPEN curs  
FETCH NEXT FROM curs into @tbl_sanction,@tbl_name,@sanction_id,@sdnentity,@sanction_name 
WHILE @@FETCH_STATUS = 0    
BEGIN       

	IF @entity=@sdnentity
	BEGIN
		INSERT INTO @tblmatch_value 
		SELECT @sanction_id,'B',@tbl_sanction,@tbl_name,tblnames.name_words,@name_word from (select name_words from dbo.SplitWords(@sanction_name)) as tblnames
		where dbo.func_name_search(tblnames.name_words) = dbo.func_name_search(@name_word)
		and LEN(tblnames.name_words)>1 and len(@name_word)>1
	END
	--SELECT @sanction_id,'B',@tbl_sanction,@tbl_name,dbo.func_name_search(tblnames.name_words),dbo.func_name_search(@name_word) from (select name_words from dbo.SplitWords(@sanction_name)) as tblnames
	--where dbo.func_name_search('Dawalia') = dbo.func_name_search('ali') 


FETCH NEXT FROM curs into @tbl_sanction,@tbl_name,@sanction_id,@sdnentity,@sanction_name;    
END; 
CLOSE curs; 
DEALLOCATE curs; 

	
	RETURN 
END
GO

--select * from dbo.func_name_match('MD JABEDUR RAHMAN','BD')
--DISHA EYE MOTHER CARE CENTER PROP
--select * from dbo.func_name_match('E','GM','BD')
