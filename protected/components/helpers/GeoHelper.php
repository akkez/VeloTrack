<?php

/**
 * Created by PhpStorm.
 * Date: 10.05.14
 * Time: 0:27
 */
class GeoHelper
{
	public static function getLengthOfPath($path)
	{
		$points   = json_decode($path);
		$distance = 0;
		for ($i = 1; $i < count($points); $i++)
		{
			$distance += GeoHelper::distanceBetweenTwoPoints2($points[$i][0], $points[$i][1], $points[$i - 1][0], $points[$i - 1][1]);
		}

		return $distance;
	}

	public static function distanceBetweenTwoPoints2($lat1, $lon1, $lat2, $lon2, $unit = "K")
	{
		$theta = $lon1 - $lon2;
		$dist  = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist  = acos($dist);
		$dist  = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit  = strtoupper($unit);

		if ($unit == "K")
		{
			return ($miles * 1.609344);
		}
		else if ($unit == "N")
		{
			return ($miles * 0.8684);
		}
		else
		{
			return $miles;
		}
	}

	public static function distanceBetweenTwoPoints($lat1, $lng1, $lat2, $lng2)
	{
		$pi80 = M_PI / 180;
		$lat1 *= $pi80;
		$lng1 *= $pi80;
		$lat2 *= $pi80;
		$lng2 *= $pi80;

		$r    = 6372.797; // mean radius of Earth in km
		$dlat = $lat2 - $lat1;
		$dlng = $lng2 - $lng1;
		$a    = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
		$c    = 2 * atan2(sqrt($a), sqrt(1 - $a));
		$km   = $r * $c;

		return $km;
	}

	public static function encodePointsAltitude($path)
	{
		$points = json_decode($path);

		return str_repeat("A", count($points));
	}

	public static function encodePoints($path)
	{
		$points = json_decode($path);

		$prevLat = 0;
		$prevLng = 0;
		$dump    = "";
		for ($i = 0; $i < count($points); $i++)
		{
			$currentLat = (int)($points[$i][0] * 1000000);
			$currentLng = (int)($points[$i][1] * 1000000);
			//little-endian to big-endian LOL
			$chunk = sprintf("%032b", $currentLat - $prevLat, $currentLng - $prevLng);
			$dump .= substr($chunk, 24, 8) . substr($chunk, 16, 8) . substr($chunk, 8, 8) . substr($chunk, 0, 8);
			$chunk = sprintf("%032b", $currentLng - $prevLng);
			$dump .= substr($chunk, 24, 8) . substr($chunk, 16, 8) . substr($chunk, 8, 8) . substr($chunk, 0, 8);
			$prevLat = $currentLat;
			$prevLng = $currentLng;
		}
		$length    = strlen($dump) / 6;
		$base64str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_";
		$response  = "";
		for ($i = 0; $i < $length; $i++)
		{
			$response .= $base64str[bindec(substr($dump, $i * 6, 6))];
		}
		if (strlen($dump) % 6 == 2)
		{
			$response .= "=";
		}
		if (strlen($dump) % 6 == 4)
		{
			$response .= "==";
		}

		return $response;
	}

	public static function getTitleOfLength($data)
	{
		return round($data, 3) . " км";
	}
}