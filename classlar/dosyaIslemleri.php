<?php

error_reporting(E_ALL | E_NOTICE);
header('Content-Type: text/html', true);

class File {

    /**
     * islem yapılan dizin
     *
     * @var string
     */
    private $pathName;
    /**
     * islem yapılan dosya
     *
     * @var string
     */
    private $fileName;
    /**
     * islem yapılan dosya objesi
     *
     * @var object
     */
    private $fileObject;

    /**
     * dizini set eder
     *
     * @param string $path
     */
    public function setPart($path, $file) {
        $this->pathName = $path;
        $this->fileName = $file;
    }

    /**
     * dosya var mı?
     *
     * @return boolean
     */
    public function fileExists() {
        if (!@file_exists($this->pathName . '/' . $this->fileName)) {
            throw new Exception('Dosya veya dizin hatalı girildi.', 1);
            return false;
        } else
            return true;
    }

    /**
     * dosyayı açar.
     *
     * @param string $paramater
     * @return void
     */
    private function fileOpen($paramater, $fileExists=true) {
        try {
            if ($fileExists)
                self::fileExists();
            $this->fileObject = fopen($this->pathName . '/'
                    . $this->fileName, $paramater);
        } catch (Exception $error) {
            trigger_error($error->getMessage(), E_USER_ERROR);
        }
    }

    /**
     * açık olan dosyayı kapatır.
     *
     * @return void
     */
    private function fileClose() {
        fclose($this->fileObject);
    }

    /**
     * dosya boyunu get eder
     *
     * @return integer
     */
    private function getFileSize() {
        return filesize($this->pathName . '/' . $this->fileName);
    }

    /**
     * metin dosyaların içerigini okur
     *
     * @param string $readParameter
     * @return string
     */
    public function read($readParameter='r') {
        try {
            self::fileOpen($readParameter);
            $fileSize = self::getFileSize();
            $read = '';
            while (!feof($this->fileObject)) {
                $read .= fread($this->fileObject, $fileSize);
            }
            self::fileClose();
            return $read;
        } catch (Exception $error) {
            trigger_error($error->getMessage(), E_USER_ERROR);
        }
        return false;
    }

    /**
     * dosya yazar
     *
     * @param string $text
     * @param string $parameter
     * @return boolean
     */
    public function write($text, $parameter='w') {
        try {
            self::fileOpen($parameter, false);
            if (!@fwrite($this->fileObject, $text))
                throw new Exception("Dosya yazamadım", 1);
            return true;
        } catch (Exception $error) {
            trigger_error($error->getMessage(), E_USER_ERROR);
        }
        return false;
    }

    /**
     * exec için return döndürür
     *
     * @param integer $int
     * @return unknown
     */
    private static function getExecReturn($int) {
        if ($int == 0)
            return true;
        else
            return false;
    }

    /**
     * yeni klasör olusturur
     *
     * @param string $pathName
     * @param boolean $exec
     * @return boolean
     */
    public static function createDirectory($pathName, $exec=false) {
        if ($exec) {
            exec("mkdir $pathName", $arr, $int);
            return self::getExecReturn($int);
        } else {
            return mkdir($pathName, 755);
        }
    }

    /**
     * dizin veya dosya siler
     *
     * @param rstring $pathName
     * @param boolean $exec
     * @return boolean
     */
    public static function remove($pathName, $exec=false) {
        if ($exec) {
            exec("rm -rf $pathName", $outArr, $int);
            return self::getExecReturn($int);
        } else {
            if (is_file($pathName))
                return unlink($pathName);
            else
                return rmdir($pathName);
        }
    }

    /**
     * dosya kopyalar
     *
     * @param string $sourceFile
     * @param string $copyFile
     * @return boolean
     */
    public static function copy($sourceFile, $copyFile, $exec=false) {
        if ($exec) {
            exec("cp $sourceFile $copyFile", $outArr, $int);
            return self::getExecReturn($int);
        } else {
            return copy($sourceFile, $copyFile);
        }
    }

    /**
     * dosya adını degistirir
     *
     * @param string $sourceFile
     * @param string $copyFile
     * @return boolean
     */
    public static function rename($sourceFile, $renameFile, $exec=false) {
        if ($exec) {
            exec("mv $sourceFile $renameFile", $outArr, $int);
            return self::getExecReturn($int);
        } else {
            return rename($sourceFile, $renameFile);
        }
    }

    /**
     * dosya upload edilirken kullanılan metod
     *
     * @param string $sourceFile
     * @param string $copyFile
     * @return boolan
     */
    public static function upload($sourceFile, $copyFile) {
        return move_uploaded_file($sourceFile, $copyFile);
    }

}

?>