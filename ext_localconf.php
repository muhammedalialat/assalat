<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Alat.Assalat',
            'Timeslisting',
            [
                'Salatday' => 'list, listMonth, show'
            ],
            // non-cacheable actions
            [
                'Salatday' => 'list, listMonth, show'
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    timeslisting {
                        iconIdentifier = assalat-plugin-timeslisting
                        title = LLL:EXT:assalat/Resources/Private/Language/locallang_db.xlf:tx_assalat_timeslisting.name
                        description = LLL:EXT:assalat/Resources/Private/Language/locallang_db.xlf:tx_assalat_timeslisting.description
                        tt_content_defValues {
                            CType = list
                            list_type = assalat_timeslisting
                        }
                    }
                }
                show = *
            }
       }'
    );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

			$iconRegistry->registerIcon(
				'assalat-plugin-timeslisting',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:assalat/Resources/Public/Icons/qibla.png']
			);

    }
);
