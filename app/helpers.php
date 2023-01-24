<?php

function file_get_contents_ssl($url)
{
    $arrContextOptions = [
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ],
    ];

    try {
        $result = file_get_contents($url, false, stream_context_create($arrContextOptions));
    } catch (ErrorException $exception) {
        $result = null;
    }

    return $result;
}
