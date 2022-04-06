use dbsanctions;
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
CREATE PROCEDURE proc_upload_remove 
	-- Add the parameters for the stored procedure here
@branch_code varchar(4),@t24 char(1),@account_type varchar(3),@upload_sl int
AS
BEGIN

--===========================
		DECLARE @error INT, @message varchar(4000), @xstate INT;

	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
	SET XACT_ABORT ON 
--DECLARE @systemstatus CHAR(1),@proc_key char(1),@currdate DATETIME,@branchcode varchar(4),@existkey VARCHAR(10),@adviceno INT,@randomnumber INT,@newkey VARCHAR(10);

	DECLARE @trancount INT;
	SET @trancount = @@trancount;
	BEGIN TRY
		IF @trancount = 0
			BEGIN TRANSACTION
		ELSE
			SAVE TRANSACTION proc_upload_remove;
--===========================

	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

    -- Insert statements for procedure here
IF @t24='N'
BEGIN
delete from tbl_account_upload where upload_sl=@upload_sl and account_type_code=@account_type and branch_code=@branch_code AND t24upload='N'
delete from tbl_account_summary where upload_sl=@upload_sl and acc_type_code=@account_type and branch_code=@branch_code AND t24upload='N'
END

ELSE IF @t24='Y'
BEGIN
delete from tbl_account_upload where upload_sl=@upload_sl and account_type_code=@account_type AND t24upload='Y'
delete from tbl_account_summary where upload_sl=@upload_sl and acc_type_code=@account_type AND t24upload='Y'
END



SET @message = 'Successfully Data Removed';
--=======================
lbexit:
		IF @trancount = 0	
			COMMIT;
	END TRY
	BEGIN CATCH
		SELECT @error = ERROR_NUMBER(), @message = ERROR_MESSAGE(), @xstate = XACT_STATE();
		IF @xstate = -1
			ROLLBACK;
		IF @xstate = 1 and @trancount = 0
			ROLLBACK
		IF @xstate = 1 and @trancount > 0
			ROLLBACK TRANSACTION proc_upload_remove;

		RAISERROR ('proc_upload_remove: %d: %s', 2, 1, @error, @message);
	END CATCH	

select @message;
--=======================

END
GO
