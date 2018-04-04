
  <div class="container">
  <form method="POST" action="/upload" enctype="multipart/form-data">
  {{{ csrf_field() }}}
  <input type="file" name="avatar"></input><br>
  <button type="submit">Save file</button>
  </div>
