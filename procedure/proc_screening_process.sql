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
ALTER PROCEDURE proc_screening_process 
	-- Add the parameters for the stored procedure here
	@branch_code VARCHAR(4),@upload_sl INT,@name_type VARCHAR(20),@user_id VARCHAR(10)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

    -- Insert statements for procedure here
	DECLARE @sl_account INT,@acc_branch_code varchar(4),@entity varchar(1),@account_name VARCHAR(255),@country_code varchar(2),@block_count INT;
	SET @block_count = 0;

DECLARE curs CURSOR FOR SELECT sl_account,account_entity,account_name,branch_code,country_code FROM tbl_account_upload where upload_sl=@upload_sl order by sl_account 

OPEN curs  
FETCH NEXT FROM curs into @sl_account,@entity,@account_name,@acc_branch_code,@country_code 
WHILE @@FETCH_STATUS = 0    
BEGIN       


	DECLARE @name_words VARCHAR(1000),@acc_block_status CHAR(1),@this_block_status CHAR(1),@sanction_id INT,@tbl_sanction varchar(50);
	SET @acc_block_status='N';
	
	DECLARE curs_words CURSOR FOR SELECT name_words FROM dbo.SplitWords(@account_name) 
	OPEN curs_words  
	FETCH NEXT FROM curs_words into @name_words 
	WHILE @@FETCH_STATUS = 0    
	BEGIN       


	--CHECK tbl_ofac_name_data
	SET @this_block_status ='N';
	--INSERT INTO tbl_account_block (name_source,branch_code,block_date,upload_sl,sl_account,tbl_sanction,sl_sanction_id,block_word) 
	--SELECT @name_type,@acc_branch_code,GETDATE(),@upload_sl,@sl_account,tbl_sanction,sanction_id,@name_words FROM dbo.func_name_match(@entity,@name_words,@country_code)
	
	SELECT tbl_sanction,sanction_id,this_block_status INTO #tbl_block_temp FROM dbsanctions.dbo.func_name_match(@entity,@name_words,@country_code) 
	SELECT @this_block_status=this_block_status FROM #tbl_block_temp where this_block_status='B'
	IF @this_block_status='B'
	BEGIN
	INSERT INTO dbsanctions.dbo.tbl_account_block (name_source,branch_code,block_date,upload_sl,sl_account,tbl_sanction,sl_sanction_id,block_word) 
	SELECT @name_type,@acc_branch_code,GETDATE(),@upload_sl,@sl_account,tbl_sanction,sanction_id,@name_words FROM #tbl_block_temp	
	END
	DROP TABLE #tbl_block_temp



	IF @this_block_status='B'
	BEGIN
	SET @acc_block_status='B';
	--INSERT INTO tbl_account_block (name_source,branch_code,block_date,upload_sl,sl_account,tbl_sanction,sl_sanction_id,block_word) VALUES (@name_type,@acc_branch_code,GETDATE(),@upload_sl,@sl_account,@tbl_sanction,@sanction_id,@name_words)
	END

	FETCH NEXT FROM curs_words into @name_words;    
	END; 
	CLOSE curs_words; 
	DEALLOCATE curs_words; 

	IF @acc_block_status='B'
	BEGIN
	SET @block_count = @block_count + 1;
	END
update tbl_account_upload set screen_status='Y',block_status=@acc_block_status where branch_code=@acc_branch_code and sl_account=@sl_account


FETCH NEXT FROM curs into @sl_account,@entity,@account_name,@acc_branch_code,@country_code;    
END; 
CLOSE curs; 
DEALLOCATE curs; 

update tbl_account_summary set upload_status='Y',block_data=@block_count,process_user=@user_id,process_time=GETDATE() where upload_sl=@upload_sl 

SELECT 'Successfully Processed'
	
END
GO

--exec proc_screening_process '0102','2','101','1072'
