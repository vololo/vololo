<?php
/**
 * Vololo
 *
 * Copyright (c) 2010 Vololo Ltd. <info@vololo.ru>, http://vololo.ru
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 */

class Vololo_Form extends Zend_Form {
	function init() {
		$this->addPrefixPath(
			'Vololo_Form_',
			'Vololo/Form'
		);
	}

	function translateError($e, $v = null) {
		$d = array(
			'isEmpty' => 'обязательно для заполнения',
			'regexNotMatch' => 'недопустимые символы',
			'fileImageSizeWidthTooBig' => 'картинка слишком широкая',
			'fileImageSizeHeightTooBig' => 'картинка слишком высокая',
			'fileMimeTypeFalse' => 'неверный тип файла',
			'fileMimeTypeNotReadable' => 'невозможно определить тип файла',
			'fileUploadErrorIniSize' => 'размер файла слишком большой',
			'fileImageSizeNotReadable' => 'невозможно прочитать размер картинки',
			'fileImageSizeNotDetected' => 'невозможно определить размер картинки',
			'fileExtensionFalse' => 'Запрещено загружать файлы этого типа',
			'recordFound' => 'Дублирующееся значение',
			'emailAddressInvalidFormat' => 'неверный e-mail адрес',
			'stringLengthTooShort' => 'слишком коротко',
			'stringLengthTooLong' => 'слишком длинно',
			'badCaptcha' => 'неверный код с картинки'
		);
		return is_numeric($e) ? $v : (isset($d[$e]) ? $d[$e] : $e);
	}

	function translateErrors($e) {
		if ($e) foreach ($e as &$el) $el = self::translateError($el);
		return $e;
	}

	public function getMessages($name = null, $suppressArrayNotation = false) {
    	$e = parent::getMessages($name, $suppressArrayNotation);
		if ($e) {
			foreach ($e as &$el) {
				if ($el) {
					foreach ($el as $k => &$el_1) $el_1 = $this->translateError($k, $el_1);
				}
			}
		}
		return $e;
    }

	function getErrors() {
		$e = parent::getErrors();
		if ($e) {
			foreach ($e as &$el) {
				if ($el) {
					foreach ($el as &$el_1) $el_1 = $this->translateError($el_1);
				}
			}
		}
		return $e;
	}
}
