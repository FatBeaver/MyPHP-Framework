<form action="/file-test" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />

    <div class="form-group">
        <label for="file">Files</label>
        <input type="file" name="user-file[]" multiple class="form-control" id="file" placeholder="File">
    </div>

    <div class="form-group">
        <label for="file">Files</label>
        <input type="file" name="user-file-2[]" multiple class="form-control" id="file" placeholder="File">
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Загрузить</button>
</form>

