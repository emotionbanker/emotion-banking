<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MultipleSelectAsset extends AdminAsset
{
    public $js = [
		//'js/bootstrap.min.js',
		'js/app.js',
        'js/multiple-select-fix.js',
    ];
}