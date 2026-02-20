<?php

class Logger {
    private static $logDir = __DIR__ . "/../../logs";
    
    public static function log($action, $details = []) {
        $timestamp = date("Y-m-d H:i:s");
        $ip = $_SERVER["REMOTE_ADDR"] ?? "CLI";
        $userId = $_SESSION["userId"] ?? "guest";
        $username = $_SESSION["username"] ?? "-";
        
        $detailsStr = "";
        if (!empty($details)) {
            $detailsStr = " | " . json_encode($details, JSON_UNESCAPED_UNICODE);
        }
        
        $logEntry = sprintf(
            "[%s] | %s | %s | %s | %s%s\n",
            $timestamp,
            $ip,
            $userId,
            $username,
            $action,
            $detailsStr
        );
        
        $date = date("Y-m-d");
        $logFile = self::$logDir . "/" . $date . ".log";
        
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
    
    public static function getLogs($days = 7) {
        $logs = [];
        for ($i = 0; $i < $days; $i++) {
            $date = date("Y-m-d", strtotime("-$i days"));
            $logFile = self::$logDir . "/" . $date . ".log";
            if (file_exists($logFile)) {
                $logs[$date] = file($logFile);
            }
        }
        return $logs;
    }
}
