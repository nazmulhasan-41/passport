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
ALTER PROCEDURE proc_un_data @country_code VARCHAR(50)

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
			SAVE TRANSACTION proc_un_data;
--===========================

	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
DECLARE @idoc int,@id_count int
DECLARE @entity_id INT,@entity_type CHAR(20);
DECLARE @smsxml AS XML,@smsstatus VARCHAR(20),@smsremarks VARCHAR(100);
SET @smsxml = (SELECT * FROM OPENROWSET(BULK N'C:\sanctions_download\un_consolidated.xml', SINGLE_CLOB) AS Contents);
--SELECT @smsxml = CAST(BulkColumn AS XML)
--FROM OPENROWSET (BULK 'C:\ofac_sdn.xml' , SINGLE_BLOB) AS XMLDATA
 
EXEC sp_xml_preparedocument @idoc OUTPUT, @smsxml
truncate table tbl_un_id;
truncate table tbl_un_name_data;
truncate table tbl_un_name_alias;
truncate table tbl_un_document;
truncate table tbl_un_birth_date;
truncate table tbl_un_birth_place;
truncate table tbl_un_address;
truncate table tbl_un_designation;
truncate table tbl_un_title;
truncate table tbl_un_nationality;

 

SET @id_count = 0;
--;with xmlnamespaces(default 'http://www.un.org/sc/committees/resources/xsd/sc-sanctions.xsd') 
--INDIVIDUAL
-- INSERT INTO tbl_un_id 
-- SELECT DATAID,'Individual' FROM (SELECT element.value('(DATAID)[1]', 'int') as DATAID
-- FROM @smsxml.nodes('/CONSOLIDATED_LIST/INDIVIDUALS/INDIVIDUAL') AS XMLTbl(element)  
-- where element.value('(UN_LIST_TYPE)[1]', 'VARCHAR(20)') like '%'+@country_code+'%'
-- or element.value('(INDIVIDUAL_ADDRESS/COUNTRY)[1]', 'VARCHAR(20)') like '%'+@country_code+'%'
-- or element.value('(INDIVIDUAL_PLACE_OF_BIRTH/COUNTRY)[1]', 'VARCHAR(20)') like '%'+@country_code+'%'
-- or element.value('(NATIONALITY/VALUE)[1]', 'VARCHAR(20)') like '%'+@country_code+'%'
-- or element.value('(INDIVIDUAL_DOCUMENT/COUNTRY_OF_ISSUE)[1]', 'VARCHAR(20)') like '%'+@country_code+'%'
-- ) AS TBLGROUP GROUP BY DATAID    

----ENTITY
-- INSERT INTO tbl_un_id 
-- SELECT DATAID,'Entity' FROM (SELECT element.value('(../DATAID)[1]', 'int') as DATAID
-- FROM @smsxml.nodes('/CONSOLIDATED_LIST/ENTITIES/ENTITY/ENTITY_ADDRESS') AS XMLTbl(element)  where element.value('(COUNTRY)[1]', 'VARCHAR(20)') like '%'+@country_code+'%') AS TBLGROUP GROUP BY DATAID    


--DECLARE curs CURSOR FOR SELECT un_sanction_id,sanction_type FROM  tbl_un_id where sanction_type='Individual' order by un_sanction_id  
--OPEN curs  
--FETCH NEXT FROM curs into @entity_id,@entity_type 
--WHILE @@FETCH_STATUS = 0    
--BEGIN

--SET @id_count = @id_count + 1

--select @entity_id;
--NAME LIST
INSERT INTO tbl_un_name_data
SELECT 
     element.value('(DATAID)[1]', 'INT') as DATAID,'Individual',
     element.value('(FIRST_NAME)[1]', 'VARCHAR(255)') as FIRST_NAME,
     element.value('(SECOND_NAME)[1]', 'VARCHAR(255)') as SECOND_NAME,
     element.value('(THIRD_NAME)[1]', 'VARCHAR(255)') as THIRD_NAME,
     element.value('(FOURTH_NAME)[1]', 'VARCHAR(255)') as FOURTH_NAME,
     element.value('(UN_LIST_TYPE)[1]', 'VARCHAR(50)') as UN_LIST_TYPE,
     element.value('(LISTED_ON)[1]', 'DATE') as LISTED_ON,
     element.value('(COMMENTS1)[1]', 'VARCHAR(1000)') as COMMENTS1,
     element.value('(SORT_KEY)[1]', 'VARCHAR(255)') as SORT_KEY,
	 GETDATE()
