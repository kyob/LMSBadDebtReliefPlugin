<?php

/**
 * LMSBadDebtReliefPlugin
 * 
 * @author Łukasz Kopiszka <lukasz@alfa-system.pl>
 */
class LMSBadDebtReliefPlugin extends LMSPlugin
{
    const PLUGIN_NAME = 'LMS BadDebtRelief Plugin';
    const PLUGIN_DESCRIPTION = 'Ulga podatkowa na złe długi.';
    const PLUGIN_AUTHOR = 'Łukasz Kopiszka &lt;lukasz@alfa-system.pl&gt;';
    const PLUGIN_DIRECTORY_NAME = 'LMSBadDebtReliefPlugin';

    public function registerHandlers()
    {
        $this->handlers = array(
            'menu_initialized' => array(
                'class' => 'BadDebtReliefHandler',
                'method' => 'menuBadDebtRelief'
            ),
            'smarty_initialized' => array(
                'class' => 'BadDebtReliefHandler',
                'method' => 'smartyBadDebtRelief'
            ),
            'modules_dir_initialized' => array(
                'class' => 'BadDebtReliefHandler',
                'method' => 'modulesDirBadDebtRelief'
            ),
        );
    }
}
