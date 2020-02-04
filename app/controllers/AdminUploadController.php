<?php

namespace App\Controllers;

class AdminUploadController extends AdminController
{
    public function uploadPhoto()
    {
      $error = null;
      $targetDir = "public/uploads/";
      $fileName = time() . basename($_FILES["file"]["name"]);
      $targetPath = $targetDir . $fileName;
      $check = getimagesize($_FILES["file"]["tmp_name"]);
      if (!$check) {
        $error = "File is not an image.";
      }
      if (file_exists($targetPath)) {
        $error = "Sorry, file already exists.";
      }
      if (!is_null($error)) {
        return abort(400, $error);
      }
      if (!move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath)) {
        return abort(500, "Sorry, there was an error uploading your file.");
      }
      return json([
        'photo' => asset('uploads/' . $fileName)
      ]);
    }
}
