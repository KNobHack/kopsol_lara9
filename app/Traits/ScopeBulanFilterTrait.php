<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

/**
 * Use for local scope filter bulan
 */
trait ScopeBulanFilterTrait
{
	public function scopeBulanFilter(Builder $query)
	{
		$request = request();
		$default = date('m');

		if (
			!$request->get('bulan') ||
			$request->get('bulan') < 1 ||
			$request->get('bulan') > 12
		) {
			return $query->whereMonth('created_at', $default);
		}

		return $query->whereMonth('created_at', $request->get('bulan'));
	}
}
