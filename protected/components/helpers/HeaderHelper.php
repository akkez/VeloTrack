<?php

/**
 * Created by PhpStorm.
 * Date: 11.05.14
 * Time: 6:26
 */
class HeaderHelper
{
	public static function page($title)
	{
		return CHtml::tag('h1', array(), $title);
	}
}