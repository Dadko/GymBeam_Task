<?php

class CSVLoader {
    private $filename;

    public function __construct($filename) {
        $this->filename = $filename;
    }

    public function load() {
        $rows = [];
        if (($handle = fopen($this->filename, "r")) !== FALSE) {
            $isFirstRow = true;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($isFirstRow) {
                    $isFirstRow = false;
                    continue;
                }
                $rows[] = $data;
            }
            fclose($handle);
        }
        return $rows;
    }
}
