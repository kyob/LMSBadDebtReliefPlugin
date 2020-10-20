<?php

/**
 * BadDebtReliefHandler
 *
 */
class BadDebtReliefHandler
{

    public function menuBadDebtRelief(array $hook_data = array())
    {
        $baddebtrelief_submenus = array(
            array(
                'name' => trans('Bad debt relief'),
                'link' => '?m=baddebtrelief',
                'tip' => trans('Bad debt relief'),
                'prio' => 140,
            ),
        );
        $hook_data['finances']['submenu'] = array_merge($hook_data['finances']['submenu'], $baddebtrelief_submenus);
        return $hook_data;
    }

    public function smartyBadDebtRelief(Smarty $hook_data)
    {
        $template_dirs = $hook_data->getTemplateDir();
        $plugin_templates = PLUGINS_DIR . DIRECTORY_SEPARATOR . LMSBadDebtReliefPlugin::PLUGIN_DIRECTORY_NAME . DIRECTORY_SEPARATOR . 'templates';
        array_unshift($template_dirs, $plugin_templates);
        $hook_data->setTemplateDir($template_dirs);
        return $hook_data;
    }

    public function modulesDirBadDebtRelief(array $hook_data = array())
    {
        $plugin_modules = PLUGINS_DIR . DIRECTORY_SEPARATOR . LMSBadDebtReliefPlugin::PLUGIN_DIRECTORY_NAME . DIRECTORY_SEPARATOR . 'modules';
        array_unshift($hook_data, $plugin_modules);
        return $hook_data;
    }
}
