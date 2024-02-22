<!DOCTYPE html>

<html>
  <head>
    <title>RecordR</title>
    <link href="style.css" type="text/css" rel="stylesheet"/>
  </head>

<!-- Main site content -->

  <body>
    <div>
      <a class="headerOption logoAdjust" href="/index.html"><img src="images/RecordRHorizontalLogo.png" alt="RecordR Logo"/></a>
      <a class="headerOption headerTweak" href="/generate.php"><p>[Create A Bin]</p></a>
      <a class="headerOption headerTweak" href="/aboutus.html"><p>[About Us]</p></a>
      <a class="headerOption headerTweak" href="/download.php"><p>[Download]</p></a>
    </div>

    <form action="" method="post" class="indent">
        <label for="first_dropdown">Select a band performance:</label>
        <select name="first_dropdown" id="first_dropdown">
            <?php
            // Function to get all files in a directory
            function getFilesInDirectory($directory)
            {
                $files = array();
                if (is_dir($directory)) {
                    if ($handle = opendir($directory)) {
                        while (false !== ($file = readdir($handle))) {
                            if ($file != "." && $file != "..") {
                                $files[] = $file;
                            }
                        }
                        closedir($handle);
                    }
                }
                return $files;
            }

            // The root filepath where the "upload" directory is located
            $root_filepath = './upload/';

            // Get all directories in the root filepath
            $directories = getFilesInDirectory($root_filepath);

            // Generate options for the first dropdown menu
            foreach ($directories as $directory) {
                echo "<option value='{$directory}'>{$directory}</option>";
            }
            ?>
        </select>
        <br>
        <br>
        <label for="second_dropdown">Select a clip:</label>
        <select name="second_dropdown" id="second_dropdown">
            <!-- This will be populated dynamically using JavaScript -->
        </select>
        <br>
        <?php
        // This hidden input is used to pass the root filepath to JavaScript
        echo "<input type='hidden' id='root_filepath' value='{$root_filepath}'>";
        ?>
        <br>
        <button type="button" id="download_button" style="display: none;">Download Clip</button>
    </form>

    <script>
        // Function to update the second dropdown based on the selected folder
        function updateSecondDropdown(selectedDirectory) {
            const rootFilePath = document.getElementById('root_filepath').value;
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        const secondDropdown = document.getElementById('second_dropdown');
                        const files = JSON.parse(xhr.responseText);

                        // Clear previous options
                        secondDropdown.innerHTML = '';

                        // Generate options for the second dropdown menu
                        files.forEach(file => {
                            const option = document.createElement('option');
                            option.value = file;
                            option.textContent = file;
                            secondDropdown.appendChild(option);
                        });

                        // Show the download button
                        const downloadButton = document.getElementById('download_button');
                        downloadButton.style.display = 'block';
                    } else {
                        console.error('Failed to fetch files for the selected directory.');
                    }
                }
            };

            xhr.open('GET', `get_files.php?directory=${selectedDirectory}`, true);
            xhr.send();
        }

        // Event listener for the first dropdown menu
        const firstDropdown = document.getElementById('first_dropdown');
        firstDropdown.addEventListener('change', function () {
            const selectedDirectory = firstDropdown.value;
            updateSecondDropdown(selectedDirectory);
        });

        // Event listener for the download button
        const downloadButton = document.getElementById('download_button');
        downloadButton.addEventListener('click', function () {
            const selectedDirectory = firstDropdown.value;
            const selectedFile = document.getElementById('second_dropdown').value;
            const downloadPath = `./upload/${selectedDirectory}/${selectedFile}`;

            // Trigger the file download
            const link = document.createElement('a');
            link.href = downloadPath;
            link.download = selectedFile;
            link.click();
        });

        // Initialize the second dropdown based on the initial selection
        const initialSelectedDirectory = firstDropdown.value;
        updateSecondDropdown(initialSelectedDirectory);
    </script>
</body>
</html>