FROM 
   @smsxml.nodes('/CONSOLIDATED_LIST/INDIVIDUALS/INDIVIDUAL') AS XMLTbl(element)   
--   @smsxml.nodes('/CONSOLIDATED_LIST/INDIVIDUALS/INDIVIDUAL') AS XMLTbl(element)  where element.value('(DATAID)[1]', 'INT') = @entity_id   

----TITLE LIST
INSERT INTO tbl_un_title
SELECT 
     element.value('(../DATAID)[1]', 'INT') as DATAID,
     element.value('(VALUE)[1]', 'VARCHAR(255)') as VALUE,
	 GETDATE()
FROM 
   @smsxml.nodes('/CONSOLIDATED_LIST/INDIVIDUALS/INDIVIDUAL/TITLE') AS XMLTbl(element)  where element.value('(VALUE)[1]', 'VARCHAR(255)') IS NOT NULL   
--   @smsxml.nodes('/CONSOLIDATED_LIST/INDIVIDUALS/INDIVIDUAL/TITLE') AS XMLTbl(element)  where element.value('(../DATAID)[1]', 'INT') = @entity_id and element.value('(VALUE)[1]', 'VARCHAR(255)') IS NOT NULL   

----NAME ALIAS LIST
INSERT INTO tbl_un_name_alias
SELECT 
     element.value('(../DATAID)[1]', 'INT') as DATAID,'Individual',
     element.value('(ALIAS_NAME)[1]', 'VARCHAR(255)') as ALIAS_NAME,
     element.value('(CITY_OF_BIRTH)[1]', 'VARCHAR(255)') as CITY_OF_BIRTH,
     element.value('(COUNTRY_OF_BIRTH)[1]', 'VARCHAR(255)') as COUNTRY_OF_BIRTH,
     element.value('(NOTE)[1]', 'VARCHAR(500)') as NOTE,     
	 GETDATE()
FROM 
   @smsxml.nodes('/CONSOLIDATED_LIST/INDIVIDUALS/INDIVIDUAL/INDIVIDUAL_ALIAS') AS XMLTbl(element)  where element.value('(ALIAS_NAME)[1]', 'VARCHAR(255)') IS NOT NULL   

----ADDRESS LIST
INSERT INTO tbl_un_address
SELECT 
     element.value('(../DATAID)[1]', 'INT') as DATAID,
     element.value('(STREET)[1]', 'VARCHAR(255)') as STREET,
     element.value('(CITY)[1]', 'VARCHAR(255)') as CITY,
     element.value('(STATE_PROVINCE)[1]', 'VARCHAR(255)') as STATE_PROVINCE,
     element.value('(ZIP_CODE)[1]', 'VARCHAR(255)') as ZIP_CODE,
     element.value('(COUNTRY)[1]', 'VARCHAR(255)') as COUNTRY,
     element.value('(NOTE)[1]', 'VARCHAR(255)') as NOTE,
	 GETDATE()
FROM 
   @smsxml.nodes('/CONSOLIDATED_LIST/INDIVIDUALS/INDIVIDUAL/INDIVIDUAL_ADDRESS') AS XMLTbl(element)  where  
   (element.value('(STREET)[1]', 'VARCHAR(255)') IS NOT NULL  or element.value('(CITY)[1]', 'VARCHAR(255)') IS NOT NULL or element.value('(COUNTRY)[1]', 'VARCHAR(255)') IS NOT NULL)   

----DESIGNATION LIST
INSERT INTO tbl_un_designation
SELECT 
     element.value('(../DATAID)[1]', 'INT') as DATAID,
     element.value('(VALUE)[1]', 'VARCHAR(500)') as VALUE,
	 GETDATE()
