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
        $oldData = $this->_getFile();

        $newData = [$this->getNameInput() => [
                'status' => 'active',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
                'deleted_at' => null,
                'types' => $options ?: 'basic',
                'datas' => $this->generatedFiles]
        ];

        $this->_writeFile(array_merge((array) $oldData, $newData));
    }

    private function _writeFile(array $datas)
    {
        // $json = json_encode($datas, JSON_PRETTY_PRINT);
        $json = json_encode($datas);
        (new Filesystem)->put($this->_fileName, $json);
    }

    private function _getFile()
    {
        if (!file_exists($this->_fileName)) {
            $this->_writeFile([]);
        }
        
        $data = [];
        try {
            $data = json_decode((new Filesystem)->get($this->_fileName));
        } catch (FileNotFoundException $exception) {
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
