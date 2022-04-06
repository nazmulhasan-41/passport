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
ALTER PROCEDURE proc_ofac_data @country_code VARCHAR(50)

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
			SAVE TRANSACTION proc_ofac_data;
--===========================

	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
DECLARE @idoc int,@id_count int
DECLARE @entity_id INT,@entity_type CHAR(20);
DECLARE @smsxml AS XML,@smsstatus VARCHAR(20),@smsremarks VARCHAR(100);

SET @id_count = 0;
SET @smsxml = (SELECT * FROM OPENROWSET(BULK N'C:\sanctions_download\ofac_sdn.xml', SINGLE_CLOB) AS Contents);


EXEC sp_xml_preparedocument @idoc OUTPUT, @smsxml
truncate table tbl_ofac_id;
truncate table tbl_ofac_name_data;
truncate table tbl_ofac_address;
truncate table tbl_ofac_aka_data;
truncate table tbl_ofac_birth;
truncate table tbl_ofac_doc_data;

create table #ofac_xml_temp (x xml)
insert into #ofac_xml_temp (x) values (@smsxml)


--;with xmlnamespaces(default 'http://tempuri.org/sdnList.xsd') 
-- INSERT INTO tbl_ofac_id SELECT * FROM (
-- SELECT								--ADDRESS
--     element.value('(../../uid)[1]', 'int') as uid,
--     element.value('(../../sdnType)[1]', 'VARCHAR(20)') as sdnType
--FROM 
--   @smsxml.nodes('/sdnList/sdnEntry/addressList/address') AS XMLTbl(element)  where
--   element.value('(country)[1]', 'VARCHAR(20)') like '%'+@country_code+'%' 
--union
--SELECT								--PLACE OF BIRTH
--     element.value('(../../uid)[1]', 'int') as uid,
--     element.value('(../../sdnType)[1]', 'VARCHAR(20)') as sdnType
--FROM 
--   @smsxml.nodes('/sdnList/sdnEntry/placeOfBirthList/placeOfBirthItem') AS XMLTbl(element)  where
--   element.value('(placeOfBirth)[1]', 'VARCHAR(255)') like '%'+@country_code+'%'
--union
-- SELECT								--DOCUMENT PLACE
--     element.value('(../../uid)[1]', 'int') as uid,
--     element.value('(../../sdnType)[1]', 'VARCHAR(20)') as sdnType
--FROM 
--   @smsxml.nodes('/sdnList/sdnEntry/idList/id') AS XMLTbl(element)  where
--   element.value('(idCountry)[1]', 'VARCHAR(255)') like '%'+@country_code+'%'
--   ) AS TBLOFAC GROUP BY uid,sdnType
    
   
--DECLARE curs CURSOR FOR SELECT ofac_sanction_id,ofac_sanction_type FROM  tbl_ofac_id order by ofac_sanction_id  
  

--OPEN curs  
--FETCH NEXT FROM curs into @entity_id,@entity_type 
--WHILE @@FETCH_STATUS = 0    
--BEGIN
--SET @id_count = @id_count + 1
--NAME LIST
;with xmlnamespaces(default 'http://tempuri.org/sdnList.xsd') 
--INSERT INTO tbl_ofac_name_data
SELECT 
     element.value('(uid)[1]', 'int') as uid, element.value('(sdnType)[1]', 'VARCHAR(50)') as entity_type,
     element.value('(firstName)[1]', 'VARCHAR(255)') as firstName,
     element.value('(lastName)[1]', 'VARCHAR(255)') as lastName,
     element.value('(title)[1]', 'VARCHAR(255)') as title,
     element.value('(remarks)[1]', 'VARCHAR(255)') as remarks,
	 GETDATE() as updatedate
	 INTO #tbl_ofac_name_temp
FROM 
--   @smsxml.nodes('/sdnList/sdnEntry') AS XMLTbl(element)  where element.value('(uid)[1]', 'VARCHAR(20)') = @entity_id order by uid asc   
   @smsxml.nodes('/sdnList/sdnEntry') AS XMLTbl(element)  order by uid asc   
INSERT INTO tbl_ofac_name_data SELECT * FROM #tbl_ofac_name_temp
DROP TABLE #tbl_ofac_name_temp

--ADDRESS LIST
;with xmlnamespaces(default 'http://tempuri.org/sdnList.xsd') 
--INSERT INTO tbl_ofac_address
SELECT
	 s.value('uid[1]', 'int') AS sanction_id,
     a.value('uid[1]', 'int') as uid,
     a.value('address1[1]', 'VARCHAR(255)') as address1,
     a.value('address2[1]', 'VARCHAR(255)') as address2,
     a.value('stateOrProvince[1]', 'VARCHAR(255)') as stateOrProvince,
     a.value('postalCode[1]', 'VARCHAR(255)') as postalCode,
     a.value('city[1]', 'VARCHAR(255)') as city,
     a.value('country[1]', 'VARCHAR(255)') as country,
	 GETDATE() as updatedate
	 INTO #tbl_ofac_address_temp
FROM  
	#ofac_xml_temp 
	CROSS APPLY @smsxml.nodes('/sdnList/sdnEntry') AS sdn_element(s)
	CROSS APPLY s.nodes('addressList/address') AS address_element(a)
--	where s.value('uid[1]', 'int')=@entity_id
	
INSERT INTO tbl_ofac_address SELECT * FROM #tbl_ofac_address_temp
DROP TABLE #tbl_ofac_address_temp