FROM 
   @smsxml.nodes('/CONSOLIDATED_LIST/INDIVIDUALS/INDIVIDUAL/DESIGNATION') AS XMLTbl(element)  where element.value('(VALUE)[1]', 'VARCHAR(500)') IS NOT NULL   

----BIRTH DATE LIST
INSERT INTO tbl_un_birth_date
SELECT 
     element.value('(../DATAID)[1]', 'INT') as DATAID,
     element.value('(TYPE_OF_DATE)[1]', 'VARCHAR(50)') as TYPE_OF_DATE,
     element.value('(DATE)[1]', 'VARCHAR(50)') as "DATE",
     element.value('(YEAR)[1]', 'VARCHAR(50)') as "YEAR",
	 GETDATE()
FROM 
   @smsxml.nodes('/CONSOLIDATED_LIST/INDIVIDUALS/INDIVIDUAL/INDIVIDUAL_DATE_OF_BIRTH') AS XMLTbl(element)  where element.value('(DATE)[1]', 'VARCHAR(50)') IS NOT NULL   

----BIRTH PLACE LIST
INSERT INTO tbl_un_birth_place
SELECT 
     element.value('(../DATAID)[1]', 'INT') as DATAID,
     element.value('(CITY)[1]', 'VARCHAR(50)') as CITY,
     element.value('(STATE_PROVINCE)[1]', 'VARCHAR(50)') as STATE_PROVINCE,
     element.value('(COUNTRY)[1]', 'VARCHAR(50)') as COUNTRY,
     
	 GETDATE()
FROM 
   @smsxml.nodes('/CONSOLIDATED_LIST/INDIVIDUALS/INDIVIDUAL/INDIVIDUAL_PLACE_OF_BIRTH') AS XMLTbl(element)  where element.value('(COUNTRY)[1]', 'VARCHAR(50)') IS NOT NULL   

----DOCUMENT LIST
INSERT INTO tbl_un_document
SELECT 
     element.value('(../DATAID)[1]', 'INT') as DATAID,
     element.value('(TYPE_OF_DOCUMENT)[1]', 'VARCHAR(100)') as TYPE_OF_DOCUMENT,
     element.value('(TYPE_OF_DOCUMENT2)[1]', 'VARCHAR(100)') as TYPE_OF_DOCUMENT2,
     element.value('(NUMBER)[1]', 'VARCHAR(50)') as NUMBER,
     element.value('(COUNTRY_OF_ISSUE)[1]', 'VARCHAR(50)') as COUNTRY_OF_ISSUE,
     element.value('(NOTE)[1]', 'VARCHAR(255)') as NOTE,
	 GETDATE()
FROM 
   @smsxml.nodes('/CONSOLIDATED_LIST/INDIVIDUALS/INDIVIDUAL/INDIVIDUAL_DOCUMENT') AS XMLTbl(element)  where element.value('(TYPE_OF_DOCUMENT)[1]', 'VARCHAR(100)') IS NOT NULL   

----NATIONALITY LIST
INSERT INTO tbl_un_nationality
SELECT 
     element.value('(../DATAID)[1]', 'INT') as DATAID,
     element.value('(VALUE)[1]', 'VARCHAR(255)') as VALUE,
	 GETDATE()
FROM 
   @smsxml.nodes('/CONSOLIDATED_LIST/INDIVIDUALS/INDIVIDUAL/NATIONALITY') AS XMLTbl(element)  where element.value('(VALUE)[1]', 'VARCHAR(255)') IS NOT NULL   


--FETCH NEXT FROM curs into @entity_id,@entity_type;    
--END; 
--CLOSE curs 
--DEALLOCATE curs; 

--ENTITY INSERT

