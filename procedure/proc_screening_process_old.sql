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
	@branch_code VARCHAR(4),@upload_sl INT,@account_type INT,@user_id VARCHAR(10)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

    -- Insert statements for procedure here
	DECLARE @sl_account INT,@account_name VARCHAR(255),@block_count INT;
	SET @block_count = 0;

DECLARE curs CURSOR FOR SELECT sl_account,account_name FROM tbl_account_upload where branch_code=@branch_code and upload_sl=@upload_sl order by sl_account 
OPEN curs  
FETCH NEXT FROM curs into @sl_account,@account_name 
WHILE @@FETCH_STATUS = 0    
BEGIN       


	DECLARE @name_words VARCHAR(1000),@acc_block_status CHAR(1),@this_block_status CHAR(1),@sanction_id INT;
	SET @acc_block_status='N';
	
	DECLARE curs_words CURSOR FOR SELECT name_words FROM dbo.SplitWords(@account_name) 
	OPEN curs_words  
	FETCH NEXT FROM curs_words into @name_words 
	WHILE @@FETCH_STATUS = 0    
	BEGIN       


	--CHECK tbl_ofac_name_data
	SET @this_block_status ='N';
	SELECT @sanction_id=ofac_sanction_id,@this_block_status='B' FROM tbl_ofac_name_data where first_name LIKE '%'+@name_words+'%' or last_name LIKE '%'+@name_words+'%'
	IF @this_block_status='B'
	BEGIN
	SET @acc_block_status='B';
	INSERT INTO tbl_account_block (branch_code,block_date,upload_sl,sl_account,tbl_sanction,sl_sanction_id,block_word) VALUES (@branch_code,GETDATE(),@upload_sl,@sl_account,'tbl_ofac_name_data',@sanction_id,@name_words)
	END
	--CHECK tbl_ofac_aka_data
	SET @this_block_status ='N'
	SELECT @sanction_id=ofac_sanction_id,@this_block_status='B' FROM tbl_ofac_aka_data where first_name LIKE '%'+@name_words+'%' or last_name LIKE '%'+@name_words+'%'
	IF @this_block_status='B'
	BEGIN
	SET @acc_block_status='B';
	INSERT INTO tbl_account_block (branch_code,block_date,upload_sl,sl_account,tbl_sanction,sl_sanction_id,block_word) VALUES (@branch_code,GETDATE(),@upload_sl,@sl_account,'tbl_ofac_name_data',@sanction_id,@name_words)
	END

	--CHECK tbl_eu_name_data
	SET @this_block_status ='N'
	SELECT @sanction_id=eu_sanction_id,@this_block_status='B' FROM tbl_eu_name_data where first_name LIKE '%'+@name_words+'%' or middle_name LIKE '%'+@name_words+'%' or last_name LIKE '%'+@name_words+'%' or whole_name LIKE '%'+@name_words+'%'
	IF @this_block_status='B'
	BEGIN
	SET @acc_block_status='B';
	INSERT INTO tbl_account_block (branch_code,block_date,upload_sl,sl_account,tbl_sanction,sl_sanction_id,block_word) VALUES (@branch_code,GETDATE(),@upload_sl,@sl_account,'tbl_eu_name_data',@sanction_id,@name_words)
	END

	--CHECK tbl_un_name_data
	SET @this_block_status ='N'
	SELECT @sanction_id=un_sanction_id,@this_block_status='B' FROM tbl_un_name_data where first_name LIKE '%'+@name_words+'%' or second_name LIKE '%'+@name_words+'%' or third_name LIKE '%'+@name_words+'%' or fourth_name LIKE '%'+@name_words+'%' or name_short_key LIKE '%'+@name_words+'%'
	IF @this_block_status='B'
	BEGIN
	SET @acc_block_status='B';
	INSERT INTO tbl_account_block (branch_code,block_date,upload_sl,sl_account,tbl_sanction,sl_sanction_id,block_word) VALUES (@branch_code,GETDATE(),@upload_sl,@sl_account,'tbl_un_name_data',@sanction_id,@name_words)
	END

	--CHECK tbl_un_name_alias
	SET @this_block_status ='N'
	SELECT @sanction_id=un_sanction_id,@this_block_status='B' FROM tbl_un_name_alias where alias_name LIKE '%'+@name_words+'%'
	IF @this_block_status='B'
	BEGIN
	SET @acc_block_status='B';
	INSERT INTO tbl_account_block (branch_code,block_date,upload_sl,sl_account,tbl_sanction,sl_sanction_id,block_word) VALUES (@branch_code,GETDATE(),@upload_sl,@sl_account,'tbl_un_name_data',@sanction_id,@name_words)
	END

	--CHECK tbl_bb_name_data
	SET @this_block_status ='N'
	SELECT @sanction_id=bb_name_id,@this_block_status='B' FROM tbl_bb_name_data where bb_sanction_name LIKE '%'+@name_words+'%'
	IF @this_block_status='B'
	BEGIN
	SET @acc_block_status='B';
	INSERT INTO tbl_account_block (branch_code,block_date,upload_sl,sl_account,tbl_sanction,sl_sanction_id,block_word) VALUES (@branch_code,GETDATE(),@upload_sl,@sl_account,'tbl_bb_name_data',@sanction_id,@name_words)
	END

	--SELECT @sl_account,@sanction_id,@block_status;

	FETCH NEXT FROM curs_words into @name_words;    
	END; 
	CLOSE curs_words; 
	DEALLOCATE curs_words; 

	IF @acc_block_status='B'
	BEGIN
	SET @block_count = @block_count + 1;
	END
update tbl_account_upload set screen_status='Y',block_status=@acc_block_status where branch_code=@branch_code and sl_account=@sl_account


FETCH NEXT FROM curs into @sl_account,@account_name;    
END; 
CLOSE curs; 
DEALLOCATE curs; 

update tbl_account_summary set upload_status='Y',block_data=@block_count,process_user=@user_id,process_time=GETDATE() where branch_code=@branch_code and upload_sl=@upload_sl 

SELECT 'Successfully Processed'
	
END
GO

--exec proc_screening_process '5044','3','101'