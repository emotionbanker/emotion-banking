<?php

namespace app\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\Settings;

class AdminMenu extends \yii\base\Widget {

	public function run()
	{
        $is_locked = Settings::getSetting('locked');

		$items = [
			[
				'title' => 'Fragen',
				'icon' => 'question-circle',
				'url' => 'question',
				'items' => [
					[
						'title' => 'Neue frage',
						'url' => 'question/create',
                        'options' => []
					],
					[
						'title' => 'Aus Datei einspielen',
						'url' => 'question/import',
                        'options' => []
					],
					[
						'title' => 'Liste',
						'url' => 'question/index',
                        'options' => []
					],
				]
			],
			[
				'title' => 'Banken',
				'icon' => 'money',
				'url' => 'bank',
				'items' => [
					[
						'title' => 'Neue bank',
						'url' => 'bank/create',
                        'options' => []
					],
					[
						'title' => 'Liste',
						'url' => 'bank/index',
                        'options' => []
					],
					[
						'title' => 'Bankenstatistik',
						'url' => 'bank/statistic-list',
                        'options' => []
					],
					[
						'title' => 'Platzhalter',
						'url' => 'bank/placeholders',
                        'options' => []
					],
					[
						'title' => 'Aus Datei einspielen',
						'url' => 'bank/import',
                        'options' => []
					],
				]
			],
			[
				'title' => 'Benutzergruppen',
				'icon' => 'users',
				'url' => 'group',
				'items' => [
					[
						'title' => 'Neue Gruppe',
						'url' => 'group/create',
                        'options' => []
					],
					[
						'title' => 'Liste',
						'url' => 'group/index',
                        'options' => []
					],
				]
			],

			[
				'title' => 'Fragebögen',
				'icon' => 'terminal',
				'url' => 'form',
				'items' => [
					[
						'title' => 'Neue Fragebögen',
						'url' => 'form/create',
                        'options' => []
					],
					[
						'title' => 'Liste',
						'url' => 'form/index',
                        'options' => []
					],
				]
			],
			[
				'title' => 'Zugangscodes',
				'icon' => 'barcode',
				'url' => 'code',
				'items' => [
					[
						'title' => 'Neue Codes erzeugen',
						'url' => 'code/create',
                        'options' => []
					],
				]
			],
			[
				'title' => 'Individualisierung',
				'icon' => 'paint-brush',
				'url' => 'user-text',
				'items' => [
					[
						'title' => 'Texte',
						'url' => 'texts/index',
                        'options' => []
					],
					[
						'title' => 'Styles',
						'url' => 'styles/index',
                        'options' => []
					],
					[
						'title' => 'Begrüßungstexte',
						'url' => 'user-text/index/start',
                        'options' => []
					],
					[
						'title' => 'Schlusstexte',
						'url' => 'user-text/index/end',
                        'options' => []
					],
				]
			],


			[
				'title' => 'Sprachen',
				'icon' => 'language',
				'url' => 'language',
				'items' => [
					[
						'title' => 'Neue Sprache',
						'url' => 'language/create',
                        'options' => []
					],
					[
						'title' => 'Liste',
						'url' => 'language/index',
                        'options' => []
					],
					[
						'title' => 'Aus Datei einspielen',
						'url' => 'language/import',
                        'options' => []
					],
                    [
                        'title' => 'Übersetzungen',
                        'url' => 'translation/index',
                        'options' => []
                    ],
				]
			],
			[
				'title' => 'System',
				'icon' => 'cogs',
				'url' => 'system',
				'items' => [
					[
						'title' => 'Statistik',
						'url' => 'system/statistic',
                        'options' => []
					],
					/*[
						'title' => 'Backup',
						'url' => 'system/index',
					    'options' => []
					],
					[
						'title' => 'Backup einspielen',
						'url' => 'system/index',
					'options' => []
					],*/
					[
						'title' => 'Sperren',
                        'icon' => 'lock',
						'url' => 'system/lock',
                        'options' => [
                            'data-confirm' => $is_locked == 0 ? 'Das System wird gesperrt. Nachdem sie OK geklickt haben, kann nur mehr der Superdamin die Sperre aufheben.' : 'Diese Aktion hebt die Sperre auf. Wollen sie dies?',
                        ],
					],
					[
						'title' => 'Reset',
						'url' => 'system/reset',
                        'options' => [
                            'data-confirm' => 'Alle Produktionsdaten werden gelöscht. Bitte stellen sie sicher, dass sie ein Backup haben. Wollen sie alles löschen?',
                        ],
					],
					[
						'title' => 'Ergebnisse löschen',
						'url' => 'system/clean',
                        'options' => [
                            'data-confirm' => 'Alle Statistiken werden gelöscht. Wollen sie dies?'
                        ]
					],
				]
			],

		];

        if($is_locked == 1)
        {
            $items[7]['items'][1]['title'] = 'Öffnen';
        }

		echo $this->render('adminmenu', ['items' => $items]);
	}

}