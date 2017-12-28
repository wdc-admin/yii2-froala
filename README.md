**YII2 widget for froala plugin** 
(extended https://github.com/froala/yii2-froala-editor/)
====================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yii2gurtam/froala "*"
```

or add

```
"yii2gurtam/froala": "*"
```

to the require section of your `composer.json` file.

After need add to depends in global assets
'yii2gurtam\froala\FroalaAsset'

**Example**

```
<?= $form->field($model, 'text')
        ->widget(\yii2gurtam\froala\FroalaWidget::class, [
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
