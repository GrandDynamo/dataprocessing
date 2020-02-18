<?php

namespace classes\fileManager\readers;

class ReadSettings implements Readable
{
    private string $contents;

    public function __construct()
    {
    }

    /**
     * Reads the contents of a file and stores it as a string.
     *
     * @param string $filePath The path to the location of the settingsfile.
     * @return void
     */
    public function readFile(string $filePath): void
    {
        $handle = $handle = fopen($filePath, "r");
        $this->contents = fread($handle, filesize($filePath));
        fclose($handle);
    }

    /**
     * Returns settings from specified category.
     *
     * @param string $settingCategory The category where certain settings fall under.
     * @return array Settings Contains settings.
     */
    public function getSettingsInCategory(string $settingCategory): array
    {
        $specificSettings = json_decode($this->contents, true);
        return $specificSettings[0][$settingCategory];
    }
}
