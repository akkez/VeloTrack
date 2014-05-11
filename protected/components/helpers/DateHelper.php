<?php

/**
 * Created by PhpStorm.
 * Date: 11.05.14
 * Time: 18:32
 */
class DateHelper
{
	public static function getDateRepresentation($date, $interval)
	{
		if (is_integer($date))
		{
			$timestamp = $date;
		}
		else
		{
			$timestamp = strtotime($date);
		}

		if ($interval == 'day')
		{
			return date('d-m-y', $timestamp);
		}
		if ($interval == 'week')
		{
			$time = $timestamp;
			$week = date("W", $time);
			while (date("W", $time) == $week)
			{
				$time -= 86400; //one day
			}

			return date('d-m-y', $time);
		}

		return date("m-Y", $timestamp);
	}
}