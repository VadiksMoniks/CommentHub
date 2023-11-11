<?

namespace App\Services;

class FileService{

    public function storeFiles(array $files)
    {
        $paths = [];
        try{
            foreach($files as $key => $file){
    
                $paths[$key] =  $files[$key]->storeAs('media/', date("Y-d-m").'-'.$files[$key]->getClientOriginalName().$files[$key]->getClientOriginalExtension());
            }
    
            return $paths;
        }
        catch(\Exception $e){
            $this->deleteUnstoredFiles($files);

            if($paths != []){
                $this->deleteStoredFiles($paths);
            }

            return $e;
        }
    }

    public function deleteStoredFiles(array $files)
    {
        foreach($files as $file){
            unlink($file);
         }
    }

    public function deleteUnstoredFiles(array $files)
    {
        foreach($files as $file){
            $file->delete();
         }
    }

}