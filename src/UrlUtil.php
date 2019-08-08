<?php
namespace programming_cat\util;

use Exception;

class UrlUtil
{
	/**
	 * リファラ文字列と相対パスから完全URLを構築します。
	 * Build Full url from referer and related path strings.
	 * @param string $url related path.
	 * @param string $referer HTTP_REFERER or url like "http(s)?://..."
	 */
	public static function buildFromRelatedUrl($url, $referer) {
		// URLが絶対パスならそのまま返して問題ない
		if (preg_match('@http(s)?://@i', $url)) {
			return $url;
		}
		// そうじゃないのに refererが絶対パスじゃなければエラーにする
		if (!preg_match('@http(s)?://@i', $referer)) {
			throw new Exception("Invalid referer string. $referer");
		}

		$referer = strtolower($referer);
		$url = strtolower($url);
		$parsed = parse_url($referer);

		$built = [];
		$built[] = $parsed['scheme'] . ':/';  // "/"で結合するから一個少なめに。
		$built[] = $parsed['host'];
		// フルパスの場合
		if (substr($url, 0,1) == '/') {
			$paths = explode('/', $url);
			foreach ($paths as $path) {
				$path = trim($path);
				if (empty($path)) continue;
				$built[] = $path;
			}
		}
		// 相対パスの場合
		else {
			$path = $parsed['path'];
			$built[] = dirname($parsed['path']);
			$built[] = $url;
		}
		return implode('/', $built);
	}

}
