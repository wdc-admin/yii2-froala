<?php

namespace gurtam\yii2Froala;

use Yii;
use yii\log\EmailTarget;
use \yii\web\JsExpression;

class FroalaWidget extends \froala\froalaeditor\FroalaEditorWidget
{
    /** Name of inline JavaScript package that is registered by the widget */
    const INLINE_JS_KEY = 'froala';

    /**
     * Events array. Array keys are the events name, and array values are the events callbacks.
     * Example:
     * ```php
     * [
     *     'froalaEditor.image.error' => 'function (e, editor, error, response) { console.log(error.message)); }',
     *     'froalaEditor.image.error' => new JsExpression('function (e, editor, error, response) { console.log(error.message)); }'),
     *     'froalaEditor.image.error' => [
     *         'function (e, editor, error) { console.log(error.message); }',
     *         'function (e, editor, error) { console.log(error.code); }'
     *     ]
     * ]
     * ```
     * @var array Plugin events
     */
    public $events = [];

    public $defaultEvents = [];

    public $disableToolbarButtons = [];

    public $enableToolbarButtons = [];

    public $template;

    public $csrfDefault = false;

    public $csrfDefaultParam = '_csrf';

    public $eventsDefault = false;

    protected $templates;

    public function __construct(array $config = [])
    {
        $config = array_merge_recursive($this->getDefaultConfig(), $config);

        parent::__construct($config);
    }

    public function init()
    {
        $this->settingCsrfToken();
        $this->getDefaultTemplates();
        $this->setTemplate();

        parent::init();
    }

    private function getDefaultConfig()
    {
        if(!empty(Yii::$app->params['froalaConfig']) && is_array(Yii::$app->params['froalaConfig'])) {
            return Yii::$app->params['froalaConfig'];
        }

        return [];
    }

    private function getDefaultTemplates()
    {
        if(!empty(Yii::$app->params['froalaTemplates'])) {
            $this->templates = Yii::$app->params['froalaTemplates'];
        }
    }

    private function setTemplate()
    {
        if(!empty($this->template) && !empty($this->templates[$this->template])) {
            $this->clientOptions = array_merge($this->clientOptions, $this->templates[$this->template]);
        }

        $this->disableToolbarButtonsConfig();
        $this->enableToolbarButtonsConfig();
    }

    private function disableToolbarButtonsConfig()
    {
        if(!empty($this->disableToolbarButtons)) {
            foreach ($this->disableToolbarButtons as $button) {
                unset($this->clientOptions['toolbarButtons'][$button]);
            }
        }
    }

    private function enableToolbarButtonsConfig()
    {
        if(!empty($this->enableToolbarButtons)) {
            foreach ($this->enableToolbarButtons as $button) {
                $this->clientOptions['toolbarButtons'][] = $button;
            }
        }
    }

    private function settingCsrfToken()
    {
        $this->setDefaultCsrfToken();
        $this->addCsrfToken();
    }

    private function setDefaultCsrfToken()
    {
        if(!empty($this->csrfDefault)) {
            $this->csrfCookieParam = Yii::$app->getRequest()->getCsrfToken();
        }
    }


    private function addCsrfToken()
    {
        if (!empty($this->csrfCookieParam)) {
            $this->addTokenToClientOptions('imageUploadParams');
            $this->addTokenToClientOptions('fileUploadParams');
        }
    }

    private function addTokenToClientOptions($option)
    {
        if(empty($this->clientOptions[$option])) {
            $this->clientOptions[$option] = [];
        }

        $this->clientOptions[$option][$this->csrfDefaultParam] = $this->csrfCookieParam;
    }

    public function registerClientScript()
    {
        parent::registerClientScript();

        $this->registerEvents();
    }

    /**
     * Register plugin' events.
     */
    protected function registerEvents()
    {
        $view = $this->getView();
        $selector = '#' . $this->options['id'];

        $events = array_merge($this->events, $this->getDefaultEvents());

        if (!empty($events)) {
            $js = [];
            foreach ($events as $event => $callback) {
                if (is_array($callback)) {
                    foreach ($callback as $function) {
                        if (!$function instanceof JsExpression) {
                            $function = new JsExpression($function);
                        }
                        $js[] = "jQuery('$selector').on('$event', $function);";
                    }
                } else {
                    if (!$callback instanceof JsExpression) {
                        $callback = new JsExpression($callback);
                    }
                    $js[] = "jQuery('$selector').on('$event', $callback);";
                }
            }
            if (!empty($js)) {
                $js = implode("\n", $js);
                $view->registerJs($js, $view::POS_READY, self::INLINE_JS_KEY . 'events/' . $this->options['id']);
            }
        }
    }

    protected function getDefaultEvents()
    {
        $events = [];

        if(!empty($this->eventsDefault)) {
            $events = $this->getEvents();
        } else if(!empty($this->defaultEvents) && is_array($this->defaultEvents)) {
            $events = array_intersect_key($this->getEvents(), array_flip($this->defaultEvents));
        }

        return $events;
    }

    protected function getEvents()
    {
        return [
            'froalaEditor.image.error' => new JsExpression('function (e, editor, error, response) {
                if(response) {
                    var response = JSON.parse(response)
                     alert(response.error); 
                     return false;
                }
            }'),
            'froalaEditor.file.error' => new JsExpression('function (e, editor, error, response) {
                if(response) {
                    var response = JSON.parse(response)
                     alert(response.error); 
                     return false;
                }
            }')
        ];
    }
}