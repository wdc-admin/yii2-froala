<?php

namespace yii2gurtam\froala;

use yii\web\AssetBundle;

class FroalaAsset extends AssetBundle
{
    public $css = [
        'css/froala.less'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        parent::init();
    }
    /**
     * Sets the source path if empty
     * @param string $path the path to be set
     */
    protected function setSourcePath($path)
    {
        if (empty($this->sourcePath)) {
            $this->sourcePath = $path;
        }
    }


}