USE dbutility;
GO
/****** Object:  StoredProcedure [dbo].[proc_send_sms]    Script Date: 11/19/2014 16:56:36 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER PROCEDURE [dbo].[proc_send_sms] 
	-- Add the parameters for the stored procedure here
	@mobileno VARCHAR(20),@sms_message VARCHAR(50)
AS
BEGIN

	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.

	DECLARE @branchcode VARCHAR(4),@seckey VARCHAR(4),@smslink VARCHAR(MAX),@sub_mobileno VARCHAR(20),@smscontent VARCHAR(300);
DECLARE @win int
DECLARE @hr  int
DECLARE @text varchar(8000)
DECLARE @smscount int
DECLARE @source varchar(255)
DECLARE @description varchar(255)

--===========================
		DECLARE @error INT, @message varchar(4000), @xstate INT;

	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
	SET XACT_ABORT ON 


--===========================
--LINK CHECK START
DECLARE @url_link varchar(8000),@data_link varchar(2000),@sms_link varchar(8000)


SET @smscount = 0;
--select @sms_message;


DECLARE @url varchar(8000),@data varchar(2000)
DECLARE @smsxml AS XML,@smsstatus VARCHAR(20),@smsremarks VARCHAR(100);

--SET @url='http://gateway.skebby.it/api/send/smseasy/advanced/http.php';
--SET @data='method=send_sms_classic&username=jahur&password=Sshima123&text=sdfsdf&recipients[]=8801718345050&sender_number=8801751632683'

--SET @url='https://api.lineasms.net/sendsms';
--SET @data='Id_anagrafica=3344&to=[{gsm:00000000},{gsm:00000000}]&text=sdfsdf&from=393293835129'


SET @url='http://mbp.srl.com.bd/mBillPlus_api/RestAPI/Payment_Gateway.php?org_code=BPDB&customer_code=janata@bank&password=janatatest@1234&org_br_code=B1&acc_num=32509689&billcycle=201703&pc_code=61&pc_br_code=&user_name=JNTA_CBS&otc=1&v=1&format=json';

--SET @data='org_code=BPDB&customer_code=janata@bank&password=janatatest@1234&org_br_code=B1&acc_num=32509689&billcycle=201703&pc_code=61&pc_br_code=&user_name=JNTA_CBS&otc=1&v=1&format=json';
SET @data='';

--203.76.102.171

--115.127.69.74

--d1ae5914-c49c-4ef6-b34a-ea10534777a4


--SELECT @url;

EXEC @hr=sp_OACreate 'WinHttp.WinHttpRequest.5.1',@win OUT
--IF @hr <> 0 EXEC sp_OAGetErrorInfo @win

--EXEC @hr=sp_OAMethod @win, 'setOption', null, 1

EXEC @hr=sp_OAMethod @win, 'Open',NULL,'POST',@url,'false'

--IF @hr <> 0 EXEC sp_OAGetErrorInfo @win
--select @win;

--EXEC @hr=sp_OAMethod @win, 'setRequestHeader',NULL, 'Content-type', 'application/x-www-form-urlencoded'
EXEC @hr=sp_OAMethod @win, 'setRequestHeader',NULL, 'content-transfer-encoding', 'application/x-www-form-urlencoded'
--EXEC @hr=sp_OAMethod @win, ' setOption ', null, 2, 13056
IF @hr <> 0 EXEC sp_OAGetErrorInfo @win


--select @win;

EXEC @hr=sp_OAMethod @win,'Send',null,@data
--IF @hr <> 0 EXEC sp_OAGetErrorInfo @win
IF @hr <> 0 EXEC sp_OAGetErrorInfo @win, @source OUT, @description OUT

--select @win
IF @description IS NOT NULL
GOTO EndError

EXEC @hr=sp_OAGetProperty @win,'ResponseText',@text OUTPUT

--IF @hr <> 0 EXEC sp_OAGetErrorInfo @win


SET @smsxml = @text;

--SELECT @smsstatus = a.b.value('status[1]','varchar(50)'),@smsremarks = a.b.value('remarks[1]','varchar(100)')  FROM @smsxml.nodes('response') a(b);

--select @text,@smsstatus;

EXEC @hr=sp_OADestroy @win
--IF @hr <> 0 EXEC sp_OAGetErrorInfo @win
IF @hr <> 0 EXEC sp_OAGetErrorInfo @win, @source OUT, @description OUT




--select @text;

EndError:

IF @description IS NOT NULL
SELECT @description;

IF @description IS NULL
select @text;


END

GO

exec proc_send_sms '00393293835129','JANTA BANK LIMITED'

--status=failed&code=30&message=No+credit+left%2C+please+buy+a+recharge+on+http%3A%2F%2Fwww.skebby.it%2F

