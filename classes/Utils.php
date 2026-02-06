<?php
class Utils {
    /**
     * Generate a unique serial ID for items.
     * Format: SR + 10-digit padded number based on current timestamp or random.
     * Ensures uniqueness by checking against database.
     */
    public static function generateSerialId($conn) {
        do {
            $timestamp = time();
            $random = mt_rand(1000, 9999);
            $serial = 'SR' . sprintf('%010d', $timestamp % 10000000000) . substr($random, 0, 2);
            $check = $conn->query("SELECT id FROM item_list WHERE serial_id = '{$serial}'");
        } while ($check->num_rows > 0);
        return $serial;
    }
}
?>
