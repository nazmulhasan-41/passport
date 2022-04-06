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
ALTER PROCEDURE proc_eu_data @country_code VARCHAR(3)

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
			SAVE TRANSACTION proc_eu_data;
--===========================

	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
DECLARE @idoc int,@id_count int
DECLARE @entity_id INT,@bd_entity_id INT,@entity_type CHAR(1);
DECLARE @smsxml AS XML,@smsstatus VARCHAR(20),@smsremarks VARCHAR(100);
SET @smsxml = (SELECT * FROM OPENROWSET(BULK N'C:\sanctions_download\eu_global.xml', SINGLE_CLOB) AS Contents);

EXEC sp_xml_preparedocument @idoc OUTPUT, @smsxml
truncate table tbl_eu_name_data
truncate table tbl_eu_address
truncate table tbl_eu_birth
truncate table tbl_eu_passport
truncate table tbl_eu_citizen
SET @id_count = 0;

--SELECT Id,"Type" FROM  OPENXML (@idoc, '/WHOLE/ENTITY',3) WITH (Id INT,"Type" CHAR(1)) ORDER BY Id  

DECLARE curs CURSOR FOR SELECT Id,"Type" FROM  OPENXML (@idoc, '/WHOLE/ENTITY',3) WITH (Id INT,"Type" CHAR(1)) ORDER BY Id  

OPEN curs  
FETCH NEXT FROM curs into @entity_id,@entity_type 
WHILE @@FETCH_STATUS = 0    
BEGIN

set @bd_entity_id = NULL;
--ADDRESS CHECK
--SELECT @bd_entity_id = Entity_id FROM OPENXML (@idoc, '/WHOLE/ENTITY/ADDRESS',3) WITH (Id INT,Entity_id  INT,COUNTRY VARCHAR(3)) WHERE Entity_id=@entity_id and COUNTRY=@country_code ORDER BY Entity_id
--IF @bd_entity_id IS NULL
--BEGIN
----BIRTH DAY CHECK
--SELECT @bd_entity_id = Entity_id FROM OPENXML (@idoc, '/WHOLE/ENTITY/BIRTH',3) WITH (Id INT,Entity_id  INT,COUNTRY VARCHAR(3)) WHERE Entity_id=@entity_id and COUNTRY=@country_code ORDER BY Entity_id
--END
----PASSPORT CHECK
--ELSE IF @bd_entity_id IS NULL
--BEGIN
--SELECT @bd_entity_id = Entity_id FROM OPENXML (@idoc, '/WHOLE/ENTITY/PASSPORT',3) WITH (Id INT,Entity_id  INT,COUNTRY VARCHAR(3)) WHERE Entity_id=@entity_id and COUNTRY=@country_code ORDER BY Entity_id
--END
----CITIZEN CHECK
--ELSE IF @bd_entity_id IS NULL
--BEGIN
--SELECT @bd_entity_id = Entity_id FROM OPENXML (@idoc, '/WHOLE/ENTITY/CITIZEN',3) WITH (Id INT,Entity_id  INT,COUNTRY VARCHAR(3)) WHERE Entity_id=@entity_id and COUNTRY=@country_code ORDER BY Entity_id
--END

--INSERT DATA
--IF @bd_entity_id IS NOT NULL
--BEGIN
--select @bd_entity_id;
SET @id_count = @id_count + 1
--select @entity_id
--NAME INSERT
INSERT INTO tbl_eu_name_data
SELECT Id,Entity_id,@entity_type,LASTNAME,FIRSTNAME,MIDDLENAME,WHOLENAME,GENDER,TITLE,"FUNCTION",GETDATE() FROM OPENXML (@idoc, '/WHOLE/ENTITY/NAME',3) 
WITH (Id INT,Entity_id  INT,LASTNAME VARCHAR(255),FIRSTNAME VARCHAR(255),MIDDLENAME VARCHAR(255),WHOLENAME VARCHAR(255),GENDER CHAR(1),TITLE VARCHAR(255),"FUNCTION" VARCHAR(255),COUNTRY VARCHAR(3)) WHERE Entity_id=@entity_id ORDER BY Id

--ADDRESS INSERT
INSERT INTO tbl_eu_address
SELECT Id,Entity_id,NUMBER,STREET,ZIPCODE,CITY,COUNTRY,OTHER,GETDATE() FROM OPENXML (@idoc, '/WHOLE/ENTITY/ADDRESS',3) 
WITH (Id INT,Entity_id  INT,NUMBER VARCHAR(100),STREET VARCHAR(255),ZIPCODE VARCHAR(50),CITY VARCHAR(50),COUNTRY CHAR(3),OTHER VARCHAR(100)) WHERE Entity_id=@entity_id ORDER BY Id

----BIRTH INSERT
INSERT INTO tbl_eu_birth
SELECT Id,Entity_id,"DATE",PLACE,COUNTRY,GETDATE() FROM OPENXML (@idoc, '/WHOLE/ENTITY/BIRTH',3) 
WITH (Id INT,Entity_id  INT,"DATE" VARCHAR(10),PLACE VARCHAR(100),COUNTRY VARCHAR(3)) WHERE Entity_id=@entity_id ORDER BY Id

----PASSPORT INSERT
INSERT INTO tbl_eu_passport
SELECT Id,Entity_id,NUMBER,COUNTRY,GETDATE() FROM OPENXML (@idoc, '/WHOLE/ENTITY/PASSPORT',3) 
WITH (Id INT,Entity_id  INT,NUMBER VARCHAR(10),COUNTRY VARCHAR(3)) WHERE Entity_id=@entity_id ORDER BY Id

----CITIZEN INSERT
INSERT INTO tbl_eu_citizen
SELECT Id,Entity_id,COUNTRY,GETDATE() FROM OPENXML (@idoc, '/WHOLE/ENTITY/CITIZEN',3) 
WITH (Id INT,Entity_id  INT,COUNTRY VARCHAR(3)) WHERE Entity_id=@entity_id ORDER BY Id

--END
FETCH NEXT FROM curs into @entity_id,@entity_type;    
END; 
CLOSE curs 
DEALLOCATE curs; 


EXEC sp_xml_removedocument @idoc


update tbl_sanctionlist set update_data=@id_count,last_update=GETDATE() where sanction_list_id=3;
INSERT INTO tbl_sanction_update VALUES ('3',GETDATE(),@id_count,@id_count,GETDATE())

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
			ROLLBACK TRANSACTION proc_eu_data;

		RAISERROR ('proc_eu_data: %d: %s', 2, 1, @error, @message);
	END CATCH	

select @message;
--=======================

END
GO



 
--exec proc_eu_data 'BGD'

--EXEC sp_addsrvrolemember 'EFTdbuser', 'bulkadmin';
--GO

