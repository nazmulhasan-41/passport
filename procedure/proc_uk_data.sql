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
ALTER PROCEDURE proc_uk_data @country_code VARCHAR(50)

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
			SAVE TRANSACTION proc_uk_data;
--===========================

	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
DECLARE @idoc int,@id_count int
DECLARE @entity_id INT,@entity_type CHAR(20);
--DECLARE @smsxml AS XML,@smsstatus VARCHAR(20),@smsremarks VARCHAR(100);
--SET @smsxml = (SELECT * FROM OPENROWSET(BULK N'C:\un_consolidated.xml', SINGLE_CLOB) AS Contents);

truncate table tbl_uk_name_data;
BULK
INSERT tbl_uk_name_data
FROM 'C:\sanctions_download\uk_sanctionsconlist.csv'
WITH
(
FIRSTROW = 2,
FORMATFILE = 'C:\sanctions_download\uk_sanction_format.fmt',
FIELDTERMINATOR = ',',
ROWTERMINATOR = '\n'
)




--EXEC sp_xml_removedocument @idoc

select @id_count = count(uk_sanction_id) from tbl_uk_name_data
update tbl_sanctionlist set update_data=@id_count,last_update=GETDATE() where sanction_list_id=4;
INSERT INTO tbl_sanction_update VALUES ('2',GETDATE(),@id_count,@id_count,GETDATE())


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
			ROLLBACK TRANSACTION proc_uk_data;

		RAISERROR ('proc_uk_data: %d: %s', 2, 1, @error, @message);
	END CATCH	

select @message;
--=======================

END
GO



 
--exec proc_uk_data 'bangladesh'

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