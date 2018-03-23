<?php

namespace HalcyonLaravel\Module\Commands\Traits;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FileNotFoundException;

/**
 * $this->generatedFiles;
 */

trait BackUpTraits
{
    private $_fileName = '.module.cache';

    public function generatingFile($options = null)
    {
        $oldData = $this->getBackupFile();

        $newData =
        [
            $this->getNameInput() =>
            [
                'status' => 'active',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
                'types' => $options ?: 'basic',
                'datas' => $this->generatedFiles
            ]
        ];

        $this->_writeFile(array_merge((array) $oldData, $newData));
    }

    public function udpateDeleteData($moduleName)
    {
        $oldData = $this->getBackupFile($moduleName);

        $updatedData = [$this->getNameInput() => [
                'status' => 'inactive',
                'created_at' => $oldData->created_at,
                'updated_at' => $oldData->updated_at,
                'deleted_at' => now()->format('Y-m-d H:i:s'),
                'types' => $oldData->types,
                'datas' => $oldData->datas]
        ];

        $this->_writeFile(array_merge((array) $this->getBackupFile(), $updatedData));
    }


    private function _writeFile(array $datas)
    {
        // $json = json_encode($datas, JSON_PRETTY_PRINT);
        $json = json_encode($datas);
        (new Filesystem)->put($this->_fileName, $json);
    }

    private function getBackupFile($moduleName = null)
    {
        if (!file_exists($this->_fileName)) {
            $this->_writeFile([]);
        }
        
        $data = [];
        try {
            $data = json_decode((new Filesystem)->get($this->_fileName));
        } catch (FileNotFoundException $exception) {
        }

        if (!is_null($moduleName)) {
            if (isset($data->$moduleName)) {
                return $data->$moduleName;
            } else {
                return null;
            }
        }
        return $data;
    }
    public function getCurrentProjectDir()
    {
        return str_replace('storage', '', storage_path());
    }

    public function removeProjectDir($path)
    {
        return str_replace($this->getCurrentProjectDir(), '', $path);
    }

    public function addProjectDir($path)
    {
        return $this->getCurrentProjectDir() . $path;
    }
}
