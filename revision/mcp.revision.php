<?php

class Revision_mcp{

    function Revision_mcp(){
        $this->EE =& get_instance();
    }


    function index(){
        $this->EE->load->library('table');
        $this->EE->view->cp_page_title = lang('revision_module_name');
        $this->EE->cp->set_breadcrumb(
            BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=revision',
            lang('revision_module_name')
        );

        $entry_id = intval($this->EE->input->get_post('entry_id'));

        $vars = array(); $versions = array(); $fields = array(); $matrix_fields = array();

        if($entry_id > 0){

            $query = $this->EE->db->query("SELECT * FROM exp_entry_versioning WHERE entry_id = '8'");

            if($query->num_rows() > 0){

                foreach($query->result_array() as $row)
                    $versions[]= $row;

                $field_result = $this->EE->db->query("SELECT field_id, field_name, field_type FROM exp_channel_fields");

                foreach($field_result->result_array() as $row)
                    $fields['field_id_'.$row['field_id']]= $row;

                $field_result = $this->EE->db->query("SELECT col_id, col_name, col_label FROM exp_matrix_cols");

                foreach($field_result->result_array() as $row)
                    $matrix_fields['col_id_'.$row['col_id']]= $row['col_name'];

            }

        }

        $vars['versions']   =   $versions;
        $vars['fields']     =   $fields;
        $vars['matrix_fields'] = $matrix_fields;

        return $this->EE->load->view('index', $vars, TRUE);
    }

}