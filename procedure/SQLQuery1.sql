DECLARE @h int
DECLARE @x xml
DECLARE @y xml
--select CHARINDEX('>','<sdnList xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://tempuri.org/sdnList.xsd">');

set @x = '<sdnList xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://tempuri.org/sdnList.xsd">

  <sdnEntry uid="2">
    
    <lastName>ACEFROSTY SHIPPING CO., LTD.</lastName>
    <sdnType>Entity</sdnType>
    <programList>
      <program>CUBA</program>
    </programList>
    <addressList>
      <address>
        
        <address1>171 Old Bakery Street</address1>
        <city>Valletta</city>
        <country>Malta</country>
      </address>
    </addressList>
  </sdnEntry>
  </sdnList>';
  --SELECT @x = REPLACE(@x,'xmlns="http://tempuri.org/sdnList.xsd"','');
DECLARE @XmlFile XML


SELECT @XmlFile = CAST(BulkColumn AS XML)
FROM OPENROWSET (BULK 'C:\ofac_sdn.xml' , SINGLE_BLOB) AS XMLDATA
 
  ;with xmlnamespaces(default 'http://tempuri.org/sdnList.xsd')
  

SELECT
    
     Prgs.value('(lastName)[1]', 'varchar(50)') as addres
FROM 
    @XmlFile.nodes('/sdnList/sdnEntry') AS XTbl(Prgs)
    
--SELECT nref.value('country[1]', 'nvarchar(50)') FirstName
--FROM   @x.nodes('sdnEntry/addressList/address') AS R(nref)

set @y = '<Root>
  <row id="1"><lname>Duffy</lname>
   <Address>
            <Street>111 Maple</Street>
            <City>Seattle</City>
   </Address>
  </row>
  <row id="2"><lname>Wang</lname>
   <Address>
            <Street>222 Pine</Street>
            <City>Bothell</City>
   </Address>
  </row>
</Root>'

EXEC sp_xml_preparedocument @h output, @x, '<ROOT xmlns:ns="http://tempuri.org/XMLSchema.xsd" xmlns:mstns="http://tempuri.org/XMLSchema.xsd" xmlns:xs="http://www.w3.org/2001/XMLSchema" />'


--SELECT *
--FROM   OPENXML (@h, 'sdnList/sdnEntry', 3)
--      WITH (uid int '@uid',
                
--            lastName    varchar(30) 'lastName',
--            xmlname  xml 'lastName',
--            OverFlow xml '@mp:xmltext')

EXEC sp_xml_preparedocument @h output, @y

--SELECT *
--FROM   OPENXML (@h, '/Root/row', 10)
--      WITH (id int '@id',
                
--            lname    varchar(30),
--            xmlname  xml 'lname',
--            OverFlow xml '@mp:xmltext')

EXEC sp_xml_removedocument @h
