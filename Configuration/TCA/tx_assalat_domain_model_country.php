<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:assalat/Resources/Private/Language/locallang_db.xlf:tx_assalat_domain_model_country',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'enablecolumns' => [
        ],
        'searchFields' => 'name,number,states',
        'iconfile' => 'EXT:assalat/Resources/Public/Icons/tx_assalat_domain_model_country.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, name, number, states',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, name, number, states'],
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
                'foreign_table' => 'tx_assalat_domain_model_country',
                'foreign_table_where' => 'AND tx_assalat_domain_model_country.pid=###CURRENT_PID### AND tx_assalat_domain_model_country.sys_language_uid IN (-1,0)',
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

        'name' => [
            'exclude' => false,
            'label' => 'LLL:EXT:assalat/Resources/Private/Language/locallang_db.xlf:tx_assalat_domain_model_country.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'number' => [
            'exclude' => false,
            'label' => 'LLL:EXT:assalat/Resources/Private/Language/locallang_db.xlf:tx_assalat_domain_model_country.number',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int,required'
            ]
        ],
        'states' => [
            'exclude' => false,
            'label' => 'LLL:EXT:assalat/Resources/Private/Language/locallang_db.xlf:tx_assalat_domain_model_country.states',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_assalat_domain_model_state',
                'foreign_field' => 'country',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
    
    ],
];