--SELECT @entity_id,
--     element.value('(addressList/address/uid)[1]', 'int') as uid,
--     element.value('(addressList/address/address1)[1]', 'VARCHAR(255)') as address1,
--     element.value('(addressList/address/address2)[1]', 'VARCHAR(255)') as address2,
--     element.value('(addressList/address/stateOrProvince)[1]', 'VARCHAR(255)') as stateOrProvince,
--     element.value('(addressList/address/postalCode)[1]', 'VARCHAR(255)') as postalCode,
--     element.value('(addressList/address/city)[1]', 'VARCHAR(255)') as city,
--     element.value('(addressList/address/country)[1]', 'VARCHAR(255)') as country,
--	 GETDATE() as updatedate
--FROM 
--   @smsxml.nodes('/sdnList/sdnEntry') AS XMLTbl(element)  where element.value('(addressList/address/uid)[1]', 'int') is not null and element.value('(uid)[1]', 'VARCHAR(20)') = @entity_id order by uid asc   

--AKA LIST
;with xmlnamespaces(default 'http://tempuri.org/sdnList.xsd') 
--INSERT INTO tbl_ofac_aka_data
SELECT element.value('(uid)[1]', 'VARCHAR(20)') as entityid,
     element.value('(akaList/aka/uid)[1]', 'int') as uid,element.value('(sdnType)[1]', 'VARCHAR(50)') as entity_type,
     element.value('(akaList/aka/category)[1]', 'VARCHAR(255)') as category,
     element.value('(akaList/aka/lastName)[1]', 'VARCHAR(255)') as lastName,
     element.value('(akaList/aka/firstName)[1]', 'VARCHAR(255)') as firstName,
     GETDATE() as updatedate
	 INTO #tbl_ofac_aka_temp
FROM 
   @smsxml.nodes('/sdnList/sdnEntry') AS XMLTbl(element)  where element.value('(akaList/aka/uid)[1]', 'int') is not null order by uid asc   
INSERT INTO tbl_ofac_aka_data SELECT * FROM #tbl_ofac_aka_temp
DROP TABLE #tbl_ofac_aka_temp

--   @smsxml.nodes('/sdnList/sdnEntry') AS XMLTbl(element)  where element.value('(akaList/aka/uid)[1]', 'int') is not null and element.value('(uid)[1]', 'VARCHAR(20)') = @entity_id order by uid asc   

--BIRTH LIST
;with xmlnamespaces(default 'http://tempuri.org/sdnList.xsd') 
--INSERT INTO tbl_ofac_birth
SELECT element.value('(uid)[1]', 'VARCHAR(20)') as entityid,
     element.value('(dateOfBirthList/dateOfBirthItem/uid)[1]', 'int') as uid,
     element.value('(dateOfBirthList/dateOfBirthItem/dateOfBirth)[1]', 'VARCHAR(255)') as dateOfBirth,
     element.value('(placeOfBirthList/placeOfBirthItem/placeOfBirth)[1]', 'VARCHAR(255)') as placeOfBirth,
     GETDATE() as updatedate
	 INTO #tbl_ofac_birth_temp
FROM 
   @smsxml.nodes('/sdnList/sdnEntry') AS XMLTbl(element)  
   where (element.value('(dateOfBirthList/dateOfBirthItem/uid)[1]', 'int') is not null)
--   order by uid asc 
INSERT INTO tbl_ofac_birth SELECT * FROM #tbl_ofac_birth_temp
DROP TABLE #tbl_ofac_birth_temp

   --or element.value('(placeOfBirthList/placeOfBirthItem/uid)[1]', 'int') is not null)  
   --order by uid asc   
--   and element.value('(uid)[1]', 'VARCHAR(20)') = @entity_id order by uid asc   

--DOCUMENT LIST
;with xmlnamespaces(default 'http://tempuri.org/sdnList.xsd') 
--INSERT INTO tbl_ofac_doc_data
SELECT element.value('(uid)[1]', 'VARCHAR(20)') as entityid,
     element.value('(idList/id/uid)[1]', 'int') as uid,
     element.value('(idList/id/idType)[1]', 'VARCHAR(255)') as idType,
     element.value('(idList/id/idNumber)[1]', 'VARCHAR(255)') as idNumber,
     element.value('(idList/id/idCountry)[1]', 'VARCHAR(255)') as idCountry,
     GETDATE() as updatedate
	 INTO #tbl_ofac_doc_temp
FROM 
   @smsxml.nodes('/sdnList/sdnEntry') AS XMLTbl(element)  where element.value('(idList/id/uid)[1]', 'int') is not null order by uid asc   
INSERT INTO tbl_ofac_doc_data SELECT * FROM #tbl_ofac_doc_temp
DROP TABLE #tbl_ofac_doc_temp

--   @smsxml.nodes('/sdnList/sdnEntry') AS XMLTbl(element)  where element.value('(idList/id/uid)[1]', 'int') is not null and element.value('(uid)[1]', 'VARCHAR(20)') = @entity_id order by uid asc   

--FETCH NEXT FROM curs into @entity_id,@entity_type;    
--END; 
--CLOSE curs 
--DEALLOCATE curs; 

drop table #ofac_xml_temp

EXEC sp_xml_removedocument @idoc

select @id_count = count(ofac_sanction_id) from tbl_ofac_name_data

update tbl_sanctionlist set update_data=@id_count,last_update=GETDATE() where sanction_list_id=1;

INSERT INTO tbl_sanction_update VALUES ('1',GETDATE(),@id_count,@id_count,GETDATE())
 
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
			ROLLBACK TRANSACTION proc_ofac_data;

		RAISERROR ('proc_ofac_data: %d: %s', 2, 1, @error, @message);
	END CATCH	

select @message;
--=======================

END
GO



 
--exec proc_ofac_data 'Bangladesh'

--EXEC sp_addsrvrolemember 'EFTdbuser', 'bulkadmin';
--GO

