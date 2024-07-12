<?php
include_once DOL_DOCUMENT_ROOT.'/core/modules/DolibarrModules.class.php';

class modAttendance extends DolibarrModules
{
    public function __construct($db)
    {
        global $langs, $conf, $user;

        $this->db = $db;

        $this->numero = 500000;
        $this->rights_class = 'attendance';
        $this->family = "other";
        $this->module_position = '90';
        $this->name = preg_replace('/^mod/i', '', get_class($this));
        $this->description = "Attendance module for managing employee attendance.";
        $this->editor_name = 'PairBytes Software Pvt. Ltd.';
        $this->editor_url = 'www.pairbytes.com';
        $this->version = '1.0';
        $this->const_name = 'MAIN_MODULE_' . strtoupper($this->name);
        $this->picto = 'fa-file-o';

        $this->module_parts = array(
            'css' => array('/attendance/css/attendance.css.php'),
            'js' => array(),
            'hooks' => array(),
            'moduleforexternal' => 0,
            'websitetemplates' => 0,
            'api' => array('attendance')
        );

        $this->dirs = array("/attendance/temp");
        $this->config_page_url = array("setup.php@attendance");

        $this->hidden = getDolGlobalInt('MODULE_ATTENDANCE_DISABLED');
        $this->depends = array();
        $this->requiredby = array();
        $this->conflictwith = array();

        $this->langfiles = array("attendance@attendance");

        $this->phpmin = array(7, 1);
        $this->need_dolibarr_version = array(19, -3);
        $this->need_javascript_ajax = 0;

        $this->warnings_activation = array();
        $this->warnings_activation_ext = array();

        $this->const = array();
        // Ensure the conf->attendance object is initialized
        if (!isset($conf->attendance)) {
            $conf->attendance = new stdClass();
        }
        $conf->attendance->enabled = 0;

        $this->tabs = array();
        $this->dictionaries = array();
        // $this->boxes = array();
        $this->boxes = array(
            0 => array(
                'file' => 'attendancewidget1.php@attendance',
                'note' => 'Attendance',
                'enabledbydefaulton' => 'Home'
            ),
            // You can declare as much boxes as you want by simply incrementing the index.
        );
        $this->cronjobs = array();

        // Define permissions
        $this->rights = array();
        $r = 0;
        $this->rights[$r][0] = 500001; // Unique identifier for this permission
        $this->rights[$r][1] = 'View Attendance Report'; // Permission label
        $this->rights[$r][3] = 0; // Permission enabled by default
        $this->rights[$r][4] = 'read'; // Permission key
        $r++;

        $this->rights[$r][0] = 500002; // Unique identifier for this permission
        $this->rights[$r][1] = 'Attendance'; // Permission label
        $this->rights[$r][3] = 0; // Permission enabled by default
        $this->rights[$r][4] = 'do'; // Permission key
        $r++;

        $this->menu = array();
        // if ($user->rights->attendance->do) {
            $this->menu[$r++] = array(
                'fk_menu' => '', 
                'type' => 'top', 
                'titre' => 'ModuleAttendanceName',
                'prefix' => img_picto('', $this->picto, 'class="pictofixedwidth valignmiddle"'),
                'mainmenu' => 'attendance',
                'leftmenu' => '',
                'url' => '/attendance/attendanceindex.php',
                'langs' => 'attendance@attendance',
                'position' => 1000 + $r,
                'enabled' => '$user->rights->attendance->do',
                'perms' => '$user->rights->attendance->do',
                'target' => '',
                'user' => 2
            );
        // }

        $this->menu[$r++] = array(
            'fk_menu' => 'fk_mainmenu=attendance', 
            'type' => 'left', 
            'titre' => 'Attendance', 
            'prefix' => img_picto('', $this->picto, 'class="pictofixedwidth valignmiddle paddingright"'), 
            'mainmenu' => 'attendance', 
            'leftmenu' => 'attendance', 
            'url' => '/attendance/attendanceindex.php', 
            'langs' => 'attendance@attendance', 
            'position' => 1000 + $r, 
            'enabled' => 1, 
            'perms' => 1, 
            'target' => '', 
            'user' => 2
        );

        // if ($user->rights->attendance->read) {
            $this->menu[$r++] = array(
                'fk_menu' => 'fk_mainmenu=attendance', 
                'type' => 'left', 
                'titre' => 'Report', 
                'prefix' => img_picto('', $this->picto, 'class="pictofixedwidth valignmiddle paddingright"'), 
                'mainmenu' => 'attendance', 
                'leftmenu' => 'report', 
                'url' => '/attendance/attendancereport.php', 
                'langs' => 'attendance@attendance', 
                'position' => 1000 + $r, 
                'enabled' => '$user->rights->attendance->read', 
                'perms' => '$user->rights->attendance->read', 
                'target' => '', 
                'user' => 2
            );
        // }
    }

    public function init($options = '')
    {
        global $conf, $langs;

        $result = $this->_load_tables('/attendance/sql/');
        if ($result < 0) {
            return -1;
        }

        $this->remove($options);

        $sql = array();

        $moduledir = dol_sanitizeFileName('attendance');
        $myTmpObjects = array();
        $myTmpObjects['MyObject'] = array('includerefgeneration'=>0, 'includedocgeneration'=>0);

        foreach ($myTmpObjects as $myTmpObjectKey => $myTmpObjectArray) {
            if ($myTmpObjectKey == 'MyObject') {
                continue;
            }
            if ($myTmpObjectArray['includerefgeneration']) {
                $src = DOL_DOCUMENT_ROOT.'/install/doctemplates/'.$moduledir.'/template_myobjects.odt';
                $dirodt = DOL_DATA_ROOT.'/doctemplates/'.$moduledir;
                $dest = $dirodt.'/template_myobjects.odt';

                if (file_exists($src) && !file_exists($dest)) {
                    require_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';
                    dol_mkdir($dirodt);
                    $result = dol_copy($src, $dest, 0, 0);
                    if ($result < 0) {
                        $langs->load("errors");
                        $this->error = $langs->trans('ErrorFailToCopyFile', $src, $dest);
                        return 0;
                    }
                }

                $sql = array_merge($sql, array(
                    "DELETE FROM ".MAIN_DB_PREFIX."document_model WHERE nom = 'standard_".strtolower($myTmpObjectKey)."' AND type = '".$this->db->escape(strtolower($myTmpObjectKey))."' AND entity = ".((int) $conf->entity),
                    "INSERT INTO ".MAIN_DB_PREFIX."document_model (nom, type, entity) VALUES('standard_".strtolower($myTmpObjectKey)."', '".$this->db->escape(strtolower($myTmpObjectKey))."', ".((int) $conf->entity).")",
                    "DELETE FROM ".MAIN_DB_PREFIX."document_model WHERE nom = 'generic_".strtolower($myTmpObjectKey)."_odt' AND type = '".$this->db->escape(strtolower($myTmpObjectKey))."' AND entity = ".((int) $conf->entity),
                    "INSERT INTO ".MAIN_DB_PREFIX."document_model (nom, type, entity) VALUES('generic_".strtolower($myTmpObjectKey)."_odt', '".$this->db->escape(strtolower($myTmpObjectKey))."', ".((int) $conf->entity).")"
                ));
            }
        }

        $result = $this->_init($sql, $options);
        if ($result < 0) {
            return -1;
        }

        return $result;
    }
}
