<?php
defined('TYPO3_MODE') || die('Access denied.');

$TCA['tt_content']['types']['list']['subtypes_addlist']['assalat_timeslisting'] = 'pi_flexform';

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Alat.Assalat',
            'Timeslisting',
            'Timeslisting'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('assalat', 'Configuration/TypoScript', 'Assalat');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_assalat_domain_model_city', 'EXT:assalat/Resources/Private/Language/locallang_csh_tx_assalat_domain_model_city.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_assalat_domain_model_city');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_assalat_domain_model_country', 'EXT:assalat/Resources/Private/Language/locallang_csh_tx_assalat_domain_model_country.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_assalat_domain_model_country');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_assalat_domain_model_salatday', 'EXT:assalat/Resources/Private/Language/locallang_csh_tx_assalat_domain_model_salatday.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_assalat_domain_model_salatday');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_assalat_domain_model_state', 'EXT:assalat/Resources/Private/Language/locallang_csh_tx_assalat_domain_model_state.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_assalat_domain_model_state');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('assalat_timeslisting',
        'FILE:EXT:assalat/Configuration/FlexForms/flexform_timeslisting.xml');
    }
);
