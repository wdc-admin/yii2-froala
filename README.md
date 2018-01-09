**YII2 widget for froala plugin** 
(extended https://github.com/froala/yii2-froala-editor/)
====================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist gurtam/yii2froala "*"
```

or add

```
"gurtam/yii2froala": "*"
```

to the require section of your `composer.json` file.

After need add to depends in global assets
'gurtam\yii2froala\FroalaAsset'

**Example**

```
<?= $form->field($model, 'text')
        ->widget(\gurtam\yii2Froala\FroalaWidget::class, [
            'csrfDefault' => true,
            'csrfDefaultParam' => '_csrf', //default
            'template' => 'comment',
            'enableToolbarButtons' => [
                'insertImage',
                'emoticons'
            ],
            'clientOptions' => [
                'imageUploadURL' => \yii\helpers\Url::to(['/user-event/upload-images']),
                'fileUploadURL' => \yii\helpers\Url::to(['/user-event/upload-file']),
            ],
            'eventsDefault' => true,
        ])->label(false); ?>
```

**Froala config params**

```
 'froalaConfig' => [
        'clientOptions' => [
            'key' =>  'YOUR_KEY',
            'imageUploadParam' => 'file',
            'fileUploadParam' => 'file',
            'toolbarInline' => false,
            'toolbarButtons' => [
                'fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|',
                'fontFamily', 'fontSize', 'color', 'paragraphFormat', 'align',
                'formatOL', 'formatUL', 'outdent', 'indent', 'quote',
                'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable',
                'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', 'help',
                'html', 'undo', 'redo'
            ],
            'videoInsertButtons' => ['videoBack', '|', 'videoByURL', 'videoEmbed'],
            'imageInsertButtons' => ['imageBack', '|', 'imageUpload', 'imageByURL'],
            'heightMin' => 250,
            'heightMax' => 500,
            'tableStyles' => [
                'fr-table-settings' => 'default'
            ]
        ]
    ],

    'froalaTemplates' => [
        'simple' => [
            'toolbarButtons' => [
                'fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'align',
                'formatOL', 'formatUL','outdent', 'indent', 'insertLink', 'insertTable', 'undo', 'redo'
            ]
        ],
        'comment' => [
            'toolbarButtons' => [
                'bold', 'italic', 'underline', 'strikeThrough', 'align', 'formatOL', 'formatUL', 'emoticons', '|',
                'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable',
            ],
        ]
    ]
```
Basic usage upload files:
------

Add path aliases and url to your file store in the main config
```php
return [
    'aliases' => [
        '@storagePath' => '/path/to/upload/dir',
        '@storageUrl' => '/url/to/upload/dir',
    ],
];
```

Add action to the main controller
```php
use gurtam\yii2Froala\actions\FroalaUploadAction;
 
class PageController extends Controller
{
    public function actions()
    {
        return [
            'upload' => [
                'class' => FroalaUploadAction::className(),
                'path' => Event::getUploadDir(), //path to uploads
                'url' => Event::getUploadUrl(), //url path for get files
                //'uploadOnlyImage' => false,
            ],
        ];
    }
    
    // ...
}
```


Need to add a param for FroalaEditorWidget
```php
<?= $form->field($model, 'comment')->widget(FroalaEditorWidget::class, [
    'clientOptions' => [
        //...
        'imageUploadURL' => \yii\helpers\Url::to(['froala-upload']),
        //..
    ]
])?>


```