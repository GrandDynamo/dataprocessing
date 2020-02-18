<?php

namespace classes\fileManager\readers;

interface Readable
{
    public function readFile(string $path): void;
}
