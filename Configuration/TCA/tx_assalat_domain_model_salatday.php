<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:assalat/Resources/Private/Language/locallang_db.xlf:tx_assalat_domain_model_salatday',
        'label' => 'date',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'enablecolumns' => [
        ],
        'searchFields' => 'date,dawn,sunrise,noon,afternoon,sunset,dusk',
        'iconfile' => 'EXT:assalat/Resources/Public/Icons/tx_assalat_domain_model_salatday.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, date, dawn, sunrise, noon, afternoon, sunset, dusk',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, date, dawn, sunrise, noon, afternoon, sunset, dusk'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_assalat_domain_model_salatday',
                'foreign_table_where' => 'AND tx_assalat_domain_model_salatday.pid=###CURRENT_PID### AND tx_assalat_domain_model_salatday.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],

        'date' => [
            'exclude' => false,
            'label' => 'LLL:EXT:assalat/Resources/Private/Language/locallang_db.xlf:tx_assalat_domain_model_salatday.date',
            'config' => [
                'dbType' => 'date',
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 7,
                'eval' => 'date',
                'default' => null,
            ],
        ],
        'dawn' => [
            'exclude' => false,
            'label' => 'LLL:EXT:assalat/Resources/Private/Language/locallang_db.xlf:tx_assalat_domain_model_salatday.dawn',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 4,
                'eval' => 'time',
                'default' => time()
            ]
        ],
        'sunrise' => [
            'exclude' => false,
            'label' => 'LLL:EXT:assalat/Resources/Private/Language/locallang_db.xlf:tx_assalat_domain_model_salatday.sunrise',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 4,
                'eval' => 'time',
                'default' => time()
            ]
        ],
        'noon' => [
            'exclude' => false,
            'label' => 'LLL:EXT:assalat/Resources/Private/Language/locallang_db.xlf:tx_assalat_domain_model_salatday.noon',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 4,
                'eval' => 'time',
                'default' => time()
            ]
        ],
        'afternoon' => [
            'exclude' => false,
            'label' => 'LLL:EXT:assalat/Resources/Private/Language/locallang_db.xlf:tx_assalat_domain_model_salatday.afternoon',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 4,
                'eval' => 'time',
                'default' => time()
            ]
        ],
        'sunset' => [
            'exclude' => false,
            'label' => 'LLL:EXT:assalat/Resources/Private/Language/locallang_db.xlf:tx_assalat_domain_model_salatday.sunset',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 4,
                'eval' => 'time',
                'default' => time()
            ]
        ],
        'dusk' => [
            'exclude' => false,
            'label' => 'LLL:EXT:assalat/Resources/Private/Language/locallang_db.xlf:tx_assalat_domain_model_salatday.dusk',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 4,
                'eval' => 'time',
                'default' => time()
            ]
        ],
        'city' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
