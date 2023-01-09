<?php
/**
 * Дополнение для WordPress
 * этот файл подключается отдельно в functions.php
 */

if (defined('ABSPATH')) {
	if (file_exists(ABSPATH . '/wp-admin/includes/image.php')) {

		require_once ABSPATH . '/wp-admin/includes/image.php';

		/**
		 * Если задать одну сторону то будет производиться пропорциональная обрезка
		 * если не указать размер то вернётся оригинальная картинка
		 *
		 * @param $attachId
		 * @param null|int $width
		 * @param null|int $height
		 * @return bool|string
		 */
		function cropImgByAttachId($attachId, $width = null, $height = null)
		{
			$url = wp_get_attachment_url($attachId);

			return cropImg($url, $width, $height);
		}

		/**
		 * Если задать одну сторону то будет производиться пропорциональная обрезка
		 * если не указать размер то вернётся оригинальная картинка
		 *
		 * @param $postId
		 * @param null|int $width
		 * @param null|int $height
		 * @return bool|string
		 */
		function cropImgByPostId($postId, $width = null, $height = null)
		{
			$url = get_the_post_thumbnail_url($postId);

			return cropImg($url, $width, $height);
		}


		/**
		 * Если задать одну сторону то будет производиться пропорциональная обрезка
		 * если не указать размер то вернётся оригинальная картинка
		 *
		 * @param $imgUrl
		 * @param null|int $width
		 * @param null|int $height
		 * @return bool|string
		 */
		function cropImg($imgUrl, $width = null, $height = null)
		{
			if (empty($imgUrl)) {
				return false;
			}
			$width = (int)$width;
			$height = (int)$height;


			$ABSPATH = rtrim(ABSPATH, '/');


			if ($width === $height and $height === 0) {
				return $imgUrl;
			}

			$pathOriginalImage = $ABSPATH . substr($imgUrl, strpos($imgUrl, $_SERVER['HTTP_HOST']) + strlen($_SERVER['HTTP_HOST']));

			if ($width === 0 or $height === 0) {
				$size = getimagesize($pathOriginalImage);

				if ($height === 0) {
					$zoom = $width / $size[0];
					$width = (int)($size[0] * $zoom);
					$height = (int)($size[1] * $zoom);
				} elseif ($width === 0) {
					$zoom = $height / $size[1];
					$width = (int)($size[0] * $zoom);
					$height = (int)($size[1] * $zoom);
				}
			}

			$newImagePath = dirname($pathOriginalImage) . '/' . $width . 'x' . $height . '-' . trim(str_replace(dirname($pathOriginalImage), '', $pathOriginalImage), '/');
			if (!file_exists($newImagePath)) {

				$sizeOriginalImage = getimagesize($pathOriginalImage);
				$startX = 0;
				$startY = 0;
				$path = wp_crop_image($pathOriginalImage, $startX, $startY, $sizeOriginalImage[0], $sizeOriginalImage[1], $width, $height, true, $newImagePath);
			} else {
				$path = $newImagePath;
			}
			return substr($path, strlen($ABSPATH));
		}
	}
}