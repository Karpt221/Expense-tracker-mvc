<form enctype="multipart/form-data" action="/transactions/export" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
    <input type="file" name="exportfiles[]" multiple>
    <input type="submit" value="Export csv" />
</form>