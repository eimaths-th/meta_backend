<form
  action="{{ url('/attendance/import') }}"
  method="post"
  enctype="multipart/form-data"
>
  @csrf
  <input type="file" name="file" accept=".xls,.xlsx" />
  <button type="submit">Import</button>
</form>
