<?php

if (! function_exists('numeroOS')) {
    function numeroOS($os, int $padding = 4): string
    {
        if (is_object($os)) {
            $idOs = (int) ($os->idOs ?? 0);
        } elseif (is_array($os)) {
            $idOs = (int) ($os['idOs'] ?? 0);
        } else {
            $idOs = (int) $os;
        }

        if ($idOs <= 0) {
            return '';
        }

        return $idOs >= 10000 ? (string) $idOs : str_pad((string) $idOs, $padding, '0', STR_PAD_LEFT);
    }
}