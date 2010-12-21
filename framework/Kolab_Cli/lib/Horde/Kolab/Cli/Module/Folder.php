<?php
/**
 * The Horde_Kolab_Cli_Module_Base:: module provides the base options of the
 * Kolab CLI.
 *
 * PHP version 5
 *
 * @category Horde
 * @package  Cli_Modular
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link     http://pear.horde.org/index.php?package=Cli_Modular
 */

/**
 * The Horde_Kolab_Cli_Module_Base:: module provides the base options of the
 * Kolab CLI.
 *
 * Copyright 2010 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @category Horde
 * @package  Cli_Modular
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link     http://pear.horde.org/index.php?package=Cli_Modular
 */
class Horde_Kolab_Cli_Module_Folder
implements Horde_Kolab_Cli_Module
{
    /**
     * Get the usage description for this module.
     *
     * @return string The description.
     */
    public function getUsage()
    {
        return Horde_Kolab_Cli_Translation::t("  folder - Handle folders
  - list [default]: List the folders in the backend
");
    }

    /**
     * Get a set of base options that this module adds to the CLI argument
     * parser.
     *
     * @return array The options.
     */
    public function getBaseOptions()
    {
        return array();
    }

    /**
     * Indicate if the module provides an option group.
     *
     * @return boolean True if an option group should be added.
     */
    public function hasOptionGroup()
    {
        return false;
    }

    /**
     * Return the title for the option group representing this module.
     *
     * @return string The group title.
     */
    public function getOptionGroupTitle()
    {
        return '';
    }

    /**
     * Return the description for the option group representing this module.
     *
     * @return string The group description.
     */
    public function getOptionGroupDescription()
    {
        return '';
    }

    /**
     * Return the options for this module.
     *
     * @return array The group options.
     */
    public function getOptionGroupOptions()
    {
        return array();
    }

    /**
     * Handle the options and arguments.
     *
     * @param mixed &$options   An array of options.
     * @param mixed &$arguments An array of arguments.
     *
     * @return NULL
     */
    public function handleArguments(&$options, &$arguments)
    {
    }

    /**
     * Run the module.
     *
     * @param Horde_Cli $cli       The CLI handler.
     * @param mixed     $options   An array of options.
     * @param mixed     $arguments An array of arguments.
     *
     * @return NULL
     */
    public function run($cli, $options, $arguments)
    {
        if (!isset($arguments[1])) {
            $action = 'list';
        } else {
            $action = $arguments[1];
        }
        switch ($action) {
        case 'list':
            $folders = $this->_getStorage($options)->getList()->listFolders();
            foreach ($folders as $folder) {
                $cli->writeln($folder);
            }
            break;
        case 'show':
            if (!isset($arguments[2])) {
                $folder_name = 'INBOX';
            } else {
                $folder_name = $arguments[2];
            }
            $folder = $this->_getStorage($options)->getFolder($folder_name);
            $cli->writeln('Path:      ' . $folder->getPath());
            $cli->writeln('Title:     ' . $folder->getTitle());
            $cli->writeln('Owner:     ' . $folder->getOwner());
            $cli->writeln('Type:      ' . $folder->getType());
            $cli->writeln('Namespace: ' . $folder->getNamespace());
            break;
        default:
            $cli->message(
                sprintf(
                    Horde_Kolab_Cli_Translation::t('Action %s not supported!'),
                    $action
                ),
                'cli.error'
            );
            break;
        }
    }

    /**
     * Return the driver for the Kolab storage backend.
     *
     * @param mixed     $options   An array of options.
     *
     * @return Horde_Kolab_Storage The storage handler.
     */
    private function _getStorage($options)
    {
        $factory = new Horde_Kolab_Storage_Factory();
        return $factory->createFromParams(
            array(
                'driver' => $options['driver'],
                'params' => $options
            )
        );
    }
}