<?php
namespace App\Helpers;

class ResponseHelper
{
    public static function handle($code, $message = ''): array
    {
        return match ($code) {
            10 => self::formatResponse(10, 'fail', [$message => 'The ' . $message . ' has already been taken.']),
            11 => self::formatResponse(11, 'fail', 'No content available.'),
            12 => self::formatResponse(12, 'fail', 'Not found this ID in database.'),
            13 => self::formatResponse(13, 'fail', [$message => 'Not found ' . $message . ' in database.']),
            14 => self::formatResponse(14, 'fail', 'Username or password is not valid.'),
            19 => self::formatResponse(15, 'fail', 'The password must be the same as the Confirm password.'),
            16 => self::formatResponse(16, 'successful', $message),
            17 => self::formatResponse(17, 'successful', $message),
            18 => self::formatResponse(18, 'successful', $message),
            27 => self::formatResponse(19, 'fail', ''),
            default => self::formatResponse(0, 'fail', 'Unknown error occurred.'),
        };
    }

    private static function formatResponse($statusId, $status, $message): array
    {
        return [
            'status_id' => $statusId,
            'status' => $status,
            'message' => $message,
        ];
    }
}
