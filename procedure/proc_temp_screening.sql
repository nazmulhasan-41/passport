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
ALTER PROCEDURE proc_temp_screening 
	-- Add the parameters for the stored procedure here
	@branch_code VARCHAR(4),@entity varchar(1),@account_name varchar(300),@country_code varchar(2)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

    -- Insert statements for procedure here
	DECLARE @sl_account INT,@block_count INT;
	SET @block_count = 0;


CREATE TABLE #tblreport (tbl_sanction varchar(30),sl_sanction_id int,block_word varchar(255));


	DECLARE @name_words VARCHAR(1000),@acc_block_status CHAR(1),@this_block_status CHAR(1),@sanction_id INT,@tbl_sanction varchar(50);
	SET @acc_block_status='N';
	
	DECLARE curs_words CURSOR FOR SELECT name_words FROM dbo.SplitWords(@account_name) 
	OPEN curs_words  
	FETCH NEXT FROM curs_words into @name_words 
	WHILE @@FETCH_STATUS = 0    
	BEGIN       


	--CHECK tbl_ofac_name_data
	SET @this_block_status ='N';
	--SELECT @sanction_id=ofac_sanction_id,@this_block_status='B' FROM tbl_ofac_name_data where CONTAINS(first_name,@name_words) or CONTAINS(last_name,@name_words)
	--SELECT @sanction_id=ofac_sanction_id,@this_block_status='B' FROM tbl_ofac_name_data where first_name LIKE '%'+@name_words+'%' or last_name LIKE '%'+@name_words+'%'
	--SELECT @tbl_sanction=tbl_name,@sanction_id=sanction_id,@this_block_status=this_block_status FROM dbo.func_name_match(@entity,@name_words,@country_code)

	INSERT INTO #tblreport (tbl_sanction,sl_sanction_id,block_word) SELECT tbl_name,sanction_id,@name_words FROM dbo.func_name_match(@entity,@name_words,@country_code)


	IF @this_block_status='B'
	BEGIN
	SET @block_count = @block_count + 1;
	SET @acc_block_status='B';
	--INSERT INTO #tblreport (tbl_sanction,sl_sanction_id,block_word) VALUES (@tbl_sanction,@sanction_id,@name_words)
	END

	FETCH NEXT FROM curs_words into @name_words;    
	END; 
	CLOSE curs_words; 
	DEALLOCATE curs_words; 

--select * from #tblreport

SELECT (ISNULL(o.first_name,'') + ' ' + ISNULL(o.last_name,'')) as sanction_name, tbl_sanction,sl_sanction_id,block_word FROM #tblreport t inner join tbl_ofac_name_data o on t.sl_sanction_id=o.ofac_sanction_id where tbl_sanction='OFAC'
union
SELECT (e.whole_name) as sanction_name, tbl_sanction,sl_sanction_id,block_word FROM #tblreport t inner join tbl_eu_name_data e on t.sl_sanction_id=e.eu_sanction_id where tbl_sanction='EU' and len(e.whole_name)>1
union
SELECT (ISNULL(u.first_name,'') +' ' + ISNULL(u.second_name,'') + ' ' + ISNULL(u.third_name,'') + ' ' + ISNULL(u.fourth_name,'')) as sanction_name, tbl_sanction,sl_sanction_id,block_word FROM #tblreport t inner join tbl_un_name_data u on t.sl_sanction_id=u.un_sanction_id where tbl_sanction='UN'
union
SELECT (b.bb_sanction_name) as sanction_name, tbl_sanction,sl_sanction_id,block_word FROM #tblreport t inner join tbl_bb_name_data b on t.sl_sanction_id=b.bb_name_id where tbl_sanction='BB'


	
END
GO

--exec proc_temp_screening '5044','P','Ali','Al'

--select * from tbl_ofac_aka_data
