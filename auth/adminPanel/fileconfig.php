<?php


// This function scans the files folder recursively, and builds a large array
function scan($dir, $sortByDate = false) {
    $files = array();
    // Is there actually such a folder/file?
    if (file_exists($dir)) {
        $fileList = scandir($dir);

        // Sort files by date if requested
        if ($sortByDate) {
            usort($fileList, function ($a, $b) use ($dir) {
                $fileA = $dir . '/' . $a;
                $fileB = $dir . '/' . $b;
                return filemtime($fileB) - filemtime($fileA);
            });
        }

        foreach ($fileList as $f) {
            if (!$f || $f[0] == '.') {
                continue; // Ignore hidden files
            }
            
            $filePath = $dir . '/' . $f;
            
            if(is_link($filePath)){
              continue;
            }

            if (is_dir($dir . '/' . $f)) {
                // The path is a folder
                $files[] = array(
                    "name" => $f,
                    "type" => "folder",
                    "path" => $dir . '/' . $f,
                    "items" => scan($dir . '/' . $f, $sortByDate) // Recursively get the contents of the folder
                );
            } else {
                // It is a file
                $files[] = array(
                    "name" => $f,
                    "type" => "file",
                    "path" => $dir . '/' . $f,
                    "size" => filesize($dir . '/' . $f), // Gets the size of this file
                    "date" => filemtime($dir . '/' . $f) // Gets the modification date of this file
                );
            }
        }
    }
    return $files;
}


function upload($file, $filesize, $directory, $overwrite) {

    $filename = trim($_FILES[$file]["name"]);

    $response['filename'] = "";
    $response['error'] = true; //assuming there is an error
    $response['error_msg'] = "";

    if (empty($filename)) {
        $response['error_msg'] = "File not selected";
        return $response;
    }

    if ($_FILES[$file]["error"] > 0) {
        $response['error_msg'] = 'There is some problem please try again later.' . $_FILES[$file]["error"];
        return $response;
    }
    //file size limit checking
    if (($filesize * 1024) < $_FILES[$file]["size"]) {
        $response['error_msg'] = 'File size should less than ' . $filesize . ' kb.';
        return $response;
    }    
    //if everything alright
    if ($directory != null && $directory <> '') {
        $directory = $directory . "/";
    } else {
        $directory = "";
    }
    //if overwrite parameter is not Y then new file name needs to be generated
    if ($overwrite != 'Y') {
        $i = 1;
        while (file_exists($directory . $filename)) {
            $filename = basename($filename, "." . $extension) . "_" . $i . "." . $extension;
            $i++;
        }
    }
    if (move_uploaded_file($_FILES[$file]["tmp_name"], $directory . $filename)) {
        $response['filename'] = basename($filename);
        $response['error'] = false;
        return $response;
    } else {
        $response['error_msg'] = "File could not moved";
        return $response;
    }
}
