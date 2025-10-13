<?php

namespace App\Helpers;

use Config;
use Illuminate\Support\Str;
use DB;
use Auth;
use Mail;
use Log;
use Exception;
use DateTime;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Razorpay\Api\Api;

class Helpers
{
    public static function generateCode($prefix,$id,$digit)
    {
        $code = $prefix . str_pad($id, $digit, '0', STR_PAD_LEFT);
        return $code;
    }

    public static function convertNumberToWords($num)
    {
        $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $words = $formatter->format($num);

        $cents = round(($num - floor($num)) * 100);
        if ($cents > 0)
        {
            $centsWords = $formatter->format($cents);
            $words .= " and {$centsWords} Cents Only";
        }

        else
        {
            $words .= " Dollars Only";
        }

        return $words;
    }

    public static function maskCardNumber($cardNumber)
    {
        $cleaned = preg_replace('/\D/', '', $cardNumber);

        $lastFour = substr($cleaned, -4);

        $masked = str_repeat('X', strlen($cleaned) - 4) . $lastFour;

        return trim(chunk_split($masked, 4, ' '));
    }


    public static function numberToWords($number) {
        $words = array(
            0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen',
            18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty',
            50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
        );

        $suffixes = array('', 'thousand', 'million', 'billion');
        $numberLength = strlen($number);
        $output = '';

        if ($number == 0) {
            return 'zero';
        }

        $i = 0;
        while ($number > 0) {
            $chunk = $number % 1000;
            if ($chunk) {
                $wordChunk = '';
                if ($chunk > 99) {
                    $wordChunk .= $words[(int)($chunk / 100)] . ' hundred ';
                    $chunk %= 100;
                }
                if ($chunk > 20) {
                    $wordChunk .= $words[10 * floor($chunk / 10)] . ' ';
                    $chunk %= 10;
                }
                $wordChunk .= $words[$chunk];
                $output = $wordChunk . ' ' . $suffixes[$i] . ' ' . $output;
            }
            $number = (int)($number / 1000);
            $i++;
        }

        return trim($output);

    }

    public static function truncateString($string, $length = 50)
    {
        return (strlen($string) > $length) ? substr($string, 0, $length) . '..' : $string;
    }

    public static function getUserIP()
    {
        $ip = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($ipList[0]);
        }
        else
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    public static function formatCurrency($amount)
    {
        if ($amount >= 10000000) {
            return  round($amount / 10000000, 2) . ' Cr';
        } elseif ($amount >= 100000) {
            return round($amount / 100000, 2) . ' L';
        } elseif ($amount >= 1000) {
            return round($amount / 1000, 2) . ' K';
        } else {
            return number_format($amount);
        }
    }

    public static function getPlanExpiryDate($planType)
    {
        $activeDate = date('Y-m-d',strtotime('now'));

        $date = DateTime::createFromFormat('Y-m-d', $activeDate);

        if($planType == 1)
        {
            $date->modify('+1 month');
        }
        else
        {
            $date->modify('+1 year');
        }

        return $date->format('Y-m-d');

    }

}
