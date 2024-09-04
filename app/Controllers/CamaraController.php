<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CamaraController extends BaseController
{
    public function upload()
    {
        $imageFile = $this->request->getFile('image');

        if ($imageFile && $imageFile->isValid()) {
            // Define the path where the file should be saved
            $path = WRITEPATH . 'uploads/';
            $newName = $imageFile->getRandomName();
            
            // Ensure the directory exists
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            // Move the file to the defined path
            $imageFile->move($path, $newName);

            // Respond with the filename or any other relevant info
            return $this->response->setJSON(['status' => 'success', 'filename' => $newName]);
        }
        

        return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo cargar la imagen']);
    }
}
