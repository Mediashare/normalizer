<?php

namespace Kzu\Normalizer;

use Kzu\Normalizer\Text;
use Symfony\Component\Yaml\Yaml as Yml;
use Symfony\Component\Yaml\Exception\ParseException;

Trait Yaml {
    static public $errors = [];

    /**
     * Convert Array to Yaml
     */
    static public function dump(?array $content): ?string {
        return Yml::dump($content ?? [], 4, 4, Yml::DUMP_OBJECT_AS_MAP || Yml::PARSE_DATETIME) ?? null;
    }

    /**
     * Convert Yaml content to Array
     */
    static public function parse(string $yaml): ?array {
        try {
            return (array) Yml::parse(Text::tabToSpace($yaml), Yml::DUMP_OBJECT_AS_MAP || Yml::PARSE_DATETIME);
        } catch (ParseException $exception) {
            Yaml::$errors[] = 'Unable to parse the YAML string: '. $exception->getMessage();
        }
        return null;
    }
    
    /**
     * Convert Yaml file to Array
     */
    static public function parseFile(string $file): ?array {
        
        return Yaml::parse(file_get_contents($file));
    }
}