--DECLARE curs CURSOR FOR SELECT un_sanction_id,sanction_type FROM  tbl_un_id where sanction_type='Entity' order by un_sanction_id  
--OPEN curs  
--FETCH NEXT FROM curs into @entity_id,@entity_type 
--WHILE @@FETCH_STATUS = 0    
--BEGIN
--SET @id_count = @id_count + 1
--select @entity_id;
--NAME LIST
INSERT INTO tbl_un_name_data
SELECT 
     element.value('(DATAID)[1]', 'INT') as DATAID,'Entity',
     element.value('(FIRST_NAME)[1]', 'VARCHAR(255)') as FIRST_NAME,
     element.value('(SECOND_NAME)[1]', 'VARCHAR(255)') as SECOND_NAME,
     element.value('(THIRD_NAME)[1]', 'VARCHAR(255)') as THIRD_NAME,
     element.value('(FOURTH_NAME)[1]', 'VARCHAR(255)') as FOURTH_NAME,
     element.value('(UN_LIST_TYPE)[1]', 'VARCHAR(50)') as UN_LIST_TYPE,
     element.value('(LISTED_ON)[1]', 'DATE') as LISTED_ON,
     element.value('(COMMENTS1)[1]', 'VARCHAR(1000)') as COMMENTS1,
     element.value('(SORT_KEY)[1]', 'VARCHAR(255)') as SORT_KEY,
	 GETDATE()
FROM 
   @smsxml.nodes('/CONSOLIDATED_LIST/ENTITIES/ENTITY') AS XMLTbl(element)   

--NAME ALIAS LIST
INSERT INTO tbl_un_name_alias
SELECT 
     element.value('(../DATAID)[1]', 'INT') as DATAID,'Entity',
     element.value('(ALIAS_NAME)[1]', 'VARCHAR(255)') as ALIAS_NAME,
     element.value('(CITY_OF_BIRTH)[1]', 'VARCHAR(255)') as CITY_OF_BIRTH,
     element.value('(COUNTRY_OF_BIRTH)[1]', 'VARCHAR(255)') as COUNTRY_OF_BIRTH,
     element.value('(NOTE)[1]', 'VARCHAR(500)') as NOTE,
	 GETDATE()
FROM 
   @smsxml.nodes('/CONSOLIDATED_LIST/ENTITIES/ENTITY/ENTITY_ALIAS') AS XMLTbl(element)  where element.value('(ALIAS_NAME)[1]', 'VARCHAR(255)') IS NOT NULL   

--ADDRESS LIST
INSERT INTO tbl_un_address
SELECT 
     element.value('(../DATAID)[1]', 'INT') as DATAID,
     element.value('(STREET)[1]', 'VARCHAR(255)') as STREET,
     element.value('(CITY)[1]', 'VARCHAR(255)') as CITY,
     element.value('(STATE_PROVINCE)[1]', 'VARCHAR(255)') as STATE_PROVINCE,
     element.value('(ZIP_CODE)[1]', 'VARCHAR(255)') as ZIP_CODE,
     element.value('(COUNTRY)[1]', 'VARCHAR(255)') as COUNTRY,
     element.value('(NOTE)[1]', 'VARCHAR(255)') as NOTE,
	 GETDATE()
FROM 
   @smsxml.nodes('/CONSOLIDATED_LIST/ENTITIES/ENTITY/ENTITY_ADDRESS') AS XMLTbl(element)  where  
   (element.value('(STREET)[1]', 'VARCHAR(255)') IS NOT NULL  or element.value('(CITY)[1]', 'VARCHAR(255)') IS NOT NULL or element.value('(COUNTRY)[1]', 'VARCHAR(255)') IS NOT NULL)   


--FETCH NEXT FROM curs into @entity_id,@entity_type;    
--END; 
--CLOSE curs 
--DEALLOCATE curs; 


EXEC sp_xml_removedocument @idoc

select @id_count = count(un_sanction_id) from tbl_un_name_data
update tbl_sanctionlist set update_data=@id_count,last_update=GETDATE() where sanction_list_id=2;
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
			ROLLBACK TRANSACTION proc_un_data;

		RAISERROR ('proc_un_data: %d: %s', 2, 1, @error, @message);
	END CATCH	

select @message;
--=======================

END
GO



 
--exec proc_un_data 'bangladesh'

--EXEC sp_addsrvrolemember 'EFTdbuser', 'bulkadmin';
--GO

