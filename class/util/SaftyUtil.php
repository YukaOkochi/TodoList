<?php
class SaftyUtil {
    public static function sanitize(array $post): array {
        foreach ($post as $k => $v) {
            $post[$k] = htmlspecialchars($v);
        }
        return $post;
    }

    public static function generateToken(string $tokenName = 'token'): string {
        $token = bin2hex(openssl_random_pseudo_bytes(Config::RANDOM_PSEUDO_STRING_LENGTH));
        $_SESSION[$tokenName] = $token;
        return $token;
    }

    public static function isValidToken(string $token, string $tokenName = 'token') : bool {
        if (!isset($_SESSION[$tokenName]) || $_SESSION[$tokenName] !== $token) {
            return false;
        }
        return true;
    }
}
?>