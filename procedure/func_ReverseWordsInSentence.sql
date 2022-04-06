ALTER FUNCTION [dbo].[fn_ReverseWordsInSentence]
(
@ip VARCHAR(MAX)
)
RETURNS VARCHAR(MAX)
BEGIN
DECLARE @op VARCHAR(MAX)
SET  @op = ''
DECLARE @Lenght INT
DECLARE @LastPos INT

SELECT @LastPos = LEN(@ip) - CHARINDEX(' ', REVERSE(@ip)) + 1;

SET @ip = SUBSTRING(@ip,0,@LastPos)

WHILE LEN(@ip) > 0
BEGIN
IF CHARINDEX(' ', @ip) > 0
BEGIN
SET @op = SUBSTRING(@ip,0,CHARINDEX(' ', @ip)) + ' ' + @op
SET @ip = LTRIM(RTRIM(SUBSTRING(@ip,CHARINDEX(' ', @ip) + 1,LEN(@ip))))
END
ELSE
BEGIN

--SET @op = @ip + ' ' + @op
SET @op = @op + ' ' + @ip

SET @ip = ''
END
END
RETURN @op
END
-- Usage

--SELECT  [dbo].[fn_ReverseWordsInSentence] ('Mohammed Jahurul Islam')