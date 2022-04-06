ALTER FUNCTION SplitWords(@text varchar(8000)) 
   RETURNS @words TABLE (
      pos smallint, 
      name_words varchar(8000)
   ) 
AS 
BEGIN 
   SET @text = RTRIM(@text)
 
   DECLARE @delims varchar(10) 
   SET @delims = ' ,:/-'
   DECLARE @pos smallint, @i smallint, @s varchar(8000)
 
   SET @pos = 1 
 
   WHILE @pos < LEN(@text) 
      AND CHARINDEX(SUBSTRING(@text, @pos, 1), @delims) > 0 
      SET @pos = @pos + 1 
 
   WHILE @pos <= LEN(@text) 
   BEGIN 
      SET @i = PATINDEX('%[' + @delims + ']%', 
         SUBSTRING(@text, @pos, len(@text) - @pos + 1)) 
      IF @i > 0 
      BEGIN 
         SET @i = @i + @pos - 1 
         IF @i > @pos 
         BEGIN 
            -- @i now holds the earliest delimiter in the string
            SET @s = SUBSTRING(@text, @pos, @i - @pos)
            INSERT INTO @words 
            VALUES (@pos, @s)
         END 
         SET @pos = @i + 1 
 
         WHILE @pos < LEN(@text) 
            AND CHARINDEX(SUBSTRING(@text, @pos, 1), @delims) > 0 
            SET @pos = @pos + 1 
      END
      ELSE 
      BEGIN
         SET @s = SUBSTRING(@text, @pos, LEN(@text) - @pos + 1)
         INSERT INTO @words 
         VALUES (@pos, @s) SET @pos = LEN(@text) + 1
      END 
   END
   -- remove common words that we don't want to search for 
   --DELETE FROM @words 
   --WHERE name_words IN ('an', 'the', 'of', '&', 'Md.') 

   DELETE FROM @words 
   WHERE name_words IN (select title_word from tbl_title_words where word_status='A') 

   RETURN 
END 


--select * from dbo.SplitWords('Hellow Bangladesh 34 an natural idea them');