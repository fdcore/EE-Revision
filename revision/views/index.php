<?php echo form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=revision'); ?>
<p>
    <input type="text" name="entry_id" id="" class="field" placeholder="Entry id" />
    <input type="submit" value="Show" class="submit" />
</p>
</form>

<?php
$this->table->set_template($cp_table_template);

if(count($versions) > 0){
$this->table->set_heading(
    'Title',
    'Status',
    'Date',
    'Fields'
);

foreach($versions as $v){

    $data = unserialize($v['version_data']);

    $title = $data['title'];
    $status = $data['status'];

    unset(
        $data['title'],
        $data['url_title'],
        $data['status'],
        $data['version_date'],
        $data['save_revision'],
        $data['versioning_enabled'],
        $data['allow_comments'],
        $data['layout_preview'],
        $data['member_group'],
        $data['autosave_entry_id'],
        $data['channel_id'],
        $data['entry_id'],
        $data['author'],
        $data['comment_expiration_date'],
        $data['expiration_date'],
        $data['entry_date'],
        $data['submit'],
        $data['filter'],
        $data['new_channel']
    );

    $table_temp = "";

    foreach($data as $k=>$d){

        if($fields[$k]['field_type'] == 'matrix'){

            $d = base64_decode($d);
            $d = unserialize($d);
            $t = "";

            $t.="<tr>";
            foreach($d[end($d['row_order'])] as $col => $r)
                $t.="<th>".$matrix_fields[$col]."</th>";

            $t.="</tr>";

            foreach($d['row_order'] as $row_order){

                $t.="<tr>";
                    foreach($d[$row_order] as $col => $r) $t.="<td>$r</td>";
                $t.="</tr>";

            }

            $d = "<table class='mainTable'>$t</table>";
        }

        $table_temp.="<tr><th>".$fields[$k]['field_name']."</th><td>$d</td></tr>";
    }

    $this->table->add_row(
        "<a href='".BASE.AMP."C=content_publish&M=entry_form&channel_id=".$v['channel_id']."&entry_id=".$v['entry_id']."&version_id=".$v['version_id']."'>".$title,
        $status,
        date('Y.m.d H:i', $v['version_date']),
        "<table class='mainTable'>$table_temp</table>"
    );
}

   echo $this->table->generate();

} else echo "No data.";

?>