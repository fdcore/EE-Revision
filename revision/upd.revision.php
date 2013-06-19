<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Revision_upd {

    var $version = '1.0';

    function Revision_upd()
    {
        // Make a local reference to the ExpressionEngine super object
        $this->EE =& get_instance();
    }

    /**
     * Module Installer
     *
     * @access	public
     * @return	bool
     */
    function install()
    {
        $this->EE->load->dbforge();

        $data = array(
            'module_name' => 'Revision' ,
            'module_version' => $this->version,
            'has_cp_backend' => 'y'
        );

        $this->EE->db->insert('modules', $data);


        $data = array(
            'class'		=> 'Download' ,
            'method'	=> 'force_download'
        );

        $this->EE->db->insert('actions', $data);


        return TRUE;
    }


    // --------------------------------------------------------------------

    /**
     * Module Uninstaller
     *
     * @access	public
     * @return	bool
     */
    function uninstall()
    {
        $this->EE->load->dbforge();

        $this->EE->db->select('module_id');
        $query = $this->EE->db->get_where('modules', array('module_name' => 'Revision'));

        $this->EE->db->where('module_id', $query->row('module_id'));
        $this->EE->db->delete('module_member_groups');

        $this->EE->db->where('module_name', 'Revision');
        $this->EE->db->delete('modules');

        $this->EE->db->where('class', 'Revision');
        $this->EE->db->delete('actions');


        return TRUE;
    }



    // --------------------------------------------------------------------

    /**
     * Module Updater
     *
     * @access	public
     * @return	bool
     */

    function update($current='')
    {
        return TRUE;
    }

}