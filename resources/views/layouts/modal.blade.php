<!-- INFO Modal -->
  <div class="modal fade" id="infoModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content text-center">
        <div class="modal-header">
          <h4 class="modal-title">Filebrowser - instructions</h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid" style="text-align:left;">

            <!-- Instructions on how to move in filebrowser -->
            <div class="panel-group" id="infoAccordion">
              <div class="panel panel-info" >
                <div class="panel-heading text-center" >
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#infoAccordion" href="#moving">Moving</a>
                  </h4>
                </div>
                  <div id="moving" class="panel-collapse collapse">
                    <div class="panel-body">
                      <ul>
                        <li><p>Click <kbd>folder's name</kbd> to move into that folder<p></li>
                        <li><p>To get back in previous folder's, see the <kbd>breadcrumbs bar</kbd> under the Filebrowser header, and click the folders name where you want to head.<p></li>
                        <li><p>You can always get back in mainpage by clicking the <kbd>Filebrowser text</kbd> at the top left or clicking the <kbd>Home icon</kbd> at the bottom right.</p></li>
                    </ul>
                    </div>
                  </div>
                </div>

                <!-- Instructions on how to create directory -->
                <div class="panel panel-success" >
                  <div class="panel-heading text-center" >
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#infoAccordion" href="#creatingDirectory">Creating directory</a>
                    </h4>
                  </div>
                    <div id="creatingDirectory" class="panel-collapse collapse">
                      <div class="panel-body">
                        <ul>
                          <li><p>Click the <kbd>green folder icon</kbd> at the bottom right of the screen. Insert folder name and click <kbd>create button</kbd>.</li>
                          <li><p><code>NOTE!</code> Folder will always be created at your current directory location.</p></li>
                      </div>
                    </div>
                  </div>

                  <!-- Instructions on how to upload files -->
                  <div class="panel panel-success" >
                    <div class="panel-heading text-center" >
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#infoAccordion" href="#uploadingFiles">Uploading files</a>
                      </h4>
                    </div>
                      <div id="uploadingFiles" class="panel-collapse collapse">
                        <div class="panel-body">
                          <ul>
                            <li><p>Click the <kbd>green text-file icon</kbd> at the bottom right of the screen.</p></li>
                            <li><p>Click <kbd>Select...</kbd> and select the file that you want to upload.</p></li>
                            <li><p>After selecting your file click <kbd>Upload file</kbd>.</p></li>
                            <li><p><code>NOTE!</code> File will always be uploaded at your current directory location.</p></li>
                          </ul>
                        </div>
                      </div>
                    </div>

                    <!-- Instructions on how to rename files -->
                    <div class="panel panel-warning" >
                      <div class="panel-heading text-center" >
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#infoAccordion" href="#renamingFiles">Renaming files</a>
                        </h4>
                      </div>
                        <div id="renamingFiles" class="panel-collapse collapse">
                          <div class="panel-body">
                            <ul>
                              <li><p>Click the <kbd>blue rename button</kbd> on the file that you want to rename.<p></li>
                              <li><p>Insert new filename and click the <kbd>green confirm button</kbd>, and the file will be renamed</p></li>
                              <li><p><code>NOTE!</code> Do not remove the filetype at the end of the name (.jpg, .txt) </p></li>
                            </ul>
                          </div>
                        </div>
                      </div>

                      <!-- Instructions on how to delete files -->
                      <div class="panel panel-danger" >
                        <div class="panel-heading text-center" >
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#infoAccordion" href="#deletingFiles">Deleting files</a>
                          </h4>
                        </div>
                          <div id="deletingFiles" class="panel-collapse collapse">
                            <div class="panel-body">
                              <ul>
                                <li><p>Click the <kbd>red trash can icon</kbd> on the file that you want to delete.</p></li>
                                <li><p>Confirm the deletion and the file will be removed.</p></li>
                                </ul>
                            </div>
                          </div>
                        </div>
                      </div>

              </div>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- FILE UPLOAD -->
    <div class="modal fade" id="fileModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content text-center">
          <div class="modal-header">
            <h4 class="modal-title">Upload file</h4>
          </div>
          <div class="modal-body">

            <div class="container-fluid" style="text-align:left;">
                {{ Form::open(['class' => 'dropzone', 'url' => 'upload', 'method' => 'POST', 'files' => true, 'enctype' => 'multipart/form-data']) }}
                  {{Form::hidden('invisible', @$directory) }}
                  {{csrf_field()}}
                {{ Form::close() }}
            </div>
          <br>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- NEW DIRECTORY -->
    <div class="modal fade" id="directoryModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content text-center">
          <div class="modal-header">
            <h4 class="modal-title">Create new directory</h4>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <br>
              <input type="text" class="form-control" placeholder="Folder name" id="directoryName" style="width:100%;"></input>
              <br>
              <button type="button" class="btn btn-success btn-create-directory" role="button">Create</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
    </div>


  <!-- USER CONTROL -->
  <div class="modal fade" id="userControlModal" role="dialog">

    </div>

  <!-- Notification bar -->
  <div id="notificationBar">Notification text...</div>
