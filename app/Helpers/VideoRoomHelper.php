<?php

namespace App\Helpers;

class VideoRoomHelper
{
    public static function createVideoLink(
        string          $baseUrl,
        string          $roomId,
        string          $password,
        int             $eventId,
        int             $userId,
        string          $name,
        VideoLinkType   $linkType,
        VideoSourceType $sourceType,
    ): string
    {
        $data = [
            $linkType->value => VideoRoomHelper::createId($eventId, $userId, $sourceType->value),
            'room' => $roomId,
            'password' => $password,
            'label' => "{$name}_{$sourceType->value}",
        ];
        $queryString = http_build_query($data);
        if ($linkType == VideoLinkType::PUSH) {
            $queryString .= '&maxframerate=30&g=0&ssid';
        } else if ($linkType == VideoLinkType::VIEW) {
            $queryString .= '&solo';
        }
        return "{$baseUrl}?{$queryString}";
    }

    public static function randomString(int $length)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $randomString = '';

        for ($i = 0; $i < $length; ++$i) {
            $randomIndex = random_int(0, strlen($characters) - 1);
            $randomString .= $characters[$randomIndex];
        }

        return $randomString;
    }

    private static function createId(int $eventId, int $userId, string $type): string
    {
        return md5("{$eventId}-{$userId}-{$type}");
    }
}
