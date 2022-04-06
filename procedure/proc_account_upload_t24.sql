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
ALTER PROCEDURE proc_account_upload_t24_t24 @upload_file_name VARCHAR(50),@temp_upload_file_name VARCHAR(50),@current_user VARCHAR(10),@user_ip VARCHAR(20)

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
			SAVE TRANSACTION proc_account_upload_t24;
--===========================

	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
--DECLARE @idoc int
--DECLARE @entity_id INT,@entity_type CHAR(20);
--DECLARE @smsxml AS XML,@smsstatus VARCHAR(20),@smsremarks VARCHAR(100);
DECLARE @cmdtext VARCHAR(500)
----'C:\sanctions_download\AC.INFO.DIRBD0010842.20150303.csv'
truncate table tbl_account_upload_temp;

SET @cmdtext = 'BULK
INSERT tbl_account_upload_temp
FROM ' + CHAR(39) + @temp_upload_file_name + CHAR(39) +
'WITH
(
FIRSTROW = 0,
FORMATFILE = '+ CHAR(39) + 'C:\sanctions_download\account_upload_format_t24.fmt' + CHAR(39) +',
FIELDTERMINATOR = '+ CHAR(39)+ ' | ' + CHAR(39) + ',
ROWTERMINATOR = ' + CHAR(39) +'\n' + CHAR(39) +
')'


	EXEC (@cmdtext)

--Insert to tbl_account_upload
DECLARE @slupload int,@totaldata int
select @slupload = upload_sl + 1 from tbl_account_summary
select @slupload = ISNULL(@slupload,1)

select @totaldata=COUNT(account_number) from tbl_account_upload_temp


insert into tbl_account_upload 
(upload_sl,account_type_code,account_type_sbs,account_number,account_entity,owner_type,account_name,father_name,mother_name,spouse_name,birth_date,national_id,passport_no,present_address,permanent_address,telephone_no,mobile_no,email_address,branch_code,upload_user,file_date,country_code,t24upload)
select @slupload,account_type_code,account_type_sbs,account_number,account_entity,owner_type,account_name,father_name,mother_name,spouse_name,birth_date,national_id,passport_no,present_address,permanent_address,telephone_no,mobile_no,email_address,branch_code,upload_user,file_date,country_code,'Y' from tbl_account_upload_temp	

insert into tbl_account_summary
(upload_sl,branch_code,bank_soft,acc_type_code,upload_date,upload_file,upload_data,upload_status,upload_remarks,upload_user,upload_user_ip,upload_time,t24upload)
select @slupload,'','1','',GETDATE(),@upload_file_name,@totaldata,'P','',@current_user,@user_ip,GETDATE(),'Y'


truncate table tbl_account_upload_temp;

--BULK
--INSERT tbl_account_upload_temp
--FROM 'C:\sanctions_download\AC.INFO.DIRBD0010842.20150303.csv' 
--WITH
--(
--FIRSTROW = 0,
--FORMATFILE = 'C:\sanctions_download\account_upload_format.fmt',
--FIELDTERMINATOR = '|',
--ROWTERMINATOR = '\n'
--)



SET @message = 'Successfully Data Upload';
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
			ROLLBACK TRANSACTION proc_account_upload_t24;

		RAISERROR ('proc_account_upload_t24: %d: %s', 2, 1, @error, @message);
	END CATCH	

select @message;
--=======================

END
GO



 
--exec proc_un_data 'bangladesh'

--EXEC sp_addsrvrolemember 'EFTdbuser', 'bulkadmin';
--GO



--EXEC sp_configure 'show advanced options', 1

--GO

--RECONFIGURE

--GO

--EXEC sp_configure 'Ad Hoc Distributed Queries', 1

--GO

--RECONFIGURE with override

--GO