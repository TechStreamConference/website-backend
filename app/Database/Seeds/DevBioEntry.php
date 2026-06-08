<?php

namespace App\Database\Seeds;


function get_sort_bio(int $entry_count = 3): string
{
    $entry = array(
        'Entwickler',
        'Streamer',
        'Fechdachs',
        'Code-Magier',
        'Bug-Jäger',
        'Kaffeegetriebener Programmierer',
        'Pixel-Schubser',
        'Open-Source-Enthusiast',
        'Tastaturakrobat',
        'Stack-Overflow-Archäologe',
        'Semikolon-Sammler',
        'Debugging-Detektiv',
        'Commit-Künstler',
        'API-Flüsterer',
        'Docker-Kapitän',
        'Full-Stack-Abenteurer',
        'Backend-Bastler',
        'Frontend-Fummeler',
        'Linux-Nerd',
        'Git-Zauberer',
        'Datenbank-Dompteur',
        'Kabelverhedderer',
        'Nachtaktiver Coder',
        'Feature-Fabrikant',
        '404-Entdecker',
        'Regex-Beschwörer',
        'Syntax-Akrobat',
        'Bit-Schubser',
        'Byte-Verbieger',
        'Koffeinbetriebene Lebensform',
        'Professioneller Tab-vs-Space-Diskutierer',
        'Bug-Produzent',
        'Meme-Ingenieur',
        'Chaos-Tester',
        'Ctrl+C Ctrl+V Spezialist',
        'Digitaler Bastler',
        'Server-Streichler',
        'Compiler-Bändiger',
        'Code-Ninja',
        'Latenz-Liebhaber',
        'Kaffee > Schlaf',
        'Works on my machine',
        'Segmentation Fault Survivor',
        'Rubber-Duck-Debugger',
        'Chief Bug Officer',
        'Merge-Conflict-Veteran',
        'Patchnotes-Leser',
        'Deploy-am-Freitag-Fan',
        '404 Personality Not Found',
        'Chief Executive Nerd',
        'Git Push --force Enjoyer',
        'AI-Flüsterer',
        'Keyboard-Warrior',
        'WLAN-Sucher',
        'Code, Kaffee, Chaos'
    );
    $entries = [];
    for($i = 0; $i < $entry_count; $i++){
        $index = array_rand($entry);
        $entries[] = $entry[$index];
    }

    return implode(', ', $entries);
}

function get_bio_text(int $word_count = 150): string
{
    $text = "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.";

    $words = preg_split('/\s+/', trim($text));
    $result = [];

    while (count($result) < $word_count) {
        $result = array_merge($result, $words);
    }

    $result = array_slice($result, 0, $word_count);

    return implode(' ', $result);
}