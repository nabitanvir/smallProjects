<!DOCTYPE html>

<html>
  <head>
    <title>RecordR</title>
    <link href="style.css" type="text/css" rel="stylesheet">
  </head>

<!-- Main site content -->

  <body>
    <div>
      <a class="headerOption logoAdjust" href="/index.html"><img src="images/RecordRHorizontalLogo.png" alt="RecordR Logo"/></a>
      <a class="headerOption headerTweak" href="/generate.php"><p>[Create A Bin]</p></a>
      <a class="headerOption headerTweak" href="/aboutus.html"><p>[About Us]</p></a>
      <a class="headerOption headerTweak" href="/download.php"><p>[Download]</p></a>
    </div>


    <form method="POST" action="" class="indent">
      <label for="directory_name">Band Name:</label>
      <input type="text" name="directory_name" id="directory_name" required><br>
      <br>
      <label for="date">Date of Performance:</label>
      <input type="date" name="date" id="date" required><br>
      <br>
      <label for="var2">Set Name:</label>
      <input type="text" name="var2" id="var2" required><br>
      <br>
      <button type="submit" name="create_directory">Create Bin</button>
    </form>

    <?php
    if (isset($_POST['create_directory'])) {
        $directoryName = $_POST['directory_name'];
        $date = $_POST['date'];
        $var2 = $_POST['var2'];

        $basePath = "upload/"; // Replace with the actual file path

        $newDirectoryName = $directoryName . "_" . $date . "_" . $var2;
        $directoryPath = $basePath . $newDirectoryName;

        if (!file_exists($directoryPath)) {
            if (mkdir($directoryPath, 0777, true)) {
                // Generate upload.php script
                $uploadScript = "<?php
                    if (\$_SERVER['REQUEST_METHOD'] === 'POST' && isset(\$_FILES['file'])) {
                        \$uploadedFiles = \$_FILES['file'];
                        \$fileCount = count(\$uploadedFiles['name']);

                        for (\$i = 0; \$i < \$fileCount; \$i++) {
                            \$fileName = \$uploadedFiles['name'][\$i];
                            \$fileTmpName = \$uploadedFiles['tmp_name'][\$i];
                            \$fileDestination = __DIR__ . '/' . \$fileName;

                            if (move_uploaded_file(\$fileTmpName, \$fileDestination)) {
                                echo '<script>alert(\"File \" + \"$fileName\" + \" successfully uploaded.\");</script>';
                            } else {
                                echo '<script>alert(\"Failed to upload file \" + \"$fileName\" + \".\");</script>';
                            }
                        }
                    }
                ?>

                <!DOCTYPE html>
                <html>
                  <head>
                    <title>RecordR: <?php echo \"$directoryName\"; ?></title>
                    <link href=\"../../style.css\" type=\"text/css\" rel=\"stylesheet\">
                  </head>
                  <body>     
                    <div>
                      <a class=\"headerOption logoAdjust\" href=\"../../index.html\"><img src=\"../../images/RecordRHorizontalLogo.png\" alt=\"RecordR Logo\"/></a>
                      <a class=\"headerOption headerTweak\" href=\"../..//generate.php\><p>[Create A Bin]</p></a>
                      <a class=\"headerOption headerTweak\" href=\"../../aboutus.html\"><p>[About Us]</p></a>
                      <a class=\"headerOption headerTweak\" href=\"../../download.php\"><p>[Download]</p></a>
                    </div>

                    <div id=\"fileUploadInterface\" class=\"indent\">
                      <h2>Upload Files For <?php echo \"$newDirectoryName\"; ?></h2>
                      <form method=\"POST\" action=\"\" enctype=\"multipart/form-data\">
                        <label for=\"file\">Select Files:</label>
                        <input type=\"file\" title=\" \" name=\"file[]\" id=\"file\" required multiple>
                        <button type=\"submit\" name=\"upload\">Upload</button>
                      </form>
                      <p id=\"fileDisplay\"></p>
                      <progress id=\"uploadProgress\" value=\"0\" max=\"100\"></progress>
                      <p id=\"uploadMessage\"></p>
                    </div>

                    <div id=\"qrcodeSave\" class=\"indent\">
                      <img src=\"qrcode.png\" alt=\"QR Code\">
                      <br>
                      <button onclick=\"saveQRCode()\">Save QR Code</button>
                    </div>

                    <script>
                        function saveQRCode() {
                            var downloadLink = document.createElement('a');
                            downloadLink.href = 'qrcode.png';
                            downloadLink.download = '$newDirectoryName.png';
                            downloadLink.click();
                        }

                        var fileInput = document.getElementById('file');
                        fileInput.addEventListener('change', function() {
                            var fileDisplay = document.getElementById('fileDisplay');
                            var fileNames = [];
                            for (var i = 0; i < fileInput.files.length; i++) {
                                fileNames.push(fileInput.files[i].name);
                            }
                            fileDisplay.textContent = 'Selected Files: ' + fileNames.join(', ');
                            fileDisplay.style.color = 'white';
                        });

                        var form = document.querySelector('form');
                        form.addEventListener('submit', function(event) {
                            event.preventDefault();

                            var fileInput = document.getElementById('file');
                            var progressBar = document.getElementById('uploadProgress');

                            var formData = new FormData();
                            for (var i = 0; i < fileInput.files.length; i++) {
                                formData.append('file[]', fileInput.files[i]);
                            }

                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'upload.php');

                            xhr.upload.addEventListener('progress', function(event) {
                                if (event.lengthComputable) {
                                    var percentComplete = (event.loaded / event.total) * 100;
                                    progressBar.value = percentComplete;
                                }
                            });

                            xhr.addEventListener('load', function(event) {
                                progressBar.value = 100;
                                document.getElementById('uploadMessage').innerHTML = 'All files successfully uploaded.';
                            });

                            xhr.send(formData);
                        });
                    </script>
                  </body>
                </html>";

                $uploadScriptPath = $directoryPath . '/upload.php';

                if (file_put_contents($uploadScriptPath, $uploadScript)) {
                    // Generate QR code that links to the upload.php page itself
                    $qrCodeUrl = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=" . urlencode("http://" . $_SERVER["HTTP_HOST"] . "/" . $uploadScriptPath);
                    $qrCodeData = file_get_contents($qrCodeUrl);
                    file_put_contents($directoryPath . '/qrcode.png', $qrCodeData);

                    echo "<br><a class=\"indent\" href=\"$uploadScriptPath\">Click here</a> to access " . $newDirectoryName;
                } else {
                    echo "<br>Failed to generate upload.php script.";
                }
            } else {
                echo "Failed to create directory: " . $newDirectoryName;
            }
        } else {
            echo "Directory already exists: " . $newDirectoryName;
        }
    }
    ?>


</body>
</html>
