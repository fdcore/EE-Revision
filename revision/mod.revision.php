<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Revision{

    var $return_data    = '';

    function Revision(){
        $this->EE =& get_instance();

        $entry_id = $this->EE->TMPL->fetch_param('entry_id', '');

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

        $vars['fields']     =   $fields;
        $vars['matrix_fields'] = $matrix_fields;

        $variables = array();

        foreach($versions as $v){
            $data = array();
            $data['data'][] = unserialize($v['version_data']);
            $data['info'][] = $v;

            $variables[]=$data;
        }


        return $this->return_data = ee()->TMPL->parse_variables($this->EE->TMPL->tagdata, $variables);
    }

}