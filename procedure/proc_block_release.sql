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
ALTER PROCEDURE proc_block_release 
	-- Add the parameters for the stored procedure here
	@branch_code varchar(4),@sl_account INT,@user_id VARCHAR(10),@user_ip VARCHAR(20)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

    -- Insert statements for procedure here
	DECLARE @upload_sl INT,@release_date DATE;
	
	
	SELECT @upload_sl=upload_sl from tbl_account_upload where sl_account=@sl_account and branch_code=@branch_code and block_status='B'

	INSERT INTO tbl_account_release (branch_code,upload_sl,account_sl,release_user,release_time,release_ip) VALUES 
	(@branch_code,@upload_sl,@sl_account,@user_id,GETDATE(),@user_ip)

	update tbl_account_upload set block_status='R' where sl_account=@sl_account and branch_code=@branch_code and block_status='B'

update tbl_account_summary set release_data= release_data + 1 where branch_code=@branch_code and upload_sl=@upload_sl 

SELECT 'Successfully Released'
	
END
GO

--exec proc_screening_process '5044','3','101'