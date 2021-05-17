<?php

namespace Kzu\Normalizer;

Trait Text {
    static public function slugify(string $text): ?string {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return $text ?? null;
    }
    
    static public function tabToSpace(string $content, ?int $tab = 4, ?bool $nbsp = false): ?string {
        $lines = "";
        foreach (explode(PHP_EOL, $content) as $line):
            while (($t = mb_strpos($line,"\t")) !== FALSE):
                $preTab = $t?mb_substr($line, 0, $t):'';
                $line = $preTab . str_repeat($nbsp?chr(7):' ', $tab-(mb_strlen($preTab)%$tab)) . mb_substr($line, $t+1);
            endwhile;
            $lines .= $nbsp?str_replace($nbsp?chr(7):' ', '&nbsp;', $line):$line . "\n";
        endforeach;
        return $lines ?? null;
    }
}